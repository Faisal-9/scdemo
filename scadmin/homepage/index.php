<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_homepage');

$slides = HomeManager::heroSlides();
$stats = HomeManager::stats();
$history = HomeManager::history();
$whyTabs = HomeManager::whyTabs();
$statsBackground = HomeManager::statsBackground();

$pageTitle='Homepage'; $activeNav='homepage';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'Homepage','url'=>null]]; require __DIR__ . '/../partials/breadcrumbs.php'; $heading='Homepage'; $description='Manage the existing homepage data without changing the current public HTML/CSS/JS.'; $actionUrl=null; $actionLabel=null; require __DIR__ . '/../partials/page-heading.php'; require __DIR__ . '/../partials/alerts.php'; ?>

<section class="content-panel">
<div class="panel-heading"><div><h2>Hero slides</h2><p class="muted">Existing five-slide structure. Keep legacy IDs stable.</p></div><a class="button-link" href="<?=e(adminUrl('homepage/slide.php'))?>">+ Add slide</a></div>
<div class="table-wrap"><table class="admin-table"><thead><tr><th>Order</th><th>ID</th><th>Title</th><th>Image</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach($slides as $row): ?><tr><td><?=e((string)$row['sort_order'])?></td><td><code><?=e((string)$row['legacy_id'])?></code></td><td><strong><?=e($row['title'])?></strong></td><td><?=e($row['image_path'])?></td><td><span class="status-badge status-<?=$row['is_active']?'active':'inactive'?>"><?= $row['is_active']?'Active':'Inactive' ?></span></td><td><a class="small-button" href="<?=e(adminUrl('homepage/slide.php?id='.(int)$row['id']))?>">Edit</a></td></tr><?php endforeach; ?>
</tbody></table></div>
</section>

<section class="content-panel">
<div class="panel-heading"><div><h2>Statistics</h2><p class="muted">The four current homepage statistics plus any future records.</p></div><a class="button-link" href="<?=e(adminUrl('homepage/stat.php'))?>">+ Add statistic</a></div>
<p class="muted">Background: <code><?=e($statsBackground)?></code> · <a href="<?=e(adminUrl('homepage/background.php'))?>">Edit background</a></p>
<div class="table-wrap"><table class="admin-table"><thead><tr><th>Order</th><th>Value</th><th>Label</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach($stats as $row): ?><tr><td><?=e((string)$row['sort_order'])?></td><td><strong><?=e((string)($row['prefix']??''))?><?=e((string)$row['number_value'])?><?=e((string)($row['suffix']??''))?></strong></td><td><?=e($row['label'])?></td><td><span class="status-badge status-<?=$row['is_active']?'active':'inactive'?>"><?= $row['is_active']?'Active':'Inactive' ?></span></td><td><a class="small-button" href="<?=e(adminUrl('homepage/stat.php?id='.(int)$row['id']))?>">Edit</a></td></tr><?php endforeach; ?>
</tbody></table></div>
</section>

<section class="content-panel">
<div class="panel-heading"><div><h2>History</h2><p class="muted">Existing timeline entries are kept as individual records.</p></div><a class="button-link" href="<?=e(adminUrl('homepage/history.php'))?>">+ Add entry</a></div>
<div class="table-wrap"><table class="admin-table"><thead><tr><th>Order</th><th>Year</th><th>Title</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach($history as $row): ?><tr><td><?=e((string)$row['sort_order'])?></td><td><?=e($row['year'])?></td><td><?=e($row['title'])?></td><td><span class="status-badge status-<?=$row['is_active']?'active':'inactive'?>"><?= $row['is_active']?'Active':'Inactive' ?></span></td><td><a class="small-button" href="<?=e(adminUrl('homepage/history.php?id='.(int)$row['id']))?>">Edit</a></td></tr><?php endforeach; ?>
</tbody></table></div>
</section>

<section class="content-panel">
<div class="panel-heading"><div><h2>Why State Corps</h2><p class="muted">The current three inner tabs and their bullet lists.</p></div><a class="button-link" href="<?=e(adminUrl('homepage/why.php'))?>">+ Add tab</a></div>
<div class="table-wrap"><table class="admin-table"><thead><tr><th>Order</th><th>Legacy ID</th><th>Tab</th><th>Items</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach($whyTabs as $row): ?><tr><td><?=e((string)$row['sort_order'])?></td><td><code><?=e((string)$row['legacy_id'])?></code></td><td><?=e($row['tab_name'])?></td><td><?=e((string)count($row['items']))?></td><td><span class="status-badge status-<?=$row['is_active']?'active':'inactive'?>"><?= $row['is_active']?'Active':'Inactive' ?></span></td><td><a class="small-button" href="<?=e(adminUrl('homepage/why.php?id='.(int)$row['id']))?>">Edit</a></td></tr><?php endforeach; ?>
</tbody></table></div>
</section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
