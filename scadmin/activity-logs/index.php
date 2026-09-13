<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/ActivityLogManager.php';
Auth::requirePermission('manage_activity_logs');

$filters = [
    'action' => trim((string)($_GET['action'] ?? '')),
    'entity_type' => trim((string)($_GET['entity_type'] ?? '')),
    'user_id' => trim((string)($_GET['user_id'] ?? '')),
    'ip_address' => trim((string)($_GET['ip_address'] ?? '')),
    'date_from' => trim((string)($_GET['date_from'] ?? '')),
    'date_to' => trim((string)($_GET['date_to'] ?? '')),
    'search' => trim((string)($_GET['search'] ?? '')),
];

$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 50;
$offset = ($page - 1) * $perPage;
$actions = ActivityLogManager::actions();
$entityTypes = ActivityLogManager::entityTypes();
$users = ActivityLogManager::users();
$rows = ActivityLogManager::all($filters, $perPage, $offset);
$total = ActivityLogManager::count($filters);
$pages = max(1, (int)ceil($total / $perPage));

$pageTitle = 'Activity Logs';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
    <div class="admin-container">
        <?php require __DIR__ . '/../partials/alerts.php'; ?>
        <div class="page-heading">
            <div>
                <h1>Activity Logs</h1>
                <p>Audit trail of CMS logins, content changes, editor actions, and other recorded administrative activity.</p>
            </div>
        </div>

        <div class="admin-card">
            <form method="get" class="admin-filter-bar">
                <input type="text" name="search" placeholder="Search description, user, IP..." value="<?= e($filters['search']) ?>">
                <select name="action">
                    <option value="">All actions</option><?php foreach ($actions as $item): ?><option value="<?= e($item['action']) ?>" <?= $filters['action'] === $item['action'] ? 'selected' : '' ?>><?= e($item['action']) ?> (<?= e((string)$item['log_count']) ?>)</option><?php endforeach; ?>
                </select>
                <select name="entity_type">
                    <option value="">All entities</option><?php foreach ($entityTypes as $item): $type = (string)$item['entity_type']; ?><option value="<?= e($type) ?>" <?= $filters['entity_type'] === $type ? 'selected' : '' ?>><?= e($type ?: 'System / none') ?> (<?= e((string)$item['log_count']) ?>)</option><?php endforeach; ?>
                </select>
                <select name="user_id">
                    <option value="">All users</option><?php foreach ($users as $user): ?><option value="<?= e((string)$user['id']) ?>" <?= (string)$filters['user_id'] === (string)$user['id'] ? 'selected' : '' ?>><?= e((string)($user['display_name'] ?: $user['email'])) ?></option><?php endforeach; ?>
                </select>
                <input type="text" name="ip_address" placeholder="IP address" value="<?= e($filters['ip_address']) ?>">
                <input type="date" name="date_from" value="<?= e($filters['date_from']) ?>">
                <input type="date" name="date_to" value="<?= e($filters['date_to']) ?>">
                <button class="btn btn-secondary" type="submit">Filter</button>
                <a class="btn btn-secondary" href="<?= e(adminUrl('activity-logs/index.php')) ?>">Reset</a>
            </form>
        </div>

        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-3"><strong><?= e((string)$total) ?> log entr<?= $total === 1 ? 'y' : 'ies' ?></strong><span class="muted">Read-only audit history</span></div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date / Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Entity</th>
                            <th>Description</th>
                            <th>IP</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td>#<?= e((string)$row['id']) ?></td>
                                <td><?= e((string)$row['created_at']) ?></td>
                                <td><?= e((string)($row['user_name'] ?: $row['user_email'] ?: 'System')) ?></td>
                                <td><?= e((string)$row['action']) ?></td>
                                <td><?= e((string)($row['entity_type'] ?: '—')) ?><?php if ($row['entity_id'] !== null): ?><div class="muted">ID <?= e((string)$row['entity_id']) ?></div><?php endif; ?></td>
                                <td><?= e((string)($row['description'] ?: '—')) ?></td>
                                <td><?= e((string)($row['ip_address'] ?: '—')) ?></td>
                                <td><a class="btn btn-sm btn-primary" href="<?= e(adminUrl('activity-logs/view.php?id=' . (int)$row['id'])) ?>">View</a></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (!$rows): ?><tr>
                                <td colspan="8">No activity logs matched the selected filters.</td>
                            </tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($pages > 1): ?><div class="admin-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>Page <?= e((string)$page) ?> of <?= e((string)$pages) ?></div>
                    <div class="d-flex gap-2"><?php
                                                $params = array_filter($filters, static fn($v) => $v !== '' && $v !== null);
                                                if ($page > 1) {
                                                    $params['page'] = $page - 1; ?><a class="btn btn-sm btn-secondary" href="<?= e(adminUrl('activity-logs/index.php?' . http_build_query($params))) ?>">Previous</a><?php }
                                                                                                                                                                            if ($page < $pages) {
                                                                                                                                                                                $params['page'] = $page + 1; ?><a class="btn btn-sm btn-secondary" href="<?= e(adminUrl('activity-logs/index.php?' . http_build_query($params))) ?>">Next</a><?php }
                                                                                                                                                                                    ?></div>
                </div>
            </div><?php endif; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>