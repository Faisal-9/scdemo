<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/ContactMessageManager.php';
Auth::requirePermission('manage_messages');
$page = ContactMessageManager::page();
$error = null;
if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);
    try {
        ContactMessageManager::savePage($_POST);
        flash('success', 'Contact page content saved.');
        redirect(adminUrl('contact/page.php'));
    } catch (Throwable $e) {
        $error = APP_DEBUG ? $e->getMessage() : 'Unable to save Contact page content.';
        $page = array_merge($page, $_POST);
    }
}
$pageTitle = 'Contact Page';
$activeNav = 'messages';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?><main class="admin-content">
    <div class="contact-cms-wrap"><?php $breadcrumbs = [['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')], ['label' => 'Contact', 'url' => adminUrl('contact/')], ['label' => 'Contact Page', 'url' => null]];
                                    require __DIR__ . '/../partials/breadcrumbs.php';
                                    $heading = 'Contact Page';
                                    $description = 'These values drive the existing public contactSection.php without changing its design.';
                                    $actionUrl = null;
                                    $actionLabel = null;
                                    require __DIR__ . '/../partials/page-heading.php';
                                    require __DIR__ . '/../partials/alerts.php';
                                    if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?><section class="form-card">
            <form method="post"><?= CSRF::field() ?><div class="form-grid">
                    <label>Section title<input name="section_title" value="<?= e($page['section_title'] ?? 'Reach Us') ?>" required></label>
                    <label>Form title<input name="form_title" value="<?= e($page['form_title'] ?? 'Drop Message') ?>" required></label>
                    <label>Head office title<input name="head_office_title" value="<?= e($page['head_office_title'] ?? '') ?>" required></label>
                    <label>Head office phone<input name="head_office_phone" value="<?= e($page['head_office_phone'] ?? '') ?>" required></label>
                    <label>Head office WhatsApp<input name="head_office_whatsapp" value="<?= e($page['head_office_whatsapp'] ?? '') ?>"></label>
                    <label>Head office email<input type="email" name="head_office_email" value="<?= e($page['head_office_email'] ?? '') ?>" required></label>
                    <label class="full">Head office address<textarea name="head_office_address" rows="3" required><?= e($page['head_office_address'] ?? '') ?></textarea></label>
                    <label>Map label<input name="map_label" value="<?= e($page['map_label'] ?? '') ?>" required></label>
                    <label>Map zoom<input type="number" min="1" max="20" name="map_zoom" value="<?= e((string)($page['map_zoom'] ?? 14)) ?>"></label>
                    <label>Map latitude<input name="map_lat" value="<?= e((string)($page['map_lat'] ?? '')) ?>" required></label>
                    <label>Map longitude<input name="map_lng" value="<?= e((string)($page['map_lng'] ?? '')) ?>" required></label>
                    <label>Overseas section title<input name="overseas_title" value="<?= e($page['overseas_title'] ?? 'Overseas Companies') ?>" required></label>
                    <label class="full">Overseas section subtitle<textarea name="overseas_subtitle" rows="3" required><?= e($page['overseas_subtitle'] ?? '') ?></textarea></label>
                </div>
                <div class="form-actions"><a class="button-link button-secondary" href="<?= e(adminUrl('contact/')) ?>">Cancel</a><button type="submit">Save</button></div>
            </form>
        </section>
    </div>
</main><?php require __DIR__ . '/../partials/footer.php'; ?>