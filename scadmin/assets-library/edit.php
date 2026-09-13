<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/AssetManager.php';
Auth::requirePermission('manage_assets');
$id=(int)($_GET['id'] ?? 0);$row=AssetManager::find($id);
if(!$row){http_response_code(404);exit('Asset not found.');}
$error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){
    try{
        CSRF::check($_POST['_csrf']??'');
        if(isset($_POST['delete'])){
            AssetManager::delete($id);Session::flash('success','Asset deleted.');redirect(adminUrl('assets-library/')); 
        }
        AssetManager::updateMeta($id,(string)($_POST['alt_text']??''),(string)($_POST['category']??''));
        Session::flash('success','Asset metadata updated.');redirect(adminUrl('assets-library/edit.php?id='.$id));
    }catch(Throwable $e){$error=APP_DEBUG?$e->getMessage():'The asset could not be updated.';$row=array_merge($row,$_POST);}
}
$pageTitle='Edit Asset';require __DIR__.'/../partials/header.php';require __DIR__.'/../partials/sidebar.php';
?>
<main class="admin-main"><div class="admin-container">
<?php if($error): ?><div class="alert alert-danger"><?=e($error)?></div><?php endif; ?>
<div class="page-heading"><div><h1>Edit Asset</h1><p><?=e($row['original_name'])?></p></div></div>
<div class="admin-card"><dl class="message-details"><dt>Path</dt><dd><code><?=e($row['relative_path'])?></code></dd><dt>MIME</dt><dd><?=e($row['mime_type'])?></dd><dt>Size</dt><dd><?=e(number_format(((int)$row['file_size'])/1048576,2))?> MB</dd></dl>
<form method="post"><input type="hidden" name="_csrf" value="<?=e(CSRF::token())?>"><div class="form-group"><label>Category</label><input class="form-control" name="category" value="<?=e((string)($row['category']??''))?>" maxlength="80"></div><div class="form-group"><label>Alt text</label><textarea class="form-control" name="alt_text" maxlength="500" rows="4"><?=e((string)($row['alt_text']??''))?></textarea></div><div class="admin-actions"><button class="btn btn-primary" type="submit">Save</button><a class="btn btn-secondary" href="<?=e(adminUrl('assets-library/'))?>">Back</a><button class="btn btn-danger" name="delete" value="1" type="submit" onclick="return confirm('Delete this asset permanently?');">Delete</button></div></form></div>
</div></main>
<?php require __DIR__.'/../partials/footer.php'; ?>
