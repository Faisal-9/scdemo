<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/DatabaseBackupManager.php';
Auth::requirePermission('manage_database_backups');
$type = (string)($_GET['type'] ?? 'full');
if (!in_array($type, ['full', 'schema'], true)) {
    http_response_code(400);
    exit('Invalid backup type.');
}
DatabaseBackupManager::exportSql($type === 'full');
exit;
