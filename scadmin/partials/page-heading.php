<?php
/** @var string $heading */
/** @var string|null $description */
/** @var string|null $actionUrl */
/** @var string|null $actionLabel */
$heading = $heading ?? '';
$description = $description ?? null;
$actionUrl = $actionUrl ?? null;
$actionLabel = $actionLabel ?? null;
$activeNav = adminResolvedActiveNav($activeNav ?? '');

if (empty($breadcrumbsRendered)) {
    $breadcrumbLabels = [
        'activity-logs' => 'Activity Logs',
        'assets-library' => 'Asset Library',
        'backup-vault' => 'Backup Vault',
        'database-backup' => 'Database Backup',
        'editors' => 'Editors',
        'footer' => 'Footer',
        'header' => 'Header',
        'navigation' => 'Navigation',
        'redirects' => 'Redirects',
        'revisions' => 'Version History',
        'seo' => 'SEO',
        'settings' => 'Settings',
        'system-health' => 'System Health',
    ];
    $breadcrumbLabel = $breadcrumbLabels[$activeNav] ?? ucwords(str_replace(['-', '_'], ' ', $activeNav));
    $breadcrumbs = [['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')]];
    if ($activeNav !== '' && $activeNav !== 'dashboard') {
        $breadcrumbs[] = ['label' => $breadcrumbLabel, 'url' => adminUrl($activeNav . '/')];
    }
    $breadcrumbs[] = ['label' => $pageTitle, 'url' => null];
    require __DIR__ . '/breadcrumbs.php';
}
?>

<div class="page-heading-row">
    <div>
        <h1><?= e($heading) ?></h1>
        <?php if ($description !== null && $description !== ''): ?>
            <p class="muted"><?= e($description) ?></p>
        <?php endif; ?>
    </div>

    <?php if ($actionUrl !== null && $actionLabel !== null): ?>
        <a class="button-link" href="<?= e($actionUrl) ?>">
            <?= e($actionLabel) ?>
        </a>
    <?php endif; ?>
</div>
