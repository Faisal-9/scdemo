<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_notifications');
if ($_SERVER['REQUEST_METHOD'] === 'POST') { CSRF::verify($_POST['csrf_token'] ?? ''); if (($_POST['action'] ?? '') === 'read_all') NotificationManager::markAllRead(); elseif (($_POST['action'] ?? '') === 'read') NotificationManager::markRead((int)($_POST['id'] ?? 0)); redirect(adminUrl('notifications/')); }
$rows = NotificationManager::latest();
$pageTitle='Notifications'; $activeNav='notifications'; require __DIR__.'/../partials/header.php'; require __DIR__.'/../partials/sidebar.php';
?>
<main class="admin-main"><div class="admin-container"><?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'Notifications','url'=>null]]; require __DIR__.'/../partials/breadcrumbs.php'; $heading='Notifications'; $description='Review system and content notifications assigned to your account.'; $actionUrl=null; $actionLabel=null; require __DIR__.'/../partials/page-heading.php'; ?>
<section class="content-panel"><div class="panel-heading"><div><h2>Notification center</h2><p class="muted"><?=e((string)NotificationManager::unreadCount())?> unread notification(s).</p></div><form method="post"><?=CSRF::field()?><input type="hidden" name="action" value="read_all"><button class="small-button" type="submit">Mark all read</button></form></div>
<div class="dashboard-notification-list"><?php foreach($rows as $row): ?><article class="dashboard-notification <?=((int)$row['is_read']===0?'is-unread':'')?>"><div><strong><?=e($row['title'])?></strong><p><?=e((string)$row['message'])?></p><small><?=e((string)$row['created_at'])?></small></div><div><?php if(!empty($row['url'])):?><a class="small-button" href="<?=e(baseUrl($row['url']))?>">Open</a><?php endif;?><?php if(!(int)$row['is_read']):?><form method="post" style="display:inline"><?=CSRF::field()?><input type="hidden" name="action" value="read"><input type="hidden" name="id" value="<?=e((string)$row['id'])?>"><button class="small-button" type="submit">Mark read</button></form><?php endif;?></div></article><?php endforeach;?><?php if(!$rows):?><p class="muted">No notifications yet.</p><?php endif;?></div></section></div></main><?php require __DIR__.'/../partials/footer.php'; ?>
