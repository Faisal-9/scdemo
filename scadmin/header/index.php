<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requirePermission('manage_settings');

$rows = SiteSettingsManager::rowsForSection('header');
$settings = [];
foreach ($rows as $row) {
    $settings[(string)$row['setting_key']] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::check($_POST['_csrf'] ?? '');
    try {
        SiteSettingsManager::saveManyForSection('header', $_POST['setting'] ?? []);
        Auth::audit(Auth::id(), 'update', 'header_settings', null, 'Updated header settings.');
        Session::flash('success', 'Header settings updated successfully.');
    } catch (Throwable $e) {
        Session::flash('error', $e->getMessage());
    }
    redirect(adminUrl('header/'));
}

$pageTitle = 'Header Administration';
$heading = $pageTitle;
$description = 'Manage the public header identity, social links, colors, and navigation structure.';
$activeNav = 'header';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main management-page">
  <?php require __DIR__ . '/../partials/alerts.php'; ?>
  <?php require __DIR__ . '/../partials/page-heading.php'; ?>
  <div class="admin-card settings-form-card">
    <div class="management-toolbar">
      <div>
        <span class="management-kicker">Header content</span>
        <p class="management-summary">These values are used by the public header on every page.</p>
      </div>
      <a class="btn btn-secondary" href="<?= e(adminUrl('navigation/?location=header')) ?>">Manage Header Navigation</a>
    </div>
    <form method="post">
      <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
      <?php foreach ($settings as $key => $row): ?>
        <?php $type = (string)$row['setting_type']; $value = (string)$row['setting_value']; ?>
        <div class="form-group">
          <label for="setting-<?= e($key) ?>"><?= e(ucwords(str_replace('_', ' ', $key))) ?></label>
          <?php if ($type === 'textarea'): ?>
            <textarea id="setting-<?= e($key) ?>" name="setting[<?= (int)$row['id'] ?>]" class="form-control" rows="5"><?= e($value) ?></textarea>
          <?php elseif (str_ends_with($key, '_color')): ?>
            <input id="setting-<?= e($key) ?>" type="color" name="setting[<?= (int)$row['id'] ?>]" value="<?= e($value) ?>">
          <?php else: ?>
            <input id="setting-<?= e($key) ?>" type="<?= $type === 'url' ? 'url' : 'text' ?>" name="setting[<?= (int)$row['id'] ?>]" class="form-control" value="<?= e($value) ?>">
          <?php endif; ?>
          <?php if (!empty($row['description'])): ?><div class="muted"><?= e($row['description']) ?></div><?php endif; ?>
        </div>
      <?php endforeach; ?>
      <div class="admin-actions"><button class="btn btn-primary" type="submit">Save Header</button></div>
    </form>
  </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>