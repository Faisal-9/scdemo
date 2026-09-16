<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';

final class AdminSearchManager
{
    public static function search(string $query, int $limit = 50): array
    {
        $query = trim($query);
        if ($query === '') return [];
        $query = mb_substr($query, 0, 120);
        $like = '%' . $query . '%';
        $limit = max(1, min($limit, 100));
        $pdo = Database::connection();
        $results = [];

        if (Auth::hasPermission('manage_projects')) {
            $stmt = $pdo->prepare('SELECT id,name,description FROM projects WHERE name LIKE ? OR description LIKE ? ORDER BY updated_at DESC LIMIT ' . $limit);
            $stmt->execute([$like, $like]);
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) $results[] = self::result('Project', $row['name'], $row['description'], 'projects/edit.php?id=' . (int)$row['id'], (int)$row['id']);
        }
        if (Auth::hasPermission('manage_services')) {
            $stmt = $pdo->prepare('SELECT id,title,short_description FROM service_items WHERE title LIKE ? OR short_description LIKE ? ORDER BY id DESC LIMIT ' . $limit);
            $stmt->execute([$like, $like]);
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) $results[] = self::result('Service', $row['title'], $row['short_description'], 'services/item.php?id=' . (int)$row['id'], (int)$row['id']);
        }
        if (Auth::hasPermission('manage_sectors')) {
            $stmt = $pdo->prepare('SELECT id,title,description FROM sectors WHERE title LIKE ? OR description LIKE ? ORDER BY id DESC LIMIT ' . $limit);
            $stmt->execute([$like, $like]);
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) $results[] = self::result('Sector', $row['title'], $row['description'], 'sectors/edit.php?id=' . (int)$row['id'], (int)$row['id']);
        }
        if (Auth::hasPermission('manage_assets')) {
            $stmt = $pdo->prepare('SELECT id,original_name,alt_text FROM media_library WHERE original_name LIKE ? OR relative_path LIKE ? OR alt_text LIKE ? ORDER BY id DESC LIMIT ' . $limit);
            $stmt->execute([$like, $like, $like]);
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) $results[] = self::result('Media', $row['original_name'], $row['alt_text'], 'assets-library/edit.php?id=' . (int)$row['id'], (int)$row['id']);
        }
        if (Auth::hasPermission('manage_messages')) {
            $stmt = $pdo->prepare('SELECT id,subject,message FROM contact_messages WHERE name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ? ORDER BY created_at DESC LIMIT ' . $limit);
            $stmt->execute([$like, $like, $like, $like]);
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) $results[] = self::result('Message', $row['subject'] ?: 'Contact message', $row['message'], 'messages/view.php?id=' . (int)$row['id'], (int)$row['id']);
        }
        return array_slice($results, 0, $limit);
    }

    private static function result(string $type, string $title, ?string $snippet, string $url, int $id): array
    {
        $snippet = trim(preg_replace('/\s+/', ' ', (string)$snippet));
        return ['type' => $type, 'title' => $title, 'snippet' => mb_substr($snippet, 0, 180), 'url' => $url, 'id' => $id];
    }
}
