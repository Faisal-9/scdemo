<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('search_content');
$q = trim((string)($_GET['q'] ?? ''));
$results = $q !== '' ? AdminSearchManager::search($q) : [];
$pageTitle = 'Search'; $activeNav = 'search';
require __DIR__ . '/../partials/header.php'; require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main"><div class="admin-container">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'Search','url'=>null]]; require __DIR__.'/../partials/breadcrumbs.php'; $heading='Global Search'; $description='Search only the CMS content your account is allowed to manage.'; $actionUrl=null; $actionLabel=null; require __DIR__.'/../partials/page-heading.php'; ?>
<section class="content-panel"><form method="get" class="admin-filter-bar"><input type="search" name="q" value="<?=e($q)?>" placeholder="Search projects, services, sectors, media, messages..." autofocus><button class="btn btn-primary" type="submit">Search</button></form></section>
<?php if ($q !== ''): ?><section class="content-panel"><div class="panel-heading"><div><h2><?=e((string)count($results))?> result<?=count($results)===1?'':'s'?></h2><p class="muted">Search term: <?=e($q)?></p></div></div><?php if (!$results): ?><p class="muted">No matching records found.</p><?php else: ?><div class="dashboard-search-results"><?php foreach($results as $result): ?><a class="dashboard-search-result" href="<?=e(adminUrl($result['url']))?>"><span class="status-badge"><?=e($result['type'])?></span><strong><?=e($result['title'])?></strong><small><?=e($result['snippet'])?></small></a><?php endforeach; ?></div><?php endif; ?></section><?php endif; ?>
</div></main><?php require __DIR__.'/../partials/footer.php'; ?>
