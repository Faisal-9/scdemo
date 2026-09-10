<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class HomeFrontend
{
    /**
     * Recreates the exact variables expected by the existing homepage:
     * $heroSlides, $statsBg, $stats, $history, $whySC.
     */
    public static function data(): array
    {
        $pdo = Database::connection();

        $heroSlides = [];
        $stmt = $pdo->query(
            'SELECT legacy_id, title, description, image_path, indicator
             FROM home_hero_slides
             WHERE is_active = 1
             ORDER BY sort_order ASC, id ASC'
        );

        foreach ($stmt->fetchAll() as $row) {
            $heroSlides[] = [
                'id' => (string) ($row['legacy_id'] ?? ''),
                'title' => (string) $row['title'],
                'desc' => (string) ($row['description'] ?? ''),
                'image' => (string) $row['image_path'],
                'indicator' => $row['indicator'] !== null ? (string) $row['indicator'] : null,
            ];
        }

        $statsBg = self::setting(
            $pdo,
            'home_stats_background',
            'assets/images/home/whybg1.jpg'
        );

        $stats = [];
        $stmt = $pdo->query(
            'SELECT prefix, number_value, suffix, label
             FROM home_stats
             WHERE is_active = 1
             ORDER BY sort_order ASC, id ASC'
        );

        foreach ($stmt->fetchAll() as $row) {
            $number = (float) $row['number_value'];
            $numberValue = fmod($number, 1.0) === 0.0 ? (int) $number : $number;

            $item = [
                'number' => $numberValue,
                'suffix' => $row['suffix'] !== null ? (string) $row['suffix'] : null,
                'label' => (string) $row['label'],
            ];

            if ($row['prefix'] !== null && (string) $row['prefix'] !== '') {
                $item['prefix'] = (string) $row['prefix'];
            }

            $stats[] = $item;
        }

        $history = [];
        $stmt = $pdo->query(
            'SELECT year, title
             FROM home_history
             WHERE is_active = 1
             ORDER BY sort_order ASC, id ASC'
        );

        foreach ($stmt->fetchAll() as $row) {
            $history[] = [
                'year' => (string) $row['year'],
                'title' => (string) $row['title'],
            ];
        }

        $whySC = [];
        $tabsStmt = $pdo->query(
            'SELECT id, legacy_id, tab_name, title, image_path
             FROM home_why_tabs
             WHERE is_active = 1
             ORDER BY sort_order ASC, id ASC'
        );

        $itemsStmt = $pdo->prepare(
            'SELECT item_text
             FROM home_why_items
             WHERE tab_id = :tab_id
             ORDER BY sort_order ASC, id ASC'
        );

        foreach ($tabsStmt->fetchAll() as $row) {
            $tabId = (int) $row['id'];

            $itemsStmt->execute([':tab_id' => $tabId]);
            $texts = array_map(
                static fn(array $item): string => (string) $item['item_text'],
                $itemsStmt->fetchAll()
            );

            $legacyKey = (string) ($row['legacy_id'] ?? $row['id']);
            $tab = [
                'tabname' => (string) $row['tab_name'],
                'image' => $row['image_path'] !== null ? (string) $row['image_path'] : null,
            ];

            if ($row['title'] !== null && (string) $row['title'] !== '') {
                $tab['title'] = (string) $row['title'];
            }

            if ($texts !== []) {
                $tab['text'] = $texts;
            }

            $whySC[$legacyKey] = $tab;
        }

        return compact('heroSlides', 'statsBg', 'stats', 'history', 'whySC');
    }

    public static function loadIntoGlobals(): void
    {
        foreach (self::data() as $key => $value) {
            $GLOBALS[$key] = $value;
        }
    }

    private static function setting(PDO $pdo, string $key, string $fallback): string
    {
        $stmt = $pdo->prepare(
            'SELECT setting_value FROM site_settings WHERE setting_key = :key LIMIT 1'
        );
        $stmt->execute([':key' => $key]);
        $value = $stmt->fetchColumn();

        return $value === false || (string) $value === '' ? $fallback : (string) $value;
    }
}
