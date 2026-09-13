<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_seo');
$rows = SeoManager::all();
$pageTitle = 'SEO & Page Metadata';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
<?php require __DIR__ . '/../partials/alerts.php'; ?>
<?php require __DIR__ . '/../partials/page-heading.php'; ?>
<div class="admin-card">
  <div class="admin-actions" style="justify-content:space-between;">
    <div><span class="muted">Metadata is inactive only when the record is disabled. Empty fields fall back to the existing public page values.</span></div>
    <a class="btn btn-primary" href="<?= e(adminUrl('seo/edit.php')) ?>">Add Page</a>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead><tr><th>Page</th><th>Title</th><th>Description</th><th>Robots</th><th>Status</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($rows as $row): ?>
      <tr>
        <td><strong><?= e($row['page_name']) ?></strong><div class="muted"><code><?= e($row['page_key']) ?></code></div></td>
        <td><?= e((string)($row['title'] ?? '—')) ?></td>
        <td><?= e((string)($row['description'] ?? '—')) ?></td>
        <td><?= e($row['robots']) ?></td>
        <td><?= (int)$row['is_active'] === 1 ? 'Active' : 'Disabled' ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="<?= e(adminUrl('seo/edit.php?id=' . (int)$row['id'])) ?>">Edit</a>
          <form method="post" action="<?= e(adminUrl('seo/toggle.php')) ?>" style="display:inline">
            <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
            <button class="btn btn-sm btn-secondary" type="submit"><?= (int)$row['is_active'] === 1 ? 'Disable' : 'Enable' ?></button>
          </form>
          <form method="post" action="<?= e(adminUrl('seo/delete.php')) ?>" style="display:inline" onsubmit="return confirm('Delete this SEO record?');">
            <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (!$rows): ?><tr><td colspan="6">No SEO records exist.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
