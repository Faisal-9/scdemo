<?php

declare(strict_types=1);

/**
 * State Corps CMS — Secure Backup Vault.
 * Stores generated SQL backups directly in the database.
 */
final class BackupVaultManager
{
    public static function listBackups(): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->query(
            "SELECT b.id, b.filename, b.backup_type, b.size_bytes, b.sha256, b.backup_sql,
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
            "SELECT b.id, b.filename, b.backup_type, b.size_bytes, b.sha256, b.backup_sql,
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
        $pdo = Database::connection();
        $dbName = (string)$pdo->query('SELECT DATABASE()')->fetchColumn();
        if ($dbName === '') {
            throw new RuntimeException('No active database is configured.');
        }

        $suffix = date('Ymd_His') . '_' . bin2hex(random_bytes(4));
        $safeDb = preg_replace('/[^A-Za-z0-9_-]+/', '_', $dbName) ?: 'database';
        $filename = $safeDb . '_cms_' . $type . '_' . $suffix . '.sql';
        $handle = @fopen('php://temp', 'w+b');
        if ($handle === false) {
            throw new RuntimeException('Could not open the backup file for writing.');
        }

        try {
            self::write($handle, $pdo, $dbName, $type === 'full');
            fflush($handle);
            rewind($handle);
            $sql = stream_get_contents($handle);
            $size = strlen((string)$sql);
            $sha = hash('sha256', (string)$sql);
            if ($size < 1 || $sql === false) {
                throw new RuntimeException('Backup integrity check failed.');
            }

            $stmt = $pdo->prepare(
                "INSERT INTO database_backups (filename, backup_type, size_bytes, sha256, backup_sql, created_by)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([$filename, $type, $size, $sha, $sql, $userId]);
            $id = (int)$pdo->lastInsertId();
            return self::get($id) ?? throw new RuntimeException('Backup metadata could not be loaded.');
        } catch (Throwable $e) {
            if (is_resource($handle)) {
                fclose($handle);
            }
            throw $e;
        }
    }

    public static function verify(array $backup): array
    {
        $sql = (string)($backup['backup_sql'] ?? '');
        if ($sql === '') {
            return ['status' => 'missing', 'message' => 'Backup SQL is missing from the database.'];
        }
        $size = strlen($sql);
        $hash = hash('sha256', $sql);
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
        $pdo = Database::connection();
        $stmt = $pdo->prepare('DELETE FROM database_backups WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function download(array $backup): void
    {
        $verify = self::verify($backup);
        if ($verify['status'] !== 'ok') {
            throw new RuntimeException('Backup failed integrity verification and cannot be downloaded.');
        }
        while (ob_get_level() > 0) {
            @ob_end_clean();
        }
        header('Content-Type: application/sql; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . basename((string)$backup['filename']) . '"');
        header('Content-Length: ' . (string)strlen((string)$backup['backup_sql']));
        header('Cache-Control: private, no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('X-Content-Type-Options: nosniff');
        echo (string)$backup['backup_sql'];
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
        // Saved backups must not contain previous backup payloads, or each full
        // backup would recursively include the preceding backup and grow forever.
        if (!$withData || $table === 'database_backups') return;

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
