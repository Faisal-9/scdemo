<?php

declare(strict_types=1);

/**
 * Phase 21: CMS Activity Logs.
 * Read-only manager for the existing audit_logs table.
 * No log deletion/editing is exposed by this module.
 */
final class ActivityLogManager
{
    public static function all(array $filters = [], int $limit = 50, int $offset = 0): array
    {
        $pdo = Database::connection();
        [$where, $params] = self::buildWhere($filters);
        $limit = max(1, min($limit, 250));
        $offset = max(0, $offset);

        $sql = 'SELECT al.*, u.username AS user_email, u.display_name AS user_name
                FROM audit_logs al
                LEFT JOIN users u ON u.id = al.user_id';
        if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY al.created_at DESC, al.id DESC LIMIT ' . $limit . ' OFFSET ' . $offset;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function count(array $filters = []): int
    {
        [$where, $params] = self::buildWhere($filters);
        $sql = 'SELECT COUNT(*) FROM audit_logs al';
        if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public static function find(int $id): ?array
    {
        if ($id < 1) return null;
        $stmt = Database::connection()->prepare(
            'SELECT al.*, u.username AS user_email, u.display_name AS user_name
             FROM audit_logs al
             LEFT JOIN users u ON u.id = al.user_id
             WHERE al.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function actions(): array
    {
        $stmt = Database::connection()->query(
            'SELECT action, COUNT(*) AS log_count, MAX(created_at) AS latest_log
             FROM audit_logs GROUP BY action ORDER BY action ASC'
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function entityTypes(): array
    {
        $stmt = Database::connection()->query(
            "SELECT COALESCE(entity_type, '') AS entity_type, COUNT(*) AS log_count, MAX(created_at) AS latest_log
             FROM audit_logs
             GROUP BY entity_type
             ORDER BY entity_type ASC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function users(): array
    {
        $stmt = Database::connection()->query(
            'SELECT DISTINCT u.id, u.username AS email, u.display_name
             FROM audit_logs al
             INNER JOIN users u ON u.id = al.user_id
             ORDER BY COALESCE(u.display_name, u.username) ASC'
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function buildWhere(array $filters): array
    {
        $where = [];
        $params = [];

        $action = trim((string)($filters['action'] ?? ''));
        if ($action !== '') {
            $where[] = 'al.action = :action';
            $params['action'] = mb_substr($action, 0, 100);
        }

        $entityType = trim((string)($filters['entity_type'] ?? ''));
        if ($entityType !== '') {
            $where[] = 'al.entity_type = :entity_type';
            $params['entity_type'] = mb_substr($entityType, 0, 100);
        }

        $userId = $filters['user_id'] ?? null;
        if (is_int($userId) || (is_string($userId) && ctype_digit($userId))) {
            $userId = (int)$userId;
            if ($userId > 0) {
                $where[] = 'al.user_id = :user_id';
                $params['user_id'] = $userId;
            }
        }

        $ip = trim((string)($filters['ip_address'] ?? ''));
        if ($ip !== '') {
            $where[] = 'al.ip_address = :ip_address';
            $params['ip_address'] = mb_substr($ip, 0, 45);
        }

        $dateFrom = trim((string)($filters['date_from'] ?? ''));
        if ($dateFrom !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom)) {
            $where[] = 'al.created_at >= :date_from';
            $params['date_from'] = $dateFrom . ' 00:00:00';
        }

        $dateTo = trim((string)($filters['date_to'] ?? ''));
        if ($dateTo !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo)) {
            $where[] = 'al.created_at <= :date_to';
            $params['date_to'] = $dateTo . ' 23:59:59';
        }

        $search = trim((string)($filters['search'] ?? ''));
        if ($search !== '') {
            $where[] = '(al.description LIKE :search OR al.entity_type LIKE :search OR al.action LIKE :search OR al.ip_address LIKE :search OR u.username LIKE :search OR u.display_name LIKE :search)';
            $params['search'] = '%' . mb_substr($search, 0, 150) . '%';
        }

        return [$where, $params];
    }
}
