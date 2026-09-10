<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class SectorFrontend
{
    public static function all(): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->query(
            'SELECT * FROM sectors WHERE is_active = 1 ORDER BY sort_order ASC, id ASC'
        );

        $result = [];

        foreach ($stmt->fetchAll() as $row) {
            $sectorId = (int) $row['id'];

            $sector = [
                'title' => (string) ($row['title'] ?? ''),
                'hero' => [
                    'tag' => (string) ($row['hero_tag'] ?? ''),
                    'headline' => (string) ($row['hero_headline'] ?? ''),
                    'sub' => (string) ($row['hero_subtitle'] ?? ''),
                    'cta_text' => (string) ($row['hero_cta_text'] ?? ''),
                    'cta_link' => (string) ($row['hero_cta_link'] ?? ''),
                    'image' => (string) ($row['hero_image'] ?? ''),
                ],
                'stats' => self::sectorStats($pdo, $sectorId),
                'why' => self::columnValues($pdo, 'sector_why', 'text_content', 'sector_id', $sectorId),
                'areas' => self::columnValues($pdo, 'sector_areas', 'title', 'sector_id', $sectorId),
                'project' => [
                    'name' => (string) ($row['featured_project_name'] ?? ''),
                    'image' => (string) ($row['featured_project_image'] ?? ''),
                    'cta_text' => (string) ($row['featured_project_cta_text'] ?? ''),
                    'cta_link' => (string) ($row['featured_project_cta_link'] ?? ''),
                ],
                'description' => self::restoreDescription((string) ($row['description'] ?? '')),
            ];

            $sections = self::sections($pdo, $sectorId);
            if ($sections !== []) {
                $sector['sections'] = $sections;
            }

            $result[(string) $row['sector_key']] = $sector;
        }

        return $result;
    }

    private static function sectorStats(PDO $pdo, int $sectorId): array
    {
        $stmt = $pdo->prepare(
            'SELECT value_text, label FROM sector_stats
             WHERE sector_id = :sector_id ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':sector_id' => $sectorId]);

        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $result[] = [
                'value' => (string) $row['value_text'],
                'label' => (string) $row['label'],
            ];
        }
        return $result;
    }

    private static function columnValues(
        PDO $pdo,
        string $table,
        string $valueColumn,
        string $foreignKey,
        int $sectorId
    ): array {
        $stmt = $pdo->prepare(
            "SELECT {$valueColumn} FROM {$table}
             WHERE {$foreignKey} = :sector_id
             ORDER BY sort_order ASC, id ASC"
        );
        $stmt->execute([':sector_id' => $sectorId]);
        return array_map(
            static fn(array $row): string => (string) $row[$valueColumn],
            $stmt->fetchAll()
        );
    }

    private static function sections(PDO $pdo, int $sectorId): array
    {
        $stmt = $pdo->prepare(
            'SELECT id, legacy_id, title, category, content
             FROM sector_sections
             WHERE sector_id = :sector_id AND is_active = 1
             ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':sector_id' => $sectorId]);

        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $sectionId = (int) $row['id'];

            $images = $pdo->prepare(
                'SELECT image_path FROM sector_section_images
                 WHERE section_id = :section_id ORDER BY sort_order ASC, id ASC'
            );
            $images->execute([':section_id' => $sectionId]);

            $stats = $pdo->prepare(
                'SELECT value_text, label FROM sector_section_stats
                 WHERE section_id = :section_id ORDER BY sort_order ASC, id ASC'
            );
            $stats->execute([':section_id' => $sectionId]);

            $sectionStats = [];
            foreach ($stats->fetchAll() as $stat) {
                $sectionStats[] = [
                    'value' => (string) $stat['value_text'],
                    'label' => (string) $stat['label'],
                ];
            }

            $result[] = [
                'id' => (string) ($row['legacy_id'] ?? ''),
                'title' => (string) $row['title'],
                'category' => (string) ($row['category'] ?? ''),
                'content' => (string) ($row['content'] ?? ''),
                'image' => array_map(
                    static fn(array $image): string => (string) $image['image_path'],
                    $images->fetchAll()
                ),
                'stats' => $sectionStats,
            ];
        }

        return $result;
    }

    private static function restoreDescription(string $value): mixed
    {
        if (str_starts_with($value, '__SC_ARRAY__')) {
            $decoded = json_decode(substr($value, 12), true);
            return is_array($decoded) ? $decoded : $value;
        }

        return $value;
    }
}
