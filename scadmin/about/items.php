<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/AboutManager.php';
Auth::requirePermission('manage_about');

$type=trim((string)($_GET['type']??''));
$allowed=['timeline','clients','certificates','awards','sister','values'];
if(!in_array($type,$allowed,true)) redirect(adminUrl('about/'));

$labels=['timeline'=>'Growth Timeline','clients'=>'Clients','certificates'=>'ISO Certifications','awards'=>'Awards & Recognitions','sister'=>'Affiliated Companies','values'=>'Core Values'];
$title=$labels[$type];$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);$editing=isset($_GET['edit']);$existing=$editing&&$id?($type==='values'?AboutManager::coreValue($id):AboutManager::item($type,$id)):null;
if($editing&&$id&&!$existing)redirect(adminUrl('about/items.php?type='.$type));

$error=null;
if(isPost() && isset($_POST['delete_item_id'])){
    CSRF::verify($_POST['csrf_token']??null);
    try{
        AboutManager::deleteItem($type,(int)$_POST['delete_item_id']);
        Auth::audit(Auth::id(),'delete','about_'.$type,(int)$_POST['delete_item_id'],'Deleted '.$title.' record');
        flash('success','Record deleted.');
        redirect(adminUrl('about/items.php?type='.$type));
    } catch(Throwable $e){
        $error=APP_DEBUG?$e->getMessage():'The About record could not be deleted.';
    }
} elseif(isPost()) {
    CSRF::verify($_POST['csrf_token']??null);
    try{
        if($type==='timeline')$new=AboutManager::saveTimeline($_POST,$editing&&$id?$id:null);
        elseif($type==='values')$new=AboutManager::saveCoreValue($_POST,$editing&&$id?$id:null);
        else $new=AboutManager::saveItem($type,$_POST,$editing&&$id?$id:null);
        Auth::audit(Auth::id(),$editing&&$id?'update':'create','about_'.$type,$new,($editing&&$id?'Updated ':'Created ').$title.' record');
        flash('success',$title.' saved.');
        redirect(adminUrl('about/items.php?type='.$type));
    }catch(Throwable $e){
        $error=APP_DEBUG?$e->getMessage():'The About record could not be saved.';
        $existing=array_merge((array)$existing,$_POST);
        $editing=true;
    }
}

$rows=AboutManager::items($type);
$pageTitle=$title;$activeNav='about';require __DIR__.'/../partials/header.php';require __DIR__.'/../partials/sidebar.php';
?>
<main class="admin-content">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'About','url'=>adminUrl('about/')],['label'=>$title,'url'=>null]];require __DIR__.'/../partials/breadcrumbs.php';$heading=$editing?'Edit '.$title:'Manage '.$title;$description=$type==='timeline'?'Keep the current six milestones and ordering during initial migration.':'Existing records are editable without changing the public markup.';$actionUrl=adminUrl('about/');$actionLabel='Back';require __DIR__.'/../partials/page-heading.php';require __DIR__.'/../partials/alerts.php';if($error):?><div class="alert alert-error"><?=e($error)?></div><?php endif;?>
<?php if($editing): ?>
<section class="form-card"><form method="post"><?=CSRF::field()?><div class="form-grid">
<?php if($type==='timeline'): ?><div class="form-field"><label>Year</label><input name="year" value="<?=e($existing['year']??'')?>" required></div><div class="form-field"><label>Sort order</label><input name="sort_order" type="number" min="0" value="<?=e((string)($existing['sort_order']??0))?>"></div><div class="form-field form-field-wide"><label>Title</label><input name="title" value="<?=e($existing['title']??'')?>" required></div><div class="form-field form-field-wide"><label>Description</label><textarea name="description" rows="5" required><?=e($existing['description']??'')?></textarea></div><div class="form-field form-field-wide"><label>Image path</label><input name="image_path" value="<?=e($existing['image_path']??'')?>" required></div>
<?php elseif($type==='values'): ?><div class="form-field form-field-wide"><label>Value text</label><textarea name="value_text" rows="3" required><?=e($existing['value_text']??'')?></textarea></div><div class="form-field"><label>Sort order</label><input name="sort_order" type="number" min="0" value="<?=e((string)($existing['sort_order']??0))?>"></div>
<?php else: ?><div class="form-field form-field-wide"><label><?=e($type==='clients'?'Client label (optional)':'Name')?></label><input name="name" value="<?=e($existing['name']??'')?>"></div><div class="form-field form-field-wide"><label>Logo path</label><input name="logo_path" value="<?=e($existing['logo_path']??'')?>" required></div><div class="form-field"><label>Sort order</label><input name="sort_order" type="number" min="0" value="<?=e((string)($existing['sort_order']??0))?>"></div><?php endif; ?>
</div><label class="permission-option"><input type="checkbox" name="is_active" value="1" <?=!isset($existing['is_active'])||$existing['is_active']?'checked':''?>><span><strong>Active</strong></span></label><div class="form-actions"><a class="button-link button-secondary" href="<?=e(adminUrl('about/items.php?type='.$type))?>">Cancel</a><button class="button-primary" type="submit">Save</button></div></form></section>
<?php else: ?>
<section class="content-panel"><div class="panel-heading"><div><h2><?=e($title)?></h2><p class="muted">Use existing asset paths. File upload management is intentionally deferred.</p></div><a class="button-link" href="<?=e(adminUrl('about/items.php?type='.$type.'&edit=1'))?>">+ Add record</a></div>
<div class="table-wrap"><table class="admin-table"><thead><tr><th>Order</th><th><?=e($type==='values'?'Value':'Name')?></th><th>Asset</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach($rows as $row): $editUrl=adminUrl('about/items.php?type='.$type.'&edit=1&id='.(int)$row['id']); ?><tr><td><?=e((string)$row['sort_order'])?></td><td><?=e($type==='values'?$row['value_text']:($row['name']??''))?></td><td><?=e($type==='values'?'—':$row['logo_path']??($row['image_path']??''))?></td><td><span class="status-badge status-<?=$row['is_active']?'active':'inactive'?>"><?= $row['is_active']?'Active':'Inactive' ?></span></td><td><a class="small-button" href="<?=e($editUrl)?>">Edit</a> <form method="post" style="display:inline" onsubmit="return confirm('Delete this record?');"><?=CSRF::field()?><input type="hidden" name="delete_item_id" value="<?=e((string)$row['id'])?>"><button class="small-button small-button-danger" type="submit">Delete</button></form></td></tr><?php endforeach; ?>
</tbody></table></div></section>
<?php endif; ?>
</main>
<?php require __DIR__.'/../partials/footer.php'; ?>
