<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class AnalyticsManager
{
    public static function overview(int $days = 30): array
    {
        $days = max(1, min(365, $days));
        $pdo = Database::connection();
        $from = date('Y-m-d 00:00:00', strtotime('-' . ($days - 1) . ' days'));

        $stmt = $pdo->prepare(
            'SELECT COUNT(*) AS page_views, COUNT(DISTINCT visitor_hash) AS visitors
             FROM analytics_page_views WHERE created_at >= :from'
        );
        $stmt->execute([':from' => $from]);
        $totals = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['page_views' => 0, 'visitors' => 0];

        $todayStmt = $pdo->query(
            "SELECT COUNT(*) AS page_views, COUNT(DISTINCT visitor_hash) AS visitors
             FROM analytics_page_views WHERE created_at >= CURDATE()"
        );
        $today = $todayStmt->fetch(PDO::FETCH_ASSOC) ?: ['page_views' => 0, 'visitors' => 0];

        $dailyStmt = $pdo->prepare(
            'SELECT DATE(created_at) AS day, COUNT(*) AS page_views, COUNT(DISTINCT visitor_hash) AS visitors
             FROM analytics_page_views WHERE created_at >= :from
             GROUP BY DATE(created_at) ORDER BY day ASC'
        );
        $dailyStmt->execute([':from' => $from]);

        $topPagesStmt = $pdo->prepare(
            'SELECT page_path, COALESCE(NULLIF(page_title, \'\'), page_path) AS page_title,
                    COUNT(*) AS page_views, COUNT(DISTINCT visitor_hash) AS visitors
             FROM analytics_page_views WHERE created_at >= :from
             GROUP BY page_path, page_title ORDER BY page_views DESC LIMIT 10'
        );
        $topPagesStmt->execute([':from' => $from]);

        $referrersStmt = $pdo->prepare(
            'SELECT COALESCE(NULLIF(referrer_host, \'\'), \'Direct / unknown\') AS referrer,
                    COUNT(*) AS page_views
             FROM analytics_page_views WHERE created_at >= :from
             GROUP BY referrer_host ORDER BY page_views DESC LIMIT 10'
        );
        $referrersStmt->execute([':from' => $from]);

        $devicesStmt = $pdo->prepare('SELECT device_type, COUNT(*) AS page_views, COUNT(DISTINCT visitor_hash) AS visitors FROM analytics_page_views WHERE created_at >= :from GROUP BY device_type ORDER BY page_views DESC');
        $devicesStmt->execute([':from' => $from]);

        return [
            'days' => $days,
            'from' => $from,
            'today' => [
                'page_views' => (int)$today['page_views'],
                'visitors' => (int)$today['visitors'],
            ],
            'totals' => [
                'page_views' => (int)$totals['page_views'],
                'visitors' => (int)$totals['visitors'],
            ],
            'daily' => $dailyStmt->fetchAll(PDO::FETCH_ASSOC),
            'top_pages' => $topPagesStmt->fetchAll(PDO::FETCH_ASSOC),
            'referrers' => $referrersStmt->fetchAll(PDO::FETCH_ASSOC),
            'devices' => $devicesStmt->fetchAll(PDO::FETCH_ASSOC),
        ];
    }

    public static function deleteOlderThan(int $days): int
    {
        $days = max(30, min(3650, $days));
        $stmt = Database::connection()->prepare('DELETE FROM analytics_page_views WHERE created_at < DATE_SUB(NOW(), INTERVAL ' . $days . ' DAY)');
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function csv(int $days): void
    {
        $days = max(1, min(365, $days));
        $from = date('Y-m-d 00:00:00', strtotime('-' . ($days - 1) . ' days'));
        $stmt = Database::connection()->prepare('SELECT created_at,page_path,page_key,page_title,referrer_host,device_type FROM analytics_page_views WHERE created_at >= :from ORDER BY created_at ASC');
        $stmt->execute([':from' => $from]);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="analytics-' . $days . '-days.csv"');
        $out = fopen('php://output', 'wb');
        fputcsv($out, ['created_at','page_path','page_key','page_title','referrer_host','device_type']);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) fputcsv($out, $row);
        fclose($out);
        exit;
    }
}
