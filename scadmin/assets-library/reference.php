<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/AssetReferenceManager.php';
require_once __DIR__ . '/../../app/core/AssetManager.php';
Auth::requirePermission('manage_assets');

$id = max(0, (int)($_GET['id'] ?? 0));
$asset = $id > 0 ? AssetManager::find($id) : null;
if (!$asset) {
    http_response_code(404);
    exit('Asset not found.');
}
$references = AssetReferenceManager::referencesForPath((string)$asset['relative_path']);
$fileExists = is_file(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, (string)$asset['relative_path']));
$pageTitle = 'Inspect Asset References';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
    <div class="admin-container">
        <div class="page-heading">
            <div>
                <h1>Inspect Asset References</h1>
                <p><?= e($asset['original_name']) ?></p>
            </div><a class="btn btn-secondary" href="<?= e(adminUrl('assets-library/references.php')) ?>">Back</a>
        </div>
        <div class="admin-card mb-4">
            <div class="table-responsive">
                <table class="admin-table">
                    <tbody>
                        <tr>
                            <th style="width:180px;">Original name</th>
                            <td><?= e($asset['original_name']) ?></td>
                        </tr>
                        <tr>
                            <th>Relative path</th>
                            <td><code><?= e($asset['relative_path']) ?></code></td>
                        </tr>
                        <tr>
                            <th>MIME type</th>
                            <td><?= e($asset['mime_type']) ?></td>
                        </tr>
                        <tr>
                            <th>File status</th>
                            <td><?= $fileExists ? 'Present' : '<span style="color:#b42318;">Missing from disk</span>' ?></td>
                        </tr>
                        <tr>
                            <th>Reference count</th>
                            <td><?= e((string)count($references)) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="admin-card">
            <div class="page-heading" style="margin-bottom:1rem;">
                <div>
                    <h2 style="font-size:1.15rem;">Database references</h2>
                    <p>These are database fields containing the asset path. Logs and revision snapshots are intentionally excluded from the scan.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Table</th>
                            <th>Column</th>
                            <th>Row ID</th>
                            <th>Snippet</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($references as $ref): ?><tr>
                                <td><code><?= e($ref['table_name']) ?></code></td>
                                <td><code><?= e($ref['column_name']) ?></code></td>
                                <td><?= e((string)$ref['row_id']) ?></td>
                                <td><small><?= e($ref['snippet']) ?></small></td>
                            </tr><?php endforeach; ?>
                        <?php if (!$references): ?><tr>
                                <td colspan="4">No live CMS database references found for this path.</td>
                            </tr><?php endif; ?></tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>