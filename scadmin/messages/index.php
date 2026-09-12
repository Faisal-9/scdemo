<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/ContactMessageManager.php';
Auth::requirePermission('manage_messages');

$page = max(1, (int)($_GET['page'] ?? 1));
$search = trim((string)($_GET['q'] ?? ''));
$status = (string)($_GET['status'] ?? '');
$result = ContactMessageManager::paginate($page, 20, $search, $status);
$pageTitle = 'Messages';
$activeNav = 'messages';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
    <?php
    $breadcrumbs = [['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')], ['label' => 'Messages', 'url' => null]];
    require __DIR__ . '/../partials/breadcrumbs.php';
    $heading = 'Messages';
    $description = 'Review messages submitted through the public Contact page.';
    $actionUrl = null;
    $actionLabel = null;
    require __DIR__ . '/../partials/page-heading.php';
    require __DIR__ . '/../partials/alerts.php';
    ?>
    <section class="content-panel">
        <form method="get" class="form-grid">
            <label>Search<input name="q" value="<?= e($search) ?>" placeholder="Name, email, subject or message"></label>
            <label>Status<select name="status">
                    <option value="">All statuses</option><?php foreach (['unread', 'read', 'archived'] as $option): ?><option value="<?= e($option) ?>" <?= $status === $option ? 'selected' : '' ?>><?= e(ucfirst($option)) ?></option><?php endforeach; ?>
                </select></label>
            <div class="form-actions"><button type="submit">Filter</button><a class="button-link button-secondary" href="<?= e(adminUrl('messages/')) ?>">Reset</a></div>
        </form>
    </section>
    <section class="content-panel">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result['items'] as $message): ?><tr>
                        <td><?= e((string)$message['created_at']) ?></td>
                        <td><?= e((string)$message['name']) ?></td>
                        <td><?= e((string)$message['email']) ?></td>
                        <td><?= e((string)($message['subject'] ?? '')) ?></td>
                        <td><?= e(ucfirst((string)$message['status'])) ?></td>
                        <td><a class="small-button" href="<?= e(adminUrl('messages/view.php?id=' . (int)$message['id'])) ?>">Open</a></td>
                    </tr><?php endforeach; ?>
                <?php if (!$result['items']): ?><tr>
                        <td colspan="6">No messages found.</td>
                    </tr><?php endif; ?>
            </tbody>
        </table>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>