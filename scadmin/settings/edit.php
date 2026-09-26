<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_settings');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
  http_response_code(404);
  exit('Setting not found.');
}
$row = SiteSettingsManager::find((int)$id);
if (!$row) {
  http_response_code(404);
  exit('Setting not found.');
}

$managedSection = SiteSettingsManager::sectionForKey((string)$row['setting_key']);
if ($managedSection !== null) {
  redirect(adminUrl($managedSection . '/'));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  CSRF::check($_POST['_csrf'] ?? '');
  try {
    SiteSettingsManager::save((int)$id, trim((string)($_POST['setting_value'] ?? '')));
    Auth::audit(Auth::id(), 'update', 'setting', (int)$id, 'Updated site setting.');
    Session::flash('success', 'Setting updated successfully.');
    header('Location: ' . adminUrl('settings/'));
    exit;
  } catch (Throwable $e) {
    Session::flash('error', $e->getMessage());
    header('Location: ' . adminUrl('settings/edit.php?id=' . (int)$id));
    exit;
  }
}

$pageTitle = 'Edit Setting';
$heading = $pageTitle;
$description = (string)($row['description'] ?? 'Update the selected global site setting.');
$actionUrl = null;
$actionLabel = null;
$timezoneOptions = [];
if ((string)$row['setting_type'] === 'timezone') {
  foreach (DateTimeZone::listIdentifiers() as $timezone) {
    $dateTimeZone = new DateTimeZone($timezone);
    $offset = $dateTimeZone->getOffset(new DateTimeImmutable('now', $dateTimeZone));
    $sign = $offset < 0 ? '-' : '+';
    $absoluteOffset = abs($offset);
    $offsetLabel = sprintf('UTC%s%02d:%02d', $sign, intdiv($absoluteOffset, 3600), intdiv($absoluteOffset % 3600, 60));
    $category = str_contains($timezone, '/') ? explode('/', $timezone, 2)[0] : 'Other';
    $timezoneOptions[$category][] = ['value' => $timezone, 'label' => $offsetLabel . ' - ' . str_replace('_', ' ', $timezone)];
  }
  ksort($timezoneOptions);
}
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
  <?php require __DIR__ . '/../partials/alerts.php'; ?>
  <?php require __DIR__ . '/../partials/page-heading.php'; ?>
  <div class="admin-card settings-form-card">
    <form method="post">
      <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
      <div class="form-group"><label>Setting Key</label><input class="form-control" value="<?= e($row['setting_key']) ?>" disabled></div>
      <div class="form-group"><label>Type</label><input class="form-control" value="<?= e($row['setting_type']) ?>" disabled></div>
      <?php $type = (string)$row['setting_type'];
      $inputType = str_ends_with((string)$row['setting_key'], '_color') ? 'color' : match ($type) {
        'email' => 'email',
        'url' => 'url',
        'phone' => 'tel',
        'number' => 'number',
        default => 'text'
      }; ?>
      <?php if ($type === 'timezone'): ?>
        <div class="form-group"><label>Value</label><select name="setting_value" class="form-control">
            <?php foreach ($timezoneOptions as $category => $options): ?>
              <optgroup label="<?= e($category) ?>">
                <?php foreach ($options as $option): ?>
                  <option value="<?= e($option['value']) ?>" <?= $option['value'] === (string)$row['setting_value'] ? 'selected' : '' ?>><?= e($option['label']) ?></option>
                <?php endforeach; ?>
              </optgroup>
            <?php endforeach; ?>
          </select></div>
      <?php elseif ($type === 'textarea'): ?>
        <div class="form-group"><label>Value</label><textarea name="setting_value" class="form-control" rows="8"><?= e((string)$row['setting_value']) ?></textarea></div>
      <?php elseif ($type === 'boolean'): ?>
        <div class="form-group"><label>Value</label><select name="setting_value" class="form-control">
            <option value="1" <?= in_array(strtolower((string)$row['setting_value']), ['1', 'true', 'yes', 'on'], true) ? 'selected' : '' ?>>Enabled</option>
            <option value="0" <?= in_array(strtolower((string)$row['setting_value']), ['0', 'false', 'no', 'off'], true) ? 'selected' : '' ?>>Disabled</option>
          </select></div>
      <?php else: ?>
        <div class="form-group"><label>Value</label><input type="<?= e($inputType) ?>" name="setting_value" class="form-control" value="<?= e((string)$row['setting_value']) ?>"></div>
      <?php endif; ?>
      <div class="admin-actions"><button class="btn btn-primary" type="submit">Save</button><a class="btn btn-secondary" href="<?= e(adminUrl('settings/')) ?>">Cancel</a></div>
    </form>
  </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>