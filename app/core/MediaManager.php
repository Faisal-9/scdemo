<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class MediaManager
{
    private const TYPES = ['news', 'events', 'gallery'];

    public static function all(?string $type = null, bool $activeOnly = false): array
    {
        $pdo = Database::connection();
        $where = [];
        $params = [];
        if ($type !== null) {
            self::assertType($type);
            $where[] = 'm.media_type = :type';
            $params[':type'] = $type;
        }
        if ($activeOnly) {
            $where[] = 'm.is_active = 1';
        }
        $sql = 'SELECT m.* FROM media_items m';
        if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY m.media_type ASC, m.sort_order ASC, COALESCE(m.media_date_sort, \'1000-01-01\') DESC, m.id ASC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        $desc = $pdo->prepare('SELECT id, description_text, sort_order FROM media_descriptions WHERE media_item_id = :id ORDER BY sort_order ASC, id ASC');
        $tags = $pdo->prepare('SELECT t.id, t.tag_name FROM media_item_tags mit INNER JOIN media_tags t ON t.id = mit.tag_id WHERE mit.media_item_id = :id ORDER BY t.tag_name ASC, t.id ASC');
        foreach ($rows as &$row) {
            $desc->execute([':id' => (int)$row['id']]);
            $row['descriptions'] = $desc->fetchAll();
            $tags->execute([':id' => (int)$row['id']]);
            $row['tag_rows'] = $tags->fetchAll();
            $row['tags_csv'] = implode(', ', array_map(static fn(array $t): string => (string)$t['tag_name'], $row['tag_rows']));
        }
        unset($row);
        return $rows;
    }

    public static function find(int $id): ?array
    {
        $rows = self::all(null, false);
        foreach ($rows as $row) if ((int)$row['id'] === $id) return $row;
        return null;
    }

    public static function save(array $data, ?int $id = null): int
    {
        $pdo = Database::connection();
        $type = trim((string)($data['media_type'] ?? ''));
        self::assertType($type);
        $title = trim((string)($data['title'] ?? ''));
        if ($title === '') throw new RuntimeException('Media title is required.');
        $image = trim((string)($data['image_path'] ?? ''));
        $date = trim((string)($data['media_date'] ?? ''));
        $dateSort = trim((string)($data['media_date_sort'] ?? ''));
        $external = self::nullable($data['external_link'] ?? null);
        $legacy = self::nullable($data['legacy_id'] ?? null);
        $sort = max(0, (int)($data['sort_order'] ?? 0));
        $active = !empty($data['is_active']) ? 1 : 0;
        $descriptions = [];
        foreach ((array)($data['descriptions'] ?? []) as $text) {
            $text = trim((string)$text);
            if ($text !== '') $descriptions[] = $text;
        }
        if (!$descriptions) throw new RuntimeException('At least one description paragraph is required.');
        $tags = self::parseTags((string)($data['tags'] ?? ''));

        $pdo->beginTransaction();
        try {
            if ($id === null) {
                $stmt = $pdo->prepare('INSERT INTO media_items (legacy_id, media_type, media_date, media_date_sort, title, image_path, external_link, sort_order, is_active) VALUES (:legacy_id,:media_type,:media_date,:media_date_sort,:title,:image_path,:external_link,:sort_order,:is_active)');
                $stmt->execute([
                    ':legacy_id' => $legacy,
                    ':media_type' => $type,
                    ':media_date' => self::nullable($date),
                    ':media_date_sort' => self::nullable($dateSort),
                    ':title' => $title,
                    ':image_path' => self::nullable($image),
                    ':external_link' => $external,
                    ':sort_order' => $sort,
                    ':is_active' => $active
                ]);
                $id = (int)$pdo->lastInsertId();
                $action = 'create';
            } else {
                $exists = $pdo->prepare('SELECT id FROM media_items WHERE id=:id LIMIT 1');
                $exists->execute([':id' => $id]);
                if (!$exists->fetchColumn()) throw new RuntimeException('Media item not found.');
                $stmt = $pdo->prepare('UPDATE media_items SET legacy_id=:legacy_id, media_type=:media_type, media_date=:media_date, media_date_sort=:media_date_sort, title=:title, image_path=:image_path, external_link=:external_link, sort_order=:sort_order, is_active=:is_active WHERE id=:id');
                $stmt->execute([
                    ':legacy_id' => $legacy,
                    ':media_type' => $type,
                    ':media_date' => self::nullable($date),
                    ':media_date_sort' => self::nullable($dateSort),
                    ':title' => $title,
                    ':image_path' => self::nullable($image),
                    ':external_link' => $external,
                    ':sort_order' => $sort,
                    ':is_active' => $active,
                    ':id' => $id
                ]);
                $action = 'update';
            }

            $pdo->prepare('DELETE FROM media_descriptions WHERE media_item_id=:id')->execute([':id' => $id]);
            $ds = $pdo->prepare('INSERT INTO media_descriptions (media_item_id, description_text, sort_order) VALUES (:id,:text,:sort)');
            foreach ($descriptions as $i => $text) $ds->execute([':id' => $id, ':text' => $text, ':sort' => $i]);

            $pdo->prepare('DELETE FROM media_item_tags WHERE media_item_id=:id')->execute([':id' => $id]);
            $tagStmt = $pdo->prepare('SELECT id FROM media_tags WHERE tag_name=:name LIMIT 1');
            $tagIns = $pdo->prepare('INSERT INTO media_tags (tag_name) VALUES (:name)');
            $link = $pdo->prepare('INSERT INTO media_item_tags (media_item_id, tag_id) VALUES (:item,:tag)');
            foreach ($tags as $tagName) {
                $tagStmt->execute([':name' => $tagName]);
                $tagId = $tagStmt->fetchColumn();
                if ($tagId === false) {
                    $tagIns->execute([':name' => $tagName]);
                    $tagId = $pdo->lastInsertId();
                }
                $link->execute([':item' => $id, ':tag' => (int)$tagId]);
            }
            $pdo->commit();
            self::audit($action, $id, $title);
            return $id;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    public static function delete(int $id): void
    {
        $pdo = Database::connection();
        $row = self::find($id);
        if (!$row) throw new RuntimeException('Media item not found.');
        $pdo->beginTransaction();
        try {
            $pdo->prepare('DELETE FROM media_item_tags WHERE media_item_id=:id')->execute([':id' => $id]);
            $pdo->prepare('DELETE FROM media_descriptions WHERE media_item_id=:id')->execute([':id' => $id]);
            $pdo->prepare('DELETE FROM media_items WHERE id=:id')->execute([':id' => $id]);
            $pdo->commit();
            self::audit('delete', $id, (string)$row['title']);
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    private static function parseTags(string $csv): array
    {
        $out = [];
        foreach (explode(',', $csv) as $tag) {
            $tag = trim($tag);
            if ($tag !== '' && !in_array($tag, $out, true)) $out[] = $tag;
        }
        return $out;
    }
    private static function nullable(mixed $value): ?string
    {
        if ($value === null) return null;
        $v = trim((string)$value);
        return $v === '' ? null : $v;
    }
    private static function assertType(string $type): void
    {
        if (!in_array($type, self::TYPES, true)) throw new RuntimeException('Invalid media type.');
    }
    private static function audit(string $action, int $id, string $title): void
    {
        try {
            $stmt = Database::connection()->prepare('INSERT INTO audit_logs (user_id, action, entity_type, entity_id, description, ip_address, user_agent) VALUES (:uid,:action,\'media_item\',:id,:description,:ip,:ua)');
            $stmt->execute([':uid' => class_exists('Auth') ? (Auth::id() ?: null) : null, ':action' => $action, ':id' => $id, ':description' => ucfirst($action) . ' media item: ' . $title, ':ip' => $_SERVER['REMOTE_ADDR'] ?? null, ':ua' => $_SERVER['HTTP_USER_AGENT'] ?? null]);
        } catch (Throwable $e) { /* audit failure must not break content save */
        }
    }
}
