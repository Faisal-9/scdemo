<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/AnalyticsManager.php';

final class DashboardManager
{
    public static function overview(): array
    {
        $pdo = Database::connection();

        return [
            'analytics' => self::analytics(),
            'counts' => [
                'projects' => self::count($pdo, 'projects'),
                'services' => self::count($pdo, 'service_items', 'is_active = 1'),
                'sectors' => self::count($pdo, 'sectors', 'is_active = 1'),
                'media' => self::count($pdo, 'media_library'),
                'messages' => self::count($pdo, 'contact_messages'),
                'unread_messages' => self::count($pdo, 'contact_messages', "status = 'unread'"),
                'active_users' => self::count($pdo, 'users', "status = 'active'"),
                'published_projects' => self::count($pdo, 'projects', 'published = 1'),
            ],
            'recent_activity' => self::recentActivity($pdo),
            'alerts' => self::alerts($pdo),
        ];
    }

    private static function analytics(): array
    {
        try {
            return AnalyticsManager::overview(7);
        } catch (Throwable) {
            return ['today' => ['page_views' => 0, 'visitors' => 0], 'totals' => ['page_views' => 0, 'visitors' => 0], 'daily' => [], 'top_pages' => [], 'referrers' => [], 'devices' => []];
        }
    }

    private static function count(PDO $pdo, string $table, string $where = '1=1'): int
    {
        $allowedTables = [
            'projects',
            'service_items',
            'sectors',
            'media_library',
            'contact_messages',
            'users',
        ];
        if (!in_array($table, $allowedTables, true)) {
            throw new InvalidArgumentException('Invalid dashboard table.');
        }
        return (int)$pdo->query("SELECT COUNT(*) FROM {$table} WHERE {$where}")->fetchColumn();
    }

    private static function recentActivity(PDO $pdo): array
    {
        $stmt = $pdo->query(
            'SELECT al.id, al.action, al.entity_type, al.entity_id, al.description, al.created_at,
                    COALESCE(u.display_name, u.username, \'System\') AS user_name
             FROM audit_logs al
             LEFT JOIN users u ON u.id = al.user_id
             ORDER BY al.created_at DESC, al.id DESC
             LIMIT 8'
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function alerts(PDO $pdo): array
    {
        $alerts = [];
        $unread = self::count($pdo, 'contact_messages', "status = 'unread'");
        if ($unread > 0) {
            $alerts[] = [
                'type' => 'info',
                'title' => $unread . ' unread contact message' . ($unread === 1 ? '' : 's'),
                'text' => 'Review incoming contact requests.',
                'url' => 'messages/',
            ];
        }

        $inactiveUsers = self::count($pdo, 'users', "status = 'inactive'");
        if ($inactiveUsers > 0) {
            $alerts[] = [
                'type' => 'warning',
                'title' => $inactiveUsers . ' inactive user' . ($inactiveUsers === 1 ? '' : 's'),
                'text' => 'Review account access and permissions.',
                'url' => 'editors/',
            ];
        }

        return $alerts;
    }
}
