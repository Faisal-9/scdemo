<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requirePermission('manage_settings');

$rows = SiteSettingsManager::rowsForSection('header');
$settings = [];
foreach ($rows as $row) {
    $settings[(string)$row['setting_key']] = $row;
}

$headerNavRows = NavigationManager::rows('header');
$headerNavId = filter_input(INPUT_GET, 'nav_id', FILTER_VALIDATE_INT);
$headerNavEditing = $headerNavId ? NavigationManager::find((int)$headerNavId) : null;
if ($headerNavEditing && $headerNavEditing['location'] !== 'header') {
  $headerNavEditing = null;
}
$headerNavParents = NavigationManager::parents('header', $headerNavId ?: null);
$headerNavError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::check($_POST['_csrf'] ?? '');
    try {
    if (($_POST['action'] ?? '') === 'save_header_nav') {
      $navId = filter_var($_POST['nav_id'] ?? null, FILTER_VALIDATE_INT) ?: null;
      NavigationManager::save($navId, [
        'location' => 'header',
        'label' => $_POST['label'] ?? '',
        'url' => $_POST['url'] ?? '#',
        'target' => $_POST['target'] ?? '_self',
        'icon_class' => $_POST['icon_class'] ?? '',
        'sort_order' => $_POST['sort_order'] ?? 0,
        'is_active' => isset($_POST['is_active']),
        'parent_id' => $_POST['parent_id'] ?? '',
      ]);
      Session::flash('success', 'Header link saved successfully.');
    } elseif (($_POST['action'] ?? '') === 'delete_header_nav') {
      NavigationManager::delete((int)($_POST['nav_id'] ?? 0));
      Session::flash('success', 'Header link deleted successfully.');
    } elseif (($_POST['action'] ?? '') === 'toggle_header_nav') {
      NavigationManager::toggle((int)($_POST['nav_id'] ?? 0));
      Session::flash('success', 'Header link visibility updated.');
    } else {
      SiteSettingsManager::saveManyForSection('header', $_POST['setting'] ?? []);
      Auth::audit(Auth::id(), 'update', 'header_settings', null, 'Updated header settings.');
      Session::flash('success', 'Header settings updated successfully.');
    }
    } catch (Throwable $e) {
    $headerNavError = APP_DEBUG ? $e->getMessage() : 'The header change could not be saved.';
  }
  if ($headerNavError === null) {
    redirect(adminUrl('header/'));
    }
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
    </div>
    <form method="post">
      <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
      <?php foreach ($settings as $key => $row): ?>
        <?php $type = (string)$row['setting_type']; $value = (string)$row['setting_value']; ?>
        <div class="form-group">
          <?php if ($key === 'site_logo'): ?>
            <?php mediaPickerField('setting[' . (int)$row['id'] . ']', $value, ['label' => 'Site Logo']); ?>
          <?php elseif ($type === 'textarea'): ?>
            <label for="setting-<?= e($key) ?>"><?= e(ucwords(str_replace('_', ' ', $key))) ?></label>
            <textarea id="setting-<?= e($key) ?>" name="setting[<?= (int)$row['id'] ?>]" class="form-control" rows="5"><?= e($value) ?></textarea>
          <?php elseif (str_ends_with($key, '_color')): ?>
            <label for="setting-<?= e($key) ?>"><?= e(ucwords(str_replace('_', ' ', $key))) ?></label>
            <input id="setting-<?= e($key) ?>" type="color" name="setting[<?= (int)$row['id'] ?>]" value="<?= e($value) ?>">
          <?php else: ?>
            <label for="setting-<?= e($key) ?>"><?= e(ucwords(str_replace('_', ' ', $key))) ?></label>
            <input id="setting-<?= e($key) ?>" type="<?= $type === 'url' ? 'url' : 'text' ?>" name="setting[<?= (int)$row['id'] ?>]" class="form-control" value="<?= e($value) ?>">
          <?php endif; ?>
          <?php if (!empty($row['description'])): ?><div class="muted"><?= e($row['description']) ?></div><?php endif; ?>
        </div>
      <?php endforeach; ?>
      <div class="admin-actions"><button class="btn btn-primary" type="submit">Save Header</button></div>
    </form>
  </div>
  <?php
  $navigationLocation = 'header';
  $navigationRows = $headerNavRows;
  $navigationEditing = $headerNavEditing;
  $navigationParents = $headerNavParents;
  $navigationId = $headerNavId;
  $navigationError = $headerNavError;
  require __DIR__ . '/../partials/navigation-management.php';
  ?>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>