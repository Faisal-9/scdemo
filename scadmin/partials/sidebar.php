<?php

/** @var string $activeNav */
$activeNav = $activeNav ?? '';

$navigation = [
    [
        'key' => 'dashboard',
        'label' => (string) SiteSettings::get('admin_nav_dashboard_label', 'Dashboard'),
        'url' => adminUrl('dashboard.php'),
        'permission' => null,
    ],

    [
        'key' => 'assets-library',
        'label' => (string) SiteSettings::get('admin_nav_assets_library_label', 'Asset Library'),
        'url' => adminUrl('assets-library/'),
        'permission' => 'manage_assets',
    ],

    [
        'key' => 'homepage',
        'label' => (string) SiteSettings::get('admin_nav_homepage_label', 'Homepage'),
        'url' => adminUrl('homepage/'),
        'permission' => 'manage_homepage',
    ],

    [
        'key' => 'about',
        'label' => (string) SiteSettings::get('admin_nav_about_label', 'About'),
        'url' => adminUrl('about/'),
        'permission' => 'manage_about',
    ],

    [
        'key' => 'projects',
        'label' => (string) SiteSettings::get('admin_nav_projects_label', 'Projects'),
        'url' => adminUrl('Projects/'),
        'permission' => 'manage_projects',
    ],

    [
        'key' => 'services',
        'label' => (string) SiteSettings::get('admin_nav_services_label', 'Services'),
        'url' => adminUrl('services/'),
        'permission' => 'manage_services',
    ],

    [
        'key' => 'sectors',
        'label' => (string) SiteSettings::get('admin_nav_sectors_label', 'Sectors'),
        'url' => adminUrl('sectors/'),
        'permission' => 'manage_sectors',
    ],

    [
        'key' => 'media',
        'label' => (string) SiteSettings::get('admin_nav_media_label', 'Media'),
        'url' => adminUrl('media/'),
        'permission' => 'manage_media',
    ],

    [
        'key' => 'legal',
        'label' => (string) SiteSettings::get('admin_nav_legal_label', 'Policies & Terms'),
        'url' => adminUrl('legal/'),
        'permission' => 'manage_legal',
    ],

    [
        'key' => 'messages',
        'label' => (string) SiteSettings::get('admin_nav_messages_label', 'Messages'),
        'url' => adminUrl('messages/'),
        'permission' => 'manage_messages',
    ],

    [
        'key' => 'contact',
        'label' => (string) SiteSettings::get('admin_nav_contact_label', 'Contact'),
        'url' => adminUrl('contact/'),
        'permission' => 'manage_messages',
    ],

    [
        'key' => 'navigation',
        'label' => (string) SiteSettings::get('admin_nav_navigation_label', 'Navigation'),
        'url' => adminUrl('navigation/'),
        'permission' => 'manage_navigation',
    ],

    [
        'key' => 'seo',
        'label' => (string) SiteSettings::get('admin_nav_seo_label', 'SEO'),
        'url' => adminUrl('seo/'),
        'permission' => 'manage_seo',
    ],

    [
        'key' => 'redirects',
        'label' => (string) SiteSettings::get('admin_nav_redirects_label', 'Redirects'),
        'url' => adminUrl('redirects/'),
        'permission' => 'manage_redirects',
    ],

    [
        'key' => 'settings',
        'label' => (string) SiteSettings::get('admin_nav_settings_label', 'Settings'),
        'url' => adminUrl('settings/'),
        'permission' => 'manage_settings',
    ],

    [
        'key' => 'analytics',
        'label' => (string) SiteSettings::get('admin_nav_analytics_label', 'Analytics'),
        'url' => adminUrl('analytics/'),
        'permission' => 'manage_analytics',
    ],

    [
        'key' => 'search',
        'label' => (string) SiteSettings::get('admin_nav_search_label', 'Search'),
        'url' => adminUrl('search/'),
        'permission' => 'search_content',
    ],

    [
        'key' => 'notifications',
        'label' => (string) SiteSettings::get('admin_nav_notifications_label', 'Notifications'),
        'url' => adminUrl('notifications/'),
        'permission' => 'manage_notifications',
    ],

];
?>

<aside class="sidebar" id="adminSidebar" aria-label="CMS navigation">
    <div class="sidebar-inner">
        <nav class="admin-nav">

            <?php foreach ($navigation as $item): ?>

                <?php if (!adminHasAccess($item['permission'])): ?>
                    <?php continue; ?>
                <?php endif; ?>

                <?php if ($item['url'] !== null): ?>

                    <a
                        class="admin-nav-link <?= e(adminActive($item['key'], $activeNav)) ?>"
                        href="<?= e($item['url']) ?>">
                        <?= e($item['label']) ?>
                    </a>

                <?php else: ?>

                    <span
                        class="admin-nav-link nav-disabled"
                        aria-disabled="true"
                        title="Available in a later CMS phase">

                        <?= e($item['label']) ?>

                        <span class="nav-soon">
                            Soon
                        </span>

                    </span>

                <?php endif; ?>

            <?php endforeach; ?>

            <?php if (Auth::isAdmin()): ?>

                <div class="nav-separator"></div>

                <a
                    class="admin-nav-link <?= e(adminActive('editors', $activeNav)) ?>"
                    href="<?= e(adminUrl('editors/')) ?>">
                    <?= e((string) SiteSettings::get('admin_nav_editors_label', 'Editors')); ?>
                </a>

                <?php if (adminHasAccess('manage_activity_logs')): ?>
                    <a
                        class="admin-nav-link <?= e(adminActive('activity-logs', $activeNav)) ?>"
                        href="<?= e(adminUrl('activity-logs/')) ?>">
                        <?= e((string) SiteSettings::get('admin_nav_activity_logs_label', 'Activity Logs')); ?>
                    </a>
                <?php endif; ?>

                <?php if (adminHasAccess('manage_system_health')): ?>
                    <a
                        class="admin-nav-link <?= e(adminActive('system-health', $activeNav)) ?>"
                        href="<?= e(adminUrl('system-health/')) ?>">
                        <?= e((string) SiteSettings::get('admin_nav_system_health_label', 'System Health')); ?>
                    </a>
                <?php endif; ?>

                <?php if (adminHasAccess('manage_database_backups')): ?>
                    <a
                        class="admin-nav-link <?= e(adminActive('database-backup', $activeNav)) ?>"
                        href="<?= e(adminUrl('database-backup/')) ?>">
                        <?= e((string) SiteSettings::get('admin_nav_database_backup_label', 'Database Backup')); ?>
                    </a>
                <?php endif; ?>

            <?php endif; ?>

        </nav>
    </div>
</aside>