<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_media');
$type = isset($_GET['type']) && in_array($_GET['type'], ['news','events','gallery'], true) ? $_GET['type'] : null;
$items = MediaManager::all($type, false);
$pageTitle='Media'; $activeNav='media';
require __DIR__ . '/../partials/header.php'; require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'Media','url'=>null]]; require __DIR__ . '/../partials/breadcrumbs.php'; $heading='Media'; $description='Manage News, Events, and Gallery content without changing the public media layout.'; $actionUrl=adminUrl('media/item.php'); $actionLabel='+ Add media item'; require __DIR__ . '/../partials/page-heading.php'; require __DIR__ . '/../partials/alerts.php'; ?>
<section class="content-panel">
<div class="filter-links"><a class="small-button" href="<?=e(adminUrl('media/'))?>">All</a> <a class="small-button" href="<?=e(adminUrl('media/?type=news'))?>">News</a> <a class="small-button" href="<?=e(adminUrl('media/?type=events'))?>">Events</a> <a class="small-button" href="<?=e(adminUrl('media/?type=gallery'))?>">Gallery</a></div>
<?php if (!$items): ?><p class="muted">No media records found.</p><?php else: ?>
<div class="table-wrap"><table class="admin-table"><thead><tr><th>Type</th><th>Order</th><th>Legacy ID</th><th>Title</th><th>Date</th><th>Tags</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach($items as $row): ?><tr><td><?=e(ucfirst((string)$row['media_type']))?></td><td><?=e((string)$row['sort_order'])?></td><td><code><?=e((string)($row['legacy_id']??''))?></code></td><td><strong><?=e($row['title'])?></strong></td><td><?=e((string)($row['media_date']??''))?></td><td><?=e((string)$row['tags_csv'])?></td><td><span class="status-badge status-<?=$row['is_active']?'active':'inactive'?>"><?= $row['is_active']?'Active':'Inactive' ?></span></td><td><a class="small-button" href="<?=e(adminUrl('media/item.php?id='.(int)$row['id']))?>">Edit</a></td></tr><?php endforeach; ?>
</tbody></table></div><?php endif; ?>
</section></main><?php require __DIR__ . '/../partials/footer.php';
