<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_revisions');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$revision = $id ? RevisionManager::find((int)$id) : null;
if (!$revision) {
    http_response_code(404);
    exit('Revision not found.');
}

$beforeRevision = RevisionManager::previous((int)$revision['id'], (string)$revision['entity_type'], (int)$revision['entity_id']);
$current = json_decode((string)$revision['snapshot_json'], true);
$before = $beforeRevision ? json_decode((string)$beforeRevision['snapshot_json'], true) : [];
$current = is_array($current) ? $current : [];
$before = is_array($before) ? $before : [];
$keys = array_values(array_unique(array_merge(array_keys($before), array_keys($current))));
sort($keys);
$changed = array_values(array_filter($keys, static fn($key): bool => ($before[$key] ?? null) !== ($current[$key] ?? null)));
$displayStatus = RevisionManager::effectiveStatus($revision, $current);

$formatValue = static function ($value): string {
    if (is_array($value) || is_object($value)) {
        return (string)json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    if ($value === null) return '';
    if (is_bool($value)) return $value ? 'true' : 'false';
    return (string)$value;
};

$pageTitle = 'Revision #' . (int)$revision['id'];
$activeNav = 'revisions';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main management-page">
    <div class="admin-container">
        <?php require __DIR__ . '/../partials/alerts.php'; ?>
        <div class="page-heading management-hero">
            <div>
                <span class="management-kicker">Change inspection</span>
                <h1><?= e($pageTitle) ?></h1>
                <p><?= e((string)$revision['entity_type']) ?> #<?= e((string)$revision['entity_id']) ?> by <?= e((string)($revision['user_name'] ?? 'System')) ?> on <?= e((string)$revision['created_at']) ?></p>
            </div>
            <div><a class="btn btn-secondary" href="<?= e(adminUrl('revisions/')) ?>">Back to history</a></div>
        </div>

        <div class="admin-card management-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <strong>Status: <?= e($displayStatus) ?></strong>
                <span class="muted"><?= e((string)($revision['note'] ?? '')) ?></span>
            </div>
            <p><?= $beforeRevision ? 'Compared with revision #' . e((string)$beforeRevision['id']) . '.' : 'This is the first recorded version; no earlier snapshot is available.' ?> <?= e((string)count($changed)) ?> changed field<?= count($changed) === 1 ? '' : 's' ?>.</p>
        </div>

        <div class="admin-card management-card">
            <h2>Changed fields</h2>
            <?php if ($changed === []): ?><p class="muted">No field-level differences were found.</p><?php else: ?>
                <div class="table-responsive"><table class="admin-table revision-diff-table"><thead><tr><th>Field</th><th>Before</th><th>Current</th></tr></thead><tbody>
                <?php foreach ($changed as $key): ?><tr>
                    <th><?= e((string)$key) ?></th>
                    <td><pre class="revision-value"><?= e($formatValue($before[$key] ?? null)) ?></pre></td>
                    <td><pre class="revision-value"><?= e($formatValue($current[$key] ?? null)) ?></pre></td>
                </tr><?php endforeach; ?>
                </tbody></table></div>
            <?php endif; ?>
        </div>

        <div class="admin-card management-card">
            <h2>Complete snapshots</h2>
            <div class="table-responsive"><table class="admin-table revision-snapshot-table"><thead><tr><th>Before</th><th>Current</th></tr></thead><tbody><tr>
                <td><pre class="revision-value revision-value-large"><?= e($formatValue($before)) ?></pre></td>
                <td><pre class="revision-value revision-value-large"><?= e($formatValue($current)) ?></pre></td>
            </tr></tbody></table></div>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
