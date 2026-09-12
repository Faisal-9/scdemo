<?php
declare(strict_types=1);

final class SiteSettings
{
    /** @var array<string,array{value:?string,type:string,description:?string}>|null */
    private static ?array $cache = null;

    /**
     * Return one setting or the provided fallback.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::load();
        if (!isset(self::$cache[$key])) {
            return $default;
        }

        $row = self::$cache[$key];
        $value = $row['value'];
        return match ($row['type']) {
            'boolean' => in_array(strtolower((string)$value), ['1', 'true', 'yes', 'on'], true),
            'number' => is_numeric($value) ? (str_contains((string)$value, '.') ? (float)$value : (int)$value) : $default,
            default => $value,
        };
    }

    /** @return array<string,array{value:?string,type:string,description:?string}> */
    public static function all(): array
    {
        self::load();
        return self::$cache ?? [];
    }

    public static function clearCache(): void
    {
        self::$cache = null;
    }

    /**
     * Read settings directly from PDO. Works with the existing Database::connection() implementation.
     */
    private static function load(): void
    {
        if (self::$cache !== null) {
            return;
        }

        $pdo = Database::connection();
        $stmt = $pdo->query(
            'SELECT setting_key, setting_value, setting_type, description
             FROM site_settings
             ORDER BY setting_key ASC'
        );

        self::$cache = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $key = (string)$row['setting_key'];
            self::$cache[$key] = [
                'value' => $row['setting_value'] !== null ? (string)$row['setting_value'] : null,
                'type' => (string)$row['setting_type'],
                'description' => $row['description'] !== null ? (string)$row['description'] : null,
            ];
        }
    }
}
