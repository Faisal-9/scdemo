<?php
declare(strict_types=1);

final class Seo
{
    private static array $cache = [];

    public static function find(string $pageKey): ?array
    {
        $pageKey = trim($pageKey);
        if ($pageKey === '') {
            return null;
        }
        if (array_key_exists($pageKey, self::$cache)) {
            return self::$cache[$pageKey];
        }

        $stmt = Database::connection()->prepare('SELECT * FROM page_seo WHERE page_key = ? AND is_active = 1 LIMIT 1');
        $stmt->execute([$pageKey]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        self::$cache[$pageKey] = $row ?: null;
        return self::$cache[$pageKey];
    }

    public static function meta(string $pageKey, array $fallback = []): array
    {
        $row = self::find($pageKey) ?? [];
        $keys = [
            'title','description','keywords','canonical_url','robots',
            'og_title','og_description','og_image','twitter_card'
        ];
        $out = [];
        foreach ($keys as $key) {
            $value = $row[$key] ?? null;
            if ($value === null || $value === '') {
                $value = $fallback[$key] ?? null;
            }
            $out[$key] = $value;
        }
        $out['page_key'] = $pageKey;
        return $out;
    }

    public static function clearCache(): void
    {
        self::$cache = [];
    }
}
