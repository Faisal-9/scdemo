<?php

declare(strict_types=1);

/**
 * State Corps CMS — Secure Backup Vault.
 * Stores generated SQL backups outside the public document root by default.
 */
final class BackupVaultManager
{
    public static function storageDir(): string
    {
        if (defined('SC_BACKUP_STORAGE') && is_string(SC_BACKUP_STORAGE) && SC_BACKUP_STORAGE !== '') {
            return rtrim(SC_BACKUP_STORAGE, DIRECTORY_SEPARATOR);
        }
        // app/core -> project root -> project storage directory.
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'backups';
    }

    public static function ensureStorage(): void
    {
        $dir = self::storageDir();
        if (!is_dir($dir) && !@mkdir($dir, 0750, true)) {
            throw new RuntimeException('Backup storage directory could not be created: ' . $dir);
        }
        if (!is_writable($dir)) {
            throw new RuntimeException('Backup storage directory is not writable. Configure SC_BACKUP_STORAGE or filesystem permissions.');
        }
    }

    public static function listBackups(): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->query(
            "SELECT b.id, b.filename, b.backup_type, b.size_bytes, b.sha256,
                    b.created_by, b.created_at, u.display_name AS creator_name, u.username AS creator_username
             FROM database_backups b
             LEFT JOIN users u ON u.id = b.created_by
             ORDER BY b.created_at DESC, b.id DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get(int $id): ?array
    {
        $stmt = Database::connection()->prepare(
            "SELECT b.id, b.filename, b.backup_type, b.size_bytes, b.sha256,
                    b.created_by, b.created_at, u.display_name AS creator_name, u.username AS creator_username
             FROM database_backups b
             LEFT JOIN users u ON u.id = b.created_by
             WHERE b.id = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function create(string $type, ?int $userId): array
    {
        $type = strtolower(trim($type));
        if (!in_array($type, ['full', 'schema'], true)) {
            throw new InvalidArgumentException('Unsupported backup type.');
        }
        self::ensureStorage();

        $pdo = Database::connection();
        $dbName = (string)$pdo->query('SELECT DATABASE()')->fetchColumn();
        if ($dbName === '') {
            throw new RuntimeException('No active database is configured.');
        }

        $suffix = date('Ymd_His') . '_' . bin2hex(random_bytes(4));
        $safeDb = preg_replace('/[^A-Za-z0-9_-]+/', '_', $dbName) ?: 'database';
        $filename = $safeDb . '_cms_' . $type . '_' . $suffix . '.sql';
        $tmp = self::storageDir() . DIRECTORY_SEPARATOR . '.' . $filename . '.part';
        $path = self::storageDir() . DIRECTORY_SEPARATOR . $filename;

        $handle = @fopen($tmp, 'wb');
        if ($handle === false) {
            throw new RuntimeException('Could not open the backup file for writing.');
        }

        try {
            self::write($handle, $pdo, $dbName, $type === 'full');
            fflush($handle);
            fclose($handle);
            $handle = null;
            if (!@rename($tmp, $path)) {
                throw new RuntimeException('Could not finalize the backup file.');
            }
            $size = (int)@filesize($path);
            $sha = @hash_file('sha256', $path);
            if ($size < 1 || !is_string($sha)) {
                throw new RuntimeException('Backup integrity check failed.');
            }

            $stmt = $pdo->prepare(
                "INSERT INTO database_backups (filename, backup_type, size_bytes, sha256, created_by)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$filename, $type, $size, $sha, $userId]);
            $id = (int)$pdo->lastInsertId();
            return self::get($id) ?? throw new RuntimeException('Backup metadata could not be loaded.');
        } catch (Throwable $e) {
            if (is_resource($handle)) {
                fclose($handle);
            }
            @unlink($tmp);
            @unlink($path);
            throw $e;
        }
    }

    public static function verify(array $backup): array
    {
        $path = self::storageDir() . DIRECTORY_SEPARATOR . basename((string)$backup['filename']);
        if (!is_file($path)) {
            return ['status' => 'missing', 'message' => 'Backup file is missing from the vault.'];
        }
        $size = (int)@filesize($path);
        $hash = @hash_file('sha256', $path);
        if (!is_string($hash)) {
            return ['status' => 'error', 'message' => 'Could not calculate the file checksum.'];
        }
        if ($size !== (int)$backup['size_bytes'] || !hash_equals((string)$backup['sha256'], $hash)) {
            return ['status' => 'failed', 'message' => 'Checksum or file size does not match the stored integrity record.'];
        }
        return ['status' => 'ok', 'message' => 'Backup file matches its stored size and SHA-256 checksum.'];
    }

    public static function delete(int $id): void
    {
        $backup = self::get($id);
        if (!$backup) {
            throw new RuntimeException('Backup not found.');
        }
        $path = self::storageDir() . DIRECTORY_SEPARATOR . basename((string)$backup['filename']);
        $pdo = Database::connection();
        $stmt = $pdo->prepare('DELETE FROM database_backups WHERE id = ?');
        $stmt->execute([$id]);
        if (is_file($path)) {
            @unlink($path);
        }
    }

    public static function download(array $backup): void
    {
        $path = self::storageDir() . DIRECTORY_SEPARATOR . basename((string)$backup['filename']);
        if (!is_file($path) || !is_readable($path)) {
            throw new RuntimeException('Backup file is unavailable.');
        }
        $verify = self::verify($backup);
        if ($verify['status'] !== 'ok') {
            throw new RuntimeException('Backup failed integrity verification and cannot be downloaded.');
        }
        while (ob_get_level() > 0) {
            @ob_end_clean();
        }
        header('Content-Type: application/sql; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . basename((string)$backup['filename']) . '"');
        header('Content-Length: ' . (string)filesize($path));
        header('Cache-Control: private, no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('X-Content-Type-Options: nosniff');
        readfile($path);
    }

    public static function formatBytes(int $bytes): string
    {
        if ($bytes < 1024) return $bytes . ' B';
        $units = ['KB', 'MB', 'GB', 'TB'];
        $value = (float)$bytes;
        foreach ($units as $unit) {
            $value /= 1024;
            if ($value < 1024) return number_format($value, $value < 10 ? 1 : 0) . ' ' . $unit;
        }
        return number_format($value, 1) . ' PB';
    }

    private static function write($handle, PDO $pdo, string $dbName, bool $withData): void
    {
        self::out($handle, "-- State Corps CMS database backup\n");
        self::out($handle, '-- Generated: ' . date('Y-m-d H:i:s') . "\n");
        self::out($handle, '-- Database: ' . str_replace(["\r", "\n"], ' ', $dbName) . "\n\n");
        self::out($handle, "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\nSET time_zone = \"+00:00\";\nSET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\n\n");
        $tables = $pdo->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME")
            ->fetchAll(PDO::FETCH_COLUMN);
        foreach ($tables as $table) {
            self::dumpTable($handle, $pdo, (string)$table, $withData);
        }
        self::out($handle, "SET FOREIGN_KEY_CHECKS=1;\n-- End of backup\n");
    }

    private static function dumpTable($handle, PDO $pdo, string $table, bool $withData): void
    {
        $quoted = self::quoteIdentifier($table);
        $row = $pdo->query('SHOW CREATE TABLE ' . $quoted)->fetch(PDO::FETCH_ASSOC);
        if (!$row) return;
        $create = '';
        foreach ($row as $key => $value) {
            if (stripos((string)$key, 'create') !== false) {
                $create = (string)$value;
                break;
            }
        }
        self::out($handle, "-- --------------------------------------------------------\n-- Table: " . str_replace(["\r", "\n"], ' ', $table) . "\n\n");
        self::out($handle, 'DROP TABLE IF EXISTS ' . $quoted . ";\n" . $create . ";\n\n");
        if (!$withData) return;

        $data = $pdo->query('SELECT * FROM ' . $quoted);
        $columns = [];
        for ($i = 0; $i < $data->columnCount(); $i++) {
            $meta = $data->getColumnMeta($i);
            $columns[] = self::quoteIdentifier((string)($meta['name'] ?? 'column_' . $i));
        }
        $columnSql = '(' . implode(', ', $columns) . ')';
        $batch = [];
        while ($record = $data->fetch(PDO::FETCH_NUM)) {
            $values = [];
            foreach ($record as $value) {
                $values[] = self::sqlValue($value);
            }
            $batch[] = '(' . implode(', ', $values) . ')';
            if (count($batch) >= 100) {
                self::out($handle, 'INSERT INTO ' . $quoted . ' ' . $columnSql . " VALUES\n" . implode(",\n", $batch) . ";\n");
                $batch = [];
            }
        }
        if ($batch) {
            self::out($handle, 'INSERT INTO ' . $quoted . ' ' . $columnSql . " VALUES\n" . implode(",\n", $batch) . ";\n");
        }
        self::out($handle, "\n");
    }

    private static function sqlValue(mixed $value): string
    {
        if ($value === null) return 'NULL';
        if (is_bool($value)) return $value ? '1' : '0';
        if (is_int($value) || is_float($value)) return (string)$value;
        return "'" . str_replace(["\\", "'", "\0", "\n", "\r", "\x1a"], ["\\\\", "\\'", "\\0", "\\n", "\\r", "\\Z"], (string)$value) . "'";
    }

    private static function quoteIdentifier(string $identifier): string
    {
        if (!preg_match('/^[A-Za-z0-9_$]+$/', $identifier)) throw new InvalidArgumentException('Unsafe SQL identifier.');
        return '`' . $identifier . '`';
    }

    private static function out($handle, string $data): void
    {
        if (@fwrite($handle, $data) === false) throw new RuntimeException('Failed while writing the backup file.');
    }
}
