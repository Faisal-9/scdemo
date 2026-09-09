<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_services');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$groupIdQuery = filter_input(INPUT_GET, 'group_id', FILTER_VALIDATE_INT);
$categoryId = $id ?: null;
$category = $categoryId ? ServiceManager::category((int) $categoryId) : null;
if ($categoryId && !$category) redirect(adminUrl('services/'));
$groupId = $category ? (int) $category['group_id'] : ($groupIdQuery ?: 0);
if ($groupId <= 0) redirect(adminUrl('services/'));
$group = ServiceManager::group($groupId);
if (!$group) redirect(adminUrl('services/'));

$error = null;
if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);
    $action = postString('form_action');
    try {
        if ($action === 'save_category') {
            $postedId = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
            $key = postString('category_key');
            $title = postString('title');
            $sortOrder = max(0, (int) ($_POST['sort_order'] ?? 0));
            $active = isset($_POST['is_active']);
            if ($postedId) {
                ServiceManager::updateCategory((int) $postedId, $key, $title, $sortOrder, $active);
                Auth::audit(Auth::id(), 'update', 'service_category', (int) $postedId, 'Updated service category: ' . $title);
                flash('success', 'Service category saved successfully.');
                redirect(adminUrl('services/category.php?id=' . (int) $postedId));
            }
            $newId = ServiceManager::createCategory($groupId, $key, $title, $sortOrder, $active);
            Auth::audit(Auth::id(), 'create', 'service_category', $newId, 'Created service category: ' . $title);
            redirect(adminUrl('services/category.php?id=' . $newId));
        }
        if ($action === 'delete_category') {
            $postedId = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
            if (!$postedId) throw new RuntimeException('Invalid category.');
            ServiceManager::deleteCategory((int) $postedId);
            Auth::audit(Auth::id(), 'delete', 'service_category', (int) $postedId, 'Deleted service category.');
            flash('success', 'Service category deleted.');
            redirect(adminUrl('services/group.php?id=' . $groupId));
        }
    } catch (Throwable $e) {
        $error = APP_DEBUG ? $e->getMessage() : 'The category could not be saved.';
    }
}

$category = $categoryId ? ServiceManager::category((int) $categoryId) : null;
$items = $category ? ServiceManager::items((int) $category['id']) : [];
$pageTitle = $category ? 'Edit Service Category' : 'Add Service Category';
$activeNav = 'services';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
    <?php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
        ['label' => 'Services', 'url' => adminUrl('services/')],
        ['label' => (string) $group['title'], 'url' => adminUrl('services/group.php?id=' . $groupId)],
        ['label' => $category ? 'Edit Category' : 'Add Category', 'url' => null],
    ];
    require __DIR__ . '/../partials/breadcrumbs.php';
    $heading = $category ? 'Edit Service Category' : 'Add Service Category';
    $description = 'Keep the category key stable for migrated content.';
    $actionUrl = adminUrl('services/group.php?id=' . $groupId);
    $actionLabel = 'Back';
    require __DIR__ . '/../partials/page-heading.php';
    require __DIR__ . '/../partials/alerts.php';
    ?>
    <?php if ($error !== null): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <section class="form-card">
        <form method="post" autocomplete="off">
            <?= CSRF::field() ?>
            <input type="hidden" name="form_action" value="save_category">
            <input type="hidden" name="category_id" value="<?= e((string) ($category['id'] ?? '')) ?>">
            <div class="form-grid">
                <div class="form-field"><label for="category_key">Category key</label><input id="category_key" name="category_key" type="text" maxlength="150" value="<?= e($category['category_key'] ?? '') ?>"></div>
                <div class="form-field"><label for="title">Title</label><input id="title" name="title" type="text" maxlength="255" value="<?= e($category['title'] ?? '') ?>" required></div>
                <div class="form-field"><label for="sort_order">Sort order</label><input id="sort_order" name="sort_order" type="number" min="0" value="<?= e((string) ($category['sort_order'] ?? 0)) ?>"></div>
            </div>
            <label class="permission-option"><input type="checkbox" name="is_active" value="1" <?= !isset($category['is_active']) || $category['is_active'] ? 'checked' : '' ?>><span><strong>Active</strong><small>Inactive categories are excluded from the public adapter.</small></span></label>
            <div class="form-actions"><a class="button-link button-secondary" href="<?= e(adminUrl('services/group.php?id=' . $groupId)) ?>">Cancel</a><button type="submit" class="button-primary">Save Category</button></div>
        </form>
    </section>
    <?php if ($category): ?>
        <section class="content-panel">
            <div class="panel-heading">
                <div>
                    <h2>Service items</h2>
                    <p class="muted">Items are the existing service panels. Child items become the existing <code>subitems</code> structure.</p>
                </div><a class="button-link" href="<?= e(adminUrl('services/item.php?category_id=' . (int) $category['id'])) ?>">+ Add Service Item</a>
            </div>
            <?php foreach ($items as $item): ?>
                <?php $children = ServiceManager::items((int) $category['id'], (int) $item['id']); ?>
                <div class="service-item-row">
                    <div><strong><?= e($item['title']) ?></strong><span class="tree-key"><?= e((string) ($item['service_key'] ?? '')) ?></span><small><?= e((string) count($children)) ?> subitems · <?= e((string) count(ServiceManager::features((int) $item['id']))) ?> features</small></div><a class="small-button" href="<?= e(adminUrl('services/item.php?id=' . (int) $item['id'])) ?>">Edit</a>
                </div>
            <?php endforeach; ?>
        </section>
        <section class="danger-zone">
            <h2>Danger zone</h2>
            <p>Deleting this category deletes its service items and features.</p>
            <form method="post" onsubmit="return confirm('Delete this category and all service items?');"><?= CSRF::field() ?><input type="hidden" name="form_action" value="delete_category"><input type="hidden" name="category_id" value="<?= e((string) $category['id']) ?>"><button class="danger-button" type="submit">Delete category</button></form>
        </section>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>