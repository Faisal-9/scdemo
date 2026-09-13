<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/AssetReferenceManager.php';
Auth::requirePermission('manage_assets');

$search = trim((string)($_GET['q'] ?? ''));
$usage = in_array($_GET['usage'] ?? '', ['used', 'unused', 'missing'], true) ? (string)$_GET['usage'] : '';
$assets = AssetReferenceManager::assets($search, $usage);
$unregistered = AssetReferenceManager::unregisteredFiles();
$summary = AssetReferenceManager::summary();
$pageTitle = 'Asset References';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
    <div class="admin-container">
        <?php require __DIR__ . '/../partials/alerts.php'; ?>
        <div class="page-heading">
            <div>
                <h1>Asset References</h1>
                <p>Check which uploaded assets are used, missing, or present on disk without a library record.</p>
            </div><a class="btn btn-secondary" href="<?= e(adminUrl('assets-library/')) ?>">Back to Asset Library</a>
        </div>
        <div class="row g-3 mb-4">
            <?php foreach ([['Asset Records', $summary['asset_count']], ['Used', $summary['used_assets']], ['Unused', $summary['unused_assets']], ['Missing Files', $summary['missing_db_files']], ['Unregistered Files', $summary['unregistered_files']]] as [$label, $value]): ?>
                <div class="col-sm-6 col-xl-3">
                    <div class="admin-card h-100">
                        <div class="muted"><?= e($label) ?></div>
                        <div style="font-size:1.8rem;font-weight:700;"><?= e((string)$value) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="get" class="admin-filter-bar"><input type="search" name="q" placeholder="Search filename, path, category..." value="<?= e($search) ?>"><select name="usage">
                <option value="">All</option>
                <option value="used" <?= $usage === 'used' ? 'selected' : '' ?>>Used</option>
                <option value="unused" <?= $usage === 'unused' ? 'selected' : '' ?>>Unused</option>
                <option value="missing" <?= $usage === 'missing' ? 'selected' : '' ?>>Missing file</option>
            </select><button class="btn btn-secondary" type="submit">Filter</button></form>
        <div class="admin-card mb-4">
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Asset</th>
                            <th>Path</th>
                            <th>References</th>
                            <th>File</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($assets as $row): ?><tr>
                                <td><strong><?= e($row['original_name']) ?></strong>
                                    <div class="muted"><?= e($row['mime_type']) ?></div>
                                </td>
                                <td><code><?= e($row['relative_path']) ?></code></td>
                                <td><?= e((string)$row['reference_count']) ?></td>
                                <td><?= $row['file_exists'] ? 'Present' : '<span style="color:#b42318;">Missing</span>' ?></td>
                                <td><?= e($row['created_at']) ?></td>
                                <td><a class="btn btn-sm btn-primary" href="<?= e(adminUrl('assets-library/reference.php?id=' . (int)$row['id'])) ?>">Inspect</a></td>
                            </tr><?php endforeach; ?>
                        <?php if (!$assets): ?><tr>
                                <td colspan="6">No matching asset records found.</td>
                            </tr><?php endif; ?></tbody>
                </table>
            </div>
        </div>
        <div class="admin-card">
            <div class="page-heading" style="margin-bottom:1rem;">
                <div>
                    <h2 style="font-size:1.15rem;">Unregistered files</h2>
                    <p>Files physically present under <code>assets/uploads/</code> that have no media_library record.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Path</th>
                            <th>Size</th>
                            <th>Modified</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($unregistered as $file): ?><tr>
                                <td><code><?= e($file['relative_path']) ?></code></td>
                                <td><?= e(number_format(((int)$file['file_size']) / 1048576, 2)) ?> MB</td>
                                <td><?= e($file['modified_at']) ?></td>
                            </tr><?php endforeach; ?>
                        <?php if (!$unregistered): ?><tr>
                                <td colspan="3">No unregistered upload files found.</td>
                            </tr><?php endif; ?></tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>