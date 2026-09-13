<?php
declare(strict_types=1);

final class Navigation
{
    private static ?array $cache = null;

    public static function all(string $location = 'header'): array
    {
        $location = self::normalizeLocation($location);
        $key = $location;

        if (self::$cache !== null && array_key_exists($key, self::$cache)) {
            return self::$cache[$key];
        }

        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'SELECT id, parent_id, label, url, target, icon_class, sort_order, is_active
             FROM site_navigation
             WHERE location = ? AND is_active = 1
             ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([$location]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        self::$cache ??= [];
        self::$cache[$key] = self::tree($rows);
        return self::$cache[$key];
    }

    public static function flat(string $location = 'header', bool $includeInactive = false): array
    {
        $location = self::normalizeLocation($location);
        $sql = 'SELECT id, parent_id, location, label, url, target, icon_class, sort_order, is_active, created_at, updated_at
                FROM site_navigation
                WHERE location = ?';
        if (!$includeInactive) {
            $sql .= ' AND is_active = 1';
        }
        $sql .= ' ORDER BY sort_order ASC, id ASC';

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute([$location]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function clearCache(): void
    {
        self::$cache = null;
    }

    private static function tree(array $rows): array
    {
        $byParent = [];
        foreach ($rows as $row) {
            $parent = $row['parent_id'] === null ? 0 : (int)$row['parent_id'];
            $byParent[$parent][] = $row;
        }

        $build = static function (int $parentId) use (&$build, $byParent): array {
            $items = [];
            foreach ($byParent[$parentId] ?? [] as $row) {
                $row['children'] = $build((int)$row['id']);
                $items[] = $row;
            }
            return $items;
        };

        return $build(0);
    }

    private static function normalizeLocation(string $location): string
    {
        $location = strtolower(trim($location));
        if (!in_array($location, ['header', 'footer'], true)) {
            throw new InvalidArgumentException('Invalid navigation location.');
        }
        return $location;
    }
}
