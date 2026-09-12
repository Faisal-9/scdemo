<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_media');

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$row = $id ? MediaManager::find($id) : null;
if ($id && !$row) { Session::flash('error','Media item not found.'); header('Location: '.adminUrl('media/')); exit; }
$errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST') {
    try {
        CSRF::verify($_POST['csrf_token'] ?? '');
        $data=$_POST;
        $data['is_active']=isset($_POST['is_active']) ? 1 : 0;
        $data['descriptions']=isset($_POST['descriptions']) && is_array($_POST['descriptions']) ? $_POST['descriptions'] : [];
        MediaManager::save($data,$id);
        Session::flash('success', $id ? 'Media item updated.' : 'Media item created.');
        header('Location: '.adminUrl('media/')); exit;
    } catch(Throwable $e) { $errors[]=$e->getMessage(); $row=array_merge((array)$row,$_POST,['descriptions'=>$data['descriptions']??[]]); }
}
if(!$row){$row=['media_type'=>'news','legacy_id'=>'','media_date'=>'','media_date_sort'=>'','title'=>'','image_path'=>'','external_link'=>'','sort_order'=>0,'is_active'=>1,'descriptions'=>[''],'tags_csv'=>''];}
$pageTitle=$id?'Edit Media':'Add Media'; $activeNav='media';
require __DIR__ . '/../partials/header.php'; require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'Media','url'=>adminUrl('media/')],['label'=>$pageTitle,'url'=>null]]; require __DIR__ . '/../partials/breadcrumbs.php'; $heading=$pageTitle; $description='All fields map directly to the existing public media data shape.'; $actionUrl=null; $actionLabel=null; require __DIR__ . '/../partials/page-heading.php'; require __DIR__ . '/../partials/alerts.php'; ?>
<?php if($errors): ?><div class="alert error"><?php foreach($errors as $err): ?><div><?=e($err)?></div><?php endforeach; ?></div><?php endif; ?>
<section class="content-panel"><form method="post" class="admin-form"><input type="hidden" name="csrf_token" value="<?=e(CSRF::token())?>">
<div class="form-grid">
<label>Type<select name="media_type" required><option value="news" <?=$row['media_type']==='news'?'selected':''?>>News</option><option value="events" <?=$row['media_type']==='events'?'selected':''?>>Events</option><option value="gallery" <?=$row['media_type']==='gallery'?'selected':''?>>Gallery</option></select></label>
<label>Legacy ID<input name="legacy_id" value="<?=e((string)($row['legacy_id']??''))?>"><small>Keep n1/n2/e1/g1-style IDs stable.</small></label>
<label>Display date<input name="media_date" value="<?=e((string)($row['media_date']??''))?>" required></label>
<label>Date for sorting<input type="date" name="media_date_sort" value="<?=e((string)($row['media_date_sort']??''))?>"></label>
<label class="full">Title<input name="title" value="<?=e((string)$row['title'])?>" required></label>
<label class="full">Image path<input name="image_path" value="<?=e((string)($row['image_path']??''))?>"><small>Example: assets/images/media/23-1225-Jawzjan.jpeg</small></label>
<label class="full">External link<input name="external_link" value="<?=e((string)($row['external_link']??''))?>"></label>
<label>Sort order<input type="number" min="0" name="sort_order" value="<?=e((string)$row['sort_order'])?>"></label>
<label class="check"><input type="checkbox" name="is_active" value="1" <?=$row['is_active']?'checked':''?>> Active / published</label>
<label class="full">Tags<input name="tags" value="<?=e((string)($row['tags_csv']??''))?>"><small>Comma-separated. Existing tags are reused; new tags are created automatically.</small></label>
</div>
<h3>Description paragraphs</h3><div id="descriptionRows">
<?php foreach((array)($row['descriptions']??['']) as $text): $text=is_array($text)?($text['description_text']??''):$text; ?><div class="repeat-row"><textarea name="descriptions[]" rows="4"><?=e((string)$text)?></textarea><button type="button" class="small-button js-remove-row">Remove</button></div><?php endforeach; ?></div>
<button type="button" class="small-button" id="addDescription">+ Add paragraph</button>
<div class="form-actions"><button class="button-link" type="submit">Save</button><a class="small-button" href="<?=e(adminUrl('media/'))?>">Cancel</a></div>
</form></section></main>
<script>document.getElementById('addDescription').addEventListener('click',function(){const w=document.getElementById('descriptionRows');const d=document.createElement('div');d.className='repeat-row';d.innerHTML='<textarea name="descriptions[]" rows="4"></textarea><button type="button" class="small-button js-remove-row">Remove</button>';w.appendChild(d);});document.addEventListener('click',function(e){if(e.target.classList.contains('js-remove-row')){const rows=document.querySelectorAll('#descriptionRows .repeat-row');if(rows.length>1)e.target.parentElement.remove();}});</script>
<?php require __DIR__ . '/../partials/footer.php'; ?>
