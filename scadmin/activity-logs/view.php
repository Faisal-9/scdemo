<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/ActivityLogManager.php';
Auth::requirePermission('manage_activity_logs');

$id = ctype_digit((string)($_GET['id'] ?? '')) ? (int)$_GET['id'] : 0;
$log = ActivityLogManager::find($id);
if (!$log) {
    http_response_code(404);
    exit('Activity log not found.');
}

$pageTitle = 'Activity Log #' . $log['id'];
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main"><div class="admin-container">
<div class="page-heading"><div><h1>Activity Log #<?= e((string)$log['id']) ?></h1><p>Immutable audit entry details.</p></div><div><a class="btn btn-secondary" href="<?= e(adminUrl('activity-logs/index.php')) ?>">Back to Logs</a></div></div>
<div class="admin-card"><div class="table-responsive"><table class="admin-table">
<tr><th>Timestamp</th><td><?= e((string)$log['created_at']) ?></td></tr>
<tr><th>User</th><td><?= e((string)($log['user_name'] ?: $log['user_email'] ?: 'System')) ?><?php if ($log['user_email']): ?><div class="muted"><?= e((string)$log['user_email']) ?></div><?php endif; ?></td></tr>
<tr><th>Action</th><td><?= e((string)$log['action']) ?></td></tr>
<tr><th>Entity</th><td><?= e((string)($log['entity_type'] ?: '—')) ?><?php if ($log['entity_id'] !== null): ?><div class="muted">ID <?= e((string)$log['entity_id']) ?></div><?php endif; ?></td></tr>
<tr><th>Description</th><td><?= nl2br(e((string)($log['description'] ?: '—'))) ?></td></tr>
<tr><th>IP address</th><td><?= e((string)($log['ip_address'] ?: '—')) ?></td></tr>
<tr><th>User agent</th><td style="word-break:break-word;"><?= e((string)($log['user_agent'] ?: '—')) ?></td></tr>
</table></div></div>
</div></main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
