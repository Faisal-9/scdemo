<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/AboutManager.php';
Auth::requirePermission('manage_about');

$sections=AboutManager::sections();
$pageTitle='About'; $activeNav='about';
require __DIR__.'/../partials/header.php';
require __DIR__.'/../partials/sidebar.php';
?>
<main class="admin-content">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'About','url'=>null]]; require __DIR__.'/../partials/breadcrumbs.php'; $heading='About'; $description='Manage all existing About page content while preserving the current public HTML/CSS/JS.'; $actionUrl=null; $actionLabel=null; require __DIR__.'/../partials/page-heading.php'; require __DIR__.'/../partials/alerts.php'; ?>

<section class="content-panel about-admin-grid">
<?php
$cards=[
 ['overview','Overview','Company overview text and growth timeline.'],
 ['mission','Mission, Vision & Values','Mission, vision, images, and core values.'],
 ['clients','Clients','Client logo list.'],
 ['certificates','ISO Certifications','Certification names and logos.'],
 ['awards','Awards & Recognitions','Award names and logos.'],
 ['sister','Affiliated Companies','Affiliated company names and logos.'],
 ['hse','HSE','Health, Safety & Environment text.'],
 ['profile','Company Profile','Profile description and PDF link.'],
];
foreach($cards as [$type,$title,$desc]):
 $url=in_array($type,['overview','mission','hse','profile'],true)?adminUrl('about/content.php?section='.$type):adminUrl('about/items.php?type='.$type);
?>
<article class="about-admin-card"><div><h2><?=e($title)?></h2><p class="muted"><?=e($desc)?></p></div><a class="button-link" href="<?=e($url)?>">Manage</a></article>
<?php endforeach; ?>
</section>

<section class="content-panel">
<div class="panel-heading"><div><h2>About sidebar sections</h2><p class="muted">These IDs stay aligned with the existing public JavaScript and section anchors.</p></div></div>
<div class="table-wrap"><table class="admin-table"><thead><tr><th>Order</th><th>Legacy ID</th><th>Title</th><th>Status</th></tr></thead><tbody>
<?php foreach($sections as $row): ?><tr><td><?=e((string)$row['sort_order'])?></td><td><code><?=e($row['legacy_id'])?></code></td><td><?=e($row['title'])?></td><td><span class="status-badge status-<?=$row['is_active']?'active':'inactive'?>"><?= $row['is_active']?'Active':'Inactive' ?></span></td></tr><?php endforeach; ?>
</tbody></table></div>
<p class="form-note">Section ordering/status is intentionally display-only in this phase; content remains fully editable from the management screens above.</p>
</section>
</main>
<?php require __DIR__.'/../partials/footer.php'; ?>
