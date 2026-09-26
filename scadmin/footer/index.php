<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requirePermission('manage_settings');

$rows = SiteSettingsManager::rowsForSection('footer');
$settings = [];
foreach ($rows as $row) {
    $settings[(string)$row['setting_key']] = $row;
}

$footerNavRows = NavigationManager::rows('footer');
$footerNavId = filter_input(INPUT_GET, 'nav_id', FILTER_VALIDATE_INT);
$footerNavEditing = $footerNavId ? NavigationManager::find((int)$footerNavId) : null;
if ($footerNavEditing && $footerNavEditing['location'] !== 'footer') {
  $footerNavEditing = null;
}
$footerNavParents = NavigationManager::parents('footer', $footerNavId ?: null);
$footerNavError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::check($_POST['_csrf'] ?? '');
    try {
    if (($_POST['action'] ?? '') === 'save_footer_nav') {
      $navId = filter_var($_POST['nav_id'] ?? null, FILTER_VALIDATE_INT) ?: null;
      NavigationManager::save($navId, [
        'location' => 'footer',
        'label' => $_POST['label'] ?? '',
        'url' => $_POST['url'] ?? '#',
        'target' => $_POST['target'] ?? '_self',
        'icon_class' => $_POST['icon_class'] ?? '',
        'sort_order' => $_POST['sort_order'] ?? 0,
        'is_active' => isset($_POST['is_active']),
        'parent_id' => $_POST['parent_id'] ?? '',
      ]);
      Session::flash('success', 'Footer link saved successfully.');
    } elseif (($_POST['action'] ?? '') === 'delete_footer_nav') {
      NavigationManager::delete((int)($_POST['nav_id'] ?? 0));
      Session::flash('success', 'Footer link deleted successfully.');
    } elseif (($_POST['action'] ?? '') === 'toggle_footer_nav') {
      NavigationManager::toggle((int)($_POST['nav_id'] ?? 0));
      Session::flash('success', 'Footer link visibility updated.');
    } else {
      $submittedSettings = $_POST['setting'] ?? [];
      foreach ($settings as $key => $row) {
        if ($key === 'footer_logo_enabled') {
          $submittedSettings[(int)$row['id']] = isset($_POST['footer_logo_enabled']) ? '1' : '0';
        }
      }
      SiteSettingsManager::saveManyForSection('footer', $submittedSettings);
      Auth::audit(Auth::id(), 'update', 'footer_settings', null, 'Updated footer settings.');
      Session::flash('success', 'Footer settings updated successfully.');
    }
    } catch (Throwable $e) {
    $footerNavError = APP_DEBUG ? $e->getMessage() : 'The footer change could not be saved.';
    }
  if ($footerNavError === null) {
    redirect(adminUrl('footer/'));
  }
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
    </div>
    <form method="post">
      <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
      <?php foreach ($settings as $key => $row): ?>
        <?php $type = (string)$row['setting_type']; $value = (string)$row['setting_value']; ?>
        <div class="form-group">
          <?php if ($key === 'footer_logo'): ?>
            <?php mediaPickerField('setting[' . (int)$row['id'] . ']', $value, ['label' => 'Footer Logo']); ?>
          <?php elseif ($key === 'footer_logo_enabled'): ?>
            <label for="setting-<?= e($key) ?>">Show Footer Logo</label>
            <input id="setting-<?= e($key) ?>" type="checkbox" name="footer_logo_enabled" value="1" <?= in_array(strtolower($value), ['1', 'true', 'yes', 'on'], true) ? 'checked' : '' ?>>
          <?php elseif ($type === 'textarea'): ?>
            <label for="setting-<?= e($key) ?>"><?= e(ucwords(str_replace('_', ' ', $key))) ?></label>
            <textarea id="setting-<?= e($key) ?>" name="setting[<?= (int)$row['id'] ?>]" class="form-control" rows="6"><?= e($value) ?></textarea>
          <?php else: ?>
            <label for="setting-<?= e($key) ?>"><?= e(ucwords(str_replace('_', ' ', $key))) ?></label>
            <input id="setting-<?= e($key) ?>" type="text" name="setting[<?= (int)$row['id'] ?>]" class="form-control" value="<?= e($value) ?>">
          <?php endif; ?>
          <?php if (!empty($row['description'])): ?><div class="muted"><?= e($row['description']) ?></div><?php endif; ?>
        </div>
      <?php endforeach; ?>
      <div class="admin-actions"><button class="btn btn-primary" type="submit">Save Footer</button></div>
    </form>
  </div>
  <?php
  $navigationLocation = 'footer';
  $navigationRows = $footerNavRows;
  $navigationEditing = $footerNavEditing;
  $navigationParents = $footerNavParents;
  $navigationId = $footerNavId;
  $navigationError = $footerNavError;
  require __DIR__ . '/../partials/navigation-management.php';
  ?>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>