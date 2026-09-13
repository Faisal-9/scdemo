<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/AssetManager.php';
Auth::requirePermission('manage_assets');

$q = trim((string)($_GET['q'] ?? ''));
$type = in_array($_GET['type'] ?? '', ['image','pdf'], true) ? (string)$_GET['type'] : '';
$rows = AssetManager::all($q, $type);
$pageTitle = 'Asset Library';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main"><div class="admin-container">
<?php require __DIR__ . '/../partials/alerts.php'; ?>
<div class="page-heading"><div><h1>Asset Library</h1><p>Upload and reuse images and PDF documents across the CMS.</p></div><a class="btn btn-primary" href="<?= e(adminUrl('assets-library/upload.php')) ?>">Upload Asset</a></div>
<form method="get" class="admin-filter-bar"><input type="search" name="q" placeholder="Search filename, category..." value="<?= e($q) ?>"><select name="type"><option value="">All types</option><option value="image" <?= $type==='image'?'selected':'' ?>>Images</option><option value="pdf" <?= $type==='pdf'?'selected':'' ?>>PDF</option></select><button class="btn btn-secondary" type="submit">Filter</button></form>
<div class="admin-card"><div class="table-responsive"><table class="admin-table"><thead><tr><th>Asset</th><th>Type</th><th>Size</th><th>Category</th><th>Path</th><th>Created</th><th></th></tr></thead><tbody>
<?php foreach ($rows as $row): ?><tr><td><strong><?= e($row['original_name']) ?></strong><?php if ($row['alt_text']): ?><div class="muted"><?= e($row['alt_text']) ?></div><?php endif; ?></td><td><?= e($row['mime_type']) ?></td><td><?= e(number_format(((int)$row['file_size'])/1048576,2)) ?> MB</td><td><?= e((string)($row['category'] ?? '—')) ?></td><td><code><?= e($row['relative_path']) ?></code></td><td><?= e($row['created_at']) ?></td><td><a class="btn btn-sm btn-primary" href="<?= e(adminUrl('assets-library/edit.php?id='.(int)$row['id'])) ?>">Edit</a></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="7">No assets found.</td></tr><?php endif; ?></tbody></table></div></div>
</div></main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
