<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';

final class ProjectManager
{
    public static function count(?string $search = null, ?string $sector = null, ?string $status = null): int
    {
        $pdo = Database::connection();
        $where = [];
        $params = [];

        self::applyFilters($where, $params, $search, $sector, $status);

        $sql = 'SELECT COUNT(*) FROM projects' . self::whereSql($where);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    public static function all(
        ?string $search = null,
        ?string $sector = null,
        ?string $status = null,
        int $limit = 20,
        int $offset = 0
    ): array {
        $pdo = Database::connection();
        $where = [];
        $params = [];

        self::applyFilters($where, $params, $search, $sector, $status);

        $limit = max(1, min(100, $limit));
        $offset = max(0, $offset);

        $sql = 'SELECT * FROM projects'
            . self::whereSql($where)
            . ' ORDER BY sort_order ASC, id ASC LIMIT :limit OFFSET :offset';

        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function sectors(): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->query(
            'SELECT DISTINCT sector_name
             FROM projects
             WHERE sector_name IS NOT NULL AND sector_name <> \'\'
             ORDER BY sector_name ASC'
        );

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function statuses(): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->query(
            'SELECT DISTINCT status
             FROM projects
             WHERE status IS NOT NULL AND status <> \'\'
             ORDER BY status ASC'
        );

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT * FROM projects WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);

        $project = $stmt->fetch();
        if (!is_array($project)) {
            return null;
        }

        $project['images'] = self::images($id);
        $project['scope'] = self::scope($id);

        return $project;
    }

    public static function images(int $projectId): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'SELECT id, image_path, alt_text, caption, sort_order
             FROM project_images
             WHERE project_id = :project_id
             ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':project_id' => $projectId]);
        return $stmt->fetchAll();
    }

    public static function scope(int $projectId): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'SELECT id, scope_text, sort_order
             FROM project_scope
             WHERE project_id = :project_id
             ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':project_id' => $projectId]);
        return $stmt->fetchAll();
    }

    public static function save(array $data, ?int $projectId = null): int
    {
        $pdo = Database::connection();

        $normalized = self::validateAndNormalize($data, $projectId);

        $pdo->beginTransaction();

        try {
            if ($projectId === null) {
                $stmt = $pdo->prepare(
                    'INSERT INTO projects
                        (legacy_id, name, slug, sector_name, category, status,
                         completion_year, location, client, description,
                         show_on_home, show_in_category_image, thumbnail_path,
                         published, sort_order)
                     VALUES
                        (:legacy_id, :name, :slug, :sector_name, :category, :status,
                         :completion_year, :location, :client, :description,
                         :show_on_home, :show_in_category_image, :thumbnail_path,
                         :published, :sort_order)'
                );

                $stmt->execute([
                    ':legacy_id' => $normalized['legacy_id'],
                    ':name' => $normalized['name'],
                    ':slug' => $normalized['slug'],
                    ':sector_name' => $normalized['sector_name'],
                    ':category' => $normalized['category'],
                    ':status' => $normalized['status'],
                    ':completion_year' => $normalized['completion_year'],
                    ':location' => $normalized['location'],
                    ':client' => $normalized['client'],
                    ':description' => $normalized['description'],
                    ':show_on_home' => $normalized['show_on_home'],
                    ':show_in_category_image' => $normalized['show_in_category_image'],
                    ':thumbnail_path' => $normalized['thumbnail_path'],
                    ':published' => $normalized['published'],
                    ':sort_order' => $normalized['sort_order'],
                ]);

                $projectId = (int) $pdo->lastInsertId();
            } else {
                $stmt = $pdo->prepare(
                    'UPDATE projects
                     SET legacy_id = :legacy_id,
                         name = :name,
                         slug = :slug,
                         sector_name = :sector_name,
                         category = :category,
                         status = :status,
                         completion_year = :completion_year,
                         location = :location,
                         client = :client,
                         description = :description,
                         show_on_home = :show_on_home,
                         show_in_category_image = :show_in_category_image,
                         thumbnail_path = :thumbnail_path,
                         published = :published,
                         sort_order = :sort_order
                     WHERE id = :id'
                );

                $stmt->execute([
                    ':legacy_id' => $normalized['legacy_id'],
                    ':name' => $normalized['name'],
                    ':slug' => $normalized['slug'],
                    ':sector_name' => $normalized['sector_name'],
                    ':category' => $normalized['category'],
                    ':status' => $normalized['status'],
                    ':completion_year' => $normalized['completion_year'],
                    ':location' => $normalized['location'],
                    ':client' => $normalized['client'],
                    ':description' => $normalized['description'],
                    ':show_on_home' => $normalized['show_on_home'],
                    ':show_in_category_image' => $normalized['show_in_category_image'],
                    ':thumbnail_path' => $normalized['thumbnail_path'],
                    ':published' => $normalized['published'],
                    ':sort_order' => $normalized['sort_order'],
                    ':id' => $projectId,
                ]);
            }

            self::replaceImages($pdo, $projectId, $normalized['images']);
            self::replaceScope($pdo, $projectId, $normalized['scope']);

            $pdo->commit();

            return $projectId;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    public static function delete(int $id): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('DELETE FROM projects WHERE id = :id');
        $stmt->execute([':id' => $id]);

        if ($stmt->rowCount() !== 1) {
            throw new RuntimeException('Project not found or could not be deleted.');
        }
    }

    public static function setPublished(int $id, bool $published): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'UPDATE projects SET published = :published WHERE id = :id'
        );
        $stmt->execute([
            ':published' => $published ? 1 : 0,
            ':id' => $id,
        ]);

        if ($stmt->rowCount() === 0 && self::findBasic($id) === null) {
            throw new RuntimeException('Project not found.');
        }
    }

    public static function maxSortOrder(): int
    {
        $pdo = Database::connection();
        return (int) $pdo->query('SELECT COALESCE(MAX(sort_order), -1) FROM projects')->fetchColumn();
    }

    private static function findBasic(int $id): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT id FROM projects WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return is_array($result) ? $result : null;
    }

    private static function applyFilters(
        array &$where,
        array &$params,
        ?string $search,
        ?string $sector,
        ?string $status
    ): void {
        if ($search !== null && trim($search) !== '') {
            $search = '%' . trim($search) . '%';

            $where[] = '(
            name LIKE :search_name
            OR client LIKE :search_client
            OR location LIKE :search_location
            OR category LIKE :search_category
        )';

            $params[':search_name'] = $search;
            $params[':search_client'] = $search;
            $params[':search_location'] = $search;
            $params[':search_category'] = $search;
        }

        if ($sector !== null && trim($sector) !== '') {
            $where[] = 'sector_name = :sector';
            $params[':sector'] = trim($sector);
        }

        if ($status !== null && trim($status) !== '') {
            $where[] = 'status = :status';
            $params[':status'] = trim($status);
        }
    }

    private static function whereSql(array $where): string
    {
        return $where === [] ? '' : ' WHERE ' . implode(' AND ', $where);
    }

    private static function validateAndNormalize(array $data, ?int $projectId): array
    {
        $name = trim((string) ($data['name'] ?? ''));
        $slug = strtolower(trim((string) ($data['slug'] ?? '')));
        $legacyId = trim((string) ($data['legacy_id'] ?? ''));

        if ($name === '' || strlen($name) > 500) {
            throw new RuntimeException('Project name is required and must not exceed 500 characters.');
        }

        if ($slug === '') {
            $slug = self::slugify($name);
        }

        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug)) {
            throw new RuntimeException('Slug may contain lowercase letters, numbers and single hyphens.');
        }

        if (self::slugExists($slug, $projectId)) {
            throw new RuntimeException('That project slug is already in use.');
        }

        $completionYear = trim((string) ($data['completion_year'] ?? ''));
        if ($completionYear === '') {
            $completionYearValue = null;
        } elseif (preg_match('/^\d{4}$/', $completionYear) && (int) $completionYear >= 1900 && (int) $completionYear <= 2200) {
            $completionYearValue = (int) $completionYear;
        } else {
            throw new RuntimeException('Completion year must be a four-digit year.');
        }

        $images = self::normalizeImages($data['images'] ?? []);
        $scope = self::normalizeScope($data['scope'] ?? []);

        $sortOrder = filter_var($data['sort_order'] ?? null, FILTER_VALIDATE_INT);
        if ($sortOrder === false || $sortOrder === null || $sortOrder < 0) {
            $sortOrder = $projectId === null ? self::maxSortOrder() + 1 : 0;
        }

        return [
            'legacy_id' => $legacyId === '' ? null : $legacyId,
            'name' => $name,
            'slug' => $slug,
            'sector_name' => self::nullable((string) ($data['sector_name'] ?? '')),
            'category' => self::nullable((string) ($data['category'] ?? '')),
            'status' => self::nullable((string) ($data['status'] ?? '')),
            'completion_year' => $completionYearValue,
            'location' => self::nullable((string) ($data['location'] ?? '')),
            'client' => self::nullable((string) ($data['client'] ?? '')),
            'description' => self::nullable((string) ($data['description'] ?? '')),
            'show_on_home' => !empty($data['show_on_home']) ? 1 : 0,
            'show_in_category_image' => !empty($data['show_in_category_image']) ? 1 : 0,
            'thumbnail_path' => self::nullable((string) ($data['thumbnail_path'] ?? '')),
            'published' => !empty($data['published']) ? 1 : 0,
            'sort_order' => $sortOrder,
            'images' => $images,
            'scope' => $scope,
        ];
    }

    private static function normalizeImages(mixed $images): array
    {
        if (!is_array($images)) {
            return [];
        }

        $normalized = [];
        $order = 0;

        foreach ($images as $image) {
            if (is_string($image)) {
                $path = trim($image);
                $alt = null;
                $caption = null;
            } elseif (is_array($image)) {
                $path = trim((string) ($image['image_path'] ?? ''));
                $alt = self::nullable((string) ($image['alt_text'] ?? ''));
                $caption = self::nullable((string) ($image['caption'] ?? ''));
            } else {
                continue;
            }

            if ($path === '') {
                continue;
            }

            if (strlen($path) > 500) {
                throw new RuntimeException('An image path is too long.');
            }

            $normalized[] = [
                'image_path' => $path,
                'alt_text' => $alt,
                'caption' => $caption,
                'sort_order' => $order++,
            ];
        }

        return $normalized;
    }

    private static function normalizeScope(mixed $scope): array
    {
        if (!is_array($scope)) {
            return [];
        }

        $normalized = [];
        $order = 0;

        foreach ($scope as $item) {
            $text = trim((string) $item);
            if ($text === '') {
                continue;
            }

            $normalized[] = [
                'scope_text' => $text,
                'sort_order' => $order++,
            ];
        }

        return $normalized;
    }

    private static function replaceImages(PDO $pdo, int $projectId, array $images): void
    {
        $delete = $pdo->prepare('DELETE FROM project_images WHERE project_id = :project_id');
        $delete->execute([':project_id' => $projectId]);

        if ($images === []) {
            return;
        }

        $insert = $pdo->prepare(
            'INSERT INTO project_images
                (project_id, image_path, alt_text, caption, sort_order)
             VALUES
                (:project_id, :image_path, :alt_text, :caption, :sort_order)'
        );

        foreach ($images as $image) {
            $insert->execute([
                ':project_id' => $projectId,
                ':image_path' => $image['image_path'],
                ':alt_text' => $image['alt_text'],
                ':caption' => $image['caption'],
                ':sort_order' => $image['sort_order'],
            ]);
        }
    }

    private static function replaceScope(PDO $pdo, int $projectId, array $scope): void
    {
        $delete = $pdo->prepare('DELETE FROM project_scope WHERE project_id = :project_id');
        $delete->execute([':project_id' => $projectId]);

        if ($scope === []) {
            return;
        }

        $insert = $pdo->prepare(
            'INSERT INTO project_scope (project_id, scope_text, sort_order)
             VALUES (:project_id, :scope_text, :sort_order)'
        );

        foreach ($scope as $item) {
            $insert->execute([
                ':project_id' => $projectId,
                ':scope_text' => $item['scope_text'],
                ':sort_order' => $item['sort_order'],
            ]);
        }
    }

    private static function slugExists(string $slug, ?int $exceptId): bool
    {
        $pdo = Database::connection();
        $sql = 'SELECT id FROM projects WHERE slug = :slug';
        $params = [':slug' => $slug];

        if ($exceptId !== null) {
            $sql .= ' AND id != :except_id';
            $params[':except_id'] = $exceptId;
        }

        $sql .= ' LIMIT 1';

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn() !== false;
    }

    private static function slugify(string $value): string
    {
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9]+/i', '-', $value) ?? '';
        $value = trim($value, '-');

        return substr($value !== '' ? $value : 'project', 0, 500);
    }

    private static function nullable(string $value): ?string
    {
        $value = trim($value);
        return $value === '' ? null : $value;
    }
}
