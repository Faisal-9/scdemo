<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';

final class RevisionManager
{
    public static function record(string $entityType, int $entityId, array $snapshot, string $status = 'draft', string $note = ''): int
    {
        $allowed = ['draft','review','approved','published','archived'];
        if (!in_array($status, $allowed, true)) $status = 'draft';
        $stmt = Database::connection()->prepare('INSERT INTO content_revisions (entity_type,entity_id,user_id,status,snapshot_json,note) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$entityType, $entityId, Auth::id(), $status, json_encode($snapshot, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $note !== '' ? $note : null]);
        return (int)Database::connection()->lastInsertId();
    }

    public static function forEntity(string $entityType, int $entityId, int $limit = 20): array
    {
        $stmt = Database::connection()->prepare('SELECT cr.*, COALESCE(u.display_name,u.username,\'System\') AS user_name FROM content_revisions cr LEFT JOIN users u ON u.id=cr.user_id WHERE entity_type=? AND entity_id=? ORDER BY created_at DESC,id DESC LIMIT ' . max(1, min(100, $limit)));
        $stmt->execute([$entityType, $entityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM content_revisions WHERE id=? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
