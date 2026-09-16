<?php

/** @var string $pageTitle */
/** @var string $activeNav */
$pageTitle = $pageTitle ?? 'Admin';
$activeNav = $activeNav ?? '';
$user = Auth::user() ?? [];
$notificationCount = class_exists('NotificationManager') && Auth::check() ? NotificationManager::unreadCount() : 0;
$assetVersion = defined('ASSET_VERSION') ? (string)constant('ASSET_VERSION') : '1.0.0';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow,noarchive">
    <title><?= e($pageTitle) ?> - <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= e(adminUrl('assets/css/admin.css') . '?v=' . urlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(baseUrl('assets/css/media-picker.css') . '?v=' . urlencode($assetVersion)) ?>">
    <script src="<?= e(baseUrl('assets/js/media-picker.js') . '?v=' . urlencode($assetVersion)) ?>" defer></script>
</head>

<body class="admin-body">
    <header class="admin-header">
        <div class="admin-brand-area">
            <button type="button" class="mobile-menu-button" id="adminMenuButton" aria-controls="adminSidebar" aria-expanded="false">
                <span></span><span></span><span></span>
                <span class="visually-hidden">Open menu</span>
            </button>
            <a class="admin-brand" href="<?= e(adminUrl('dashboard.php')) ?>">STATE CORPS CMS</a>
            <span class="role-badge"><?= e(ucfirst((string) ($user['role'] ?? ''))) ?></span>
        </div>

        <div class="header-user">
            <?php if (Auth::hasPermission('search_content')): ?><form class="admin-header-search" method="get" action="<?= e(adminUrl('search/')) ?>"><input type="search" name="q" placeholder="Search CMS..." aria-label="Search CMS"></form><?php endif; ?>
            <?php if ($notificationCount > 0): ?><a class="admin-notification-link" href="<?= e(adminUrl('notifications/')) ?>">Notifications (<?= e((string)$notificationCount) ?>)</a><?php endif; ?>
            <span class="header-user-name"><?= e((string) ($user['display_name'] ?? '')) ?></span>
            <a href="<?= e(adminUrl('logout.php')) ?>">Logout</a>
        </div>
    </header>

    <script>
        window.SC_BASE_URL = <?= json_encode(rtrim(BASE_URL, '/'), JSON_UNESCAPED_SLASHES) ?>;
        window.SC_MEDIA_PICKER_URL = <?= json_encode(adminUrl('assets-library/picker.php'), JSON_UNESCAPED_SLASHES) ?>;
    </script>

    <div class="admin-shell">