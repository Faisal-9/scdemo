<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';

final class RevisionManager
{
    private static bool $schemaReady = false;

    public static function record(string $entityType, int $entityId, array $snapshot, string $status = 'draft', string $note = ''): int
    {
        self::ensureSchema();
        $allowed = ['draft','review','approved','published','archived'];
        if (!in_array($status, $allowed, true)) {
            $status = 'draft';
        }

        $stmt = Database::connection()->prepare(
            'INSERT INTO content_revisions (entity_type, entity_id, user_id, status, snapshot_json, note)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $entityType,
            $entityId,
            Auth::id(),
            $status,
            json_encode($snapshot, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
            $note,
        ]);
        return (int)Database::connection()->lastInsertId();
    }

    public static function all(array $filters = [], int $limit = 50, int $offset = 0): array
    {
        self::ensureSchema();
        $where = [];
        $params = [];
        if (($filters['entity_type'] ?? '') !== '') {
            $where[] = 'cr.entity_type = :entity_type';
            $params['entity_type'] = (string)$filters['entity_type'];
        }

        $limit = max(1, min(250, $limit));
        $offset = max(0, $offset);
        $sql = 'SELECT cr.*, COALESCE(u.display_name, u.username, \'System\') AS user_name
                FROM content_revisions cr
                LEFT JOIN users u ON u.id = cr.user_id';
        if ($where !== []) $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY cr.created_at DESC, cr.id DESC LIMIT ' . $limit . ' OFFSET ' . $offset;
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as &$row) {
            $snapshot = json_decode((string)$row['snapshot_json'], true);
            if (is_array($snapshot)) $row['status'] = self::effectiveStatus($row, $snapshot);
        }
        unset($row);
        return $rows;
    }

    public static function count(array $filters = []): int
    {
        self::ensureSchema();
        $where = [];
        $params = [];
        if (($filters['entity_type'] ?? '') !== '') {
            $where[] = 'entity_type = :entity_type';
            $params['entity_type'] = (string)$filters['entity_type'];
        }
        $sql = 'SELECT COUNT(*) FROM content_revisions';
        if ($where !== []) $sql .= ' WHERE ' . implode(' AND ', $where);
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public static function entityTypes(): array
    {
        self::ensureSchema();
        $stmt = Database::connection()->query(
            'SELECT entity_type, COUNT(*) AS revision_count
             FROM content_revisions
             GROUP BY entity_type
             ORDER BY entity_type ASC'
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function forEntity(string $entityType, int $entityId, int $limit = 20): array
    {
        self::ensureSchema();
        $stmt = Database::connection()->prepare("SELECT cr.*, COALESCE(u.display_name,u.username,'System') AS user_name FROM content_revisions cr LEFT JOIN users u ON u.id=cr.user_id WHERE cr.entity_type=? AND cr.entity_id=? ORDER BY cr.created_at DESC,cr.id DESC LIMIT " . max(1, min(100, $limit)));
        $stmt->execute([$entityType, $entityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        self::ensureSchema();
        $stmt = Database::connection()->prepare(
            "SELECT cr.*, COALESCE(u.display_name, u.username, 'System') AS user_name
             FROM content_revisions cr LEFT JOIN users u ON u.id = cr.user_id
             WHERE cr.id = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (is_array($row)) {
            $row['snapshot_json'] = $row['snapshot_json'] ?? '';
        }
        return $row ?: null;
    }

    public static function previous(int $id, string $entityType, int $entityId): ?array
    {
        self::ensureSchema();
        $stmt = Database::connection()->prepare(
            'SELECT * FROM content_revisions
             WHERE entity_type = ? AND entity_id = ? AND id < ?
             ORDER BY id DESC LIMIT 1'
        );
        $stmt->execute([$entityType, $entityId, $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return is_array($row) ? $row : null;
    }

    public static function statusForSnapshot(array $snapshot): string
    {
        $status = strtolower(trim((string)($snapshot['status'] ?? '')));
        if (($snapshot['published'] ?? false) || $status === 'published') return 'published';
        return in_array($status, ['draft', 'review', 'approved', 'archived'], true) ? $status : 'published';
    }

    public static function effectiveStatus(array $revision, array $snapshot): string
    {
        $stored = strtolower(trim((string)($revision['status'] ?? '')));
        if ($stored !== '' && $stored !== 'draft') return $stored;
        return self::statusForSnapshot($snapshot);
    }

    private static function ensureSchema(): void
    {
        if (self::$schemaReady) return;

        $pdo = Database::connection();
        $columns = $pdo->query(
            "SELECT COLUMN_NAME FROM information_schema.columns
             WHERE table_schema = DATABASE() AND table_name = 'content_revisions'"
        )->fetchAll(PDO::FETCH_COLUMN);
        if ($columns === []) {
            throw new RuntimeException('The content_revisions table is missing. Run the CMS database schema migration.');
        }

        if (!in_array('status', $columns, true)) {
            $pdo->exec("ALTER TABLE content_revisions ADD COLUMN status ENUM('draft','review','approved','published','archived') NOT NULL DEFAULT 'draft' AFTER entity_id");
        }
        if (!in_array('snapshot_json', $columns, true)) {
            $pdo->exec('ALTER TABLE content_revisions ADD COLUMN snapshot_json LONGTEXT NULL AFTER status');
            if (in_array('revision_data', $columns, true)) {
                $pdo->exec('UPDATE content_revisions SET snapshot_json = revision_data WHERE snapshot_json IS NULL');
            }
            $pdo->exec('ALTER TABLE content_revisions MODIFY snapshot_json LONGTEXT NOT NULL');
        }
        if (!in_array('note', $columns, true)) {
            $pdo->exec('ALTER TABLE content_revisions ADD COLUMN note VARCHAR(500) NULL AFTER snapshot_json');
        }
        self::$schemaReady = true;
    }
}
