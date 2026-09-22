<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class AboutManager
{
    private const SECTION_ORDER = [
        'general-info',
        'mission-vision',
        'clients',
        'certificates',
        'awards',
        'sister',
        'hse',
        'cprofile'
    ];

    public static function sections(): array
    {
        return Database::connection()->query(
            'SELECT * FROM about_sections ORDER BY sort_order ASC, id ASC'
        )->fetchAll();
    }

    public static function section(string $legacyId): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT * FROM about_sections WHERE legacy_id = :legacy_id LIMIT 1'
        );
        $stmt->execute([':legacy_id' => $legacyId]);
        $row = $stmt->fetch();
        return is_array($row) ? $row : null;
    }

    public static function saveSection(array $data, ?int $id = null): int
    {
        $pdo = Database::connection();
        $legacyId = trim((string)($data['legacy_id'] ?? ''));
        $title = trim((string)($data['title'] ?? ''));
        if ($legacyId === '' || $title === '') {
            throw new RuntimeException('Section ID and title are required.');
        }

        $params = [
            ':legacy_id' => $legacyId,
            ':title' => $title,
            ':sort_order' => max(0, (int)($data['sort_order'] ?? 0)),
            ':is_active' => !empty($data['is_active']) ? 1 : 0,
        ];

        if ($id === null) {
            $stmt = $pdo->prepare(
                'INSERT INTO about_sections (legacy_id, title, sort_order, is_active)
                 VALUES (:legacy_id, :title, :sort_order, :is_active)'
            );
            $stmt->execute($params);
            return (int)$pdo->lastInsertId();
        }

        $params[':id'] = $id;
        $stmt = $pdo->prepare(
            'UPDATE about_sections
             SET legacy_id=:legacy_id, title=:title, sort_order=:sort_order, is_active=:is_active
             WHERE id=:id'
        );
        $stmt->execute($params);
        return $id;
    }

    public static function generalInfo(): ?array
    {
        $row = Database::connection()->query('SELECT * FROM about_general WHERE id=1')->fetch();
        return is_array($row) ? $row : null;
    }

    public static function saveGeneralInfo(array $data): void
    {
        $title = trim((string)($data['title'] ?? ''));
        $content = trim((string)($data['content'] ?? ''));
        if ($title === '' || $content === '') throw new RuntimeException('Overview title and content are required.');
        $stmt = Database::connection()->prepare(
            'INSERT INTO about_general (id,title,content) VALUES (1,:title,:content)
             ON DUPLICATE KEY UPDATE title=VALUES(title),content=VALUES(content)'
        );
        $stmt->execute([':title' => $title, ':content' => $content]);
    }

    public static function timeline(): array
    {
        $rows = Database::connection()->query('SELECT * FROM about_timeline ORDER BY sort_order ASC, id ASC')->fetchAll();
        return array_map(static fn(array $row): array => AssetResolver::hydrate($row, ['timeline_asset_id' => 'image_path']), $rows);
    }

    public static function timelineItem(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM about_timeline WHERE id=:id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return is_array($row) ? AssetResolver::hydrate($row, ['timeline_asset_id' => 'image_path']) : null;
    }

    public static function saveTimeline(array $data, ?int $id = null): int
    {
        $pdo = Database::connection();
        $year = trim((string)($data['year'] ?? ''));
        $title = trim((string)($data['title'] ?? ''));
        $description = trim((string)($data['description'] ?? ''));
        $image = AssetResolver::id($data['timeline_asset_id'] ?? null);
        if ($year === '' || $title === '' || $description === '' || !$image) throw new RuntimeException('All timeline fields are required.');
        $params = [':year' => $year, ':title' => $title, ':description' => $description, ':timeline_asset_id' => $image, ':sort_order' => max(0, (int)($data['sort_order'] ?? 0)), ':is_active' => !empty($data['is_active']) ? 1 : 0];
        if ($id === null) {
            $st = $pdo->prepare('INSERT INTO about_timeline (year,title,description,timeline_asset_id,sort_order,is_active) VALUES (:year,:title,:description,:timeline_asset_id,:sort_order,:is_active)');
            $st->execute($params);
            return (int)$pdo->lastInsertId();
        }
        $params[':id'] = $id;
        $st = $pdo->prepare('UPDATE about_timeline SET year=:year,title=:title,description=:description,timeline_asset_id=:timeline_asset_id,sort_order=:sort_order,is_active=:is_active WHERE id=:id');
        $st->execute($params);
        return $id;
    }

    public static function missionVision(): ?array
    {
        $row = Database::connection()->query('SELECT * FROM about_mission_vision WHERE id=1')->fetch();
        return is_array($row) ? $row : null;
    }

    public static function saveMissionVision(array $data): void
    {
        $required = ['title', 'mission', 'mission_asset_id', 'vision', 'vision_asset_id', 'core_values_asset_id'];
        foreach ($required as $key) {
            if (trim((string)($data[$key] ?? '')) === '') throw new RuntimeException('Mission & Vision: ' . $key . ' is required.');
        }
        $pdo = Database::connection();
        $st = $pdo->prepare('INSERT INTO about_mission_vision (id,title,mission,mission_asset_id,vision,vision_asset_id,core_values_asset_id) VALUES (1,:title,:mission,:mission_asset_id,:vision,:vision_asset_id,:core_values_asset_id) ON DUPLICATE KEY UPDATE title=VALUES(title),mission=VALUES(mission),mission_asset_id=VALUES(mission_asset_id),vision=VALUES(vision),vision_asset_id=VALUES(vision_asset_id),core_values_asset_id=VALUES(core_values_asset_id)');
        $st->execute([':title' => trim((string)$data['title']), ':mission' => trim((string)$data['mission']), ':mission_asset_id' => (int)$data['mission_asset_id'], ':vision' => trim((string)$data['vision']), ':vision_asset_id' => (int)$data['vision_asset_id'], ':core_values_asset_id' => (int)$data['core_values_asset_id']]);
    }

    public static function coreValues(): array
    {
        return Database::connection()->query('SELECT * FROM about_core_values ORDER BY sort_order ASC,id ASC')->fetchAll();
    }
    public static function coreValue(int $id): ?array
    {
        $st = Database::connection()->prepare('SELECT * FROM about_core_values WHERE id=:id LIMIT 1');
        $st->execute([':id' => $id]);
        $r = $st->fetch();
        return is_array($r) ? $r : null;
    }
    public static function saveCoreValue(array $data, ?int $id = null): int
    {
        $text = trim((string)($data['value_text'] ?? ''));
        if ($text === '') throw new RuntimeException('Core value text is required.');
        $p = [':value_text' => $text, ':sort_order' => max(0, (int)($data['sort_order'] ?? 0)), ':is_active' => !empty($data['is_active']) ? 1 : 0];
        $pdo = Database::connection();
        if ($id === null) {
            $st = $pdo->prepare('INSERT INTO about_core_values (value_text,sort_order,is_active) VALUES (:value_text,:sort_order,:is_active)');
            $st->execute($p);
            return (int)$pdo->lastInsertId();
        }
        $p[':id'] = $id;
        $st = $pdo->prepare('UPDATE about_core_values SET value_text=:value_text,sort_order=:sort_order,is_active=:is_active WHERE id=:id');
        $st->execute($p);
        return $id;
    }

    public static function items(string $type): array
    {
        $table = self::tableFor($type);
        $rows = Database::connection()->query("SELECT * FROM {$table} ORDER BY sort_order ASC,id ASC")->fetchAll();
        return array_map(static function (array $row): array {
            if (array_key_exists('about_asset_id', $row) && AssetResolver::id($row['about_asset_id'])) {
                $row['logo_path'] = AssetResolver::path($row['about_asset_id']);
            }
            return $row;
        }, $rows);
    }

    public static function item(string $type, int $id): ?array
    {
        $table = self::tableFor($type);
        $st = Database::connection()->prepare("SELECT * FROM {$table} WHERE id=:id LIMIT 1");
        $st->execute([':id' => $id]);
        $r = $st->fetch();
        if (!is_array($r)) return null;
        if (array_key_exists('about_asset_id', $r) && AssetResolver::id($r['about_asset_id'])) {
            $r['logo_path'] = AssetResolver::path($r['about_asset_id']);
        }
        return $r;
    }

    public static function saveItem(string $type, array $data, ?int $id = null): int
    {
        $pdo = Database::connection();
        $table = self::tableFor($type);
        if ($type === 'sister') {
            $assetId = AssetResolver::id($data['about_asset_id'] ?? null);
            $logo = $assetId ? AssetResolver::path($assetId) : trim((string)($data['logo_path'] ?? ''));
            if (!$assetId || $logo === '') throw new RuntimeException('Affiliated company logo is required.');
            $params = [
                ':name' => trim((string)($data['name'] ?? '')),
                ':about_asset_id' => $assetId,
                ':logo_path' => $logo,
                ':sort_order' => max(0, (int)($data['sort_order'] ?? 0)),
                ':is_active' => !empty($data['is_active']) ? 1 : 0,
            ];
            if ($params[':name'] === '') throw new RuntimeException('Affiliated company name is required.');
            if ($id === null) {
                $st = $pdo->prepare('INSERT INTO about_sister_companies (name,about_asset_id,logo_path,sort_order,is_active) VALUES (:name,:about_asset_id,:logo_path,:sort_order,:is_active)');
                $st->execute($params);
                return (int)$pdo->lastInsertId();
            }
            $params[':id'] = $id;
            $st = $pdo->prepare('UPDATE about_sister_companies SET name=:name,about_asset_id=:about_asset_id,logo_path=:logo_path,sort_order=:sort_order,is_active=:is_active WHERE id=:id');
            $st->execute($params);
            return $id;
        }
        if ($type === 'clients') {
            $name = null;
            $path = 'logo_path';
            $title = null;
        } else {
            $name = trim((string)($data['name'] ?? ''));
            $path = 'logo_path';
            $title = null;
        }
        $logo = AssetResolver::id($data['about_asset_id'] ?? null);
        if ($type === 'clients') {
            if (!$logo) throw new RuntimeException('Client logo is required.');
        } else if ($name === '' || !$logo) throw new RuntimeException('Name and logo are required.');
        $p = [':name' => $name, ':about_asset_id' => $logo, ':sort_order' => max(0, (int)($data['sort_order'] ?? 0)), ':is_active' => !empty($data['is_active']) ? 1 : 0];
        $sqlInsert = "INSERT INTO {$table} (name,about_asset_id,sort_order,is_active) VALUES (:name,:about_asset_id,:sort_order,:is_active)";
        $sqlUpdate = "UPDATE {$table} SET name=:name,about_asset_id=:about_asset_id,sort_order=:sort_order,is_active=:is_active WHERE id=:id";
        if ($id === null) {
            $st = $pdo->prepare($sqlInsert);
            $st->execute($p);
            return (int)$pdo->lastInsertId();
        }
        $p[':id'] = $id;
        $st = $pdo->prepare($sqlUpdate);
        $st->execute($p);
        return $id;
    }

    public static function hse(): ?array
    {
        $r = Database::connection()->query('SELECT * FROM about_hse WHERE id=1')->fetch();
        return is_array($r) ? $r : null;
    }
    public static function saveHse(array $data): void
    {
        $title = trim((string)($data['title'] ?? ''));
        $content = trim((string)($data['content'] ?? ''));
        if ($title === '' || $content === '') throw new RuntimeException('HSE title and content are required.');
        $st = Database::connection()->prepare('INSERT INTO about_hse (id,title,content) VALUES (1,:title,:content) ON DUPLICATE KEY UPDATE title=VALUES(title),content=VALUES(content)');
        $st->execute([':title' => $title, ':content' => $content]);
    }

    public static function companyProfile(): ?array
    {
        $r = Database::connection()->query('SELECT * FROM about_company_profile WHERE id=1')->fetch();
        return is_array($r) ? AssetResolver::hydrate($r, ['profile_asset_id' => 'link']) : null;
    }
    public static function saveCompanyProfile(array $data): void
    {
        if (trim((string)($data['title'] ?? '')) === '' || trim((string)($data['content'] ?? '')) === '' || !AssetResolver::id($data['profile_asset_id'] ?? null)) throw new RuntimeException('Company Profile fields are required.');
        $st = Database::connection()->prepare('INSERT INTO about_company_profile (id,title,content,profile_asset_id) VALUES (1,:title,:content,:profile_asset_id) ON DUPLICATE KEY UPDATE title=VALUES(title),content=VALUES(content),profile_asset_id=VALUES(profile_asset_id)');
        $st->execute([':title' => trim((string)$data['title']), ':content' => trim((string)$data['content']), ':profile_asset_id' => (int)$data['profile_asset_id']]);
    }

    public static function deleteItem(string $type, int $id): void
    {
        $table = self::tableFor($type);
        $st = Database::connection()->prepare("DELETE FROM {$table} WHERE id=:id");
        $st->execute([':id' => $id]);
        if ($st->rowCount() !== 1) throw new RuntimeException('About record not found.');
    }

    private static function tableFor(string $type): string
    {
        $map = ['clients' => 'about_clients', 'certificates' => 'about_certificates', 'awards' => 'about_awards', 'sister' => 'about_sister_companies', 'timeline' => 'about_timeline', 'values' => 'about_core_values'];
        if (!isset($map[$type])) throw new RuntimeException('Invalid About item type.');
        return $map[$type];
    }
}
