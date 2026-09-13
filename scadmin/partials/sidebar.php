<?php

/** @var string $activeNav */
$activeNav = $activeNav ?? '';

$navigation = [
    [
        'key' => 'dashboard',
        'label' => 'Dashboard',
        'url' => adminUrl('dashboard.php'),
        'permission' => null,
    ],

    [
        'key' => 'assets-library',
        'label' => 'Asset Library',
        'url' => adminUrl('assets-library/'),
        'permission' => 'manage_assets',
    ],

    [
        'key' => 'homepage',
        'label' => 'Homepage',
        'url' => adminUrl('homepage/'),
        'permission' => 'manage_homepage',
    ],

    [
        'key' => 'about',
        'label' => 'About',
        'url' => adminUrl('about/'),
        'permission' => 'manage_about',
    ],

    [
        'key' => 'projects',
        'label' => 'Projects',
        'url' => adminUrl('Projects/'),
        'permission' => 'manage_projects',
    ],

    [
        'key' => 'services',
        'label' => 'Services',
        'url' => adminUrl('services/'),
        'permission' => 'manage_services',
    ],

    [
        'key' => 'sectors',
        'label' => 'Sectors',
        'url' => adminUrl('sectors/'),
        'permission' => 'manage_sectors',
    ],

    [
        'key' => 'media',
        'label' => 'Media',
        'url' => adminUrl('media/'),
        'permission' => 'manage_media',
    ],

    [
        'key' => 'legal',
        'label' => 'Policies & Terms',
        'url' => adminUrl('legal/'),
        'permission' => 'manage_legal',
    ],

    [
        'key' => 'messages',
        'label' => 'Messages',
        'url' => adminUrl('messages/'),
        'permission' => 'manage_messages',
    ],

    [
        'key' => 'contact',
        'label' => 'Contact',
        'url' => adminUrl('contact/'),
        'permission' => 'manage_messages',
    ],

    [
        'key' => 'navigation',
        'label' => 'Navigation',
        'url' => adminUrl('navigation/'),
        'permission' => 'manage_navigation',
    ],

    [
        'key' => 'seo',
        'label' => 'Seo',
        'url' => adminUrl('seo/'),
        'permission' => 'manage_seo',
    ],

    [
        'key' => 'redirects',
        'label' => 'Redirects',
        'url' => adminUrl('redirects/'),
        'permission' => 'manage_redirects',
    ],

    [
        'key' => 'settings',
        'label' => 'Settings',
        'url' => adminUrl('settings/'),
        'permission' => 'manage_settings',
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
                    Editors
                </a>

                <?php if (adminHasAccess('manage_activity_logs')): ?>
                    <a
                        class="admin-nav-link <?= e(adminActive('activity-logs', $activeNav)) ?>"
                        href="<?= e(adminUrl('activity-logs/')) ?>">
                        Activity Logs
                    </a>
                <?php endif; ?>

                <?php if (adminHasAccess('manage_system_health')): ?>
                    <a
                        class="admin-nav-link <?= e(adminActive('system-health', $activeNav)) ?>"
                        href="<?= e(adminUrl('system-health/')) ?>">
                        System Health
                    </a>
                <?php endif; ?>

                <?php if (adminHasAccess('manage_database_backups')): ?>
                    <a
                        class="admin-nav-link <?= e(adminActive('database-backup', $activeNav)) ?>"
                        href="<?= e(adminUrl('database-backup/')) ?>">
                        Database Backup
                    </a>
                <?php endif; ?>

                <?php if (adminHasAccess('manage_backup_vault')): ?>
                    <a
                        class="admin-nav-link <?= e(adminActive('backup-vault', $activeNav)) ?>"
                        href="<?= e(adminUrl('backup-vault/')) ?>">
                        Backup Vault
                    </a>
                <?php endif; ?>

            <?php endif; ?>

        </nav>
    </div>
</aside>