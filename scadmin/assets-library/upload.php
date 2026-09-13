<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/AssetManager.php';
Auth::requirePermission('manage_assets');
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        CSRF::check($_POST['_csrf'] ?? '');
        $id = AssetManager::upload($_FILES['asset'] ?? [], (string)($_POST['category'] ?? ''), (string)($_POST['alt_text'] ?? ''));
        Session::flash('success', 'Asset uploaded successfully.');
        redirect(adminUrl('assets-library/edit.php?id='.$id));
    } catch (Throwable $e) { $error = APP_DEBUG ? $e->getMessage() : 'The asset could not be uploaded.'; }
}
$pageTitle='Upload Asset';
require __DIR__ . '/../partials/header.php'; require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main"><div class="admin-container">
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<div class="page-heading"><div><h1>Upload Asset</h1><p>Images: max 8 MB. PDF: max 15 MB.</p></div></div>
<div class="admin-card"><form method="post" enctype="multipart/form-data"><input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>"><div class="form-group"><label>File</label><input type="file" name="asset" accept="image/jpeg,image/png,image/webp,image/gif,application/pdf" required></div><div class="form-group"><label>Category</label><input class="form-control" name="category" maxlength="80" placeholder="homepage, about, projects..."></div><div class="form-group"><label>Alt text</label><textarea class="form-control" name="alt_text" maxlength="500" rows="3"></textarea></div><div class="admin-actions"><button class="btn btn-primary" type="submit">Upload</button><a class="btn btn-secondary" href="<?= e(adminUrl('assets-library/')) ?>">Cancel</a></div></form></div>
</div></main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
