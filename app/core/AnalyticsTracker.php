<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class AnalyticsTracker
{
    private static bool $tracked = false;

    public static function track(string $pageTitle = '', ?string $pageKey = null): void
    {
        if (self::$tracked || PHP_SAPI === 'cli' || ($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
            return;
        }
        self::$tracked = true;

        $userAgent = (string)($_SERVER['HTTP_USER_AGENT'] ?? '');
        if ($userAgent !== '' && preg_match('/bot|crawl|spider|slurp|headless|preview/i', $userAgent)) {
            return;
        }

        $visitorToken = (string)($_COOKIE['sc_visitor'] ?? '');
        if ($visitorToken === '' || !preg_match('/^[a-f0-9]{32}$/', $visitorToken)) {
            $visitorToken = bin2hex(random_bytes(16));
            setcookie('sc_visitor', $visitorToken, [
                'expires' => time() + 31536000,
                'path' => '/',
                'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        }

        $salt = defined('ANALYTICS_HASH_SALT') ? ANALYTICS_HASH_SALT : 'state-corps-local-analytics';
        $visitorHash = hash('sha256', $visitorToken . '|' . $salt);
        $path = substr((string)parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), 0, 500);
        $referrerHost = '';
        $referrer = trim((string)($_SERVER['HTTP_REFERER'] ?? ''));
        if ($referrer !== '') {
            $referrerHost = substr((string)(parse_url($referrer, PHP_URL_HOST) ?: ''), 0, 255);
        }

        $device = self::deviceType($userAgent);
        $stmt = Database::connection()->prepare(
            'INSERT INTO analytics_page_views
             (visitor_hash, page_path, page_key, page_title, referrer_host, device_type)
             VALUES (:visitor_hash, :page_path, :page_key, :page_title, :referrer_host, :device_type)'
        );
        $stmt->execute([
            ':visitor_hash' => $visitorHash,
            ':page_path' => $path !== '' ? $path : '/',
            ':page_key' => $pageKey !== null ? substr($pageKey, 0, 100) : null,
            ':page_title' => $pageTitle !== '' ? substr($pageTitle, 0, 255) : null,
            ':referrer_host' => $referrerHost !== '' ? $referrerHost : null,
            ':device_type' => $device,
        ]);
    }

    private static function deviceType(string $userAgent): string
    {
        if ($userAgent === '') return 'unknown';
        if (preg_match('/tablet|ipad|playbook|silk/i', $userAgent)) return 'tablet';
        if (preg_match('/mobile|iphone|ipod|android/i', $userAgent)) return 'mobile';
        return 'desktop';
    }
}
