<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class ServiceFrontend
{
    public static function all(): array
    {
        $pdo = Database::connection();
        $groups = $pdo->query(
            'SELECT id, service_key, title, hero_image, hero_text
             FROM service_groups
             WHERE is_active = 1
             ORDER BY sort_order ASC, id ASC'
        )->fetchAll();

        if ($groups === []) {
            return [];
        }

        $categories = $pdo->query(
            'SELECT id, group_id, category_key, title
             FROM service_categories
             WHERE is_active = 1
             ORDER BY sort_order ASC, id ASC'
        )->fetchAll();
        $items = $pdo->query(
            'SELECT id, category_id, parent_id, service_key, title, image_path, short_description, why_description
             FROM service_items
             WHERE is_active = 1
             ORDER BY sort_order ASC, id ASC'
        )->fetchAll();
        $features = $pdo->query(
            'SELECT service_item_id, feature_text
             FROM service_features
             ORDER BY sort_order ASC, id ASC'
        )->fetchAll();

        $categoriesByGroup = [];
        foreach ($categories as $category) {
            $categoriesByGroup[(int)$category['group_id']][] = $category;
        }
        $itemsByCategory = [];
        foreach ($items as $item) {
            $itemsByCategory[(int)$item['category_id']][] = $item;
        }
        $featuresByItem = [];
        foreach ($features as $feature) {
            $featuresByItem[(int)$feature['service_item_id']][] = (string)$feature['feature_text'];
        }

        $output = [];
        foreach ($groups as $group) {
            $subServices = [];
            foreach ($categoriesByGroup[(int)$group['id']] ?? [] as $category) {
                $subServices[] = [
                    'id' => (string) ($category['category_key'] ?: $category['id']),
                    'title' => (string) $category['title'],
                    'items' => self::buildItems(
                        $itemsByCategory[(int)$category['id']] ?? [],
                        $featuresByItem
                    ),
                ];
            }

            $output[(string) $group['service_key']] = [
                'title' => (string) $group['title'],
                'hero_image' => (string) ($group['hero_image'] ?? ''),
                'hero_text' => (string) ($group['hero_text'] ?? ''),
                'sub_services' => $subServices,
            ];
        }

        return $output;
    }

    private static function buildItems(array $rows, array $featuresByItem): array
    {
        $children = [];
        $top = [];
        foreach ($rows as $row) {
            if ($row['parent_id'] === null) {
                $top[] = self::itemArray($row, $featuresByItem);
            } else {
                $children[(int) $row['parent_id']][] = self::itemArray($row, $featuresByItem);
            }
        }

        foreach ($top as &$item) {
            $id = (int) $item['_db_id'];
            if (!empty($children[$id])) {
                $item['subitems'] = $children[$id];
            }
            unset($item['_db_id']);
        }
        unset($item);

        foreach ($children as &$childItems) {
            foreach ($childItems as &$item) unset($item['_db_id']);
        }
        unset($childItems, $item);

        return $top;
    }

    private static function itemArray(array $row, array $featuresByItem): array
    {
        return [
            '_db_id' => (int) $row['id'],
            'id' => (string) ($row['service_key'] ?? ''),
            'title' => (string) $row['title'],
            'image' => (string) ($row['image_path'] ?? ''),
            'short_desc' => (string) ($row['short_description'] ?? ''),
            'why' => (string) ($row['why_description'] ?? ''),
            'features' => $featuresByItem[(int)$row['id']] ?? [],
        ];
    }
}
