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
        return is_array($row) ? $row : null;
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
            $stmt = $pdo->prepare(
                'UPDATE sectors SET
                    sector_key = :sector_key,
                    title = :title,
                    description = :description,
                    hero_tag = :hero_tag,
                    hero_headline = :hero_headline,
                    hero_subtitle = :hero_subtitle,
                    hero_cta_text = :hero_cta_text,
                    hero_cta_link = :hero_cta_link,
                    hero_image = :hero_image,
                    featured_project_name = :featured_project_name,
                    featured_project_image = :featured_project_image,
                    featured_project_cta_text = :featured_project_cta_text,
                    featured_project_cta_link = :featured_project_cta_link,
                    sort_order = :sort_order,
                    is_active = :is_active
                 WHERE id = :id'
            );
            $stmt->execute([
                ':sector_key' => $key,
                ':title' => $title,
                ':description' => $description,
                ':hero_tag' => self::nullable($data['hero_tag'] ?? null),
                ':hero_headline' => self::nullable($data['hero_headline'] ?? null),
                ':hero_subtitle' => self::nullable($data['hero_subtitle'] ?? null),
                ':hero_cta_text' => self::nullable($data['hero_cta_text'] ?? null),
                ':hero_cta_link' => self::nullable($data['hero_cta_link'] ?? null),
                ':hero_image' => self::nullable($data['hero_image'] ?? null),
                ':featured_project_name' => self::nullable($data['featured_project_name'] ?? null),
                ':featured_project_image' => self::nullable($data['featured_project_image'] ?? null),
                ':featured_project_cta_text' => self::nullable($data['featured_project_cta_text'] ?? null),
                ':featured_project_cta_link' => self::nullable($data['featured_project_cta_link'] ?? null),
                ':sort_order' => max(0, (int) ($data['sort_order'] ?? 0)),
                ':is_active' => !empty($data['is_active']) ? 1 : 0,
                ':id' => $id,
            ]);
            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    private static function nullable(mixed $value): ?string
    {
        $value = trim((string) ($value ?? ''));
        return $value === '' ? null : $value;
    }
}
