<?php
declare(strict_types=1);

final class Redirect
{
    private static ?array $map = null;

    public static function applyCurrentRequest(): void
    {
        $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $requestPath = '/' . ltrim($requestPath, '/');
        $requestPath = rtrim($requestPath, '/') ?: '/';
        $map = self::map();
        if (!isset($map[$requestPath])) return;
        $row = $map[$requestPath];
        $destination = (string)$row['destination_url'];
        if ((int)$row['preserve_query'] === 1 && !empty($_SERVER['QUERY_STRING'])) {
            $separator = str_contains($destination, '?') ? '&' : '?';
            $destination .= $separator . $_SERVER['QUERY_STRING'];
        }
        $status = (int)$row['status_code'];
        if (!in_array($status, [301,302,307,308], true)) $status = 301;
        header('Location: ' . $destination, true, $status);
        exit;
    }

    public static function clearCache(): void { self::$map = null; }

    private static function map(): array
    {
        if (self::$map !== null) return self::$map;
        $rows = Database::connection()->query('SELECT source_path,destination_url,status_code,preserve_query FROM url_redirects WHERE is_active=1 ORDER BY sort_order ASC,id ASC')->fetchAll(PDO::FETCH_ASSOC);
        self::$map = [];
        foreach ($rows as $row) {
            $path = '/' . ltrim((string)$row['source_path'], '/');
            $path = rtrim(parse_url($path, PHP_URL_PATH) ?: '/', '/') ?: '/';
            if (!isset(self::$map[$path])) self::$map[$path] = $row;
        }
        return self::$map;
    }
}
