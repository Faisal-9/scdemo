<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit("This script must be run from the command line." . PHP_EOL);
}

require_once __DIR__ . '/../app/config/config.php';

$services = [];
require __DIR__ . '/../includes/data/servicesdata.php';

$pdo = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
    DB_USER,
    DB_PASS,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);

$findCategory = $pdo->prepare(
    'SELECT sc.id
     FROM service_categories sc
     INNER JOIN service_groups sg ON sg.id = sc.group_id
     WHERE sg.service_key = :service_key AND sc.category_key = :category_key
     LIMIT 1'
);
$findParent = $pdo->prepare(
    'SELECT id
     FROM service_items
     WHERE category_id = :category_id AND parent_id IS NULL AND title = :title
     LIMIT 1'
);
$findChild = $pdo->prepare(
    'SELECT id
     FROM service_items
     WHERE category_id = :category_id AND parent_id = :parent_id AND title = :title
     LIMIT 1'
);
$insertItem = $pdo->prepare(
    'INSERT INTO service_items
        (category_id, parent_id, service_key, title, image_path, short_description, why_description, sort_order, is_active)
     VALUES
        (:category_id, :parent_id, :service_key, :title, :image_path, :short_description, :why_description, :sort_order, 1)'
);
$insertFeature = $pdo->prepare(
    'INSERT INTO service_features (service_item_id, feature_text, sort_order)
     VALUES (:service_item_id, :feature_text, :sort_order)'
);

$pdo->beginTransaction();
$inserted = 0;

try {
    foreach ($services as $serviceKey => $service) {
        foreach ($service['sub_services'] ?? [] as $category) {
            $categoryKey = (string)($category['id'] ?? '');
            $findCategory->execute([
                ':service_key' => $serviceKey,
                ':category_key' => $categoryKey,
            ]);
            $categoryId = $findCategory->fetchColumn();

            if ($categoryId === false) {
                continue;
            }

            foreach ($category['items'] ?? [] as $parent) {
                $children = $parent['subitems'] ?? $parent['items'] ?? null;
                if (!is_array($children)) {
                    continue;
                }

                $findParent->execute([
                    ':category_id' => $categoryId,
                    ':title' => (string)($parent['title'] ?? ''),
                ]);
                $parentId = $findParent->fetchColumn();

                if ($parentId === false) {
                    continue;
                }

                foreach ($children as $sortOrder => $child) {
                    if (!is_array($child)) {
                        continue;
                    }

                    $title = (string)($child['title'] ?? '');
                    $findChild->execute([
                        ':category_id' => $categoryId,
                        ':parent_id' => $parentId,
                        ':title' => $title,
                    ]);
                    if ($findChild->fetchColumn() !== false) {
                        continue;
                    }

                    $image = $child['image'] ?? null;
                    if (is_array($image)) {
                        $image = $image[0] ?? null;
                    }

                    $insertItem->execute([
                        ':category_id' => $categoryId,
                        ':parent_id' => $parentId,
                        ':service_key' => $child['id'] ?? null,
                        ':title' => $title,
                        ':image_path' => $image,
                        ':short_description' => $child['short_desc'] ?? $child['text'] ?? null,
                        ':why_description' => $child['why'] ?? null,
                        ':sort_order' => (int)$sortOrder,
                    ]);
                    $childId = (int)$pdo->lastInsertId();
                    $inserted++;

                    foreach ($child['features'] ?? [] as $featureOrder => $feature) {
                        $feature = trim((string)$feature);
                        if ($feature === '') {
                            continue;
                        }
                        $insertFeature->execute([
                            ':service_item_id' => $childId,
                            ':feature_text' => $feature,
                            ':sort_order' => (int)$featureOrder,
                        ]);
                    }
                }
            }
        }
    }

    $pdo->commit();
    echo "Inserted {$inserted} nested service items." . PHP_EOL;
} catch (Throwable $e) {
    $pdo->rollBack();
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
}
