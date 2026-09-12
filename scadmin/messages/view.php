<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/ContactMessageManager.php';
Auth::requirePermission('manage_messages');

$id = (int)($_GET['id'] ?? 0);
$message = ContactMessageManager::find($id);
if (!$message) {
    flash('error', 'Message not found.');
    redirect(adminUrl('messages/'));
}
if (isPost()) {
    try {
        CSRF::verify($_POST['csrf_token'] ?? null);
        ContactMessageManager::setStatus($id, (string)($_POST['status'] ?? ''));
        flash('success', 'Message status updated.');
        redirect(adminUrl('messages/view.php?id=' . $id));
    } catch (Throwable $e) {
        flash('error', APP_DEBUG ? $e->getMessage() : 'Unable to update message.');
        redirect(adminUrl('messages/view.php?id=' . $id));
    }
}
$pageTitle = 'Message';
$activeNav = 'messages';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
    <?php
    $breadcrumbs = [['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')], ['label' => 'Messages', 'url' => adminUrl('messages/')], ['label' => 'Message', 'url' => null]];
    require __DIR__ . '/../partials/breadcrumbs.php';
    $heading = 'Message from ' . (string)$message['name'];
    $description = (string)$message['created_at'];
    $actionUrl = null;
    $actionLabel = null;
    require __DIR__ . '/../partials/page-heading.php';
    require __DIR__ . '/../partials/alerts.php';
    ?>
    <section class="content-panel">
        <p><strong>Email:</strong> <?= e((string)$message['email']) ?></p>
        <p><strong>Phone:</strong> <?= e((string)($message['phone'] ?? '')) ?></p>
        <p><strong>Subject:</strong> <?= e((string)($message['subject'] ?? '')) ?></p>
        <div class="content-panel"><strong>Message</strong>
            <p><?= nl2br(e((string)$message['message'])) ?></p>
        </div>
        <form method="post" class="form-actions"><?= CSRF::field() ?><label>Status<select name="status"><?php foreach (['unread', 'read', 'archived'] as $option): ?><option value="<?= e($option) ?>" <?= $message['status'] === $option ? 'selected' : '' ?>><?= e(ucfirst($option)) ?></option><?php endforeach; ?></select></label><button type="submit">Save status</button><a class="button-link button-secondary" href="<?= e(adminUrl('messages/')) ?>">Back</a></form>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>