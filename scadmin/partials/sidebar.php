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
        'key' => 'homepage',
        'label' => 'Homepage',
        'url' => null,
        'permission' => 'manage_homepage',
    ],
    [
        'key' => 'about',
        'label' => 'About',
        'url' => null,
        'permission' => 'manage_about',
    ],
    [
        'key' => 'projects',
        'label' => 'Projects',
        'url' => null,
        'permission' => 'manage_projects',
    ],
    [
        'key' => 'services',
        'label' => 'Services',
        'url' => null,
        'permission' => 'manage_services',
    ],
    [
        'key' => 'sectors',
        'label' => 'Sectors',
        'url' => null,
        'permission' => 'manage_sectors',
    ],
    [
        'key' => 'media',
        'label' => 'Media',
        'url' => null,
        'permission' => 'manage_media',
    ],
    [
        'key' => 'legal',
        'label' => 'Policies & Terms',
        'url' => null,
        'permission' => 'manage_legal',
    ],
    [
        'key' => 'messages',
        'label' => 'Messages',
        'url' => null,
        'permission' => 'manage_messages',
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
                        href="<?= e($item['url']) ?>"
                    >
                        <?= e($item['label']) ?>
                    </a>
                <?php else: ?>
                    <span class="admin-nav-link nav-disabled" aria-disabled="true" title="Available in a later CMS phase">
                        <?= e($item['label']) ?>
                        <span class="nav-soon">Soon</span>
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if (Auth::isAdmin()): ?>
                <div class="nav-separator"></div>

                <a
                    class="admin-nav-link <?= e(adminActive('editors', $activeNav)) ?>"
                    href="<?= e(adminUrl('editors/')) ?>"
                >
                    Editors
                </a>

                <span class="admin-nav-link nav-disabled" aria-disabled="true" title="Available in a later CMS phase">
                    Settings
                    <span class="nav-soon">Soon</span>
                </span>

                <span class="admin-nav-link nav-disabled" aria-disabled="true" title="Available in a later CMS phase">
                    Activity Log
                    <span class="nav-soon">Soon</span>
                </span>
            <?php endif; ?>
        </nav>
    </div>
</aside>
