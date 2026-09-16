<?php

declare(strict_types=1);

/**
 * State Corps CMS — Central Media Library.
 *
 * Phase 28 expands the Phase 20 media_library into a central asset registry.
 * It can register existing assets without moving them, upload new assets,
 * rename managed files while updating live DB references, edit metadata,
 * and provide data for the reusable admin media picker.
 */
final class MediaLibraryManager
{
    private const UPLOAD_MAX_IMAGE = 8 * 1024 * 1024;
    private const UPLOAD_MAX_FILE = 20 * 1024 * 1024;

    private const ALLOWED_MIME = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
        'application/pdf' => 'pdf',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.ms-excel' => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
        'application/vnd.ms-powerpoint' => 'ppt',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        'application/zip' => 'zip',
    ];

    private const LEGACY_ROOTS = ['assets/images', 'assets/documents'];

    public static function list(array $filters = []): array
    {
        $pdo = Database::connection();
        $where = [];
        $params = [];
        $search = trim((string)($filters['search'] ?? ''));
        $type = (string)($filters['type'] ?? '');
        $scope = (string)($filters['scope'] ?? '');
        $status = (string)($filters['status'] ?? '');

        if ($search !== '') {
            $where[] = '(original_name LIKE :search OR relative_path LIKE :search OR alt_text LIKE :search OR category LIKE :search)';
            $params['search'] = '%' . mb_substr($search, 0, 150) . '%';
        }
        if ($type === 'image') $where[] = "mime_type LIKE 'image/%'";
        elseif ($type === 'document') $where[] = "mime_type NOT LIKE 'image/%'";
        if (in_array($scope, ['upload', 'legacy'], true)) {
            $where[] = 'storage_scope = :scope';
            $params['scope'] = $scope;
        }
        if (in_array($status, ['active', 'archived'], true)) $where[] = 'status = :status';
        if (in_array($status, ['active', 'archived'], true)) $params['status'] = $status;

        $sql = 'SELECT * FROM media_library';
        if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY created_at DESC, id DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function pickerSearch(string $query = '', string $type = 'image', int $limit = 36): array
    {
        $limit = max(1, min($limit, 100));
        $where = ['1=1'];
        $params = [];
        $query = trim($query);
        if ($query !== '') {
            $where[] = '(original_name LIKE :q OR relative_path LIKE :q OR alt_text LIKE :q OR category LIKE :q)';
            $params['q'] = '%' . mb_substr($query, 0, 120) . '%';
        }
        if ($type === 'image') $where[] = "mime_type LIKE 'image/%'";
        elseif ($type === 'document') $where[] = "mime_type NOT LIKE 'image/%'";

        $sql = 'SELECT id, original_name, relative_path, mime_type, file_size, alt_text, category
                FROM media_library WHERE ' . implode(' AND ', $where) .
            ' ORDER BY created_at DESC, id DESC LIMIT ' . $limit;
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM media_library WHERE id=? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function upload(array $file, string $displayName = '', string $category = '', string $altText = ''): int
    {
        if (!isset($file['error'], $file['tmp_name'], $file['name'], $file['size']) || is_array($file['error'])) {
            throw new InvalidArgumentException('Invalid upload payload.');
        }
        if ((int)$file['error'] !== UPLOAD_ERR_OK) throw new RuntimeException(self::uploadError((int)$file['error']));
        if (!is_uploaded_file($file['tmp_name'])) throw new RuntimeException('Upload validation failed.');

        $mime = self::detectMime($file['tmp_name']);
        if (!isset(self::ALLOWED_MIME[$mime])) throw new InvalidArgumentException('File type is not allowed.');
        $size = (int)$file['size'];
        $limit = str_starts_with($mime, 'image/') ? self::UPLOAD_MAX_IMAGE : self::UPLOAD_MAX_FILE;
        if ($size < 1 || $size > $limit) throw new InvalidArgumentException('The uploaded file exceeds the permitted size.');
        if (str_starts_with($mime, 'image/') && @getimagesize($file['tmp_name']) === false) throw new InvalidArgumentException('The uploaded image could not be validated.');
        $dimensions = str_starts_with($mime, 'image/') ? @getimagesize($file['tmp_name']) : false;
        $checksum = hash_file('sha256', $file['tmp_name']) ?: null;

        $extension = self::ALLOWED_MIME[$mime];
        $base = $displayName !== '' ? $displayName : pathinfo(basename((string)$file['name']), PATHINFO_FILENAME);
        $base = self::cleanDisplayName($base);
        $category = self::cleanCategory($category);
        $altText = mb_substr(trim($altText), 0, 500);

        $dir = self::uploadRoot() . DIRECTORY_SEPARATOR . date('Y/m');
        if (!is_dir($dir) && !@mkdir($dir, 0750, true)) throw new RuntimeException('Upload directory could not be created.');
        $stored = self::uniqueStoredName($dir, $base, $extension);
        $absolute = $dir . DIRECTORY_SEPARATOR . $stored;
        if (!@move_uploaded_file($file['tmp_name'], $absolute)) throw new RuntimeException('The uploaded file could not be stored.');

        $relative = 'assets/uploads/' . date('Y/m') . '/' . $stored;
        $userId = self::currentUserId();
        try {
            $stmt = Database::connection()->prepare(
                 'INSERT INTO media_library (original_name, stored_name, relative_path, mime_type, file_size, checksum, width_px, height_px, alt_text, category, storage_scope, created_by)
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?)'
            );
              $stmt->execute([$base . '.' . $extension, $stored, $relative, $mime, $size, $checksum, $dimensions[0] ?? null, $dimensions[1] ?? null, $altText ?: null, $category ?: null, 'upload', $userId]);
            return (int)Database::connection()->lastInsertId();
        } catch (Throwable $e) {
            @unlink($absolute);
            throw $e;
        }
    }

    public static function importExistingAssets(): array
    {
        $pdo = Database::connection();
        $known = [];
        foreach ($pdo->query('SELECT relative_path FROM media_library')->fetchAll(PDO::FETCH_COLUMN) as $path) $known[(string)$path] = true;

        $root = dirname(__DIR__, 2);
        $created = 0;
        $skipped = 0;
        $missing = 0;
        foreach (self::LEGACY_ROOTS as $relativeRoot) {
            $absoluteRoot = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativeRoot);
            if (!is_dir($absoluteRoot)) {
                $missing++;
                continue;
            }
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($absoluteRoot, FilesystemIterator::SKIP_DOTS));
            foreach ($it as $file) {
                if (!$file->isFile()) continue;
                $absolute = $file->getPathname();
                $relative = $relativeRoot . '/' . str_replace(DIRECTORY_SEPARATOR, '/', substr($absolute, strlen($absoluteRoot) + 1));
                $relative = ltrim($relative, '/');
                if (isset($known[$relative])) {
                    $skipped++;
                    continue;
                }
                $mime = self::detectMime($absolute);
                if (!isset(self::ALLOWED_MIME[$mime])) {
                    $skipped++;
                    continue;
                }
                $name = basename($relative);
                $dimensions = str_starts_with($mime, 'image/') ? @getimagesize($absolute) : false;
                $checksum = hash_file('sha256', $absolute) ?: null;
                $stmt = $pdo->prepare(
                    'INSERT INTO media_library (original_name, stored_name, relative_path, mime_type, file_size, checksum, width_px, height_px, category, storage_scope, created_by)
                     VALUES (?,?,?,?,?,?,?,?,?,?,?)'
                );
                $category = self::categoryFromPath($relative);
                $stmt->execute([$name, $name, $relative, $mime, (int)$file->getSize(), $checksum, $dimensions[0] ?? null, $dimensions[1] ?? null, $category, 'legacy', self::currentUserId()]);
                $known[$relative] = true;
                $created++;
            }
        }
        return compact('created', 'skipped', 'missing');
    }

    public static function updateMeta(int $id, string $displayName, string $altText, string $category, string $status = 'active'): void
    {
        $row = self::find($id);
        if (!$row) throw new RuntimeException('Asset not found.');
        $displayName = self::cleanDisplayName($displayName);
        $altText = mb_substr(trim($altText), 0, 500);
        $category = self::cleanCategory($category);
        $status = in_array($status, ['active', 'archived'], true) ? $status : 'active';
        $extension = pathinfo((string)$row['original_name'], PATHINFO_EXTENSION);
        $originalName = $displayName . ($extension !== '' ? '.' . strtolower($extension) : '');
        $stmt = Database::connection()->prepare('UPDATE media_library SET original_name=?, alt_text=?, category=?, status=?, updated_at=NOW() WHERE id=?');
        $stmt->execute([$originalName, $altText ?: null, $category ?: null, $status, $id]);
    }

    public static function rename(int $id, string $newBaseName): array
    {
        $row = self::find($id);
        if (!$row) throw new RuntimeException('Asset not found.');
        $newBaseName = self::cleanDisplayName($newBaseName);
        $extension = strtolower(pathinfo((string)$row['original_name'], PATHINFO_EXTENSION));
        if ($extension === '') $extension = strtolower((string)(self::ALLOWED_MIME[(string)$row['mime_type']] ?? 'bin'));
        $oldRelative = (string)$row['relative_path'];
        $oldAbsolute = self::absoluteFromRelative($oldRelative);
        if (!is_file($oldAbsolute)) throw new RuntimeException('The physical file is missing. Repair the asset before renaming it.');

        $directory = dirname($oldAbsolute);
        $newStored = self::uniqueStoredName($directory, $newBaseName, $extension, $oldAbsolute);
        $newAbsolute = $directory . DIRECTORY_SEPARATOR . $newStored;
        if (!@rename($oldAbsolute, $newAbsolute)) throw new RuntimeException('The physical file could not be renamed.');

        $newRelative = self::relativeFromAbsolute($newAbsolute);
        $pdo = Database::connection();
        try {
            $pdo->beginTransaction();
            self::replaceLiveReferences($pdo, $oldRelative, $newRelative);
            $stmt = $pdo->prepare('UPDATE media_library SET original_name=?, stored_name=?, relative_path=?, updated_at=NOW() WHERE id=?');
            $stmt->execute([$newBaseName . '.' . $extension, $newStored, $newRelative, $id]);
            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            @rename($newAbsolute, $oldAbsolute);
            throw $e;
        }
        return ['old_path' => $oldRelative, 'new_path' => $newRelative];
    }

    public static function delete(int $id): void
    {
        $row = self::find($id);
        if (!$row) throw new RuntimeException('Asset not found.');
        if (self::referenceCount((string)$row['relative_path']) > 0) throw new RuntimeException('This asset is still referenced by live CMS content. Remove those references before deleting it.');
        $absolute = self::absoluteFromRelative((string)$row['relative_path']);
        if (!is_file($absolute)) throw new RuntimeException('The physical file is missing; database record was kept for repair.');
        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('DELETE FROM media_library WHERE id=?');
            $stmt->execute([$id]);
            if (!@unlink($absolute)) throw new RuntimeException('The physical file could not be deleted.');
            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    public static function referenceCount(string $relativePath): int
    {
        $count = 0;
        foreach (self::textColumns() as $target) {
            $table = self::quoteIdentifier($target['table_name']);
            $column = self::quoteIdentifier($target['column_name']);
            $stmt = Database::connection()->prepare("SELECT COUNT(*) FROM {$table} WHERE LOCATE(:needle, {$column}) > 0");
            $stmt->execute(['needle' => $relativePath]);
            $count += (int)$stmt->fetchColumn();
        }
        return $count;
    }

    public static function references(string $relativePath): array
    {
        $results = [];
        foreach (self::textColumns() as $target) {
            $table = self::quoteIdentifier($target['table_name']);
            $column = self::quoteIdentifier($target['column_name']);
            $pk = self::quoteIdentifier($target['pk_column']);
            $stmt = Database::connection()->prepare("SELECT {$pk} AS row_id, {$column} AS value FROM {$table} WHERE LOCATE(:needle, {$column}) > 0 LIMIT 200");
            $stmt->execute(['needle' => $relativePath]);
            while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) $results[] = ['table_name' => $target['table_name'], 'column_name' => $target['column_name'], 'row_id' => $r['row_id']];
        }
        return $results;
    }

    public static function fileUrl(string $relative): string
    {
        return rtrim((string)(defined('BASE_URL') ? BASE_URL : ''), '/') . '/' . ltrim($relative, '/');
    }

    private static function replaceLiveReferences(PDO $pdo, string $old, string $new): void
    {
        foreach (self::textColumns() as $target) {
            $table = self::quoteIdentifier($target['table_name']);
            $column = self::quoteIdentifier($target['column_name']);
            $stmt = $pdo->prepare("UPDATE {$table} SET {$column}=REPLACE({$column}, :old, :new) WHERE LOCATE(:needle, {$column}) > 0");
            $stmt->execute(['old' => $old, 'new' => $new, 'needle' => $old]);
        }
    }

    private static function textColumns(): array
    {
        $types = ['char', 'varchar', 'tinytext', 'text', 'mediumtext', 'longtext'];
        $ph = implode(',', array_fill(0, count($types), '?'));
        $sql = "SELECT c.TABLE_NAME AS table_name,c.COLUMN_NAME AS column_name,pk.COLUMN_NAME AS pk_column
              FROM information_schema.COLUMNS c
              INNER JOIN (SELECT tc.TABLE_SCHEMA,tc.TABLE_NAME,kcu.COLUMN_NAME FROM information_schema.TABLE_CONSTRAINTS tc
              INNER JOIN information_schema.KEY_COLUMN_USAGE kcu ON kcu.CONSTRAINT_SCHEMA=tc.CONSTRAINT_SCHEMA AND kcu.CONSTRAINT_NAME=tc.CONSTRAINT_NAME AND kcu.TABLE_SCHEMA=tc.TABLE_SCHEMA AND kcu.TABLE_NAME=tc.TABLE_NAME
              WHERE tc.CONSTRAINT_TYPE='PRIMARY KEY') pk ON pk.TABLE_SCHEMA=c.TABLE_SCHEMA AND pk.TABLE_NAME=c.TABLE_NAME
              WHERE c.TABLE_SCHEMA=DATABASE() AND c.DATA_TYPE IN ($ph) AND c.TABLE_NAME NOT IN ('audit_logs','content_revisions','media_library')
              ORDER BY c.TABLE_NAME,c.ORDINAL_POSITION";
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($types);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function absoluteFromRelative(string $relative): string
    {
        $relative = self::normalizePath($relative);
        if ($relative === '') throw new RuntimeException('Invalid asset path.');
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    }
    private static function relativeFromAbsolute(string $absolute): string
    {
        $root = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR;
        $relative = str_replace(DIRECTORY_SEPARATOR, '/', substr($absolute, strlen($root)));
        return ltrim($relative, '/');
    }
    private static function uploadRoot(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads';
    }
    private static function normalizePath(string $path): string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');
        if (str_contains($path, '..') || !preg_match('#^assets/(?:images|documents|uploads)/#', $path)) return '';
        return $path;
    }
    private static function uniqueStoredName(string $directory, string $base, string $extension, string $ignore = ''): string
    {
        $candidate = $base . '.' . $extension;
        $i = 2;
        while (file_exists($directory . DIRECTORY_SEPARATOR . $candidate) && $directory . DIRECTORY_SEPARATOR . $candidate !== $ignore) {
            $candidate = $base . '-' . $i . '.' . $extension;
            $i++;
        }
        return $candidate;
    }
    private static function detectMime(string $path): string
    {
        $f = new finfo(FILEINFO_MIME_TYPE);
        return (string)$f->file($path);
    }
    private static function cleanDisplayName(string $name): string
    {
        $name = trim(pathinfo(basename($name), PATHINFO_FILENAME));
        $name = preg_replace('/[^A-Za-z0-9 _-]+/', '-', $name) ?? '';
        $name = preg_replace('/\s+/', '-', trim($name)) ?? '';
        $name = trim($name, '-');
        if ($name === '' || strlen($name) > 150) throw new InvalidArgumentException('Asset name must contain 1–150 letters/numbers/spaces/hyphens.');
        return $name;
    }
    private static function cleanCategory(string $category): string
    {
        $category = trim($category);
        if ($category === '') return '';
        if (!preg_match('/^[A-Za-z0-9 _-]{1,80}$/', $category)) throw new InvalidArgumentException('Invalid asset category.');
        return $category;
    }
    private static function categoryFromPath(string $relative): string
    {
        $parts = explode('/', trim($relative, '/'));
        return count($parts) >= 3 ? $parts[1] : '';
    }
    private static function currentUserId(): ?int
    {
        return class_exists('Auth') ? Auth::id() : null;
    }
    private static function quoteIdentifier(string $value): string
    {
        return '`' . str_replace('`', '``', $value) . '`';
    }
    private static function uploadError(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'The uploaded file is too large.',
            UPLOAD_ERR_PARTIAL => 'The upload was incomplete.',
            UPLOAD_ERR_NO_FILE => 'Please choose a file.',
            UPLOAD_ERR_NO_TMP_DIR => 'Temporary upload directory is unavailable.',
            UPLOAD_ERR_CANT_WRITE => 'The server could not write the uploaded file.',
            UPLOAD_ERR_EXTENSION => 'The upload was blocked by a server extension.',
            default => 'The upload failed.'
        };
    }
}
