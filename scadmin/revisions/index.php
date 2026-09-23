<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_revisions');

$entityType = trim((string)($_GET['entity_type'] ?? ''));
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 50;
$rows = RevisionManager::all(['entity_type' => $entityType], $perPage, ($page - 1) * $perPage);
$total = RevisionManager::count(['entity_type' => $entityType]);
$pages = max(1, (int)ceil($total / $perPage));
$entityTypes = RevisionManager::entityTypes();

$pageTitle = 'Version History';
$activeNav = 'revisions';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main management-page">
    <div class="admin-container">
        <?php require __DIR__ . '/../partials/alerts.php'; ?>
        <div class="page-heading management-hero">
            <div>
                <span class="management-kicker">Content recovery</span>
                <h1>Version History</h1>
                <p>Every saved CMS edit is recorded here in one place.</p>
            </div>
        </div>
        <div class="admin-card management-card">
            <form method="get" class="admin-filter-bar">
                <select name="entity_type">
                    <option value="">All content types</option>
                    <?php foreach ($entityTypes as $type): ?><option value="<?= e((string)$type['entity_type']) ?>" <?= $entityType === $type['entity_type'] ? 'selected' : '' ?>><?= e((string)$type['entity_type']) ?> (<?= e((string)$type['revision_count']) ?>)</option><?php endforeach; ?>
                </select>
                <button class="btn btn-secondary" type="submit">Filter</button>
                <a class="btn btn-secondary" href="<?= e(adminUrl('revisions/')) ?>">Reset</a>
            </form>
        </div>
        <div class="admin-card management-card">
            <div class="d-flex justify-content-between align-items-center mb-3"><strong><?= e((string)$total) ?> revision<?= $total === 1 ? '' : 's' ?></strong><span class="muted">Immutable saved versions</span></div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead><tr><th>Date</th><th>Content type</th><th>Record</th><th>Author</th><th>Status</th><th>Note</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($rows as $row): ?><tr>
                        <td><a class="btn btn-sm btn-secondary" href="<?= e(adminUrl('revisions/view.php?id=' . (int)$row['id'])) ?>">View changes</a><div class="muted"><?= e((string)$row['created_at']) ?></div></td>
                        <td><?= e((string)$row['entity_type']) ?></td>
                        <td>#<?= e((string)$row['entity_id']) ?></td>
                        <td><?= e((string)$row['user_name']) ?></td>
                        <td><?= e((string)$row['status']) ?></td>
                        <td><?= e((string)($row['note'] ?? '')) ?></td>
                        <td><?php if (in_array($row['entity_type'], ['project', 'media', 'media_item', 'navigation', 'redirect', 'seo', 'setting'], true)): ?><form method="post" action="<?= e(adminUrl('revisions/restore.php')) ?>" onsubmit="return confirm('Restore this version as a new saved version?');"><?= CSRF::field() ?><input type="hidden" name="revision_id" value="<?= e((string)$row['id']) ?>"><button class="btn btn-sm btn-primary" type="submit">Restore</button></form><?php else: ?><span class="muted">Review in editor</span><?php endif; ?></td>
                    </tr><?php endforeach; ?>
                    <?php if (!$rows): ?><tr><td colspan="7">No revisions have been recorded yet.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if ($pages > 1): ?><div class="admin-card"><div class="d-flex justify-content-between align-items-center"><div>Page <?= e((string)$page) ?> of <?= e((string)$pages) ?></div><div class="d-flex gap-2"><?php if ($page > 1): ?><a class="btn btn-sm btn-secondary" href="<?= e(adminUrl('revisions/?' . http_build_query(['entity_type' => $entityType, 'page' => $page - 1]))) ?>">Previous</a><?php endif; ?><?php if ($page < $pages): ?><a class="btn btn-sm btn-secondary" href="<?= e(adminUrl('revisions/?' . http_build_query(['entity_type' => $entityType, 'page' => $page + 1]))) ?>">Next</a><?php endif; ?></div></div></div><?php endif; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
