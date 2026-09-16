<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';

final class NotificationManager
{
    public static function unreadCount(?int $userId = null): int
    {
        $userId ??= Auth::id();
        if (!$userId) return 0;
        $stmt = Database::connection()->prepare('SELECT COUNT(*) FROM admin_notifications WHERE user_id = :user_id AND is_read = 0');
        $stmt->execute([':user_id' => $userId]);
        return (int)$stmt->fetchColumn();
    }

    public static function latest(?int $userId = null, int $limit = 50): array
    {
        $userId ??= Auth::id();
        if (!$userId) return [];
        $limit = max(1, min($limit, 100));
        $stmt = Database::connection()->prepare('SELECT * FROM admin_notifications WHERE user_id = :user_id ORDER BY created_at DESC, id DESC LIMIT ' . $limit);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(int $userId, string $title, string $message = '', string $type = 'info', ?string $url = null, ?string $entityType = null, ?int $entityId = null): int
    {
        $stmt = Database::connection()->prepare('INSERT INTO admin_notifications (user_id,type,title,message,url,entity_type,entity_id) VALUES (?,?,?,?,?,?,?)');
        $stmt->execute([$userId, substr($type, 0, 50), substr($title, 0, 255), $message !== '' ? $message : null, $url, $entityType, $entityId]);
        return (int)Database::connection()->lastInsertId();
    }

    public static function notifyAdmins(string $title, string $message = '', string $type = 'info', ?string $url = null, ?string $entityType = null, ?int $entityId = null): void
    {
        $ids = Database::connection()->query("SELECT id FROM users WHERE role='admin' AND status='active'")->fetchAll(PDO::FETCH_COLUMN);
        foreach ($ids as $id) self::create((int)$id, $title, $message, $type, $url, $entityType, $entityId);
    }

    public static function markRead(int $id): void
    {
        $stmt = Database::connection()->prepare('UPDATE admin_notifications SET is_read=1, read_at=NOW() WHERE id=? AND user_id=?');
        $stmt->execute([$id, Auth::id()]);
    }

    public static function markAllRead(): void
    {
        $stmt = Database::connection()->prepare('UPDATE admin_notifications SET is_read=1, read_at=NOW() WHERE user_id=? AND is_read=0');
        $stmt->execute([Auth::id()]);
    }
}
