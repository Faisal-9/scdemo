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

        $output = [];
        foreach ($groups as $group) {
            $categories = $pdo->prepare(
                'SELECT id, category_key, title
                 FROM service_categories
                 WHERE group_id = :group_id AND is_active = 1
                 ORDER BY sort_order ASC, id ASC'
            );
            $categories->execute([':group_id' => (int) $group['id']]);

            $subServices = [];
            foreach ($categories->fetchAll() as $category) {
                $subServices[] = [
                    'id' => (string) ($category['category_key'] ?: $category['id']),
                    'title' => (string) $category['title'],
                    'items' => self::buildItems($pdo, (int) $category['id']),
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

    private static function buildItems(PDO $pdo, int $categoryId): array
    {
        $stmt = $pdo->prepare(
            'SELECT id, parent_id, service_key, title, image_path, short_description, why_description
             FROM service_items
             WHERE category_id = :category_id AND is_active = 1
             ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':category_id' => $categoryId]);
        $rows = $stmt->fetchAll();

        $children = [];
        $top = [];
        foreach ($rows as $row) {
            if ($row['parent_id'] === null) {
                $top[] = self::itemArray($pdo, $row);
            } else {
                $children[(int) $row['parent_id']][] = self::itemArray($pdo, $row);
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

    private static function itemArray(PDO $pdo, array $row): array
    {
        $stmt = $pdo->prepare(
            'SELECT feature_text
             FROM service_features
             WHERE service_item_id = :item_id
             ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':item_id' => (int) $row['id']]);

        return [
            '_db_id' => (int) $row['id'],
            'id' => (string) ($row['service_key'] ?? ''),
            'title' => (string) $row['title'],
            'image' => (string) ($row['image_path'] ?? ''),
            'short_desc' => (string) ($row['short_description'] ?? ''),
            'why' => (string) ($row['why_description'] ?? ''),
            'features' => array_map(
                static fn(array $feature): string => (string) $feature['feature_text'],
                $stmt->fetchAll()
            ),
        ];
    }
}
