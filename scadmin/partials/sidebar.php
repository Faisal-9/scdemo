<?php

/** @var string $activeNav */
$activeNav = adminResolvedActiveNav($activeNav ?? '');

$navigationGroups = [
    'Public Pages' => [
        ['key' => 'homepage', 'label' => 'Homepage', 'url' => adminUrl('homepage/'), 'permission' => 'manage_homepage'],
        ['key' => 'about', 'label' => 'About', 'url' => adminUrl('about/'), 'permission' => 'manage_about'],
        ['key' => 'services', 'label' => 'Services', 'url' => adminUrl('services/'), 'permission' => 'manage_services'],
        ['key' => 'sectors', 'label' => 'Expertise', 'url' => adminUrl('sectors/'), 'permission' => 'manage_sectors'],
        ['key' => 'projects', 'label' => 'Projects', 'url' => adminUrl('projects/'), 'permission' => 'manage_projects'],
        ['key' => 'media', 'label' => 'Media', 'url' => adminUrl('media/'), 'permission' => 'manage_media'],
        ['key' => 'opportunities', 'label' => 'Opportunities', 'url' => null, 'permission' => 'manage_opportunities'],
        ['key' => 'contact', 'label' => 'Contact', 'url' => adminUrl('contact/'), 'permission' => 'manage_messages'],
    ],
    'Content & Assets' => [
        ['key' => 'assets-library', 'label' => 'Asset Library', 'url' => adminUrl('assets-library/'), 'permission' => 'manage_assets'],
        ['key' => 'messages', 'label' => 'Messages', 'url' => adminUrl('messages/'), 'permission' => 'manage_messages'],
        ['key' => 'legal', 'label' => 'Policies & Terms', 'url' => adminUrl('legal/'), 'permission' => 'manage_legal'],
    ],
    'Site Management' => [
        ['key' => 'navigation', 'label' => 'Navigation', 'url' => adminUrl('navigation/'), 'permission' => 'manage_navigation'],
        ['key' => 'seo', 'label' => 'SEO', 'url' => adminUrl('seo/'), 'permission' => 'manage_seo'],
        ['key' => 'redirects', 'label' => 'Redirects', 'url' => adminUrl('redirects/'), 'permission' => 'manage_redirects'],
        ['key' => 'settings', 'label' => 'Settings', 'url' => adminUrl('settings/'), 'permission' => 'manage_settings'],
        ['key' => 'analytics', 'label' => 'Analytics', 'url' => adminUrl('analytics/'), 'permission' => 'manage_analytics'],
        ['key' => 'search', 'label' => 'Search', 'url' => adminUrl('search/'), 'permission' => 'search_content'],
        ['key' => 'notifications', 'label' => 'Notifications', 'url' => adminUrl('notifications/'), 'permission' => 'manage_notifications'],
    ],
];
?>

<aside class="sidebar" id="adminSidebar" aria-label="CMS navigation">
    <div class="sidebar-inner">
        <nav class="admin-nav">
            <div class="admin-nav-group admin-nav-group-dashboard">
                <a class="admin-nav-link <?= e(adminActive('dashboard', $activeNav)) ?>" href="<?= e(adminUrl('dashboard.php')) ?>">Dashboard</a>
            </div>

            <?php foreach ($navigationGroups as $heading => $navItems): ?>
                <?php $visibleItems = array_values(array_filter($navItems, static fn(array $item): bool => adminHasAccess($item['permission']))); ?>
                <?php if ($visibleItems === []): continue; endif; ?>
                <div class="admin-nav-group">
                    <div class="admin-nav-heading"><?= e($heading) ?></div>
                    <?php foreach ($visibleItems as $item): ?>
                        <?php if ($item['url'] !== null): ?>
                            <a class="admin-nav-link <?= e(adminActive($item['key'], $activeNav)) ?>" href="<?= e($item['url']) ?>"><?= e($item['label']) ?></a>
                        <?php else: ?>
                            <span class="admin-nav-link nav-disabled" aria-disabled="true" title="No editor is available yet">
                                <?= e($item['label']) ?><span class="nav-soon">Soon</span>
                            </span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <?php if (Auth::isAdmin()): ?>
                <div class="admin-nav-group">
                    <div class="admin-nav-heading">Administration</div>
                    <a class="admin-nav-link <?= e(adminActive('editors', $activeNav)) ?>" href="<?= e(adminUrl('editors/')) ?>"><?= e((string) SiteSettings::get('admin_nav_editors_label', 'Editors')); ?></a>
                    <?php if (adminHasAccess('manage_activity_logs')): ?>
                        <a class="admin-nav-link <?= e(adminActive('activity-logs', $activeNav)) ?>" href="<?= e(adminUrl('activity-logs/')) ?>"><?= e((string) SiteSettings::get('admin_nav_activity_logs_label', 'Activity Logs')); ?></a>
                    <?php endif; ?>
                    <?php if (adminHasAccess('manage_revisions')): ?>
                        <a class="admin-nav-link <?= e(adminActive('revisions', $activeNav)) ?>" href="<?= e(adminUrl('revisions/')) ?>">Version History</a>
                    <?php endif; ?>
                    <?php if (adminHasAccess('manage_system_health')): ?>
                        <a class="admin-nav-link <?= e(adminActive('system-health', $activeNav)) ?>" href="<?= e(adminUrl('system-health/')) ?>"><?= e((string) SiteSettings::get('admin_nav_system_health_label', 'System Health')); ?></a>
                    <?php endif; ?>
                    <?php if (adminHasAccess('manage_database_backups')): ?>
                        <a class="admin-nav-link <?= e(adminActive('database-backup', $activeNav)) ?>" href="<?= e(adminUrl('database-backup/')) ?>"><?= e((string) SiteSettings::get('admin_nav_database_backup_label', 'Database Backup')); ?></a>
                    <?php endif; ?>
                </div>

            <?php endif; ?>

        </nav>
    </div>
</aside>