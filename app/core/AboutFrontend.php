<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/AboutManager.php';

final class AboutFrontend
{
    /**
     * Rebuild the exact associative-array contract used by includes/aboutSection.php.
     * Missing/legacy is_active columns are treated as active for backwards compatibility.
     */
    public static function data(): array
    {
        $sectionTitles = [];
        foreach (AboutManager::sections() as $row) {
            if ((int)($row['is_active'] ?? 1) !== 1) {
                continue;
            }
            $sectionTitles[(string)($row['legacy_id'] ?? '')] = (string)($row['title'] ?? '');
        }

        $general = AboutManager::generalInfo() ?? [];
        $mv = AboutManager::missionVision() ?? [];
        $hseRow = AboutManager::hse() ?? [];
        $profile = AboutManager::companyProfile() ?? [];

        $timelineRows = self::activeRows(AboutManager::timeline());
        $coreRows = self::activeRows(AboutManager::coreValues());
        $clientRows = self::activeRows(AboutManager::items('clients'));
        $certificateRows = self::activeRows(AboutManager::items('certificates'));
        $awardRows = self::activeRows(AboutManager::items('awards'));
        $sisterRows = self::activeRows(AboutManager::items('sister'));

        $generalInfo = [
            'title' => self::sectionTitle($sectionTitles, 'general-info', $general['title'] ?? ''),
            'content' => (string)($general['content'] ?? ''),
            'items' => array_map(
                static fn(array $row): array => [
                    'year' => (string)($row['year'] ?? ''),
                    'title' => (string)($row['title'] ?? ''),
                    'description' => (string)($row['description'] ?? ''),
                    'img' => (string)($row['image_path'] ?? ''),
                ],
                $timelineRows
            ),
        ];

        $missionVision = [
            'title' => self::sectionTitle($sectionTitles, 'mission-vision', $mv['title'] ?? ''),
            'mission' => (string)($mv['mission'] ?? ''),
            'mission_img' => (string)($mv['mission_img'] ?? ''),
            'vision' => (string)($mv['vision'] ?? ''),
            'vision_img' => (string)($mv['vision_img'] ?? ''),
            'core_values_img' => (string)($mv['core_values_img'] ?? ''),
            'core_values' => array_values(array_map(
                static fn(array $row): string => (string)($row['value_text'] ?? ''),
                $coreRows
            )),
        ];

        $clients = [
            'title' => self::sectionTitle($sectionTitles, 'clients', 'Clients'),
            'items' => array_map(
                static fn(array $row): array => ['logo' => (string)($row['logo_path'] ?? '')],
                $clientRows
            ),
        ];

        $certificates = [
            'title' => self::sectionTitle($sectionTitles, 'certificates', 'ISO Certifications'),
            'items' => array_map(
                static fn(array $row): array => [
                    'name' => (string)($row['name'] ?? ''),
                    'logo' => (string)($row['logo_path'] ?? ''),
                ],
                $certificateRows
            ),
        ];

        $awards = [
            'title' => self::sectionTitle($sectionTitles, 'awards', 'Awards & Recognitions'),
            'items' => array_map(
                static fn(array $row): array => [
                    'name' => (string)($row['name'] ?? ''),
                    'logo' => (string)($row['logo_path'] ?? ''),
                ],
                $awardRows
            ),
        ];

        $sisterCompanies = [
            'title' => self::sectionTitle($sectionTitles, 'sister', 'Affiliated Companies'),
            'items' => array_map(
                static fn(array $row): array => [
                    'name' => (string)($row['name'] ?? ''),
                    'logo' => (string)($row['logo_path'] ?? ''),
                ],
                $sisterRows
            ),
        ];

        $hse = [
            'title' => self::sectionTitle($sectionTitles, 'hse', $hseRow['title'] ?? ''),
            'content' => (string)($hseRow['content'] ?? ''),
        ];

        $cprofile = [
            'title' => self::sectionTitle($sectionTitles, 'cprofile', $profile['title'] ?? ''),
            'content' => (string)($profile['content'] ?? ''),
            'link' => (string)($profile['link'] ?? ''),
        ];

        return compact(
            'generalInfo',
            'missionVision',
            'clients',
            'certificates',
            'awards',
            'sisterCompanies',
            'hse',
            'cprofile'
        );
    }

    private static function activeRows(array $rows): array
    {
        return array_values(array_filter(
            $rows,
            static fn(array $row): bool => (int)($row['is_active'] ?? 1) === 1
        ));
    }

    private static function sectionTitle(array $titles, string $key, string $fallback): string
    {
        $title = trim((string)($titles[$key] ?? ''));
        return $title !== '' ? $title : (string)$fallback;
    }
}
