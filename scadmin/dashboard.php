<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

Auth::requireLogin();

$user = Auth::user() ?? [];
$role = Auth::role();

$pageTitle = 'Dashboard';
$activeNav = 'dashboard';

require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/sidebar.php';
?>

<main class="admin-content">
    <?php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => null],
    ];
    require __DIR__ . '/partials/breadcrumbs.php';
    ?>

    <?php
    $heading = 'Dashboard';
    $description = 'Central administration area for the State Corps website.';
    $actionUrl = null;
    $actionLabel = null;
    require __DIR__ . '/partials/page-heading.php';
    ?>

    <?php require __DIR__ . '/partials/alerts.php'; ?>

    <section class="dashboard-grid">
        <article class="dashboard-card">
            <span class="card-label">Signed in as</span>
            <strong><?= e((string) ($user['display_name'] ?? '')) ?></strong>
            <small><?= e(ucfirst((string) $role)) ?> account</small>
        </article>

        <article class="dashboard-card">
            <span class="card-label">Access level</span>
            <strong><?= Auth::isAdmin() ? 'Full access' : 'Assigned sections' ?></strong>
            <small><?= Auth::isAdmin() ? 'Administrator' : 'Editor permissions apply server-side' ?></small>
        </article>

        <article class="dashboard-card">
            <span class="card-label">Website</span>
            <strong>Protected</strong>
            <small>Public frontend has not been changed by the CMS.</small>
        </article>
    </section>

    <section class="content-panel">
        <div class="panel-heading">
            <div>
                <h2>CMS sections</h2>
                <p class="muted">The modules below will be activated phase by phase.</p>
            </div>
        </div>

        <div class="module-grid">
            <?php
            $modules = [
                ['label' => 'Homepage', 'permission' => 'manage_homepage'],
                ['label' => 'About', 'permission' => 'manage_about'],
                ['label' => 'Projects', 'permission' => 'manage_projects'],
                ['label' => 'Services', 'permission' => 'manage_services'],
                ['label' => 'Sectors', 'permission' => 'manage_sectors'],
                ['label' => 'Media', 'permission' => 'manage_media'],
                ['label' => 'Policies & Terms', 'permission' => 'manage_legal'],
                ['label' => 'Messages', 'permission' => 'manage_messages'],
            ];
            ?>

            <?php foreach ($modules as $module): ?>
                <?php if (!adminHasAccess($module['permission'])): ?>
                    <?php continue; ?>
                <?php endif; ?>

                <div class="module-card module-card-disabled">
                    <div>
                        <strong><?= e($module['label']) ?></strong>
                        <span>Module will be connected in a later phase.</span>
                    </div>
                    <span class="module-status">Coming next</span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
