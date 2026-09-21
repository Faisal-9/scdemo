<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class MediaFrontend
{
    public static function all(): array
    {
        $pdo = Database::connection();
        $items = $pdo->query("SELECT * FROM media_items WHERE is_active = 1 ORDER BY media_type ASC, sort_order ASC, COALESCE(media_date_sort, '1000-01-01') DESC, id ASC")->fetchAll();
        if ($items === []) {
            return ['news' => [], 'events' => [], 'gallery' => []];
        }

        $descriptions = $pdo->query(
            'SELECT media_item_id, description_text
             FROM media_descriptions
             ORDER BY media_item_id ASC, sort_order ASC, id ASC'
        )->fetchAll();
        $tagRows = $pdo->query(
            'SELECT mit.media_item_id, t.tag_name
             FROM media_item_tags mit
             INNER JOIN media_tags t ON t.id = mit.tag_id
             ORDER BY mit.media_item_id ASC, t.tag_name ASC, t.id ASC'
        )->fetchAll();
        $paragraphsByItem = [];
        foreach ($descriptions as $description) {
            $paragraphsByItem[(int)$description['media_item_id']][] = (string)$description['description_text'];
        }
        $tagsByItem = [];
        foreach ($tagRows as $tag) {
            $tagsByItem[(int)$tag['media_item_id']][] = (string)$tag['tag_name'];
        }

        $out = ['news' => [], 'events' => [], 'gallery' => []];
        foreach ($items as $row) {
            $id = (int)$row['id'];
            $paragraphs = $paragraphsByItem[$id] ?? [];
            $tagNames = $tagsByItem[$id] ?? [];
            $item = [
                'id' => (string)($row['legacy_id'] ?: 'm' . $id),
                'date' => (string)($row['media_date'] ?? ''),
                'title' => (string)$row['title'],
                'description' => $row['media_type'] === 'gallery' ? (string)($paragraphs[0] ?? '') : $paragraphs,
                'image' => AssetResolver::path($row['media_asset_id'] ?? null),
                'link' => (string)($row['external_link'] ?? ''),
                'tags' => $tagNames,
            ];
            $out[(string)$row['media_type']][] = $item;
        }
        return $out;
    }
}
