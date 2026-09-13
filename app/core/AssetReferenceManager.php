<?php
declare(strict_types=1);

/**
 * Phase 22: Asset Usage / Reference Checker.
 * Read-only diagnostics for the existing media_library upload library.
 * No content or file records are modified by this class.
 */
final class AssetReferenceManager
{
    private const TEXT_TYPES = [
        'char', 'varchar', 'tinytext', 'text', 'mediumtext', 'longtext',
    ];

    /**
     * Return a summary of the upload library and filesystem consistency.
     */
    public static function summary(): array
    {
        $pdo = Database::connection();

        $assetCount = (int)$pdo->query('SELECT COUNT(*) FROM media_library')->fetchColumn();
        $imageCount = (int)$pdo->query("SELECT COUNT(*) FROM media_library WHERE mime_type LIKE 'image/%'")->fetchColumn();
        $pdfCount = (int)$pdo->query("SELECT COUNT(*) FROM media_library WHERE mime_type = 'application/pdf'")->fetchColumn();

        $missingDbFiles = 0;
        $missingDbBytes = 0;
        foreach (self::libraryRows() as $row) {
            $path = self::absoluteFromRelative((string)$row['relative_path']);
            if (!is_file($path)) {
                $missingDbFiles++;
                $missingDbBytes += (int)$row['file_size'];
            }
        }

        $filesystem = self::filesystemInventory();
        $registered = [];
        foreach (self::libraryRows() as $row) {
            $registered[(string)$row['relative_path']] = true;
        }

        $unregisteredFiles = 0;
        $unregisteredBytes = 0;
        foreach ($filesystem as $relative => $meta) {
            if (!isset($registered[$relative])) {
                $unregisteredFiles++;
                $unregisteredBytes += (int)$meta['size'];
            }
        }

        $referenced = self::referenceCountsForPaths(array_keys($registered));
        $usedAssets = 0;
        foreach ($referenced as $count) {
            if ($count > 0) $usedAssets++;
        }

        return [
            'asset_count' => $assetCount,
            'image_count' => $imageCount,
            'pdf_count' => $pdfCount,
            'used_assets' => $usedAssets,
            'unused_assets' => max(0, $assetCount - $usedAssets),
            'missing_db_files' => $missingDbFiles,
            'missing_db_bytes' => $missingDbBytes,
            'unregistered_files' => $unregisteredFiles,
            'unregistered_bytes' => $unregisteredBytes,
        ];
    }

    /**
     * Library rows with a calculated reference count and existence flag.
     */
    public static function assets(string $search = '', string $usage = ''): array
    {
        $rows = self::libraryRows($search);
        $paths = [];
        foreach ($rows as $row) {
            $paths[] = (string)$row['relative_path'];
        }

        $counts = self::referenceCountsForPaths($paths);
        $out = [];
        foreach ($rows as $row) {
            $relative = (string)$row['relative_path'];
            $count = (int)($counts[$relative] ?? 0);
            $exists = is_file(self::absoluteFromRelative($relative));
            $row['reference_count'] = $count;
            $row['file_exists'] = $exists;
            $state = !$exists ? 'missing' : ($count > 0 ? 'used' : 'unused');
            if ($usage !== '' && $usage !== $state) continue;
            $out[] = $row;
        }
        return $out;
    }

    /**
     * Find every database text field that contains a given relative path.
     * Returns one result per table/column/row.
     */
    public static function referencesForPath(string $relativePath): array
    {
        $relativePath = self::normalizeRelativePath($relativePath);
        if ($relativePath === '') return [];

        $pdo = Database::connection();
        $targets = self::textColumns();
        $results = [];

        foreach ($targets as $target) {
            $table = self::quoteIdentifier($target['table_name']);
            $column = self::quoteIdentifier($target['column_name']);
            $pkColumn = self::quoteIdentifier($target['pk_column']);
            $sql = "SELECT {$pkColumn} AS row_id, {$column} AS column_value FROM {$table} WHERE LOCATE(:needle, {$column}) > 0 LIMIT 250";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['needle' => $relativePath]);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $value = (string)$row['column_value'];
                $results[] = [
                    'table_name' => $target['table_name'],
                    'column_name' => $target['column_name'],
                    'row_id' => $row['row_id'],
                    'snippet' => self::snippet($value, $relativePath),
                ];
            }
        }

        return $results;
    }

    /**
     * Inventory the upload directory only. Other public assets are not scanned here.
     */
    public static function filesystemInventory(): array
    {
        $root = self::uploadRoot();
        if (!is_dir($root)) return [];

        $result = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (!$file->isFile()) continue;
            $absolute = $file->getPathname();
            $relative = 'assets/uploads/' . str_replace(DIRECTORY_SEPARATOR, '/', substr($absolute, strlen($root) + 1));
            $result[$relative] = [
                'size' => $file->getSize(),
                'modified_at' => date('Y-m-d H:i:s', $file->getMTime()),
            ];
        }

        ksort($result);
        return $result;
    }

    /**
     * Files in assets/uploads that are not represented in media_library.
     */
    public static function unregisteredFiles(): array
    {
        $registered = [];
        foreach (self::libraryRows() as $row) {
            $registered[(string)$row['relative_path']] = true;
        }

        $out = [];
        foreach (self::filesystemInventory() as $relative => $meta) {
            if (!isset($registered[$relative])) {
                $out[] = [
                    'relative_path' => $relative,
                    'file_size' => (int)$meta['size'],
                    'modified_at' => $meta['modified_at'],
                ];
            }
        }
        return $out;
    }

    private static function libraryRows(string $search = ''): array
    {
        $pdo = Database::connection();
        $sql = 'SELECT id, original_name, relative_path, mime_type, file_size, alt_text, category, created_by, created_at, updated_at FROM media_library';
        $params = [];
        if ($search !== '') {
            $sql .= ' WHERE original_name LIKE :q OR relative_path LIKE :q OR category LIKE :q OR alt_text LIKE :q';
            $params['q'] = '%' . mb_substr($search, 0, 150) . '%';
        }
        $sql .= ' ORDER BY created_at DESC, id DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function referenceCountsForPaths(array $paths): array
    {
        $counts = [];
        foreach ($paths as $path) $counts[$path] = 0;
        foreach ($paths as $path) {
            $counts[$path] = count(self::referencesForPath($path));
        }
        return $counts;
    }

    private static function textColumns(): array
    {
        $pdo = Database::connection();
        $placeholders = implode(',', array_fill(0, count(self::TEXT_TYPES), '?'));
        $sql = "SELECT c.TABLE_NAME AS table_name, c.COLUMN_NAME AS column_name,
                       pk.COLUMN_NAME AS pk_column
                FROM information_schema.COLUMNS c
                INNER JOIN (
                    SELECT tc.TABLE_SCHEMA, tc.TABLE_NAME, kcu.COLUMN_NAME
                    FROM information_schema.TABLE_CONSTRAINTS tc
                    INNER JOIN information_schema.KEY_COLUMN_USAGE kcu
                        ON kcu.CONSTRAINT_SCHEMA = tc.CONSTRAINT_SCHEMA
                       AND kcu.CONSTRAINT_NAME = tc.CONSTRAINT_NAME
                       AND kcu.TABLE_SCHEMA = tc.TABLE_SCHEMA
                       AND kcu.TABLE_NAME = tc.TABLE_NAME
                    WHERE tc.CONSTRAINT_TYPE = 'PRIMARY KEY'
                ) pk ON pk.TABLE_SCHEMA = c.TABLE_SCHEMA AND pk.TABLE_NAME = c.TABLE_NAME
                WHERE c.TABLE_SCHEMA = DATABASE()
                  AND c.DATA_TYPE IN ($placeholders)
                  AND c.TABLE_NAME NOT IN ('audit_logs', 'content_revisions')
                ORDER BY c.TABLE_NAME, c.ORDINAL_POSITION";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(self::TEXT_TYPES);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function snippet(string $value, string $needle): string
    {
        $pos = mb_stripos($value, $needle);
        if ($pos === false) return mb_substr($value, 0, 180);
        $start = max(0, $pos - 90);
        $snippet = mb_substr($value, $start, 240);
        if ($start > 0) $snippet = '…' . $snippet;
        if ($start + 240 < mb_strlen($value)) $snippet .= '…';
        return $snippet;
    }

    private static function quoteIdentifier(string $value): string
    {
        return '`' . str_replace('`', '``', $value) . '`';
    }

    private static function normalizeRelativePath(string $path): string
    {
        $path = trim(str_replace('\\', '/', $path));
        $path = ltrim($path, '/');
        if (!str_starts_with($path, 'assets/uploads/')) return '';
        if (str_contains($path, '..')) return '';
        return $path;
    }

    private static function absoluteFromRelative(string $relative): string
    {
        $relative = self::normalizeRelativePath($relative);
        if ($relative === '') return '';
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    }

    private static function uploadRoot(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads';
    }
}
