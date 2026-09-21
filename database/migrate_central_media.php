<?php

declare(strict_types=1);

/**
 * Centralize legacy assets without deleting CMS content.
 *
 * Usage:
 *   php database/migrate_central_media.php --dry-run
 *   php database/migrate_central_media.php --execute
 */

require_once __DIR__ . '/../app/bootstrap.php';

$execute = in_array('--execute', $argv ?? [], true);
$dryRun = !$execute;
$root = dirname(__DIR__);
$migrationId = date('Ymd_His');
$archiveRoot = $root . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'media-archive' . DIRECTORY_SEPARATOR . $migrationId;
$centralRoot = $root . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'legacy' . DIRECTORY_SEPARATOR . $migrationId;
$legacyRoots = ['assets/images', 'assets/documents'];

function cmRelative(string $path): string
{
    return ltrim(str_replace(DIRECTORY_SEPARATOR, '/', $path), '/');
}

function cmAbsolute(string $root, string $relative): string
{
    return $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
}

function cmColumnExists(PDO $pdo, string $column): bool
{
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = \'media_library\' AND COLUMN_NAME = ?'
    );
    $stmt->execute([$column]);
    return (int) $stmt->fetchColumn() > 0;
}

function cmTextColumns(PDO $pdo): array
{
    $types = ['char', 'varchar', 'tinytext', 'text', 'mediumtext', 'longtext'];
    $placeholders = implode(',', array_fill(0, count($types), '?'));
    $sql = "SELECT c.TABLE_NAME AS table_name, c.COLUMN_NAME AS column_name
            FROM information_schema.COLUMNS c
            INNER JOIN information_schema.TABLE_CONSTRAINTS tc
              ON tc.TABLE_SCHEMA = c.TABLE_SCHEMA AND tc.TABLE_NAME = c.TABLE_NAME
             AND tc.CONSTRAINT_TYPE = 'PRIMARY KEY'
            WHERE c.TABLE_SCHEMA = DATABASE()
              AND c.DATA_TYPE IN ($placeholders)
              AND c.TABLE_NAME NOT IN ('media_library', 'audit_logs', 'content_revisions')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($types);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cmReplaceReference(PDO $pdo, array $targets, string $old, string $new): int
{
    $count = 0;
    foreach ($targets as $target) {
        $table = '`' . str_replace('`', '``', (string) $target['table_name']) . '`';
        $column = '`' . str_replace('`', '``', (string) $target['column_name']) . '`';
        $stmt = $pdo->prepare("UPDATE {$table} SET {$column} = REPLACE({$column}, :old, :new) WHERE LOCATE(:needle, {$column}) > 0");
        $stmt->execute([':old' => $old, ':new' => $new, ':needle' => $old]);
        $count += $stmt->rowCount();
    }
    return $count;
}

function cmReferenceCount(PDO $pdo, array $targets, string $path): int
{
    $count = 0;
    foreach ($targets as $target) {
        $table = '`' . str_replace('`', '``', (string) $target['table_name']) . '`';
        $column = '`' . str_replace('`', '``', (string) $target['column_name']) . '`';
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM {$table} WHERE LOCATE(:needle, {$column}) > 0");
        $stmt->execute([':needle' => $path]);
        $count += (int) $stmt->fetchColumn();
    }
    return $count;
}

function cmUniqueName(string $directory, string $base, string $extension): string
{
    $base = preg_replace('/[^A-Za-z0-9._-]+/', '-', $base) ?: 'asset';
    $base = trim($base, '.-') ?: 'asset';
    $candidate = $base . '.' . $extension;
    $counter = 1;
    while (is_file($directory . DIRECTORY_SEPARATOR . $candidate)) {
        $candidate = $base . '-' . $counter . '.' . $extension;
        $counter++;
    }
    return $candidate;
}

function cmRemoveEmptyDirectories(string $directory): void
{
    if (!is_dir($directory)) {
        return;
    }
    $children = scandir($directory) ?: [];
    foreach ($children as $child) {
        if ($child === '.' || $child === '..') {
            continue;
        }
        $path = $directory . DIRECTORY_SEPARATOR . $child;
        if (is_dir($path)) {
            cmRemoveEmptyDirectories($path);
        }
    }
    @rmdir($directory);
}

$pdo = Database::connection();
$files = [];
foreach ($legacyRoots as $legacyRoot) {
    $absoluteRoot = cmAbsolute($root, $legacyRoot);
    if (!is_dir($absoluteRoot)) {
        continue;
    }
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($absoluteRoot, FilesystemIterator::SKIP_DOTS));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $files[] = ['absolute' => $file->getPathname(), 'legacy' => $legacyRoot . '/' . cmRelative(substr($file->getPathname(), strlen($absoluteRoot) + 1))];
        }
    }
}

echo ($dryRun ? 'DRY RUN' : 'EXECUTE') . PHP_EOL;
echo 'Legacy files found: ' . count($files) . PHP_EOL;
echo 'Archive: ' . $archiveRoot . PHP_EOL;
echo 'Central root: ' . $centralRoot . PHP_EOL;

if ($dryRun) {
    echo 'No files or database records were changed. Run with --execute to apply.' . PHP_EOL;
    exit(0);
}

if (!is_dir($archiveRoot) && !mkdir($archiveRoot, 0750, true) && !is_dir($archiveRoot)) {
    throw new RuntimeException('Could not create the media archive directory.');
}
if (!is_dir($centralRoot) && !mkdir($centralRoot, 0750, true) && !is_dir($centralRoot)) {
    throw new RuntimeException('Could not create the centralized media directory.');
}

$targets = cmTextColumns($pdo);
$optionalColumns = array_values(array_filter(
    ['checksum', 'width_px', 'height_px', 'storage_scope', 'status'],
    static fn(string $column): bool => cmColumnExists($pdo, $column)
));
$moved = [];
$references = 0;
$removedLegacyRecords = 0;

try {
    $pdo->beginTransaction();
    foreach ($files as $file) {
        $oldRelative = cmRelative($file['legacy']);
        $extension = strtolower(pathinfo($file['absolute'], PATHINFO_EXTENSION)) ?: 'bin';
        $storedName = cmUniqueName($centralRoot, pathinfo($file['legacy'], PATHINFO_FILENAME), $extension);
        $newAbsolute = $centralRoot . DIRECTORY_SEPARATOR . $storedName;
        $newRelative = 'assets/uploads/legacy/' . $migrationId . '/' . $storedName;
        $archiveAbsolute = cmAbsolute($archiveRoot, $oldRelative);
        if (!is_dir(dirname($archiveAbsolute)) && !mkdir(dirname($archiveAbsolute), 0750, true) && !is_dir(dirname($archiveAbsolute))) {
            throw new RuntimeException('Could not create an archive subdirectory.');
        }
        if (!copy($file['absolute'], $archiveAbsolute) || !rename($file['absolute'], $newAbsolute)) {
            throw new RuntimeException('Could not archive and move: ' . $oldRelative);
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = (string) $finfo->file($newAbsolute);
        $dimensions = str_starts_with($mime, 'image/') ? @getimagesize($newAbsolute) : false;
        $checksum = hash_file('sha256', $newAbsolute) ?: null;
        $category = basename(dirname($oldRelative));
        $columns = ['original_name', 'stored_name', 'relative_path', 'mime_type', 'file_size', 'alt_text', 'category', 'created_by'];
        $values = [basename($oldRelative), $storedName, $newRelative, $mime, filesize($newAbsolute) ?: 0, null, $category, Auth::id() ?: null];
        if (in_array('checksum', $optionalColumns, true)) {
            $columns[] = 'checksum';
            $values[] = $checksum;
        }
        if (in_array('width_px', $optionalColumns, true)) {
            $columns[] = 'width_px';
            $values[] = $dimensions[0] ?? null;
        }
        if (in_array('height_px', $optionalColumns, true)) {
            $columns[] = 'height_px';
            $values[] = $dimensions[1] ?? null;
        }
        if (in_array('storage_scope', $optionalColumns, true)) {
            $columns[] = 'storage_scope';
            $values[] = 'upload';
        }
        if (in_array('status', $optionalColumns, true)) {
            $columns[] = 'status';
            $values[] = 'active';
        }
        $columnSql = implode(',', array_map(static fn(string $column): string => '`' . $column . '`', $columns));
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $stmt = $pdo->prepare("INSERT INTO media_library ({$columnSql}) VALUES ({$placeholders}) ON DUPLICATE KEY UPDATE relative_path=VALUES(relative_path)");
        $stmt->execute($values);
        $references += cmReplaceReference($pdo, $targets, $oldRelative, $newRelative);
        $moved[] = [$file['absolute'], $newAbsolute];
    }

    $legacyRows = $pdo->query("SELECT id, relative_path FROM media_library WHERE relative_path LIKE 'assets/images/%' OR relative_path LIKE 'assets/documents/%'")->fetchAll(PDO::FETCH_ASSOC);
    $delete = $pdo->prepare('DELETE FROM media_library WHERE id = ?');
    foreach ($legacyRows as $legacyRow) {
        if (cmReferenceCount($pdo, $targets, (string) $legacyRow['relative_path']) > 0) {
            throw new RuntimeException('Legacy media record is still referenced: ' . $legacyRow['relative_path']);
        }
        $delete->execute([(int) $legacyRow['id']]);
        $removedLegacyRecords += $delete->rowCount();
    }
    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    foreach (array_reverse($moved) as [$oldAbsolute, $newAbsolute]) {
        if (is_file($newAbsolute)) @rename($newAbsolute, $oldAbsolute);
    }
    throw $e;
}

foreach ($legacyRoots as $legacyRoot) {
    $absoluteRoot = cmAbsolute($root, $legacyRoot);
    if (is_dir($absoluteRoot)) {
        cmRemoveEmptyDirectories($absoluteRoot);
    }
}

echo 'Centralized assets: ' . count($moved) . PHP_EOL;
echo 'Updated database reference rows: ' . $references . PHP_EOL;
echo 'Removed obsolete legacy media records: ' . $removedLegacyRecords . PHP_EOL;
echo 'Backup archive retained at: ' . $archiveRoot . PHP_EOL;
