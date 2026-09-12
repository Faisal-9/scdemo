<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class MediaFrontend
{
    public static function all(): array
    {
        $pdo = Database::connection();
        $items = $pdo->query("SELECT * FROM media_items WHERE is_active = 1 ORDER BY media_type ASC, sort_order ASC, COALESCE(media_date_sort, '1000-01-01') DESC, id ASC")->fetchAll();
        $desc = $pdo->prepare('SELECT description_text FROM media_descriptions WHERE media_item_id=:id ORDER BY sort_order ASC, id ASC');
        $tags = $pdo->prepare('SELECT t.tag_name FROM media_item_tags mit INNER JOIN media_tags t ON t.id=mit.tag_id WHERE mit.media_item_id=:id ORDER BY t.tag_name ASC, t.id ASC');
        $out = ['news' => [], 'events' => [], 'gallery' => []];
        foreach ($items as $row) {
            $id = (int)$row['id'];
            $desc->execute([':id' => $id]);
            $paragraphs = array_map(static fn(array $r): string => (string)$r['description_text'], $desc->fetchAll());
            $tags->execute([':id' => $id]);
            $tagNames = array_map(static fn(array $r): string => (string)$r['tag_name'], $tags->fetchAll());
            $item = [
                'id' => (string)($row['legacy_id'] ?: 'm' . $id),
                'date' => (string)($row['media_date'] ?? ''),
                'title' => (string)$row['title'],
                'description' => $row['media_type'] === 'gallery' ? (string)($paragraphs[0] ?? '') : $paragraphs,
                'image' => (string)($row['image_path'] ?? ''),
                'link' => (string)($row['external_link'] ?? ''),
                'tags' => $tagNames,
            ];
            $out[(string)$row['media_type']][] = $item;
        }
        return $out;
    }
}
