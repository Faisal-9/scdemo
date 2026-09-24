<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/MediaLibraryManager.php';
Auth::requirePermission('manage_assets');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        CSRF::check($_POST['_csrf'] ?? '');
        $action = (string)($_POST['action'] ?? '');
        if ($action === 'import') {
            $r = MediaLibraryManager::importExistingAssets();
            Session::flash('success', 'Imported ' . $r['created'] . ' existing assets. ' . $r['skipped'] . ' already registered/unsupported.');
        }
    } catch (Throwable $e) {
        Session::flash('error', $e->getMessage());
    }
    redirect(adminUrl('assets-library/'));
    exit;
}
$rows = MediaLibraryManager::list(['search' => trim((string)($_GET['q'] ?? '')), 'type' => (string)($_GET['type'] ?? ''), 'scope' => (string)($_GET['scope'] ?? ''), 'status' => (string)($_GET['status'] ?? '')]);
$q = trim((string)($_GET['q'] ?? ''));
$type = (string)($_GET['type'] ?? '');
$scope = (string)($_GET['scope'] ?? '');
$status = (string)($_GET['status'] ?? '');
$pageTitle = 'Media Library';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?><main class="admin-main management-page">
    <div class="admin-container">
        <div class="media-library-hero management-hero">
            <div><span class="management-kicker">Content workspace</span>
                <h1>Media Library</h1>
                <p>One central place for images and documents used by the CMS.</p>
            </div>
            <div class="media-library-actions"><a class="btn btn-primary" href="<?= e(adminUrl('assets-library/upload.php')) ?>">Upload</a></div>
        </div>
        <div class="admin-card media-import">
            <div><strong>Central media library</strong>
                <div class="muted">Images and documents are managed from this library and selected through the picker. New uploads are stored under the centralized upload root.</div>
            </div><a class="btn btn-secondary" href="<?= e(adminUrl('assets-library/references.php')) ?>">Check References</a>
        </div>
        <form method="get" class="admin-filter-bar"><input type="search" name="q" value="<?= e($q) ?>" placeholder="Type an image or file name..."><select name="type">
                <option value="">All</option>
                <option value="image" <?= $type === 'image' ? 'selected' : '' ?>>Images</option>
                <option value="document" <?= $type === 'document' ? 'selected' : '' ?>>Files</option>
            </select><select name="scope">
                <option value="">All sources</option>
                <option value="upload" <?= $scope === 'upload' ? 'selected' : '' ?>>CMS uploads</option>
                <option value="legacy" <?= $scope === 'legacy' ? 'selected' : '' ?>>Existing site assets</option>
            </select><select name="status">
                <option value="">All status</option>
                <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="archived" <?= $status === 'archived' ? 'selected' : '' ?>>Archived</option>
            </select><button class="btn btn-secondary" type="submit">Filter</button></form>
        <div class="media-library-grid"><?php foreach ($rows as $row): $image = str_starts_with((string)$row['mime_type'], 'image/'); ?><article class="media-library-card">
                    <div class="media-library-thumb"><?php if ($image): ?><img src="<?= e(baseUrl(AssetResolver::path($row['id']))) ?>" alt="<?= e((string)($row['alt_text'] ?? '')) ?>" loading="lazy"><?php else: ?><span><?= e(strtoupper(pathinfo((string)$row['original_name'], PATHINFO_EXTENSION) ?: 'FILE')) ?></span><?php endif; ?></div>
                    <div class="media-library-body"><strong title="<?= e($row['original_name']) ?>"><?= e($row['original_name']) ?></strong><small><?= e($row['relative_path']) ?></small><small><?= e((string)($row['category'] ?? '')) ?> · <?= e($row['storage_scope'] ?? '') ?> · <?= e($row['status'] ?? 'active') ?></small><?php if ($row['width_px'] || $row['height_px']): ?><small><?= e((string)$row['width_px']) ?> × <?= e((string)$row['height_px']) ?> px</small><?php endif; ?><div class="media-library-card-actions"><a class="btn btn-sm btn-primary" href="<?= e(adminUrl('assets-library/edit.php?id=' . (int)$row['id'])) ?>">Edit</a><button type="button" class="btn btn-sm btn-secondary" data-media-pick-path="<?= e($row['relative_path']) ?>" data-media-pick-name="<?= e($row['original_name']) ?>">Copy path</button></div>
                    </div>
                </article><?php endforeach; ?></div>
        <?php if (!$rows): ?><div class="admin-card">No assets found. Upload an image or document to add it to the centralized library.</div><?php endif; ?>
    </div>
</main>
<script>
    document.addEventListener('click', e => {
        const b = e.target.closest('[data-media-pick-path]');
        if (!b) return;
        navigator.clipboard?.writeText(b.dataset.mediaPickPath).then(() => {
            b.textContent = 'Copied';
            setTimeout(() => b.textContent = 'Copy path', 1200)
        });
    });
</script>
<?php require __DIR__ . '/../partials/footer.php'; ?>