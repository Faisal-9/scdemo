<?php

declare(strict_types=1);

/**
 * State Corps CMS — Database Backup Center.
 *
 * Generates SQL exports through PDO without requiring mysqldump or shell access.
 * Intended for the existing XAMPP deployment and cPanel-style shared hosting.
 */
final class DatabaseBackupManager
{
    public static function overview(): array
    {
        $pdo = Database::connection();
        $dbName = (string)$pdo->query('SELECT DATABASE()')->fetchColumn();
        $serverVersion = (string)$pdo->query('SELECT VERSION()')->fetchColumn();
        $charset = '';
        $collation = '';
        try {
            $charset = (string)$pdo->query('SELECT @@character_set_database')->fetchColumn();
        } catch (Throwable) {
        }
        try {
            $collation = (string)$pdo->query('SELECT @@collation_database')->fetchColumn();
        } catch (Throwable) {
        }

        $rows = [];
        $stmt = $pdo->query(
            "SELECT TABLE_NAME, ENGINE, TABLE_ROWS, DATA_LENGTH, INDEX_LENGTH, CREATE_TIME, UPDATE_TIME
             FROM information_schema.TABLES
             WHERE TABLE_SCHEMA = DATABASE()
             ORDER BY TABLE_NAME"
        );
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $rows[] = [
                'name' => (string)$row['TABLE_NAME'],
                'engine' => (string)($row['ENGINE'] ?? ''),
                'rows' => (int)($row['TABLE_ROWS'] ?? 0),
                'data_bytes' => (int)($row['DATA_LENGTH'] ?? 0),
                'index_bytes' => (int)($row['INDEX_LENGTH'] ?? 0),
                'create_time' => (string)($row['CREATE_TIME'] ?? ''),
                'update_time' => (string)($row['UPDATE_TIME'] ?? ''),
            ];
        }

        $totalRows = 0;
        $totalBytes = 0;
        $largest = null;
        foreach ($rows as $row) {
            $totalRows += $row['rows'];
            $bytes = $row['data_bytes'] + $row['index_bytes'];
            $totalBytes += $bytes;
            if ($largest === null || $bytes > $largest['bytes']) {
                $largest = ['name' => $row['name'], 'bytes' => $bytes];
            }
        }

        return [
            'database' => $dbName,
            'server_version' => $serverVersion,
            'charset' => $charset,
            'collation' => $collation,
            'tables' => $rows,
            'table_count' => count($rows),
            'total_rows' => $totalRows,
            'estimated_bytes' => $totalBytes,
            'largest_table' => $largest,
        ];
    }

    public static function exportSql(bool $withData = true): void
    {
        $pdo = Database::connection();
        $dbName = (string)$pdo->query('SELECT DATABASE()')->fetchColumn();
        if ($dbName === '') {
            throw new RuntimeException('No active database is configured.');
        }

        $filename = preg_replace('/[^A-Za-z0-9_-]+/', '_', $dbName) . '_cms_backup_' . date('Ymd_His') . '.sql';

        @set_time_limit(0);
        while (ob_get_level() > 0) {
            @ob_end_clean();
        }
        header('Content-Type: application/sql; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: private, no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('X-Content-Type-Options: nosniff');

        echo "-- State Corps CMS database backup\n";
        echo '-- Generated: ' . date('Y-m-d H:i:s') . "\n";
        echo '-- Database: ' . self::sqlComment($dbName) . "\n\n";
        echo "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        echo "SET time_zone = \"+00:00\";\n";
        echo "SET NAMES utf8mb4;\n";
        echo "SET FOREIGN_KEY_CHECKS=0;\n\n";

        $tables = $pdo->query(
            "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME"
        )->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            $table = (string)$table;
            self::dumpTable($pdo, $table, $withData);
            @flush();
        }

        echo "SET FOREIGN_KEY_CHECKS=1;\n";
        echo "-- End of backup\n";
    }

    private static function dumpTable(PDO $pdo, string $table, bool $withData): void
    {
        $quoted = self::quoteIdentifier($table);
        $stmt = $pdo->query('SHOW CREATE TABLE ' . $quoted);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return;
        $create = '';
        foreach ($row as $key => $value) {
            if (stripos((string)$key, 'create') !== false) {
                $create = (string)$value;
                break;
            }
        }
        echo "-- --------------------------------------------------------\n";
        echo '-- Table: ' . self::sqlComment($table) . "\n\n";
        echo 'DROP TABLE IF EXISTS ' . $quoted . ";\n";
        echo $create . ";\n\n";
        // Do not recursively embed saved backup payloads in a full export.
        if (!$withData || $table === 'database_backups') return;

        $data = $pdo->query('SELECT * FROM ' . $quoted);
        $columns = [];
        $columnCount = $data->columnCount();
        for ($i = 0; $i < $columnCount; $i++) {
            $meta = $data->getColumnMeta($i);
            $columns[] = self::quoteIdentifier((string)($meta['name'] ?? 'column_' . $i));
        }
        $columnSql = '(' . implode(', ', $columns) . ')';
        $batch = [];
        $batchLimit = 100;
        while ($record = $data->fetch(PDO::FETCH_NUM)) {
            $values = [];
            foreach ($record as $value) {
                $values[] = self::sqlValue($value);
            }
            $batch[] = '(' . implode(', ', $values) . ')';
            if (count($batch) >= $batchLimit) {
                echo 'INSERT INTO ' . $quoted . ' ' . $columnSql . ' VALUES\n' . implode(",\n", $batch) . ";\n";
                $batch = [];
                @flush();
            }
        }
        if ($batch) {
            echo 'INSERT INTO ' . $quoted . ' ' . $columnSql . ' VALUES\n' . implode(",\n", $batch) . ";\n";
        }
        echo "\n";
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
        if (!preg_match('/^[A-Za-z0-9_$]+$/', $identifier)) {
            throw new InvalidArgumentException('Unsafe SQL identifier.');
        }
        return '`' . $identifier . '`';
    }

    private static function sqlComment(string $value): string
    {
        return str_replace(["\r", "\n"], ' ', $value);
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
}
