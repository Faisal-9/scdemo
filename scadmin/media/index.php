<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_media');
$type = isset($_GET['type']) && in_array($_GET['type'], ['news','events','gallery'], true) ? $_GET['type'] : null;
$mediaItems = MediaManager::all($type, false);
$pageTitle='Media'; $activeNav='media';
require __DIR__ . '/../partials/header.php'; require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'Media','url'=>null]]; require __DIR__ . '/../partials/breadcrumbs.php'; $heading='Media'; $description='Manage News, Events, and Gallery content without changing the public media layout.'; $actionUrl=adminUrl('media/item.php'); $actionLabel='+ Add media item'; require __DIR__ . '/../partials/page-heading.php'; require __DIR__ . '/../partials/alerts.php'; ?>
<section class="content-panel">
<div class="media-admin-toolbar"><div><strong><?= e((string)count($mediaItems)) ?> <?= $type ? e(ucfirst($type)) : 'media' ?> record<?= count($mediaItems) === 1 ? '' : 's' ?></strong><span class="muted">Create, edit, review, or delete published media content.</span></div><nav class="media-admin-filters" aria-label="Filter media"><a class="small-button <?= $type === null ? 'active' : '' ?>" href="<?=e(adminUrl('media/'))?>">All</a><a class="small-button <?= $type === 'news' ? 'active' : '' ?>" href="<?=e(adminUrl('media/?type=news'))?>">News</a><a class="small-button <?= $type === 'events' ? 'active' : '' ?>" href="<?=e(adminUrl('media/?type=events'))?>">Events</a><a class="small-button <?= $type === 'gallery' ? 'active' : '' ?>" href="<?=e(adminUrl('media/?type=gallery'))?>">Gallery</a></nav></div>
<?php if (!$mediaItems): ?><p class="muted">No media records found.</p><?php else: ?>
<div class="table-wrap"><table class="admin-table media-admin-table"><colgroup><col class="media-image-column"><col><col class="media-order-column"><col class="media-legacy-column"><col class="media-title-column"><col class="media-date-column"><col class="media-tags-column"><col class="media-status-column"><col class="media-actions-column"></colgroup><thead><tr><th>Image</th><th>Type</th><th>Order</th><th>Legacy ID</th><th>Title</th><th>Date</th><th>Tags</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach($mediaItems as $row): ?><tr><td><?php if (!empty($row['media_image_path'])): ?><img class="media-admin-thumbnail" src="<?= e(baseUrl((string)$row['media_image_path'])) ?>" alt="<?= e((string)($row['title'] ?? 'Media image')) ?>" loading="lazy"><?php else: ?><span class="muted">No image</span><?php endif; ?></td><td><?= e(ucfirst((string)($row['media_type'] ?? ''))) ?></td><td><?= e((string)($row['sort_order'] ?? 0)) ?></td><td><code><?= e((string)($row['legacy_id'] ?? '')) ?></code></td><td><strong><?= e((string)($row['title'] ?? '')) ?></strong></td><td><?= e((string)($row['media_date'] ?? '')) ?></td><td><?= e((string)($row['tags_csv'] ?? '')) ?></td><td><span class="status-badge status-<?= !empty($row['is_active']) ? 'active' : 'inactive' ?>"><?= !empty($row['is_active']) ? 'Active' : 'Inactive' ?></span></td><td><div class="media-row-actions"><a class="small-button" href="<?= e(adminUrl('media/item.php?id=' . (int)($row['id'] ?? 0))) ?>">Edit</a><form method="post" action="<?= e(adminUrl('media/delete.php')) ?>" onsubmit="return confirm('Delete this media item and its descriptions and tags?');"><?= CSRF::field() ?><input type="hidden" name="id" value="<?= e((string)(int)($row['id'] ?? 0)) ?>"><button class="small-button small-button-danger" type="submit">Delete</button></form></div></td></tr><?php endforeach; ?>
</tbody></table></div><?php endif; ?>
</section></main><?php require __DIR__ . '/../partials/footer.php';
