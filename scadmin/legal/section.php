<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/LegalManager.php';
Auth::requirePermission('manage_legal');

$documentId=(int)($_GET['document_id'] ?? $_POST['document_id'] ?? 0);
$sectionId=isset($_GET['id'])?(int)$_GET['id']:null;
$doc=LegalManager::findDocument($documentId);
if(!$doc){Session::flash('error','Legal document not found.');header('Location: '.adminUrl('legal/'));exit;}
$row=$sectionId?LegalManager::findSection($sectionId):null;
if($sectionId && (!$row || (int)$row['document_id']!==$documentId)){Session::flash('error','Legal section not found.');header('Location: '.adminUrl('legal/document.php?id='.$documentId));exit;}
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
 try{
   CSRF::verify($_POST['csrf_token'] ?? '');
   $data=$_POST;
   $sectionId=LegalManager::saveSection($documentId,$data,$sectionId);
   LegalManager::replaceSectionItems($sectionId,is_array($_POST['items']??null)?$_POST['items']:[]);
   Session::flash('success','Legal section saved.'); header('Location: '.adminUrl('legal/document.php?id='.$documentId)); exit;
 }catch(Throwable $e){$errors[]=$e->getMessage();$row=array_merge((array)$row,$_POST);}
}
if(!$row)$row=['title'=>'','content'=>'','section_type'=>'content','sort_order'=>0,'items'=>['']];
$items=$row['items']??[''];
$pageTitle=$sectionId?'Edit Section':'Add Section';$activeNav='legal';
require __DIR__.'/../partials/header.php';require __DIR__.'/../partials/sidebar.php';
?>
<main class="admin-content">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'Policies & Terms','url'=>adminUrl('legal/')],['label'=>$pageTitle,'url'=>null]]; require __DIR__.'/../partials/breadcrumbs.php'; $heading=$pageTitle; $description='Preserve the existing content/list structure used by the public legal pages.'; $actionUrl=null;$actionLabel=null;require __DIR__.'/../partials/page-heading.php';require __DIR__.'/../partials/alerts.php'; ?>
<?php if($errors): ?><div class="alert error"><?php foreach($errors as $err): ?><div><?=e($err)?></div><?php endforeach; ?></div><?php endif; ?>
<section class="content-panel"><form method="post" class="admin-form"><input type="hidden" name="csrf_token" value="<?=e(CSRF::token())?>"><input type="hidden" name="document_id" value="<?=e((string)$documentId)?>"><div class="form-grid">
<label class="full">Title<input name="title" value="<?=e((string)$row['title'])?>" required></label>
<label>Type<select name="section_type"><option value="content" <?=$row['section_type']==='content'?'selected':''?>>Content</option><option value="list" <?=$row['section_type']==='list'?'selected':''?>>List</option></select></label>
<label>Sort order<input type="number" min="0" name="sort_order" value="<?=e((string)$row['sort_order'])?>"></label>
<label class="full">Content<textarea name="content" rows="8"><?=e((string)($row['content']??''))?></textarea><small>For list sections, leave this blank. Existing HTML such as &lt;i&gt;...&lt;/i&gt; is preserved.</small></label>
</div>
<h3>List items</h3><div id="legalItems">
<?php foreach((array)$items as $item): $text=is_array($item)?($item['item_text']??''):$item; ?><div class="repeat-row"><textarea name="items[]" rows="3"><?=e((string)$text)?></textarea><button type="button" class="small-button js-remove-row">Remove</button></div><?php endforeach; ?>
</div><button type="button" class="small-button" id="addItem">+ Add item</button>
<div class="form-actions"><button class="button-link" type="submit">Save section</button><a class="small-button" href="<?=e(adminUrl('legal/document.php?id='.$documentId))?>">Cancel</a></div></form></section>
</main>
<script>document.getElementById('addItem').addEventListener('click',function(){const w=document.getElementById('legalItems');const d=document.createElement('div');d.className='repeat-row';d.innerHTML='<textarea name="items[]" rows="3"></textarea><button type="button" class="small-button js-remove-row">Remove</button>';w.appendChild(d);});document.addEventListener('click',function(e){if(e.target.classList.contains('js-remove-row')){const rows=document.querySelectorAll('#legalItems .repeat-row');if(rows.length>1)e.target.parentElement.remove();}});</script>
<?php require __DIR__.'/../partials/footer.php'; ?>
