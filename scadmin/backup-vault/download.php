<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/BackupVaultManager.php';
Auth::requirePermission('manage_backup_vault');
try {
    $backup = BackupVaultManager::get((int)($_GET['id'] ?? 0));
    if (!$backup) throw new RuntimeException('Backup not found.');
    BackupVaultManager::download($backup);
    exit;
} catch (Throwable $e) {
    http_response_code(404);
    $pageTitle = 'Backup Download';
    require __DIR__ . '/../partials/header.php'; require __DIR__ . '/../partials/sidebar.php';
    ?><main class="admin-main"><div class="admin-container"><div class="admin-card"><h1>Backup unavailable</h1><p><?= e($e->getMessage()) ?></p><a href="index.php">← Back to Backup Vault</a></div></div></main><?php
    require __DIR__ . '/../partials/footer.php';
}
