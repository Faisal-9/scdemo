<?php

declare(strict_types=1);

final class SeoManager
{
    public static function all(): array
    {
        return Database::connection()->query(
            'SELECT * FROM page_seo ORDER BY sort_order ASC, id ASC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM page_seo WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function save(?int $id, array $data): int
    {
        $pdo = Database::connection();
        $data = self::validate($data);
        $userId = Auth::id();

        if ($id !== null) {
            $stmt = $pdo->prepare(
                'UPDATE page_seo SET page_name=?, title=?, description=?, keywords=?, canonical_url=?, robots=?, og_title=?, og_description=?, og_image=?, twitter_card=?, sort_order=?, is_active=?, updated_by=?, updated_at=NOW() WHERE id=?'
            );
            $stmt->execute([
                $data['page_name'],
                $data['title'],
                $data['description'],
                $data['keywords'],
                $data['canonical_url'],
                $data['robots'],
                $data['og_title'],
                $data['og_description'],
                $data['og_image'],
                $data['twitter_card'],
                $data['sort_order'],
                $data['is_active'],
                $userId,
                $id
            ]);
            $savedId = $id;
            $action = 'update';
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO page_seo (page_key,page_name,title,description,keywords,canonical_url,robots,og_title,og_description,og_image,twitter_card,sort_order,is_active,created_by,updated_by) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
            );
            $stmt->execute([
                $data['page_key'],
                $data['page_name'],
                $data['title'],
                $data['description'],
                $data['keywords'],
                $data['canonical_url'],
                $data['robots'],
                $data['og_title'],
                $data['og_description'],
                $data['og_image'],
                $data['twitter_card'],
                $data['sort_order'],
                $data['is_active'],
                $userId,
                $userId
            ]);
            $savedId = (int)$pdo->lastInsertId();
            $action = 'create';
        }

        self::clearCache();
        if (class_exists('AuditLogger')) {
            AuditLogger::log($action, 'page_seo', $savedId, ucfirst($action) . ' SEO metadata: ' . $data['page_key']);
        }
        return $savedId;
    }

    public static function toggle(int $id): void
    {
        $row = self::find($id);
        if (!$row) throw new RuntimeException('SEO record not found.');
        $userId = Auth::id();
        $stmt = Database::connection()->prepare('UPDATE page_seo SET is_active=?, updated_by=?, updated_at=NOW() WHERE id=?');
        $stmt->execute([(int)$row['is_active'] === 1 ? 0 : 1, $userId, $id]);
        self::clearCache();
        if (class_exists('AuditLogger')) AuditLogger::log('update', 'page_seo', $id, 'Toggled SEO record: ' . $row['page_key']);
    }

    public static function delete(int $id): void
    {
        $row = self::find($id);
        if (!$row) throw new RuntimeException('SEO record not found.');
        $stmt = Database::connection()->prepare('DELETE FROM page_seo WHERE id=?');
        $stmt->execute([$id]);
        self::clearCache();
        if (class_exists('AuditLogger')) AuditLogger::log('delete', 'page_seo', $id, 'Deleted SEO record: ' . $row['page_key']);
    }

    private static function clearCache(): void
    {
        if (class_exists('Seo')) Seo::clearCache();
    }

    private static function validate(array $data): array
    {
        $pageKey = trim((string)($data['page_key'] ?? ''));
        if ($pageKey === '' || !preg_match('/^[a-z0-9][a-z0-9_-]{0,99}$/', $pageKey)) {
            throw new InvalidArgumentException('Page key must use lowercase letters, numbers, hyphens, or underscores.');
        }
        $pageName = trim((string)($data['page_name'] ?? ''));
        if ($pageName === '' || mb_strlen($pageName) > 150) throw new InvalidArgumentException('Page name is required.');

        $robots = trim((string)($data['robots'] ?? 'index,follow'));
        $allowedRobots = ['index,follow', 'index,nofollow', 'noindex,follow', 'noindex,nofollow'];
        if (!in_array($robots, $allowedRobots, true)) $robots = 'index,follow';

        $twitter = trim((string)($data['twitter_card'] ?? 'summary_large_image'));
        if (!in_array($twitter, ['summary', 'summary_large_image', ''], true)) $twitter = 'summary_large_image';

        $canonical = trim((string)($data['canonical_url'] ?? ''));
        if ($canonical !== '' && !preg_match('#^https?://#i', $canonical)) throw new InvalidArgumentException('Canonical URL must be absolute or empty.');

        $ogImage = trim((string)($data['og_image'] ?? ''));
        if (preg_match('/\s/', $ogImage)) throw new InvalidArgumentException('Social image path/URL cannot contain whitespace.');

        return [
            'page_key' => $pageKey,
            'page_name' => $pageName,
            'title' => self::limitText($data['title'] ?? null, 255),
            'description' => self::limitText($data['description'] ?? null, 320),
            'keywords' => self::limitText($data['keywords'] ?? null, 500),
            'canonical_url' => $canonical,
            'robots' => $robots,
            'og_title' => self::limitText($data['og_title'] ?? null, 255),
            'og_description' => self::limitText($data['og_description'] ?? null, 320),
            'og_image' => self::limitText($ogImage, 500),
            'twitter_card' => $twitter,
            'sort_order' => max(0, (int)($data['sort_order'] ?? 0)),
            'is_active' => !empty($data['is_active']) ? 1 : 0,
        ];
    }

    private static function limitText($value, int $max): ?string
    {
        $value = trim((string)($value ?? ''));
        if ($value === '') return null;
        return mb_substr($value, 0, $max);
    }
}
