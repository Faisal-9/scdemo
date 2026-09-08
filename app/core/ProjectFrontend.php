<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class ProjectFrontend
{
    /**
     * Return published projects in the same associative-array shape used by
     * the current static projectsdata.php file.
     */
    public static function all(): array
    {
        $pdo = Database::connection();

        $stmt = $pdo->query(
            'SELECT
                id,
                legacy_id,
                name,
                sector_name,
                category,
                status,
                completion_year,
                location,
                client,
                description,
                show_on_home,
                show_in_category_image,
                thumbnail_path
             FROM projects
             WHERE published = 1
             ORDER BY sort_order ASC, id ASC'
        );

        $rows = $stmt->fetchAll();
        $projects = [];

        foreach ($rows as $row) {
            $projects[] = self::toLegacyShape($row);
        }

        return $projects;
    }

    public static function findByLegacyId(string $legacyId): ?array
    {
        $pdo = Database::connection();

        $stmt = $pdo->prepare(
            'SELECT
                id,
                legacy_id,
                name,
                sector_name,
                category,
                status,
                completion_year,
                location,
                client,
                description,
                show_on_home,
                show_in_category_image,
                thumbnail_path
             FROM projects
             WHERE published = 1
               AND legacy_id = :legacy_id
             LIMIT 1'
        );

        $stmt->execute([':legacy_id' => $legacyId]);
        $row = $stmt->fetch();

        if (!is_array($row)) {
            return null;
        }

        return self::toLegacyShape($row);
    }

    public static function projectHero(): array
    {
        $pdo = Database::connection();

        $settingStmt = $pdo->query(
            "SELECT setting_key, setting_value
             FROM site_settings
             WHERE setting_key IN (
                 'projects_hero_background',
                 'projects_hero_title',
                 'projects_hero_subtitle'
             )"
        );

        $settings = [];
        foreach ($settingStmt->fetchAll() as $row) {
            $settings[(string) $row['setting_key']] = (string) ($row['setting_value'] ?? '');
        }

        $statsStmt = $pdo->query(
            "SELECT setting_key, setting_value
             FROM site_settings
             WHERE setting_key LIKE 'projects_hero_stat_%_count'
                OR setting_key LIKE 'projects_hero_stat_%_label'
             ORDER BY setting_key ASC"
        );

        $statsRaw = [];
        foreach ($statsStmt->fetchAll() as $row) {
            $key = (string) $row['setting_key'];
            $value = (string) ($row['setting_value'] ?? '');

            if (preg_match('/^projects_hero_stat_(\d+)_(count|label)$/', $key, $matches)) {
                $index = (int) $matches[1];
                $field = $matches[2];
                $statsRaw[$index][$field] = $value;
            }
        }

        ksort($statsRaw);

        $stats = [];
        foreach ($statsRaw as $stat) {
            if (!isset($stat['count']) && !isset($stat['label'])) {
                continue;
            }

            $stats[] = [
                'count' => (string) ($stat['count'] ?? ''),
                'label' => (string) ($stat['label'] ?? ''),
            ];
        }

        return [
            'background' => $settings['projects_hero_background'] ?? 'assets/images/slider_04.jpg',
            'title' => $settings['projects_hero_title'] ?? 'Turning Ambition Into <span>Lasting</span> Impact',
            'subtitle' => $settings['projects_hero_subtitle'] ?? 'Delivering infrastructure, power & energy, mining, and development projects across regions.',
            'stats' => $stats,
        ];
    }

    private static function toLegacyShape(array $row): array
    {
        return [
            'id' => (string) ($row['legacy_id'] ?? ''),
            'name' => (string) ($row['name'] ?? ''),
            'sector' => (string) ($row['sector_name'] ?? ''),
            'category' => (string) ($row['category'] ?? ''),
            'status' => (string) ($row['status'] ?? ''),
            'completion-year' => $row['completion_year'] ?? null,
            'location' => (string) ($row['location'] ?? ''),
            'client' => (string) ($row['client'] ?? ''),
            'inhome' => (int) ($row['show_on_home'] ?? 0) === 1 ? 'yes' : 'no',
            'catimage' => (int) ($row['show_in_category_image'] ?? 0) === 1 ? 'yes' : 'no',
            'thumbnail' => (string) ($row['thumbnail_path'] ?? ''),
            'images' => self::images((int) $row['id']),
            'description' => (string) ($row['description'] ?? ''),
            'scope' => self::scope((int) $row['id']),
        ];
    }

    private static function images(int $projectId): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'SELECT image_path
             FROM project_images
             WHERE project_id = :project_id
             ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':project_id' => $projectId]);

        return array_map(
            static fn($value): string => (string) $value,
            $stmt->fetchAll(PDO::FETCH_COLUMN)
        );
    }

    private static function scope(int $projectId): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'SELECT scope_text
             FROM project_scope
             WHERE project_id = :project_id
             ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':project_id' => $projectId]);

        return array_map(
            static fn($value): string => (string) $value,
            $stmt->fetchAll(PDO::FETCH_COLUMN)
        );
    }
}
