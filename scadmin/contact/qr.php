<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/ContactMessageManager.php';
Auth::requirePermission('manage_messages');
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$rows = ContactMessageManager::qrCodes();
$existing = null;
if ($id) {
    foreach ($rows as $r) if ((int)$r['id'] === $id) $existing = $r;
    if (!$existing) redirect(adminUrl('contact/qr.php'));
}
$error = null;
if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);
    try {
        $new = ContactMessageManager::saveQr($_POST, $id ?: null);
        flash('success', 'QR code saved.');
        redirect(adminUrl('contact/qr.php'));
    } catch (Throwable $e) {
        $error = APP_DEBUG ? $e->getMessage() : 'Unable to save QR code.';
        $existing = array_merge((array)$existing, $_POST);
    }
}
$rows = ContactMessageManager::qrCodes();
$pageTitle = 'QR Codes';
$activeNav = 'messages';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?><main class="admin-content">
    <div class="contact-cms-wrap"><?php $breadcrumbs = [['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')], ['label' => 'Contact', 'url' => adminUrl('contact/')], ['label' => 'QR Codes', 'url' => null]];
                                    require __DIR__ . '/../partials/breadcrumbs.php';
                                    $heading = $id ? 'Edit QR Code' : 'QR Codes';
                                    $description = 'Manage the QR images currently shown in the head-office block.';
                                    $actionUrl = adminUrl('contact/qr.php');
                                    $actionLabel = '+ Add QR';
                                    require __DIR__ . '/../partials/page-heading.php';
                                    require __DIR__ . '/../partials/alerts.php';
                                    if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?><?php if ($id): ?><section class="form-card">
                <form method="post"><?= CSRF::field() ?><label>Label<input name="label" value="<?= e($existing['label'] ?? '') ?>" required></label><label>Image path<input name="image_path" value="<?= e($existing['image_path'] ?? '') ?>" required></label><label>Sort order<input type="number" min="0" name="sort_order" value="<?= e((string)($existing['sort_order'] ?? 0)) ?>"></label><label><input type="checkbox" name="is_active" value="1" <?= !isset($existing['is_active']) || $existing['is_active'] ? 'checked' : '' ?>> Active</label>
                    <div class="form-actions"><button type="submit">Save</button><a class="button-link button-secondary" href="<?= e(adminUrl('contact/qr.php')) ?>">Cancel</a></div>
                </form>
            </section><?php else: ?><section class="content-panel">
                <div class="panel-heading">
                    <h2>Configured QR codes</h2>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Label</th>
                            <th>Path</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody><?php foreach ($rows as $r): ?><tr>
                                <td><?= e((string)$r['sort_order']) ?></td>
                                <td><?= e($r['label']) ?></td>
                                <td><code><?= e($r['image_path']) ?></code></td>
                                <td><?= ((int)$r['is_active'] === 1) ? 'Active' : 'Inactive' ?></td>
                                <td><a class="small-button" href="<?= e(adminUrl('contact/qr.php?id=' . (int)$r['id'])) ?>">Edit</a></td>
                            </tr><?php endforeach; ?></tbody>
                </table>
            </section><?php endif; ?></div>
</main><?php require __DIR__ . '/../partials/footer.php'; ?>