<?php

declare(strict_types=1);

/**
 * State Corps CMS — Extended System Health Center.
 * Read-only diagnostics. Never changes database rows or public files.
 */
final class SystemHealthManager
{
    /** @return array{overall:string,score:int,summary:array,groups:array<int,array>,generated_at:string} */
    public static function report(): array
    {
        $checks = [
            self::phpCheck(),
            self::extensionsCheck(),
            self::databaseCheck(),
            self::schemaCheck(),
            self::dataIntegrityCheck(),
            self::usersPermissionsCheck(),
            self::auditActivityCheck(),
            self::filesystemCheck(),
            self::assetHealthCheck(),
            self::storageCheck(),
            self::uploadConfigCheck(),
            self::runtimeConfigCheck(),
            self::sessionCheck(),
            self::securityHeadersCheck(),
            self::opcacheCheck(),
        ];

        $counts = ['ok' => 0, 'warning' => 0, 'critical' => 0];
        $weightedTotal = 0;
        $weightedEarned = 0;
        foreach ($checks as $check) {
            $status = $check['status'];
            $counts[$status]++;
            $weight = (int)($check['weight'] ?? 1);
            $weightedTotal += $weight;
            $weightedEarned += $status === 'ok' ? $weight : ($status === 'warning' ? (int)round($weight * .55) : 0);
        }
        $score = $weightedTotal > 0 ? (int)round(($weightedEarned / $weightedTotal) * 100) : 0;
        $overall = $counts['critical'] > 0 ? 'critical' : ($counts['warning'] > 0 ? 'warning' : 'ok');

        $groups = [
            ['key' => 'environment', 'title' => 'Environment & Runtime', 'icon' => '⚙', 'checks' => array_values(array_filter($checks, static fn(array $c): bool => in_array($c['key'], ['php', 'extensions', 'runtime', 'session', 'opcache'], true)))],
            ['key' => 'database', 'title' => 'Database & CMS Data', 'icon' => '◉', 'checks' => array_values(array_filter($checks, static fn(array $c): bool => in_array($c['key'], ['database', 'schema', 'integrity', 'users'], true)))],
            ['key' => 'activity', 'title' => 'Activity & Security', 'icon' => '✓', 'checks' => array_values(array_filter($checks, static fn(array $c): bool => in_array($c['key'], ['audit', 'headers'], true)))],
            ['key' => 'storage', 'title' => 'Files, Assets & Storage', 'icon' => '▣', 'checks' => array_values(array_filter($checks, static fn(array $c): bool => in_array($c['key'], ['filesystem', 'assets', 'storage', 'uploads'], true)))],
        ];

        return [
            'overall' => $overall,
            'score' => $score,
            'summary' => $counts,
            'groups' => $groups,
            'generated_at' => date('Y-m-d H:i:s'),
        ];
    }

    private static function phpCheck(): array
    {
        $version = PHP_VERSION;
        $ok = version_compare($version, '8.1.0', '>=');
        return self::check('php', 'PHP Runtime', $ok ? 'ok' : 'critical', $ok ? 'PHP meets the CMS runtime baseline.' : 'PHP is below the CMS runtime baseline.', [
            'Version: ' . $version,
            'SAPI: ' . PHP_SAPI,
            'memory_limit: ' . (string)ini_get('memory_limit'),
            'max_execution_time: ' . (string)ini_get('max_execution_time') . ' seconds',
        ], 3);
    }

    private static function extensionsCheck(): array
    {
        $required = ['PDO', 'pdo_mysql', 'mbstring', 'fileinfo', 'json', 'session'];
        $missing = array_values(array_filter($required, static fn(string $e): bool => !extension_loaded($e)));
        return self::check(
            'extensions',
            'Required PHP Extensions',
            $missing ? 'critical' : 'ok',
            $missing ? 'One or more required extensions are unavailable.' : 'All core CMS extensions are loaded.',
            $missing ? ['Missing: ' . implode(', ', $missing)] : ['Loaded: ' . implode(', ', $required)],
            3
        );
    }

    private static function databaseCheck(): array
    {
        try {
            $pdo = Database::connection();
            $version = (string)$pdo->query('SELECT VERSION()')->fetchColumn();
            $driver = (string)$pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
            $charset = '';
            try {
                $charset = (string)$pdo->query('SELECT @@character_set_database')->fetchColumn();
            } catch (Throwable) {
            }
            return self::check('database', 'Database Connection', 'ok', 'The CMS can connect to the configured database.', [
                'Driver: ' . $driver,
                'Server: ' . $version,
                'Database charset: ' . ($charset !== '' ? $charset : 'not detected'),
            ], 4);
        } catch (Throwable $e) {
            return self::check('database', 'Database Connection', 'critical', 'Database connection failed.', ['Error class: ' . get_class($e)], 5);
        }
    }

    private static function schemaCheck(): array
    {
        $required = [
            'users',
            'permissions',
            'user_permissions',
            'audit_logs',
            'media_library',
            'site_settings',
            'projects',
            'service_groups',
            'service_categories',
            'service_items',
            'sectors',
            'legal_documents',
            'contact_messages',
        ];
        try {
            $pdo = Database::connection();
            $placeholders = implode(',', array_fill(0, count($required), '?'));
            $stmt = $pdo->prepare('SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME IN (' . $placeholders . ')');
            $stmt->execute($required);
            $found = array_fill_keys($stmt->fetchAll(PDO::FETCH_COLUMN), true);
            $missing = array_values(array_filter($required, static fn(string $t): bool => !isset($found[$t])));
            return self::check(
                'schema',
                'CMS Database Schema',
                $missing ? 'critical' : 'ok',
                $missing ? 'Expected CMS tables are missing.' : 'Core CMS tables are present.',
                $missing ? ['Missing: ' . implode(', ', $missing)] : ['Checked: ' . count($required) . ' core tables'],
                5
            );
        } catch (Throwable $e) {
            return self::check('schema', 'CMS Database Schema', 'critical', 'Schema inspection failed.', ['Error class: ' . get_class($e)], 5);
        }
    }

    private static function dataIntegrityCheck(): array
    {
        try {
            $pdo = Database::connection();
            $orphans = (int)$pdo->query('SELECT COUNT(*) FROM user_permissions up LEFT JOIN users u ON u.id = up.user_id WHERE u.id IS NULL')->fetchColumn();
            $orphanPerms = (int)$pdo->query('SELECT COUNT(*) FROM user_permissions up LEFT JOIN permissions p ON p.id = up.permission_id WHERE p.id IS NULL')->fetchColumn();
            $duplicateUsers = (int)$pdo->query('SELECT COUNT(*) FROM (SELECT username FROM users GROUP BY username HAVING COUNT(*) > 1) d')->fetchColumn();
            $problems = [];
            if ($orphans > 0) $problems[] = 'Orphan user permission links: ' . $orphans;
            if ($orphanPerms > 0) $problems[] = 'Permission links to missing permissions: ' . $orphanPerms;
            if ($duplicateUsers > 0) $problems[] = 'Duplicate usernames: ' . $duplicateUsers;
            return self::check(
                'integrity',
                'Data Integrity',
                $problems ? 'warning' : 'ok',
                $problems ? 'Some referential or uniqueness issues were detected.' : 'No obvious user/permission integrity issues detected.',
                $problems ?: ['User/permission relationships look consistent.'],
                4
            );
        } catch (Throwable $e) {
            return self::check('integrity', 'Data Integrity', 'warning', 'Integrity checks could not be completed.', ['Error class: ' . get_class($e)], 2);
        }
    }

    private static function usersPermissionsCheck(): array
    {
        try {
            $pdo = Database::connection();
            $admin = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='admin' AND status='active'")->fetchColumn();
            $editors = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='editor' AND status='active'")->fetchColumn();
            $inactive = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE status='inactive'")->fetchColumn();
            $manageHealth = (int)$pdo->query("SELECT COUNT(*) FROM permissions WHERE permission_key='manage_system_health'")->fetchColumn();
            $status = 'ok';
            $details = ['Active admins: ' . $admin, 'Active editors: ' . $editors, 'Inactive users: ' . $inactive];
            if ($admin < 1) {
                $status = 'critical';
                $details[] = 'No active administrator account was detected.';
            }
            if ($editors > 3) {
                $status = 'warning';
                $details[] = 'Active editors exceed the planned maximum of 3.';
            }
            if ($manageHealth < 1) {
                $status = 'warning';
                $details[] = 'manage_system_health permission is missing.';
            }
            return self::check('users', 'Users & Permissions', $status, $status === 'ok' ? 'CMS account structure looks healthy.' : 'Review the CMS account and permission configuration.', $details, 4);
        } catch (Throwable $e) {
            return self::check('users', 'Users & Permissions', 'warning', 'User/permission health could not be fully checked.', ['Error class: ' . get_class($e)], 2);
        }
    }

    private static function auditActivityCheck(): array
    {
        try {
            $pdo = Database::connection();
            $total = (int)$pdo->query('SELECT COUNT(*) FROM audit_logs')->fetchColumn();
            $recent = (int)$pdo->query("SELECT COUNT(*) FROM audit_logs WHERE created_at >= (NOW() - INTERVAL 24 HOUR)")->fetchColumn();
            $last = (string)($pdo->query('SELECT created_at FROM audit_logs ORDER BY id DESC LIMIT 1')->fetchColumn() ?: 'Never');
            return self::check('audit', 'Activity Log Health', 'ok', 'Audit logging is available and receiving records.', [
                'Total log entries: ' . $total,
                'Entries in last 24 hours: ' . $recent,
                'Latest entry: ' . $last,
            ], 3);
        } catch (Throwable $e) {
            return self::check('audit', 'Activity Log Health', 'critical', 'Audit log table could not be checked.', ['Error class: ' . get_class($e)], 4);
        }
    }

    private static function filesystemCheck(): array
    {
        $root = dirname(__DIR__, 2);
        $paths = ['app' => $root . '/app', 'assets' => $root . '/assets', 'uploads' => $root . '/assets/uploads', 'scadmin' => $root . '/scadmin'];
        $missing = [];
        $unwritable = [];
        foreach ($paths as $name => $path) {
            if (!is_dir($path)) $missing[] = $name;
            elseif (in_array($name, ['uploads'], true) && !is_writable($path)) $unwritable[] = $name;
        }
        if ($missing) return self::check('filesystem', 'CMS Directories', 'critical', 'Required CMS directories are missing.', ['Missing: ' . implode(', ', $missing)], 4);
        if ($unwritable) return self::check('filesystem', 'CMS Directories', 'warning', 'The upload directory is not writable.', ['Not writable: ' . implode(', ', $unwritable)], 3);
        return self::check('filesystem', 'CMS Directories', 'ok', 'Core CMS directories exist and uploads are writable.', [], 3);
    }

    private static function assetHealthCheck(): array
    {
        try {
            $pdo = Database::connection();
            $count = (int)$pdo->query('SELECT COUNT(*) FROM media_library')->fetchColumn();
            $published = 0;
            $missing = 0;
            try {
                $published = (int)$pdo->query("SELECT COUNT(*) FROM media_library WHERE status='active'")->fetchColumn();
            } catch (Throwable) {
            }
            $root = dirname(__DIR__, 2);
            $stmt = $pdo->query('SELECT file_path FROM media_library WHERE file_path IS NOT NULL AND file_path <> "" LIMIT 5000');
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $path = ltrim((string)$row['file_path'], '/\\');
                $path = str_starts_with($path, 'publicV6/') ? substr($path, 9) : $path;
                if (!is_file($root . '/' . $path)) $missing++;
            }
            $status = $missing > 0 ? 'warning' : 'ok';
            $details = ['Media library records: ' . $count, 'Active assets: ' . $published, 'Missing physical files detected: ' . $missing];
            if ($count > 5000) $details[] = 'Reference check sampled the first 5,000 records for safety.';
            return self::check('assets', 'Asset Library Health', $status, $missing ? 'Some asset records point to missing files.' : 'Asset records currently map to physical files.', $details, 4);
        } catch (Throwable $e) {
            return self::check('assets', 'Asset Library Health', 'warning', 'Asset library could not be fully inspected.', ['Error class: ' . get_class($e)], 2);
        }
    }

    private static function storageCheck(): array
    {
        $root = dirname(__DIR__, 2);
        $uploads = $root . '/assets/uploads';
        $free = @disk_free_space($root);
        $total = @disk_total_space($root);
        $uploadBytes = self::directorySize($uploads);
        $fileCount = self::directoryFileCount($uploads);
        $details = [
            'Uploads files: ' . $fileCount,
            'Uploads size: ' . self::formatBytes($uploadBytes),
        ];
        if ($free !== false && $total !== false && $total > 0) {
            $usedPct = (int)round((1 - ($free / $total)) * 100);
            $details[] = 'Disk free: ' . self::formatBytes((int)$free) . ' of ' . self::formatBytes((int)$total) . ' (' . $usedPct . '% used)';
            $status = $free < 512 * 1024 * 1024 ? 'critical' : ($free < 2 * 1024 * 1024 * 1024 ? 'warning' : 'ok');
            $message = $status === 'ok' ? 'Available disk space looks healthy.' : 'Available disk space should be monitored.';
        } else {
            $status = 'warning';
            $message = 'Disk capacity could not be determined by PHP.';
        }
        return self::check('storage', 'Storage & Disk Space', $status, $message, $details, 3);
    }

    private static function uploadConfigCheck(): array
    {
        $uploadMax = self::iniBytes((string)ini_get('upload_max_filesize'));
        $postMax = self::iniBytes((string)ini_get('post_max_size'));
        $memory = self::iniBytes((string)ini_get('memory_limit'));
        $required = 15 * 1024 * 1024;
        $limit = min($uploadMax ?: PHP_INT_MAX, $postMax ?: PHP_INT_MAX);
        $status = $limit >= $required ? 'ok' : 'warning';
        return self::check('uploads', 'Upload Configuration', $status, $status === 'ok' ? 'Server upload limits accommodate the CMS PDF maximum.' : 'Server upload limits are below the CMS PDF maximum.', [
            'upload_max_filesize: ' . (string)ini_get('upload_max_filesize'),
            'post_max_size: ' . (string)ini_get('post_max_size'),
            'memory_limit: ' . (string)ini_get('memory_limit'),
            'CMS PDF maximum: 15M',
        ], 3);
    }

    private static function runtimeConfigCheck(): array
    {
        $issues = [];
        $display = (string)ini_get('display_errors');
        $log = (string)ini_get('log_errors');
        $timezone = (string)date_default_timezone_get();
        if ($display === '1') $issues[] = 'display_errors is enabled; production deployments should normally disable it.';
        if ($log !== '1') $issues[] = 'log_errors is disabled; production diagnostics may be harder to trace.';
        if ($timezone === '' || $timezone === 'UTC') $issues[] = 'PHP timezone is ' . ($timezone ?: 'unset') . '; confirm it matches the server/application expectation.';
        return self::check('runtime', 'Runtime Configuration', $issues ? 'warning' : 'ok', $issues ? 'Some runtime settings deserve review.' : 'Common production runtime settings look reasonable.', array_merge(['Timezone: ' . $timezone, 'display_errors: ' . ($display !== '' ? $display : 'unset'), 'log_errors: ' . ($log !== '' ? $log : 'unset')], $issues), 2);
    }

    private static function sessionCheck(): array
    {
        $status = session_status() !== PHP_SESSION_DISABLED ? 'ok' : 'critical';
        return self::check('session', 'PHP Sessions', $status, $status === 'ok' ? 'PHP sessions are available.' : 'PHP sessions are disabled.', ['save_path: ' . (string)ini_get('session.save_path')], 3);
    }

    private static function securityHeadersCheck(): array
    {
        $headers = headers_list();
        $names = [];
        foreach ($headers as $header) {
            $parts = explode(':', $header, 2);
            $names[strtolower(trim($parts[0]))] = true;
        }
        $missing = [];
        foreach (['x-content-type-options', 'x-frame-options', 'referrer-policy'] as $name) if (!isset($names[$name])) $missing[] = $name;
        return self::check('headers', 'Response Security Headers', $missing ? 'warning' : 'ok', $missing ? 'Some recommended security headers were not detected on the current response.' : 'Recommended security headers were detected.', $missing ? array_map(static fn(string $n): string => strtoupper($n) . ' not detected', $missing) : ['X-Content-Type-Options', 'X-Frame-Options', 'Referrer-Policy'], 2);
    }

    private static function opcacheCheck(): array
    {
        if (!function_exists('opcache_get_status')) return self::check('opcache', 'OPcache', 'warning', 'OPcache extension is not available.', ['PHP opcache_get_status() is unavailable.'], 1);
        $status = @opcache_get_status(false);
        if (!is_array($status) || !($status['opcache_enabled'] ?? false)) return self::check('opcache', 'OPcache', 'warning', 'OPcache is available but disabled.', [], 1);
        $memory = $status['memory_usage'] ?? [];
        $freePct = isset($memory['free_memory'], $memory['used_memory']) && ($memory['free_memory'] + $memory['used_memory']) > 0
            ? (int)round(($memory['free_memory'] / ($memory['free_memory'] + $memory['used_memory'])) * 100) : null;
        return self::check('opcache', 'OPcache', 'ok', 'PHP OPcache is enabled.', [$freePct !== null ? 'Approx. free OPcache memory: ' . $freePct . '%' : 'OPcache memory status unavailable'], 1);
    }

    private static function directorySize(string $dir): int
    {
        if (!is_dir($dir)) return 0;
        $size = 0;
        try {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
            foreach ($it as $file) if ($file->isFile()) $size += $file->getSize();
        } catch (Throwable) {
        }
        return $size;
    }

    private static function directoryFileCount(string $dir): int
    {
        if (!is_dir($dir)) return 0;
        $count = 0;
        try {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
            foreach ($it as $file) if ($file->isFile()) $count++;
        } catch (Throwable) {
        }
        return $count;
    }

    private static function formatBytes(int $bytes): string
    {
        if ($bytes <= 0) return '0 B';
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        $value = (float)$bytes;
        while ($value >= 1024 && $i < count($units) - 1) {
            $value /= 1024;
            $i++;
        }
        return number_format($value, $i === 0 ? 0 : 1) . ' ' . $units[$i];
    }

    private static function iniBytes(string $value): int
    {
        $value = trim($value);
        if ($value === '' || $value === '-1') return PHP_INT_MAX;
        $last = strtolower(substr($value, -1));
        $number = (float)$value;
        return (int)match ($last) {
            'g' => $number * 1024 * 1024 * 1024,
            'm' => $number * 1024 * 1024,
            'k' => $number * 1024,
            default => $number
        };
    }

    private static function check(string $key, string $title, string $status, string $message, array $details, int $weight = 1): array
    {
        return ['key' => $key, 'title' => $title, 'status' => $status, 'message' => $message, 'details' => $details, 'weight' => $weight];
    }
}
