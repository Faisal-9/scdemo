<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

Auth::requireLogin();

$user = Auth::user() ?? [];
$role = Auth::role();
$overview = DashboardManager::overview();
$counts = $overview['counts'];
$analytics = $overview['analytics'];
$health = null;
if (adminHasAccess('manage_system_health')) {
    require_once __DIR__ . '/../app/core/SystemHealthManager.php';
    $health = SystemHealthManager::report();
}

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

    <section class="dashboard-grid dashboard-summary-grid">
        <article class="dashboard-card">
            <span class="card-label">Projects</span>
            <strong><?= e((string)$counts['projects']) ?></strong>
            <small><?= e((string)$counts['published_projects']) ?> published</small>
        </article>

        <article class="dashboard-card">
            <span class="card-label">Active services</span>
            <strong><?= e((string)$counts['services']) ?></strong>
            <small>Nested service items</small>
        </article>

        <article class="dashboard-card">
            <span class="card-label">Media assets</span>
            <strong><?= e((string)$counts['media']) ?></strong>
            <small>Managed library records</small>
        </article>

        <article class="dashboard-card <?= $counts['unread_messages'] > 0 ? 'dashboard-card-attention' : '' ?>">
            <span class="card-label">Unread messages</span>
            <strong><?= e((string)$counts['unread_messages']) ?></strong>
            <small><?= e((string)$counts['messages']) ?> total submissions</small>
        </article>

        <article class="dashboard-card">
            <span class="card-label">Active users</span>
            <strong><?= e((string)$counts['active_users']) ?></strong>
            <small><?= e(ucfirst((string)$role)) ?> view: <?= e((string)($user['display_name'] ?? '')) ?></small>
        </article>

        <article class="dashboard-card">
            <span class="card-label">Website status</span>
            <strong><?= $health ? e(ucfirst($health['overall'])) : 'Protected' ?></strong>
            <small><?= $health ? e((string)$health['score']) . '% system health score' : 'Permission-scoped overview' ?></small>
        </article>

        <?php if (adminHasAccess('manage_analytics')): ?>
            <article class="dashboard-card">
                <span class="card-label">Visitors · 7 days</span>
                <strong><?= e((string)$analytics['totals']['visitors']) ?></strong>
                <small><?= e((string)$analytics['today']['visitors']) ?> today</small>
            </article>

            <article class="dashboard-card">
                <span class="card-label">Page views · 7 days</span>
                <strong><?= e((string)$analytics['totals']['page_views']) ?></strong>
                <small><?= e((string)$analytics['today']['page_views']) ?> today</small>
            </article>
        <?php endif; ?>
    </section>

    <?php if ($overview['alerts'] !== [] || ($health && $health['overall'] !== 'ok')): ?>
        <section class="content-panel dashboard-alerts-panel">
            <div class="panel-heading"><div><h2>Attention needed</h2><p class="muted">Items that may need an administrator or editor review.</p></div></div>
            <div class="dashboard-alert-list">
                <?php foreach ($overview['alerts'] as $alert): ?>
                    <a class="dashboard-alert dashboard-alert-<?= e($alert['type']) ?>" href="<?= e(adminUrl($alert['url'])) ?>">
                        <strong><?= e($alert['title']) ?></strong><span><?= e($alert['text']) ?></span>
                    </a>
                <?php endforeach; ?>
                <?php if ($health && $health['overall'] !== 'ok'): ?>
                    <a class="dashboard-alert dashboard-alert-<?= e($health['overall']) ?>" href="<?= e(adminUrl('system-health/')) ?>">
                        <strong>System health is <?= e($health['overall']) ?></strong><span>Open System Health for detailed diagnostics.</span>
                    </a>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <section class="content-panel">
        <div class="panel-heading">
            <div>
                <h2>Quick actions</h2>
                <p class="muted">Create or review the content areas available to your account.</p>
            </div>
        </div>
        <div class="dashboard-quick-actions">
            <?php $quickActions = [
                ['label' => 'Add Project', 'url' => 'projects/create.php', 'permission' => 'manage_projects'],
                ['label' => 'Add Service Group', 'url' => 'services/group.php', 'permission' => 'manage_services'],
                ['label' => 'Upload Media', 'url' => 'media/item.php', 'permission' => 'manage_media'],
                ['label' => 'Manage Homepage', 'url' => 'homepage/', 'permission' => 'manage_homepage'],
                ['label' => 'Review Messages', 'url' => 'messages/', 'permission' => 'manage_messages'],
                ['label' => 'Add Editor', 'url' => 'editors/create.php', 'permission' => 'manage_editors'],
            ]; ?>
            <?php foreach ($quickActions as $action): ?>
                <?php if (adminHasAccess($action['permission'])): ?><a class="dashboard-action" href="<?= e(adminUrl($action['url'])) ?>"><?= e($action['label']) ?></a><?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <?php if (adminHasAccess('manage_analytics')): ?>
        <section class="content-panel dashboard-analytics-panel">
            <div class="panel-heading"><div><h2>Analytics snapshot</h2><p class="muted">First-party public page activity for the last 7 days.</p></div><a class="small-button" href="<?= e(adminUrl('analytics/')) ?>">View analytics</a></div>
            <div class="dashboard-analytics-grid">
                <div><strong><?= e((string)$analytics['today']['visitors']) ?></strong><span>Visitors today</span></div>
                <div><strong><?= e((string)$analytics['today']['page_views']) ?></strong><span>Page views today</span></div>
                <div><strong><?= e((string)count($analytics['top_pages'])) ?></strong><span>Tracked popular pages</span></div>
            </div>
        </section>
    <?php endif; ?>

    <div class="dashboard-columns">
        <section class="content-panel">
            <div class="panel-heading"><div><h2>Recent activity</h2><p class="muted">Latest recorded CMS actions.</p></div><a class="small-button" href="<?= e(adminUrl('activity-logs/')) ?>">View all</a></div>
            <?php if ($overview['recent_activity'] === []): ?><p class="muted">No activity has been recorded yet.</p><?php else: ?>
                <div class="dashboard-activity-list">
                    <?php foreach ($overview['recent_activity'] as $activity): ?>
                        <a class="dashboard-activity-row" href="<?= e(adminUrl('activity-logs/view.php?id=' . (int)$activity['id'])) ?>"><span><strong><?= e((string)$activity['action']) ?></strong> <?= e((string)($activity['description'] ?: $activity['entity_type'])) ?></span><small><?= e((string)$activity['user_name']) ?> · <?= e((string)$activity['created_at']) ?></small></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <section class="content-panel">
            <div class="panel-heading"><div><h2>Content overview</h2><p class="muted">Live records available in this CMS.</p></div></div>
            <?php $overviewLinks = [
                ['label' => 'Sectors', 'count' => $counts['sectors'], 'url' => 'sectors/', 'permission' => 'manage_sectors'],
                ['label' => 'Projects', 'count' => $counts['projects'], 'url' => 'projects/', 'permission' => 'manage_projects'],
                ['label' => 'Services', 'count' => $counts['services'], 'url' => 'services/', 'permission' => 'manage_services'],
                ['label' => 'Media', 'count' => $counts['media'], 'url' => 'media/', 'permission' => 'manage_media'],
                ['label' => 'Contact messages', 'count' => $counts['messages'], 'url' => 'messages/', 'permission' => 'manage_messages'],
            ]; ?>
            <div class="dashboard-content-links">
                <?php foreach ($overviewLinks as $link): ?><?php if (adminHasAccess($link['permission'])): ?><a href="<?= e(adminUrl($link['url'])) ?>"><strong><?= e((string)$link['count']) ?></strong><span><?= e($link['label']) ?></span></a><?php endif; ?><?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
