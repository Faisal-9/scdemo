<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_homepage');
$error = null;
$path = HomeManager::statsBackground();
if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);
    try {
        HomeManager::saveStatsBackground(postString('asset_id'));
        Auth::audit(Auth::id(), 'update', 'home_setting', 1, 'Updated homepage statistics background image.');
        flash('success', 'Background saved.');
        redirect(adminUrl('homepage/background.php'));
    } catch (Throwable $e) {
        $error = APP_DEBUG ? $e->getMessage() : 'Background could not be saved.';
        $path = postString('asset_id');
    }
}
$pageTitle = 'Homepage Statistics Background';
$activeNav = 'homepage';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?><main class="admin-content"><?php $breadcrumbs = [['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')], ['label' => 'Homepage', 'url' => adminUrl('homepage/')], ['label' => 'Statistics Background', 'url' => null]];
                                require __DIR__ . '/../partials/breadcrumbs.php';
                                $heading = 'Statistics Background';
                                $description = 'Choose the background image stored in the media library.';
                                $actionUrl = adminUrl('homepage/');
                                $actionLabel = 'Back';
                                require __DIR__ . '/../partials/page-heading.php';
                                require __DIR__ . '/../partials/alerts.php';
                                if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?><section class="form-card">
        <form method="post"><?= CSRF::field() ?><?php mediaPickerField('asset_id', (string) $path, ['label' => 'Background image', 'required' => true]); ?>
            <div class="form-actions"><a class="button-link button-secondary" href="<?= e(adminUrl('homepage/')) ?>">Cancel</a><button class="button-primary" type="submit">Save Background</button></div>
        </form>
    </section>
</main><?php require __DIR__ . '/../partials/footer.php'; ?>