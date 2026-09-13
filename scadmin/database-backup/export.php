<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/DatabaseBackupManager.php';

$uid = Auth::id() ?? 0;
$allowed = false;
try {
    $pdo = Database::connection();
    $stmt = $pdo->prepare("SELECT role,status FROM users WHERE id=? LIMIT 1");
    $stmt->execute([$uid]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($u && ($u['status'] ?? '') === 'active' && ($u['role'] ?? '') === 'admin') $allowed = true;
    if (!$allowed) {
        $q = $pdo->prepare("SELECT 1 FROM user_permissions up INNER JOIN permissions p ON p.id=up.permission_id WHERE up.user_id=? AND p.permission_key IN ('manage_backup_center','manage_database_backups','manage_backup_vault') LIMIT 1");
        $q->execute([$uid]);
        $allowed = (bool)$q->fetchColumn();
    }
} catch (Throwable $e) {
}
if (!$allowed) {
    http_response_code(403);
    exit('Access denied.');
}
$type = (string)($_GET['type'] ?? 'full');
if (!in_array($type, ['full', 'schema'], true)) {
    http_response_code(400);
    exit('Invalid backup type.');
}
DatabaseBackupManager::exportSql($type === 'full');
exit;
