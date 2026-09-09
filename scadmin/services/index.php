<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_services');

$groups = ServiceManager::groups();
$pageTitle = 'Services';
$activeNav = 'services';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
    <?php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
        ['label' => 'Services', 'url' => null],
    ];
    require __DIR__ . '/../partials/breadcrumbs.php';
    $heading = 'Services';
    $description = 'Manage the existing service hierarchy without changing the public layout.';
    $actionUrl = adminUrl('services/group.php');
    $actionLabel = '+ Add Service Group';
    require __DIR__ . '/../partials/page-heading.php';
    require __DIR__ . '/../partials/alerts.php';
    ?>
    <section class="content-panel">
        <div class="panel-heading">
            <div>
                <h2>Service groups</h2>
                <p class="muted">Group → category → service → sub-service → features.</p>
            </div>
        </div>
        <?php if ($groups === []): ?>
            <div class="empty-state">No service groups found.</div>
        <?php else: ?>
            <div class="service-admin-tree">
                <?php foreach ($groups as $group): ?>
                    <?php $categories = ServiceManager::categories((int) $group['id']); ?>
                    <article class="service-group-card">
                        <div class="service-group-card-header">
                            <div>
                                <div class="eyebrow">Group key: <?= e($group['service_key']) ?></div>
                                <h3><?= e($group['title']) ?></h3>
                                <p><?= e((string) $group['hero_text']) ?></p>
                            </div>
                            <div class="actions-cell">
                                <span class="status-badge status-<?= $group['is_active'] ? 'active' : 'inactive' ?>"><?= $group['is_active'] ? 'Active' : 'Inactive' ?></span>
                                <a class="small-button" href="<?= e(adminUrl('services/group.php?id=' . (int) $group['id'])) ?>">Edit group</a>
                            </div>
                        </div>
                        <div class="service-category-list">
                            <?php foreach ($categories as $category): ?>
                                <?php $items = ServiceManager::items((int) $category['id']); ?>
                                <div class="service-category-row">
                                    <div>
                                        <strong><?= e($category['title']) ?></strong>
                                        <?php if (!empty($category['category_key'])): ?><span class="tree-key"><?= e($category['category_key']) ?></span><?php endif; ?>
                                        <small><?= e((string) count($items)) ?> top-level service items</small>
                                    </div>
                                    <a class="small-button" href="<?= e(adminUrl('services/category.php?id=' . (int) $category['id'])) ?>">Manage</a>
                                </div>
                            <?php endforeach; ?>
                            <a class="button-link button-secondary add-inline" href="<?= e(adminUrl('services/category.php?group_id=' . (int) $group['id'])) ?>">+ Add category</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>