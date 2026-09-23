<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_redirects');
$id = isset($_GET['id']) && ctype_digit((string)$_GET['id']) ? (int)$_GET['id'] : null;
$row = $id ? RedirectManager::find($id) : null;
if ($id && !$row) { http_response_code(404); exit('Redirect not found.'); }
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        CSRF::verify($_POST['_csrf'] ?? '');
        $saved = RedirectManager::save($id, [
            'source_path'=>$_POST['source_path'] ?? '', 'destination_url'=>$_POST['destination_url'] ?? '',
            'status_code'=>$_POST['status_code'] ?? 301, 'preserve_query'=>$_POST['preserve_query'] ?? 0,
            'note'=>$_POST['note'] ?? '', 'sort_order'=>$_POST['sort_order'] ?? 0,
            'is_active'=>isset($_POST['is_active']) ? 1 : 0,
        ]);
        Auth::audit(Auth::id(), $id ? 'update' : 'create', 'redirect', $saved, ($id ? 'Updated' : 'Created') . ' redirect.');
        header('Location: ' . adminUrl('redirects/index.php')); exit;
    } catch (Throwable $e) { $error = $e->getMessage(); }
}
$row = $row ?: ['source_path'=>'','destination_url'=>'','status_code'=>301,'preserve_query'=>0,'note'=>'','sort_order'=>0,'is_active'=>1];
$pageTitle = $id ? 'Edit Redirect' : 'Add Redirect';
require __DIR__ . '/../partials/header.php'; require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
<?php require __DIR__ . '/../partials/alerts.php'; ?>
<?php require __DIR__ . '/../partials/page-heading.php'; ?>
<?php if ($error): ?><div class="admin-alert admin-alert-error"><?= e($error) ?></div><?php endif; ?>
<div class="admin-card"><form method="post">
<input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
<div class="form-grid">
<label>Source path<input type="text" name="source_path" required maxlength="500" placeholder="/old-page" value="<?= e($row['source_path']) ?>"></label>
<label>Destination URL<input type="text" name="destination_url" required maxlength="1000" placeholder="/new-page or https://example.com/new" value="<?= e($row['destination_url']) ?>"></label>
<label>Status code<select name="status_code"><?php foreach ([301,302,307,308] as $code): ?><option value="<?= $code ?>" <?= (int)$row['status_code'] === $code ? 'selected' : '' ?>><?= $code ?></option><?php endforeach; ?></select></label>
<label>Sort order<input type="number" min="0" name="sort_order" value="<?= (int)$row['sort_order'] ?>"></label>
<label style="grid-column:1/-1">Note<textarea name="note" maxlength="255" rows="3"><?= e($row['note']) ?></textarea></label>
</div>
<label><input type="checkbox" name="preserve_query" value="1" <?= (int)$row['preserve_query'] === 1 ? 'checked' : '' ?>> Preserve the original query string</label>
<label><input type="checkbox" name="is_active" value="1" <?= (int)$row['is_active'] === 1 ? 'checked' : '' ?>> Active</label>
<div class="admin-actions"><button class="btn btn-primary" type="submit">Save</button><a class="btn btn-secondary" href="<?= e(adminUrl('redirects/index.php')) ?>">Cancel</a></div>
</form></div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
