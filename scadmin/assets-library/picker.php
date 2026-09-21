<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/MediaLibraryManager.php';
Auth::requirePermission('manage_assets');
$q = trim((string)($_GET['q'] ?? ''));
$type = (string)($_GET['type'] ?? 'image');
if (!in_array($type, ['image', 'document'], true)) $type = 'image';
$rows = MediaLibraryManager::pickerSearch($q, $type, 48);
if (($_GET['format'] ?? '') === 'json') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['items' => $rows], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}
$pageTitle = 'Media Picker';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?><main class="admin-main">
    <div class="admin-container">
        <div class="admin-card">
            <h1>Media Picker</h1>
            <p>Select an asset to use in a CMS field.</p>
            <form method="get"><input type="hidden" name="type" value="<?= e($type) ?>">
                <div class="media-picker-row"><input class="form-control" type="search" name="q" value="<?= e($q) ?>" placeholder="Start typing a filename..."><button class="btn btn-primary" type="submit">Search</button></div>
            </form>
            <div class="media-picker-grid"><?php foreach ($rows as $row): ?><button type="button" class="media-picker-card" data-id="<?= e((string)$row['id']) ?>" data-name="<?= e($row['original_name']) ?>"><?php if (str_starts_with($row['mime_type'], 'image/')): ?><img src="<?= e(function_exists('baseUrl') ? baseUrl($row['relative_path']) : $row['relative_path']) ?>" alt="" loading="lazy"><?php else: ?><div class="media-picker-file">FILE</div><?php endif; ?><strong><?= e($row['original_name']) ?></strong><small><?= e($row['relative_path']) ?></small></button><?php endforeach; ?></div><?php if (!$rows): ?><div class="admin-card">No matching assets.</div><?php endif; ?>
        </div>
    </div>
</main><?php require __DIR__ . '/../partials/footer.php'; ?>