<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_analytics');

$days = (int)($_GET['days'] ?? 30);
$days = in_array($days, [7, 30, 90], true) ? $days : 30;
if (($_GET['export'] ?? '') === 'csv') AnalyticsManager::csv($days);
$retentionMessage = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'purge') { CSRF::verify($_POST['csrf_token'] ?? ''); $deleted = AnalyticsManager::deleteOlderThan((int)($_POST['retention_days'] ?? 365)); $retentionMessage = 'Deleted ' . $deleted . ' old analytics record(s).'; }
$report = AnalyticsManager::overview($days);
$chartMax = 1;
foreach ($report['daily'] as $chartRow) $chartMax = max($chartMax, (int)$chartRow['page_views'], (int)$chartRow['visitors']);

$pageTitle = 'Analytics';
$activeNav = 'analytics';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
    <div class="admin-container">
        <?php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
            ['label' => 'Analytics', 'url' => null],
        ];
        require __DIR__ . '/../partials/breadcrumbs.php';
        $heading = 'Analytics';
        $description = 'First-party page views and pseudonymous visitors collected from the public website.';
        $actionUrl = null;
        $actionLabel = null;
        require __DIR__ . '/../partials/page-heading.php';
        require __DIR__ . '/../partials/alerts.php';
        ?>
        <?php if ($retentionMessage): ?><div class="alert alert-success"><?=e($retentionMessage)?></div><?php endif; ?>

        <section class="dashboard-grid dashboard-summary-grid">
            <article class="dashboard-card"><span class="card-label">Visitors today</span><strong><?= e((string)$report['today']['visitors']) ?></strong><small>Unique pseudonymous visitors</small></article>
            <article class="dashboard-card"><span class="card-label">Page views today</span><strong><?= e((string)$report['today']['page_views']) ?></strong><small>Public GET page views</small></article>
            <article class="dashboard-card"><span class="card-label">Visitors · <?= e((string)$days) ?> days</span><strong><?= e((string)$report['totals']['visitors']) ?></strong><small>Selected date range</small></article>
            <article class="dashboard-card"><span class="card-label">Page views · <?= e((string)$days) ?> days</span><strong><?= e((string)$report['totals']['page_views']) ?></strong><small>Selected date range</small></article>
        </section>

        <section class="content-panel">
            <div class="panel-heading"><div><h2>Report range</h2><p class="muted">Visitor identity is pseudonymous and no raw IP address is stored.</p></div><div><a class="small-button" href="<?=e(adminUrl('analytics/?days='.$days.'&export=csv'))?>">Export CSV</a></div></div>
            <div class="dashboard-quick-actions">
                <?php foreach ([7 => 'Last 7 days', 30 => 'Last 30 days', 90 => 'Last 90 days'] as $value => $label): ?>
                    <a class="dashboard-action <?= $days === $value ? 'dashboard-action-active' : '' ?>" href="<?= e(adminUrl('analytics/?days=' . $value)) ?>"><?= e($label) ?></a>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="content-panel"><div class="panel-heading"><div><h2>Devices</h2><p class="muted">Device categories for the selected range.</p></div></div><div class="dashboard-content-links"><?php foreach($report['devices'] as $device): ?><div><strong><?=e((string)$device['page_views'])?></strong><span><?=e(ucfirst((string)$device['device_type']))?> · <?=e((string)$device['visitors'])?> visitors</span></div><?php endforeach; ?></div></section>

        <div class="dashboard-columns">
            <section class="content-panel">
                <div class="panel-heading"><div><h2>Popular pages</h2><p class="muted">Most viewed public paths.</p></div></div>
                <div class="table-responsive"><table class="admin-table"><thead><tr><th>Page</th><th>Views</th><th>Visitors</th></tr></thead><tbody>
                <?php foreach ($report['top_pages'] as $row): ?><tr><td><strong><?= e((string)$row['page_title']) ?></strong><div class="muted"><code><?= e((string)$row['page_path']) ?></code></div></td><td><?= e((string)$row['page_views']) ?></td><td><?= e((string)$row['visitors']) ?></td></tr><?php endforeach; ?>
                <?php if ($report['top_pages'] === []): ?><tr><td colspan="3">No page views recorded for this range.</td></tr><?php endif; ?>
                </tbody></table></div>
            </section>
            <section class="content-panel">
                <div class="panel-heading"><div><h2>Traffic sources</h2><p class="muted">Referrer hosts recorded with page views.</p></div></div>
                <div class="table-responsive"><table class="admin-table"><thead><tr><th>Source</th><th>Views</th></tr></thead><tbody>
                <?php foreach ($report['referrers'] as $row): ?><tr><td><?= e((string)$row['referrer']) ?></td><td><?= e((string)$row['page_views']) ?></td></tr><?php endforeach; ?>
                <?php if ($report['referrers'] === []): ?><tr><td colspan="2">No referrer data recorded for this range.</td></tr><?php endif; ?>
                </tbody></table></div>
            </section>
        </div>

        <section class="content-panel">
            <div class="panel-heading"><div><h2>Daily activity</h2><p class="muted">Views and visitors grouped by day.</p></div></div>
            <div class="analytics-chart" aria-label="Daily visitors and page views chart">
                <?php foreach ($report['daily'] as $chartRow): ?><div class="analytics-chart-day"><div class="analytics-chart-bars"><span class="analytics-bar analytics-bar-visitors" style="height:<?=e((string)max(4, round(((int)$chartRow['visitors'] / $chartMax) * 100)))?>%" title="<?=e((string)$chartRow['visitors'])?> visitors"></span><span class="analytics-bar analytics-bar-views" style="height:<?=e((string)max(4, round(((int)$chartRow['page_views'] / $chartMax) * 100)))?>%" title="<?=e((string)$chartRow['page_views'])?> page views"></span></div><small><?=e(substr((string)$chartRow['day'], 5))?></small></div><?php endforeach; ?>
            </div>
            <div class="table-responsive"><table class="admin-table"><thead><tr><th>Date</th><th>Visitors</th><th>Page views</th></tr></thead><tbody>
            <?php foreach ($report['daily'] as $row): ?><tr><td><?= e((string)$row['day']) ?></td><td><?= e((string)$row['visitors']) ?></td><td><?= e((string)$row['page_views']) ?></td></tr><?php endforeach; ?>
            <?php if ($report['daily'] === []): ?><tr><td colspan="3">No analytics data recorded for this range.</td></tr><?php endif; ?>
            </tbody></table></div>
        </section>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
