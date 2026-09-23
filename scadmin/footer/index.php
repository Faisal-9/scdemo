<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requirePermission('manage_settings');

$rows = SiteSettingsManager::rowsForSection('footer');
$settings = [];
foreach ($rows as $row) {
    $settings[(string)$row['setting_key']] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::check($_POST['_csrf'] ?? '');
    try {
        SiteSettingsManager::saveManyForSection('footer', $_POST['setting'] ?? []);
        Auth::audit(Auth::id(), 'update', 'footer_settings', null, 'Updated footer settings.');
        Session::flash('success', 'Footer settings updated successfully.');
    } catch (Throwable $e) {
        Session::flash('error', $e->getMessage());
    }
    redirect(adminUrl('footer/'));
}

$pageTitle = 'Footer Administration';
$heading = $pageTitle;
$description = 'Manage the public footer content, labels, logo, and navigation structure.';
$activeNav = 'footer';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main management-page">
  <?php require __DIR__ . '/../partials/alerts.php'; ?>
  <?php require __DIR__ . '/../partials/page-heading.php'; ?>
  <div class="admin-card settings-form-card">
    <div class="management-toolbar">
      <div>
        <span class="management-kicker">Footer content</span>
        <p class="management-summary">These values are used by the public footer on every page.</p>
      </div>
      <a class="btn btn-secondary" href="<?= e(adminUrl('navigation/?location=footer')) ?>">Manage Footer Navigation</a>
    </div>
    <form method="post">
      <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
      <?php foreach ($settings as $key => $row): ?>
        <?php $type = (string)$row['setting_type']; $value = (string)$row['setting_value']; ?>
        <div class="form-group">
          <label for="setting-<?= e($key) ?>"><?= e(ucwords(str_replace('_', ' ', $key))) ?></label>
          <?php if ($type === 'textarea'): ?>
            <textarea id="setting-<?= e($key) ?>" name="setting[<?= (int)$row['id'] ?>]" class="form-control" rows="6"><?= e($value) ?></textarea>
          <?php else: ?>
            <input id="setting-<?= e($key) ?>" type="text" name="setting[<?= (int)$row['id'] ?>]" class="form-control" value="<?= e($value) ?>">
          <?php endif; ?>
          <?php if (!empty($row['description'])): ?><div class="muted"><?= e($row['description']) ?></div><?php endif; ?>
        </div>
      <?php endforeach; ?>
      <div class="admin-actions"><button class="btn btn-primary" type="submit">Save Footer</button></div>
    </form>
  </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>