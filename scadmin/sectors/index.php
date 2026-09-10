<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_sectors');

$sectors = SectorManager::all();
$pageTitle = 'Sectors';
$activeNav = 'sectors';

require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
<?php
$breadcrumbs = [
    ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
    ['label' => 'Sectors', 'url' => null],
];
require __DIR__ . '/../partials/breadcrumbs.php';
$heading = 'Sectors';
$description = 'Manage sector content without changing the existing public design.';
$actionUrl = adminUrl('sectors/create.php');
$actionLabel = '+ Add Sector';
require __DIR__ . '/../partials/page-heading.php';
?>
<?php require __DIR__ . '/../partials/alerts.php'; ?>
<section class="table-card">
<div class="table-wrap">
<table class="admin-table">
<thead><tr><th>Order</th><th>Key</th><th>Title</th><th>Status</th><th></th></tr></thead>
<tbody>
<?php if ($sectors === []): ?>
<tr><td colspan="5" class="empty-state">No sectors found.</td></tr>
<?php else: ?>
<?php foreach ($sectors as $sector): ?>
<tr>
<td><?= e((string) $sector['sort_order']) ?></td>
<td><code><?= e($sector['sector_key']) ?></code></td>
<td><strong><?= e($sector['title']) ?></strong></td>
<td><span class="status-badge status-<?= $sector['is_active'] ? 'active' : 'inactive' ?>"><?= $sector['is_active'] ? 'Active' : 'Inactive' ?></span></td>
<td class="actions-cell">
<a class="small-button" href="<?= e(adminUrl('sectors/edit.php?id=' . (int) $sector['id'])) ?>">Edit</a>
<form method="post" action="<?= e(adminUrl('sectors/toggle.php')) ?>" class="inline-form">
<?= CSRF::field() ?><input type="hidden" name="id" value="<?= e((string) $sector['id']) ?>"><input type="hidden" name="active" value="<?= $sector['is_active'] ? '0' : '1' ?>">
<button class="small-button" type="submit"><?= $sector['is_active'] ? 'Disable' : 'Enable' ?></button>
</form>
<form method="post" action="<?= e(adminUrl('sectors/delete.php')) ?>" class="inline-form" onsubmit="return confirm('Delete this sector and all its nested content? This cannot be undone.');">
<?= CSRF::field() ?><input type="hidden" name="id" value="<?= e((string) $sector['id']) ?>"><button class="small-button small-button-danger" type="submit">Delete</button>
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
