<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/ContactMessageManager.php';
Auth::requirePermission('manage_messages');
$page = ContactMessageManager::page();
$q = ContactMessageManager::qrCodes();
$o = ContactMessageManager::offices();
$pageTitle = 'Contact';
$activeNav = 'messages';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
    <div class="contact-cms-wrap">
        <?php $breadcrumbs = [['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')], ['label' => 'Contact', 'url' => null]];
        require __DIR__ . '/../partials/breadcrumbs.php';
        $heading = 'Contact';
        $description = 'Manage the public Contact page content and message inbox.';
        $actionUrl = null;
        $actionLabel = null;
        require __DIR__ . '/../partials/page-heading.php';
        require __DIR__ . '/../partials/alerts.php'; ?>
        <section class="contact-cms-grid">
            <article class="content-panel">
                <h2>Contact page</h2>
                <p class="muted">Head office, map, form heading and Overseas Companies text.</p><a class="button-link" href="<?= e(adminUrl('contact/page.php')) ?>">Edit contact page</a>
            </article>
            <article class="content-panel">
                <h2>QR codes</h2>
                <p class="muted"><?= count($q) ?> configured QR code(s).</p><a class="button-link" href="<?= e(adminUrl('contact/qr.php')) ?>">Manage QR codes</a>
            </article>
            <article class="content-panel">
                <h2>Overseas offices</h2>
                <p class="muted"><?= count($o) ?> configured office(s).</p><a class="button-link" href="<?= e(adminUrl('contact/offices.php')) ?>">Manage offices</a>
            </article>
            <article class="content-panel">
                <h2>Messages</h2>
                <p class="muted">Open the contact-form inbox.</p><a class="button-link" href="<?= e(adminUrl('messages/')) ?>">Open messages</a>
            </article>
        </section>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>