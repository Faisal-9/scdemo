<?php
/** @var string $pageTitle */
/** @var string $activeNav */
$pageTitle = $pageTitle ?? 'Admin';
$activeNav = $activeNav ?? '';
$user = Auth::user() ?? [];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow,noarchive">
    <title><?= e($pageTitle) ?> - <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= e(adminUrl('assets/css/admin.css')) ?>">
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
        <span class="header-user-name"><?= e((string) ($user['display_name'] ?? '')) ?></span>
        <a href="<?= e(adminUrl('logout.php')) ?>">Logout</a>
    </div>
</header>

<div class="admin-shell">
