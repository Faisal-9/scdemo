<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_seo');

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$row = $id ? SeoManager::find($id) : null;
if ($id && !$row) {
  Session::flash('error', 'SEO record not found.');
  redirect(adminUrl('seo/'));
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    CSRF::verify($_POST['_csrf'] ?? '');
    $savedId = SeoManager::save($id, $_POST);
    Session::flash('success', 'SEO metadata saved.');
    redirect(adminUrl('seo/edit.php?id=' . $savedId));
  } catch (Throwable $e) {
    $errors[] = $e->getMessage();
    $row = array_merge($row ?? [], $_POST);
  }
}

$pageTitle = $id ? 'Edit SEO Metadata' : 'Add SEO Metadata';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
  <?php require __DIR__ . '/../partials/alerts.php'; ?>
  <?php if ($errors): ?><div class="alert alert-danger"><?= e(implode(' ', $errors)) ?></div><?php endif; ?>
  <?php require __DIR__ . '/../partials/page-heading.php'; ?>
  <div class="admin-card">
    <form method="post">
      <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
      <div class="form-grid">
        <label>Page Key<input name="page_key" value="<?= e((string)($row['page_key'] ?? '')) ?>" required maxlength="100" <?= $id ? 'readonly' : '' ?>></label>
        <label>Page Name<input name="page_name" value="<?= e((string)($row['page_name'] ?? '')) ?>" required maxlength="150"></label>
        <label>Title<input name="title" value="<?= e((string)($row['title'] ?? '')) ?>" maxlength="255"></label>
        <label>Canonical URL<input name="canonical_url" value="<?= e((string)($row['canonical_url'] ?? '')) ?>" maxlength="500" placeholder="https://example.com/page"></label>
        <label style="grid-column:1/-1">Meta Description<textarea name="description" rows="3" maxlength="320"><?= e((string)($row['description'] ?? '')) ?></textarea></label>
        <label>Keywords<input name="keywords" value="<?= e((string)($row['keywords'] ?? '')) ?>" maxlength="500"></label>
        <label>Robots<select name="robots">
            <?php foreach (['index,follow', 'index,nofollow', 'noindex,follow', 'noindex,nofollow'] as $v): ?><option value="<?= e($v) ?>" <?= ($row['robots'] ?? 'index,follow') === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?>
          </select></label>
        <label>Open Graph Title<input name="og_title" value="<?= e((string)($row['og_title'] ?? '')) ?>" maxlength="255"></label>
        <div class="form-field"><?php mediaPickerField('og_image', (string) ($row['og_image'] ?? ''), ['label' => 'Open Graph Image']); ?></div>
        <label style="grid-column:1/-1">Open Graph Description<textarea name="og_description" rows="3" maxlength="320"><?= e((string)($row['og_description'] ?? '')) ?></textarea></label>
        <label>Twitter Card<select name="twitter_card">
            <?php foreach (['summary_large_image', 'summary', ''] as $v): ?><option value="<?= e($v) ?>" <?= ($row['twitter_card'] ?? 'summary_large_image') === $v ? 'selected' : '' ?>><?= e($v === '' ? 'None' : $v) ?></option><?php endforeach; ?>
          </select></label>
        <label>Sort Order<input type="number" min="0" name="sort_order" value="<?= (int)($row['sort_order'] ?? 0) ?>"></label>
      </div>
      <label style="display:block;margin-top:1rem"><input type="checkbox" name="is_active" value="1" <?= !isset($row['is_active']) || (int)$row['is_active'] === 1 ? 'checked' : '' ?>> Active</label>
      <div class="admin-actions" style="margin-top:1rem"><button class="btn btn-primary" type="submit">Save</button><a class="btn btn-secondary" href="<?= e(adminUrl('seo/')) ?>">Cancel</a></div>
    </form>
  </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>