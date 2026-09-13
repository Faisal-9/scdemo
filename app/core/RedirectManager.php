<?php
declare(strict_types=1);

final class RedirectManager
{
    public static function all(): array
    {
        return Database::connection()->query(
            'SELECT * FROM url_redirects ORDER BY sort_order ASC, id ASC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM url_redirects WHERE id=? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function save(?int $id, array $data): int
    {
        $pdo = Database::connection();
        $data = self::validate($data, $id);
        $userId = isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

        if ($id !== null) {
            $stmt = $pdo->prepare('UPDATE url_redirects SET source_path=?, destination_url=?, status_code=?, preserve_query=?, note=?, sort_order=?, is_active=?, updated_by=?, updated_at=NOW() WHERE id=?');
            $stmt->execute([
                $data['source_path'], $data['destination_url'], $data['status_code'], $data['preserve_query'], $data['note'],
                $data['sort_order'], $data['is_active'], $userId, $id
            ]);
            $savedId = $id;
            $action = 'update';
        } else {
            $stmt = $pdo->prepare('INSERT INTO url_redirects (source_path,destination_url,status_code,preserve_query,note,sort_order,is_active,created_by,updated_by) VALUES (?,?,?,?,?,?,?,?,?)');
            $stmt->execute([
                $data['source_path'], $data['destination_url'], $data['status_code'], $data['preserve_query'], $data['note'],
                $data['sort_order'], $data['is_active'], $userId, $userId
            ]);
            $savedId = (int)$pdo->lastInsertId();
            $action = 'create';
        }

        Redirect::clearCache();
        if (class_exists('AuditLogger')) {
            AuditLogger::log($action, 'url_redirects', $savedId, ucfirst($action) . ' redirect: ' . $data['source_path']);
        }
        return $savedId;
    }

    public static function toggle(int $id): void
    {
        $row = self::find($id);
        if (!$row) throw new RuntimeException('Redirect not found.');
        $userId = isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
        $stmt = Database::connection()->prepare('UPDATE url_redirects SET is_active=?, updated_by=?, updated_at=NOW() WHERE id=?');
        $stmt->execute([(int)$row['is_active'] === 1 ? 0 : 1, $userId, $id]);
        Redirect::clearCache();
        if (class_exists('AuditLogger')) AuditLogger::log('update', 'url_redirects', $id, 'Toggled redirect: ' . $row['source_path']);
    }

    public static function delete(int $id): void
    {
        $row = self::find($id);
        if (!$row) throw new RuntimeException('Redirect not found.');
        Database::connection()->prepare('DELETE FROM url_redirects WHERE id=?')->execute([$id]);
        Redirect::clearCache();
        if (class_exists('AuditLogger')) AuditLogger::log('delete', 'url_redirects', $id, 'Deleted redirect: ' . $row['source_path']);
    }

    private static function validate(array $data, ?int $id): array
    {
        $source = trim((string)($data['source_path'] ?? ''));
        if ($source === '' || $source[0] !== '/') throw new InvalidArgumentException('Source path must begin with /.');
        if (preg_match('#\s#', $source) || preg_match('#https?://#i', $source)) throw new InvalidArgumentException('Source path must be a local path without spaces.');
        $source = '/' . ltrim($source, '/');
        $sourcePathOnly = parse_url($source, PHP_URL_PATH) ?: '/';
        if ($sourcePathOnly === '/scadmin' || str_starts_with($sourcePathOnly, '/scadmin/')) throw new InvalidArgumentException('Admin paths cannot be configured as public redirects.');
        if (in_array($sourcePathOnly, ['/redirects','/app'], true) || str_starts_with($sourcePathOnly, '/app/')) throw new InvalidArgumentException('Application paths cannot be configured as public redirects.');

        $destination = trim((string)($data['destination_url'] ?? ''));
        if ($destination === '' || preg_match('/\s|javascript:|data:/i', $destination)) throw new InvalidArgumentException('Destination URL is required and must be valid.');
        if (!preg_match('#^(?:/|https?://)#i', $destination)) throw new InvalidArgumentException('Destination must be a local path or an http/https URL.');

        $status = (int)($data['status_code'] ?? 301);
        if (!in_array($status, [301,302,307,308], true)) $status = 301;
        $preserve = !empty($data['preserve_query']) ? 1 : 0;
        $note = trim((string)($data['note'] ?? ''));
        $sort = max(0, (int)($data['sort_order'] ?? 0));
        $active = !empty($data['is_active']) ? 1 : 0;
        $normalizedSource = rtrim(parse_url($source, PHP_URL_PATH) ?: '/', '/') ?: '/';
        $normalizedDestination = $destination;
        if (rtrim($normalizedDestination, '/') === $normalizedSource && $preserve === 0) throw new InvalidArgumentException('Source and destination cannot be the same path.');

        $stmt = Database::connection()->prepare('SELECT id FROM url_redirects WHERE source_path=? AND id<>? LIMIT 1');
        $stmt->execute([$normalizedSource, $id ?? 0]);
        if ($stmt->fetchColumn()) throw new InvalidArgumentException('A redirect for this source path already exists.');

        return compact('normalizedSource','normalizedDestination','status','preserve','note','sort','active') + [
            'source_path'=>$normalizedSource,
            'destination_url'=>$normalizedDestination,
            'status_code'=>$status,
            'preserve_query'=>$preserve,
            'sort_order'=>$sort,
            'is_active'=>$active,
        ];
    }
}
