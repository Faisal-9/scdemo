<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_redirects');
$rows = RedirectManager::all();
$pageTitle = 'URL Redirects';
$heading = $pageTitle;
$description = 'Keep legacy links working and route retired URLs without changing application code.';
$actionUrl = null;
$actionLabel = null;
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main management-page">
<?php require __DIR__ . '/../partials/alerts.php'; ?>
<?php require __DIR__ . '/../partials/page-heading.php'; ?>
<div class="admin-card management-card">
  <div class="management-toolbar">
    <div><span class="management-kicker">Traffic control</span><p class="management-summary">Keep legacy links working and route retired URLs without changing application code.</p></div>
    <a class="btn btn-primary" href="<?= e(adminUrl('redirects/edit.php')) ?>">Add Redirect</a>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead><tr><th>Source</th><th>Destination</th><th>Code</th><th>Query</th><th>State</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($rows as $row): ?>
      <tr>
        <td><strong><?= e($row['source_path']) ?></strong><?php if (!empty($row['note'])): ?><div class="muted"><?= e($row['note']) ?></div><?php endif; ?></td>
        <td><?= e($row['destination_url']) ?></td>
        <td><?= (int)$row['status_code'] ?></td>
        <td><?= (int)$row['preserve_query'] === 1 ? 'Preserve' : 'Drop' ?></td>
        <td><span class="status-badge <?= (int)$row['is_active'] === 1 ? 'status-active' : 'status-inactive' ?>"><?= (int)$row['is_active'] === 1 ? 'Active' : 'Disabled' ?></span></td>
        <td>
          <a class="btn btn-sm btn-primary" href="<?= e(adminUrl('redirects/edit.php?id=' . (int)$row['id'])) ?>">Edit</a>
          <form method="post" action="<?= e(adminUrl('redirects/toggle.php')) ?>" style="display:inline">
            <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
            <button class="btn btn-sm btn-secondary" type="submit"><?= (int)$row['is_active'] === 1 ? 'Disable' : 'Enable' ?></button>
          </form>
          <form method="post" action="<?= e(adminUrl('redirects/delete.php')) ?>" style="display:inline" onsubmit="return confirm('Delete this redirect?');">
            <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (!$rows): ?><tr><td colspan="6">No redirects exist.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
