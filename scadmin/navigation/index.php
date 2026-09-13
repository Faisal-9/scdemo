<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requirePermission('manage_navigation');

$location = strtolower(trim((string)($_GET['location'] ?? 'header')));

if (!in_array($location, ['header', 'footer'], true)) {
  $location = 'header';
}

$rows = NavigationManager::rows($location);

$pageTitle = ucfirst($location) . ' Navigation';

require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
  <?php require __DIR__ . '/../partials/alerts.php'; ?>
  <?php require __DIR__ . '/../partials/page-heading.php'; ?>
  <div class="admin-card">
    <div class="admin-actions" style="justify-content:space-between;">
      <div>
        <a class="btn btn-sm <?= $location === 'header' ? 'btn-primary' : 'btn-secondary' ?>" href="<?= e(adminUrl('navigation/?location=header')) ?>">Header</a>
        <a class="btn btn-sm <?= $location === 'footer' ? 'btn-primary' : 'btn-secondary' ?>" href="<?= e(adminUrl('navigation/?location=footer')) ?>">Footer</a>
      </div>
      <a class="btn btn-primary" href="<?= e(adminUrl('navigation/edit.php?location=' . urlencode($location))) ?>">Add Item</a>
    </div>
    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Order</th>
            <th>Label</th>
            <th>URL</th>
            <th>Parent</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row): ?>
            <tr>
              <td><?= (int)$row['sort_order'] ?></td>
              <td><strong><?= e($row['label']) ?></strong><?php if (!empty($row['icon_class'])): ?><div class="muted"><?= e($row['icon_class']) ?></div><?php endif; ?></td>
              <td><code><?= e($row['url']) ?></code></td>
              <td><?= e((string)($row['parent_label'] ?? '—')) ?></td>
              <td><?= (int)$row['is_active'] === 1 ? 'Active' : 'Hidden' ?></td>
              <td>
                <a class="btn btn-sm btn-primary" href="<?= e(adminUrl('navigation/edit.php?id=' . (int)$row['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(adminUrl('navigation/toggle.php')) ?>" style="display:inline">
                  <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                  <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                  <button class="btn btn-sm btn-secondary" type="submit"><?= (int)$row['is_active'] === 1 ? 'Hide' : 'Show' ?></button>
                </form>
                <form method="post" action="<?= e(adminUrl('navigation/delete.php')) ?>" style="display:inline" onsubmit="return confirm('Delete this navigation item?');">
                  <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                  <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                  <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$rows): ?><tr>
              <td colspan="6">No <?= e($location) ?> navigation items exist yet.</td>
            </tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>