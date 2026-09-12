<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/LegalManager.php';
Auth::requirePermission('manage_legal');

$docs = LegalManager::documents(false);
$pageTitle = 'Policies & Terms';
$activeNav = 'legal';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
<?php
$breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'Policies & Terms','url'=>null]];
require __DIR__ . '/../partials/breadcrumbs.php';
$heading='Policies & Terms'; $description='Manage the existing legal documents without changing the public legal-page layout.'; $actionUrl=null; $actionLabel=null;
require __DIR__ . '/../partials/page-heading.php'; require __DIR__ . '/../partials/alerts.php';
?>
<section class="content-panel">
<table class="admin-table"><thead><tr><th>Document</th><th>Key</th><th>Order</th><th>Status</th><th>Action</th></tr></thead><tbody>
<?php foreach($docs as $doc): ?>
<tr>
<td><?=e((string)$doc['title'])?></td>
<td><?=e((string)$doc['document_key'])?></td>
<td><?=e((string)$doc['sort_order'])?></td>
<td><?=((int)$doc['is_active']===1)?'Active':'Inactive'?></td>
<td><a class="small-button" href="<?=e(adminUrl('legal/document.php?id='.(int)$doc['id']))?>">Manage</a></td>
</tr>
<?php endforeach; ?>
</tbody></table>
</section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
