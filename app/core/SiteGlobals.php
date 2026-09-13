<?php
declare(strict_types=1);

final class SiteGlobals
{
    private static ?array $settings = null;

    public static function all(): array
    {
        if (self::$settings !== null) {
            return self::$settings;
        }

        $pdo = Database::connection();
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
        $rows = $stmt->fetchAll();

        self::$settings = [];
        foreach ($rows as $row) {
            self::$settings[(string)$row['setting_key']] = $row['setting_value'];
        }

        return self::$settings;
    }

    public static function get(string $key, ?string $fallback = null): ?string
    {
        $settings = self::all();
        return array_key_exists($key, $settings) ? (string)$settings[$key] : $fallback;
    }

    public static function text(string $key, string $fallback = ''): string
    {
        return self::get($key, $fallback) ?? $fallback;
    }
}
