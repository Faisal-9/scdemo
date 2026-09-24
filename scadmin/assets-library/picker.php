<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/MediaLibraryManager.php';
Auth::requirePermission('manage_assets');
$q = trim((string)($_GET['q'] ?? ''));
$type = (string)($_GET['type'] ?? 'image');
if (!in_array($type, ['image', 'document'], true)) $type = 'image';
$rows = MediaLibraryManager::pickerSearch($q, $type, 2000);
if (($_GET['format'] ?? '') === 'json') {
    foreach ($rows as &$row) {
        $row['public_path'] = AssetResolver::path($row['id']);
    }
    unset($row);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['items' => $rows], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}
redirect(adminUrl('assets-library/'));