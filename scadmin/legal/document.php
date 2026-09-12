<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/LegalManager.php';
Auth::requirePermission('manage_legal');

$id=(int)($_GET['id'] ?? 0);
$doc=LegalManager::findDocument($id);
if(!$doc){ Session::flash('error','Legal document not found.'); header('Location: '.adminUrl('legal/')); exit; }
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    try{
        CSRF::verify($_POST['csrf_token'] ?? '');
        $data=$_POST; $data['is_active']=isset($_POST['is_active'])?1:0;
        LegalManager::saveDocument($data,$id);
        Session::flash('success','Legal document updated.'); header('Location: '.adminUrl('legal/document.php?id='.$id)); exit;
    }catch(Throwable $e){$errors[]=$e->getMessage(); $doc=array_merge($doc,$_POST);}
}
$sections=LegalManager::sections($id);
$pageTitle='Edit '.(string)$doc['title']; $activeNav='legal';
require __DIR__.'/../partials/header.php'; require __DIR__.'/../partials/sidebar.php';
?>
<main class="admin-content">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'Policies & Terms','url'=>adminUrl('legal/')],['label'=>$pageTitle,'url'=>null]]; require __DIR__.'/../partials/breadcrumbs.php'; $heading=$pageTitle; $description='Document settings and sections are editable independently.'; $actionUrl=null; $actionLabel=null; require __DIR__.'/../partials/page-heading.php'; require __DIR__.'/../partials/alerts.php'; ?>
<?php if($errors): ?><div class="alert error"><?php foreach($errors as $err): ?><div><?=e($err)?></div><?php endforeach; ?></div><?php endif; ?>
<section class="content-panel"><form method="post" class="admin-form"><input type="hidden" name="csrf_token" value="<?=e(CSRF::token())?>"><div class="form-grid">
<label>Title<input name="title" value="<?=e((string)$doc['title'])?>" required></label>
<label>Document key<input value="<?=e((string)$doc['document_key'])?>" readonly></label>
<label>Sort order<input type="number" min="0" name="sort_order" value="<?=e((string)$doc['sort_order'])?>"></label>
<label class="check"><input type="checkbox" name="is_active" value="1" <?=$doc['is_active']?'checked':''?>> Active / published</label>
</div><div class="form-actions"><button class="button-link" type="submit">Save document</button><a class="small-button" href="<?=e(adminUrl('legal/'))?>">Back</a></div></form></section>
<section class="content-panel"><div class="panel-header"><h2>Sections</h2><a class="button-link" href="<?=e(adminUrl('legal/section.php?document_id='.$id))?>">+ Add section</a></div>
<table class="admin-table"><thead><tr><th>Order</th><th>Title</th><th>Type</th><th>Items</th><th>Action</th></tr></thead><tbody>
<?php foreach($sections as $section): ?><tr><td><?=e((string)$section['sort_order'])?></td><td><?=e((string)$section['title'])?></td><td><?=e((string)$section['section_type'])?></td><td><?=count((array)$section['items'])?></td><td><a class="small-button" href="<?=e(adminUrl('legal/section.php?document_id='.$id.'&id='.(int)$section['id']))?>">Edit</a></td></tr><?php endforeach; ?>
</tbody></table></section>
</main>
<?php require __DIR__.'/../partials/footer.php'; ?>
