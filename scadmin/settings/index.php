<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_settings');

$rows = SiteSettingsManager::rows();
$pageTitle = 'Site Settings';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
<?php require __DIR__ . '/../partials/alerts.php'; ?>
<?php require __DIR__ . '/../partials/page-heading.php'; ?>
<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead><tr><th>Setting</th><th>Type</th><th>Value</th><th>Updated</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($rows as $row): ?>
        <tr>
          <td><strong><?= e($row['setting_key']) ?></strong><?php if (!empty($row['description'])): ?><div class="muted"><?= e($row['description']) ?></div><?php endif; ?></td>
          <td><?= e($row['setting_type']) ?></td>
          <td><code><?= e((string)$row['setting_value']) ?></code></td>
          <td><?= e((string)$row['updated_at']) ?></td>
          <td><a class="btn btn-sm btn-primary" href="<?= e(adminUrl('settings/edit.php?id=' . (int)$row['id'])) ?>">Edit</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
