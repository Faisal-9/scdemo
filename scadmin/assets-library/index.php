<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/AssetManager.php';
require_once __DIR__ . '/../../app/core/AssetReferenceManager.php';
Auth::requirePermission('manage_assets');

$q = trim((string)($_GET['q'] ?? ''));
$type = in_array($_GET['type'] ?? '', ['image', 'pdf'], true) ? (string)$_GET['type'] : '';
$usage = in_array($_GET['usage'] ?? '', ['used', 'unused', 'missing'], true) ? (string)$_GET['usage'] : '';

$summary = AssetReferenceManager::summary();
$rows = AssetReferenceManager::assets($q, $usage);
if ($type !== '') {
    $rows = array_values(array_filter($rows, static function (array $row) use ($type): bool {
        return $type === 'image' ? str_starts_with((string)$row['mime_type'], 'image/') : (string)$row['mime_type'] === 'application/pdf';
    }));
}
$pageTitle = 'Asset Library';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
    <div class="admin-container">
        <?php require __DIR__ . '/../partials/alerts.php'; ?>
        <div class="page-heading">
            <div>
                <h1>Asset Library</h1>
                <p>Manage reusable images and PDF documents, and see where each asset is being used.</p>
            </div>
            <a class="btn btn-primary" href="<?= e(adminUrl('assets-library/upload.php')) ?>">Upload Asset</a>
        </div>

        <div class="row g-3 mb-4">
            <?php foreach (
                [
                    ['Total Assets', $summary['asset_count']],
                    ['Images', $summary['image_count']],
                    ['PDF', $summary['pdf_count']],
                    ['In Use', $summary['used_assets']],
                    ['Unused', $summary['unused_assets']],
                    ['Missing Files', $summary['missing_db_files']],
                ] as [$label, $value]
            ): ?>
                <div class="col-sm-6 col-xl-2">
                    <div class="admin-card h-100">
                        <div class="muted"><?= e($label) ?></div>
                        <div style="font-size:1.65rem;font-weight:700;"><?= e((string)$value) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <form method="get" class="admin-filter-bar">
            <input type="search" name="q" placeholder="Search filename, path, category..." value="<?= e($q) ?>">
            <select name="type">
                <option value="">All types</option>
                <option value="image" <?= $type === 'image' ? 'selected' : '' ?>>Images</option>
                <option value="pdf" <?= $type === 'pdf' ? 'selected' : '' ?>>PDF</option>
            </select>
            <select name="usage">
                <option value="">All usage states</option>
                <option value="used" <?= $usage === 'used' ? 'selected' : '' ?>>In use</option>
                <option value="unused" <?= $usage === 'unused' ? 'selected' : '' ?>>Unused</option>
                <option value="missing" <?= $usage === 'missing' ? 'selected' : '' ?>>Missing file</option>
            </select>
            <button class="btn btn-secondary" type="submit">Filter</button>
            <?php if ($q !== '' || $type !== '' || $usage !== ''): ?><a class="btn btn-secondary" href="<?= e(adminUrl('assets-library/')) ?>">Clear</a><?php endif; ?>
        </form>

        <div class="admin-card">
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Asset</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Category</th>
                            <th>Usage</th>
                            <th>File</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><strong><?= e($row['original_name']) ?></strong><?php if ($row['alt_text']): ?><div class="muted"><?= e($row['alt_text']) ?></div><?php endif; ?></td>
                                <td><?= e($row['mime_type']) ?></td>
                                <td><?= e(number_format(((int)$row['file_size']) / 1048576, 2)) ?> MB</td>
                                <td><?= e((string)($row['category'] ?? '—')) ?></td>
                                <td>
                                    <?php if (!$row['file_exists']): ?>
                                        <span style="color:#b42318;font-weight:600;">Missing</span>
                                    <?php elseif ((int)$row['reference_count'] > 0): ?>
                                        <a href="<?= e(adminUrl('assets-library/reference.php?id=' . (int)$row['id'])) ?>"><?= e((string)$row['reference_count']) ?> reference<?= (int)$row['reference_count'] === 1 ? '' : 's' ?></a>
                                    <?php else: ?>
                                        <span class="muted">Unused</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $row['file_exists'] ? 'Present' : '<span style="color:#b42318;">Missing</span>' ?></td>
                                <td><?= e($row['created_at']) ?></td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="<?= e(adminUrl('assets-library/edit.php?id=' . (int)$row['id'])) ?>">Edit</a>
                                    <a class="btn btn-sm btn-secondary" href="<?= e(adminUrl('assets-library/reference.php?id=' . (int)$row['id'])) ?>">References</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (!$rows): ?><tr>
                                <td colspan="8">No matching assets found.</td>
                            </tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ((int)$summary['unregistered_files'] > 0): ?>
            <div class="admin-card" style="margin-top:1rem;">
                <div class="page-heading" style="margin-bottom:0;">
                    <div>
                        <h2 style="font-size:1.1rem;">Filesystem notice</h2>
                        <p><?= e((string)$summary['unregistered_files']) ?> file<?= (int)$summary['unregistered_files'] === 1 ? '' : 's' ?> exist under <code>assets/uploads/</code> without a library record.</p>
                    </div>
                    <a class="btn btn-secondary" href="<?= e(adminUrl('assets-library/references.php')) ?>">Inspect filesystem</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>