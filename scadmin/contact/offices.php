<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/ContactMessageManager.php';
Auth::requirePermission('manage_messages');
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$rows = ContactMessageManager::offices();
$existing = null;
if ($id) {
    foreach ($rows as $r) if ((int)$r['id'] === $id) $existing = $r;
    if (!$existing) redirect(adminUrl('contact/offices.php'));
}
$error = null;
if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);
    try {
        $new = ContactMessageManager::saveOffice($_POST, $id ?: null);
        flash('success', 'Office saved.');
        redirect(adminUrl('contact/offices.php'));
    } catch (Throwable $e) {
        $error = APP_DEBUG ? $e->getMessage() : 'Unable to save office.';
        $existing = array_merge((array)$existing, $_POST);
    }
}
$rows = ContactMessageManager::offices();
$pageTitle = 'Overseas Offices';
$activeNav = 'messages';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?><main class="admin-content">
    <div class="contact-cms-wrap"><?php $breadcrumbs = [['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')], ['label' => 'Contact', 'url' => adminUrl('contact/')], ['label' => 'Overseas Offices', 'url' => null]];
                                    require __DIR__ . '/../partials/breadcrumbs.php';
                                    $heading = $id ? 'Edit Office' : 'Overseas Offices';
                                    $description = 'Manage the offices displayed in the existing Overseas Companies cards.';
                                    $actionUrl = adminUrl('contact/offices.php?edit=1');
                                    $actionLabel = '+ Add Office';
                                    require __DIR__ . '/../partials/page-heading.php';
                                    require __DIR__ . '/../partials/alerts.php';
                                    if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?><?php if ($id): ?><section class="form-card">
                <form method="post"><?= CSRF::field() ?><div class="form-grid"><label>Title<input name="title" value="<?= e($existing['title'] ?? '') ?>" required></label><label>Phone<input name="phone" value="<?= e($existing['phone'] ?? '') ?>"></label><label>WhatsApp<input name="whatsapp" value="<?= e($existing['whatsapp'] ?? '') ?>"></label><label>Email<input type="email" name="email" value="<?= e($existing['email'] ?? '') ?>"></label><label>Sort order<input type="number" min="0" name="sort_order" value="<?= e((string)($existing['sort_order'] ?? 0)) ?>"></label><label class="full">Address<textarea name="address" rows="4" required><?= e($existing['address'] ?? '') ?></textarea></label></div><label><input type="checkbox" name="is_active" value="1" <?= !isset($existing['is_active']) || $existing['is_active'] ? 'checked' : '' ?>> Active</label>
                    <div class="form-actions"><button type="submit">Save</button><a class="button-link button-secondary" href="<?= e(adminUrl('contact/offices.php')) ?>">Cancel</a></div>
                </form>
            </section><?php else: ?><section class="content-panel">
                <div class="panel-heading">
                    <h2>Configured offices</h2><a class="button-link" href="<?= e(adminUrl('contact/offices.php?id=0')) ?>">+ Add Office</a>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Office</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody><?php foreach ($rows as $r): ?><tr>
                                <td><?= e((string)$r['sort_order']) ?></td>
                                <td><strong><?= e($r['title']) ?></strong><br><?= e($r['address']) ?></td>
                                <td><?= e($r['phone'] ?? '') ?><?php if ($r['email']): ?><br><?= e($r['email']) ?><?php endif; ?></td>
                                <td><?= ((int)$r['is_active'] === 1) ? 'Active' : 'Inactive' ?></td>
                                <td><a class="small-button" href="<?= e(adminUrl('contact/offices.php?id=' . (int)$r['id'])) ?>">Edit</a></td>
                            </tr><?php endforeach; ?></tbody>
                </table>
            </section><?php endif; ?></div>
</main><?php require __DIR__ . '/../partials/footer.php'; ?>