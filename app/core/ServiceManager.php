<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';

final class ServiceManager
{
    public static function groups(): array
    {
        $stmt = Database::connection()->query(
            'SELECT id, service_key, title, hero_image, hero_text, sort_order, is_active
             FROM service_groups
             ORDER BY sort_order ASC, id ASC'
        );
        return $stmt->fetchAll();
    }

    public static function group(int $id): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT * FROM service_groups WHERE id = :id LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return is_array($row) ? $row : null;
    }

    public static function categories(int $groupId): array
    {
        $stmt = Database::connection()->prepare(
            'SELECT * FROM service_categories
             WHERE group_id = :group_id
             ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':group_id' => $groupId]);
        return $stmt->fetchAll();
    }

    public static function category(int $id): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT sc.*, sg.title AS group_title
             FROM service_categories sc
             INNER JOIN service_groups sg ON sg.id = sc.group_id
             WHERE sc.id = :id
             LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return is_array($row) ? $row : null;
    }

    public static function items(int $categoryId, ?int $parentId = null): array
    {
        $pdo = Database::connection();
        if ($parentId === null) {
            $stmt = $pdo->prepare(
                'SELECT * FROM service_items
                 WHERE category_id = :category_id AND parent_id IS NULL
                 ORDER BY sort_order ASC, id ASC'
            );
            $stmt->execute([':category_id' => $categoryId]);
        } else {
            $stmt = $pdo->prepare(
                'SELECT * FROM service_items
                 WHERE category_id = :category_id AND parent_id = :parent_id
                 ORDER BY sort_order ASC, id ASC'
            );
            $stmt->execute([
                ':category_id' => $categoryId,
                ':parent_id' => $parentId,
            ]);
        }
        return $stmt->fetchAll();
    }

    public static function item(int $id): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT si.*, sc.title AS category_title, sc.group_id, sg.title AS group_title
             FROM service_items si
             INNER JOIN service_categories sc ON sc.id = si.category_id
             INNER JOIN service_groups sg ON sg.id = sc.group_id
             WHERE si.id = :id
             LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return is_array($row) ? $row : null;
    }

    public static function features(int $itemId): array
    {
        $stmt = Database::connection()->prepare(
            'SELECT * FROM service_features
             WHERE service_item_id = :item_id
             ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':item_id' => $itemId]);
        return $stmt->fetchAll();
    }

    public static function createGroup(string $key, string $title, string $heroImage, string $heroText, int $sortOrder, bool $active): int
    {
        $key = self::normalizeKey($key);
        $title = trim($title);
        self::validateKey($key, 'Service group key');
        self::validateTitle($title, 'Service group title');

        $pdo = Database::connection();
        self::assertGroupKeyAvailable($key);

        $stmt = $pdo->prepare(
            'INSERT INTO service_groups
                (service_key, title, hero_image, hero_text, sort_order, is_active)
             VALUES
                (:service_key, :title, :hero_image, :hero_text, :sort_order, :is_active)'
        );
        $stmt->execute([
            ':service_key' => $key,
            ':title' => $title,
            ':hero_image' => self::nullable($heroImage),
            ':hero_text' => self::nullable($heroText),
            ':sort_order' => $sortOrder,
            ':is_active' => $active ? 1 : 0,
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function updateGroup(int $id, string $key, string $title, string $heroImage, string $heroText, int $sortOrder, bool $active): void
    {
        $group = self::group($id);
        if ($group === null) throw new RuntimeException('Service group not found.');
        $key = self::normalizeKey($key);
        $title = trim($title);
        self::validateKey($key, 'Service group key');
        self::validateTitle($title, 'Service group title');
        self::assertGroupKeyAvailable($key, $id);

        $stmt = Database::connection()->prepare(
            'UPDATE service_groups
             SET service_key = :service_key,
                 title = :title,
                 hero_image = :hero_image,
                 hero_text = :hero_text,
                 sort_order = :sort_order,
                 is_active = :is_active
             WHERE id = :id'
        );
        $stmt->execute([
            ':service_key' => $key,
            ':title' => $title,
            ':hero_image' => self::nullable($heroImage),
            ':hero_text' => self::nullable($heroText),
            ':sort_order' => $sortOrder,
            ':is_active' => $active ? 1 : 0,
            ':id' => $id,
        ]);
    }

    public static function createCategory(int $groupId, string $key, string $title, int $sortOrder, bool $active): int
    {
        if (self::group($groupId) === null) throw new RuntimeException('Service group not found.');
        $key = self::normalizeOptionalKey($key);
        $title = trim($title);
        self::validateTitle($title, 'Category title');
        if ($key !== null) self::assertCategoryKeyAvailable($groupId, $key);

        $stmt = Database::connection()->prepare(
            'INSERT INTO service_categories
                (group_id, category_key, title, sort_order, is_active)
             VALUES
                (:group_id, :category_key, :title, :sort_order, :is_active)'
        );
        $stmt->execute([
            ':group_id' => $groupId,
            ':category_key' => $key,
            ':title' => $title,
            ':sort_order' => $sortOrder,
            ':is_active' => $active ? 1 : 0,
        ]);
        return (int) Database::connection()->lastInsertId();
    }

    public static function updateCategory(int $id, string $key, string $title, int $sortOrder, bool $active): void
    {
        $category = self::category($id);
        if ($category === null) throw new RuntimeException('Service category not found.');
        $key = self::normalizeOptionalKey($key);
        $title = trim($title);
        self::validateTitle($title, 'Category title');
        if ($key !== null) self::assertCategoryKeyAvailable((int) $category['group_id'], $key, $id);

        $stmt = Database::connection()->prepare(
            'UPDATE service_categories
             SET category_key = :category_key,
                 title = :title,
                 sort_order = :sort_order,
                 is_active = :is_active
             WHERE id = :id'
        );
        $stmt->execute([
            ':category_key' => $key,
            ':title' => $title,
            ':sort_order' => $sortOrder,
            ':is_active' => $active ? 1 : 0,
            ':id' => $id,
        ]);
    }

    public static function createItem(
        int $categoryId,
        ?int $parentId,
        string $key,
        string $title,
        string $image,
        string $shortDescription,
        string $why,
        array $features,
        int $sortOrder,
        bool $active
    ): int {
        if (self::category($categoryId) === null) throw new RuntimeException('Service category not found.');
        if ($parentId !== null) {
            $parent = self::item($parentId);
            if ($parent === null || (int) $parent['category_id'] !== $categoryId) {
                throw new RuntimeException('Invalid parent service item.');
            }
        }

        $key = self::normalizeOptionalKey($key);
        $title = trim($title);
        self::validateTitle($title, 'Service item title');

        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO service_items
                    (category_id, parent_id, service_key, title, image_path, short_description, why_description, sort_order, is_active)
                 VALUES
                    (:category_id, :parent_id, :service_key, :title, :image_path, :short_description, :why_description, :sort_order, :is_active)'
            );
            $stmt->execute([
                ':category_id' => $categoryId,
                ':parent_id' => $parentId,
                ':service_key' => $key,
                ':title' => $title,
                ':image_path' => self::nullable($image),
                ':short_description' => self::nullable($shortDescription),
                ':why_description' => self::nullable($why),
                ':sort_order' => $sortOrder,
                ':is_active' => $active ? 1 : 0,
            ]);
            $itemId = (int) $pdo->lastInsertId();
            self::replaceFeatures($pdo, $itemId, $features);
            $pdo->commit();
            return $itemId;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    public static function updateItem(
        int $id,
        ?int $parentId,
        string $key,
        string $title,
        string $image,
        string $shortDescription,
        string $why,
        array $features,
        int $sortOrder,
        bool $active
    ): void {
        $item = self::item($id);
        if ($item === null) throw new RuntimeException('Service item not found.');
        $categoryId = (int) $item['category_id'];
        if ($parentId !== null) {
            if ($parentId === $id) throw new RuntimeException('A service item cannot be its own parent.');
            $parent = self::item($parentId);
            if ($parent === null || (int) $parent['category_id'] !== $categoryId) throw new RuntimeException('Invalid parent service item.');
            if (self::isDescendant($parentId, $id)) throw new RuntimeException('Invalid parent: this would create a hierarchy cycle.');
        }
        $key = self::normalizeOptionalKey($key);
        $title = trim($title);
        self::validateTitle($title, 'Service item title');

        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare(
                'UPDATE service_items
                 SET parent_id = :parent_id,
                     service_key = :service_key,
                     title = :title,
                     image_path = :image_path,
                     short_description = :short_description,
                     why_description = :why_description,
                     sort_order = :sort_order,
                     is_active = :is_active
                 WHERE id = :id'
            );
            $stmt->execute([
                ':parent_id' => $parentId,
                ':service_key' => $key,
                ':title' => $title,
                ':image_path' => self::nullable($image),
                ':short_description' => self::nullable($shortDescription),
                ':why_description' => self::nullable($why),
                ':sort_order' => $sortOrder,
                ':is_active' => $active ? 1 : 0,
                ':id' => $id,
            ]);
            self::replaceFeatures($pdo, $id, $features);
            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    public static function deleteItem(int $id): void
    {
        $item = self::item($id);

        if ($item === null) {
            throw new RuntimeException(
                'Service item not found.'
            );
        }

        $pdo = Database::connection();

        $pdo->beginTransaction();

        try {

            /*
         * First delete every descendant.
         */
            self::deleteItemChildren(
                $pdo,
                $id
            );

            /*
         * Delete features belonging to the current item.
         */
            $deleteFeatures = $pdo->prepare(
                'DELETE FROM service_features
             WHERE service_item_id = :item_id'
            );

            $deleteFeatures->execute([
                ':item_id' => $id,
            ]);

            /*
         * Finally delete the actual service item.
         */
            $deleteItem = $pdo->prepare(
                'DELETE FROM service_items
             WHERE id = :id'
            );

            $deleteItem->execute([
                ':id' => $id,
            ]);

            if ($deleteItem->rowCount() !== 1) {
                throw new RuntimeException(
                    'The service item could not be deleted.'
                );
            }

            $pdo->commit();
        } catch (Throwable $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            throw $e;
        }
    }

    private static function deleteItemChildren(
        PDO $pdo,
        int $parentId
    ): void {

        $stmt = $pdo->prepare(
            'SELECT id
         FROM service_items
         WHERE parent_id = :parent_id
         ORDER BY id DESC'
        );

        $stmt->execute([
            ':parent_id' => $parentId,
        ]);

        $children = $stmt->fetchAll(
            PDO::FETCH_COLUMN
        );

        foreach ($children as $childId) {

            $childId = (int) $childId;

            /*
         * Delete deeper descendants first.
         */
            self::deleteItemChildren(
                $pdo,
                $childId
            );

            /*
         * Remove child features.
         */
            $deleteFeatures = $pdo->prepare(
                'DELETE FROM service_features
             WHERE service_item_id = :item_id'
            );

            $deleteFeatures->execute([
                ':item_id' => $childId,
            ]);

            /*
         * Remove child item.
         */
            $deleteItem = $pdo->prepare(
                'DELETE FROM service_items
             WHERE id = :id'
            );

            $deleteItem->execute([
                ':id' => $childId,
            ]);
        }
    }

    public static function deleteCategory(int $id): void
    {
        if (self::category($id) === null) throw new RuntimeException('Service category not found.');
        $stmt = Database::connection()->prepare('DELETE FROM service_categories WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public static function deleteGroup(int $id): void
    {
        if (self::group($id) === null) throw new RuntimeException('Service group not found.');
        $stmt = Database::connection()->prepare('DELETE FROM service_groups WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    private static function replaceFeatures(PDO $pdo, int $itemId, array $features): void
    {
        $pdo->prepare('DELETE FROM service_features WHERE service_item_id = :item_id')
            ->execute([':item_id' => $itemId]);
        $stmt = $pdo->prepare(
            'INSERT INTO service_features (service_item_id, feature_text, sort_order)
             VALUES (:item_id, :feature_text, :sort_order)'
        );
        $order = 0;
        foreach ($features as $feature) {
            $feature = trim((string) $feature);
            if ($feature === '') continue;
            $stmt->execute([
                ':item_id' => $itemId,
                ':feature_text' => $feature,
                ':sort_order' => $order++,
            ]);
        }
    }

    private static function isDescendant(int $candidateParent, int $itemId): bool
    {
        $current = $candidateParent;
        while (true) {
            $row = self::item($current);
            if ($row === null || $row['parent_id'] === null) return false;
            $parentId = (int) $row['parent_id'];
            if ($parentId === $itemId) return true;
            $current = $parentId;
        }
    }

    private static function assertGroupKeyAvailable(string $key, ?int $exceptId = null): void
    {
        $sql = 'SELECT id FROM service_groups WHERE service_key = :key';
        $params = [':key' => $key];
        if ($exceptId !== null) {
            $sql .= ' AND id != :except_id';
            $params[':except_id'] = $exceptId;
        }
        $sql .= ' LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        if ($stmt->fetchColumn() !== false) throw new RuntimeException('That service group key is already in use.');
    }

    private static function assertCategoryKeyAvailable(int $groupId, string $key, ?int $exceptId = null): void
    {
        $sql = 'SELECT id FROM service_categories WHERE group_id = :group_id AND category_key = :key';
        $params = [':group_id' => $groupId, ':key' => $key];
        if ($exceptId !== null) {
            $sql .= ' AND id != :except_id';
            $params[':except_id'] = $exceptId;
        }
        $sql .= ' LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        if ($stmt->fetchColumn() !== false) throw new RuntimeException('That category key is already used in this group.');
    }

    private static function normalizeKey(string $value): string
    {
        return strtolower(trim($value));
    }

    private static function normalizeOptionalKey(string $value): ?string
    {
        $value = strtolower(trim($value));
        return $value === '' ? null : $value;
    }

    private static function validateKey(string $key, string $label): void
    {
        if ($key === '' || !preg_match('/^[a-z0-9][a-z0-9-]*$/', $key)) {
            throw new RuntimeException($label . ' may contain lowercase letters, numbers and hyphens only.');
        }
    }

    private static function validateTitle(string $title, string $label): void
    {
        if ($title === '' || strlen($title) > 500) throw new RuntimeException($label . ' is required and must not exceed 500 characters.');
    }

    private static function nullable(string $value): ?string
    {
        $value = trim($value);
        return $value === '' ? null : $value;
    }
}
