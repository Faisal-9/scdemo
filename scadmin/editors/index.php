<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requireAdmin();

$editors = EditorManager::allEditors();
$count = count($editors);
$permissions = EditorManager::allPermissions();

$permissionNames = [];
foreach ($permissions as $permission) {
    $permissionNames[(int) $permission['id']] = (string) $permission['permission_name'];
}

$permissionCache = [];

function editorPermissionsForView(int $editorId, array &$cache): array
{
    if (!isset($cache[$editorId])) {
        $cache[$editorId] = EditorManager::permissionIdsForEditor($editorId);
    }

    return $cache[$editorId];
}

$pageTitle = 'Editors';
$activeNav = 'editors';

require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>

<main class="admin-content">
    <?php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
        ['label' => 'Editors', 'url' => null],
    ];
    require __DIR__ . '/../partials/breadcrumbs.php';

    $heading = 'Editor Accounts';
    $description = 'Maximum 3 editor accounts. Only the Admin can manage them.';
    $actionUrl = $count < 3 ? adminUrl('editors/create.php') : null;
    $actionLabel = $count < 3 ? '+ Create Editor' : null;
    require __DIR__ . '/../partials/page-heading.php';
    ?>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <section class="dashboard-grid editor-stat-grid">
        <article class="dashboard-card">
            <span class="card-label">Editor accounts</span>
            <strong><?= e((string) $count) ?> / 3</strong>
            <small>Created editor accounts</small>
        </article>
        <article class="dashboard-card">
            <span class="card-label">Active</span>
            <strong><?= e((string) count(array_filter($editors, static fn(array $e): bool => $e['status'] === 'active'))) ?></strong>
            <small>Editors currently allowed to sign in</small>
        </article>
        <article class="dashboard-card">
            <span class="card-label">Available slots</span>
            <strong><?= e((string) max(0, 3 - $count)) ?></strong>
            <small>Unused editor accounts</small>
        </article>
    </section>

    <section class="table-card">
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Display name</th>
                    <th>Status</th>
                    <th>Permissions</th>
                    <th>Last login</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if ($editors === []): ?>
                    <tr>
                        <td colspan="6" class="empty-state">No editors have been created yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($editors as $editor): ?>
                        <?php
                        $editorPermissionIds = editorPermissionsForView((int) $editor['id'], $permissionCache);
                        $names = [];
                        foreach ($editorPermissionIds as $permissionId) {
                            if (isset($permissionNames[$permissionId])) {
                                $names[] = $permissionNames[$permissionId];
                            }
                        }
                        ?>
                        <tr>
                            <td><strong><?= e($editor['username']) ?></strong></td>
                            <td><?= e($editor['display_name']) ?></td>
                            <td>
                                <span class="status-badge status-<?= e($editor['status']) ?>">
                                    <?= e(ucfirst($editor['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($names === []): ?>
                                    <span class="muted">None</span>
                                <?php else: ?>
                                    <?= e(implode(', ', $names)) ?>
                                <?php endif; ?>
                            </td>
                            <td><?= e($editor['last_login_at'] ?? 'Never') ?></td>
                            <td class="actions-cell">
                                <a class="small-button" href="<?= e(adminUrl('editors/edit.php?id=' . (int) $editor['id'])) ?>">Edit</a>
                                <form method="post" action="<?= e(adminUrl('editors/delete.php')) ?>" class="inline-form" onsubmit="return confirm('Delete this editor account? This action cannot be undone.');">
                                    <?= CSRF::field() ?>
                                    <input type="hidden" name="id" value="<?= e((string) $editor['id']) ?>">
                                    <button type="submit" class="small-button small-button-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
