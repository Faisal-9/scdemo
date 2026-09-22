<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class SectorManager
{
    public static function all(): array
    {
        return Database::connection()->query(
            'SELECT * FROM sectors ORDER BY sort_order ASC, id ASC'
        )->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT * FROM sectors WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if (!is_array($row)) return null;
        $row = AssetResolver::hydrate($row, ['hero_asset_id' => 'hero_image', 'featured_project_asset_id' => 'featured_project_image']);
        $row['stats'] = $pdo->query('SELECT value_text, label FROM sector_stats WHERE sector_id = ' . $id . ' ORDER BY sort_order ASC, id ASC')->fetchAll();
        $row['why'] = $pdo->query('SELECT text_content FROM sector_why WHERE sector_id = ' . $id . ' ORDER BY sort_order ASC, id ASC')->fetchAll(PDO::FETCH_COLUMN);
        $row['areas'] = $pdo->query('SELECT title FROM sector_areas WHERE sector_id = ' . $id . ' ORDER BY sort_order ASC, id ASC')->fetchAll(PDO::FETCH_COLUMN);
        return $row;
    }

    public static function create(array $data): int
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $id = self::insertSector($pdo, $data);
            self::saveChildren($pdo, $id, $data);
            $pdo->commit();
            return $id;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    public static function update(int $id, array $data): void
    {
        if (self::findBasic($id) === null) throw new RuntimeException('Sector not found.');
        self::save($id, $data);
    }

    public static function save(int $id, array $data): void
    {
        $key = trim((string) ($data['sector_key'] ?? ''));
        $title = trim((string) ($data['title'] ?? ''));
        if ($key === '' || !preg_match('/^[A-Za-z0-9_-]+$/', $key)) {
            throw new RuntimeException('Invalid sector key.');
        }
        if ($title === '') {
            throw new RuntimeException('Sector title is required.');
        }

        $description = (string) ($data['description'] ?? '');
        $paragraphs = preg_split('/\R\s*\R/', trim($description), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        if (count($paragraphs) > 1) {
            $description = '__SC_ARRAY__' . json_encode(
                array_values(array_map('trim', $paragraphs)),
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR
            );
        }

        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            self::updateSector($pdo, $id, $data, $key, $title, $description);
            self::saveChildren($pdo, $id, $data);
            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    private static function findBasic(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT id FROM sectors WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return is_array($row) ? $row : null;
    }

    private static function insertSector(PDO $pdo, array $data): int
    {
        $key = trim((string)($data['sector_key'] ?? ''));
        $title = trim((string)($data['title'] ?? ''));
        if ($key === '' || !preg_match('/^[A-Za-z0-9_-]+$/', $key)) throw new RuntimeException('Invalid sector key.');
        if ($title === '') throw new RuntimeException('Sector title is required.');
        $description = self::descriptionValue((string)($data['description'] ?? ''));
        $stmt = $pdo->prepare('INSERT INTO sectors (sector_key,title,description,hero_tag,hero_headline,hero_subtitle,hero_cta_text,hero_cta_link,hero_asset_id,featured_project_name,featured_project_asset_id,featured_project_cta_text,featured_project_cta_link,sort_order,is_active) VALUES (:sector_key,:title,:description,:hero_tag,:hero_headline,:hero_subtitle,:hero_cta_text,:hero_cta_link,:hero_asset_id,:featured_project_name,:featured_project_asset_id,:featured_project_cta_text,:featured_project_cta_link,:sort_order,:is_active)');
        $stmt->execute(self::sectorParams($data, $key, $title, $description));
        return (int)$pdo->lastInsertId();
    }

    private static function updateSector(PDO $pdo, int $id, array $data, string $key, string $title, string $description): void
    {
        $params = self::sectorParams($data, $key, $title, $description);
        $params[':id'] = $id;
        $stmt = $pdo->prepare('UPDATE sectors SET sector_key=:sector_key,title=:title,description=:description,hero_tag=:hero_tag,hero_headline=:hero_headline,hero_subtitle=:hero_subtitle,hero_cta_text=:hero_cta_text,hero_cta_link=:hero_cta_link,hero_asset_id=:hero_asset_id,featured_project_name=:featured_project_name,featured_project_asset_id=:featured_project_asset_id,featured_project_cta_text=:featured_project_cta_text,featured_project_cta_link=:featured_project_cta_link,sort_order=:sort_order,is_active=:is_active WHERE id=:id');
        $stmt->execute($params);
    }

    private static function sectorParams(array $data, string $key, string $title, string $description): array
    {
        return [
            ':sector_key' => $key, ':title' => $title, ':description' => $description,
            ':hero_tag' => self::nullable($data['hero_tag'] ?? null), ':hero_headline' => self::nullable($data['hero_headline'] ?? null),
            ':hero_subtitle' => self::nullable($data['hero_subtitle'] ?? null), ':hero_cta_text' => self::nullable($data['hero_cta_text'] ?? null),
            ':hero_cta_link' => self::nullable($data['hero_cta_link'] ?? null), ':hero_asset_id' => AssetResolver::id($data['hero_asset_id'] ?? null),
            ':featured_project_name' => self::nullable($data['featured_project_name'] ?? null), ':featured_project_asset_id' => AssetResolver::id($data['featured_project_asset_id'] ?? null),
            ':featured_project_cta_text' => self::nullable($data['featured_project_cta_text'] ?? null), ':featured_project_cta_link' => self::nullable($data['featured_project_cta_link'] ?? null),
            ':sort_order' => max(0, (int)($data['sort_order'] ?? 0)), ':is_active' => !empty($data['is_active']) ? 1 : 0,
        ];
    }

    private static function saveChildren(PDO $pdo, int $sectorId, array $data): void
    {
        foreach (['sector_stats', 'sector_why', 'sector_areas'] as $table) $pdo->prepare("DELETE FROM {$table} WHERE sector_id=:id")->execute([':id' => $sectorId]);
        $stmt = $pdo->prepare('INSERT INTO sector_stats (sector_id,value_text,label,sort_order) VALUES (:sector_id,:value_text,:label,:sort_order)');
        foreach (array_values((array)($data['stats'] ?? [])) as $order => $row) if (trim((string)($row['value'] ?? $row['value_text'] ?? '')) !== '' || trim((string)($row['label'] ?? '')) !== '') $stmt->execute([':sector_id'=>$sectorId,':value_text'=>trim((string)($row['value'] ?? $row['value_text'] ?? '')),':label'=>trim((string)($row['label'] ?? '')),':sort_order'=>$order]);
        $stmt = $pdo->prepare('INSERT INTO sector_why (sector_id,text_content,sort_order) VALUES (:sector_id,:text_content,:sort_order)');
        foreach (array_values((array)($data['why'] ?? [])) as $order => $value) if (trim((string)$value) !== '') $stmt->execute([':sector_id'=>$sectorId,':text_content'=>trim((string)$value),':sort_order'=>$order]);
        $stmt = $pdo->prepare('INSERT INTO sector_areas (sector_id,title,sort_order) VALUES (:sector_id,:title,:sort_order)');
        foreach (array_values((array)($data['areas'] ?? [])) as $order => $value) if (trim((string)$value) !== '') $stmt->execute([':sector_id'=>$sectorId,':title'=>trim((string)$value),':sort_order'=>$order]);
    }

    private static function descriptionValue(string $description): string
    {
        $paragraphs=preg_split('/\R\s*\R/',trim($description),-1,PREG_SPLIT_NO_EMPTY) ?: [];
        return count($paragraphs)>1 ? '__SC_ARRAY__'.json_encode(array_values(array_map('trim',$paragraphs)),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR) : trim($description);
    }

    private static function nullable(mixed $value): ?string
    {
        $value = trim((string) ($value ?? ''));
        return $value === '' ? null : $value;
    }
}
