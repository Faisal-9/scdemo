<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_services');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$groupId = $id ?: null;
$error = null;
$success = flash('success');

if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);
    $action = postString('form_action');
    try {
        if ($action === 'save_group') {
            $groupIdPost = filter_input(INPUT_POST, 'group_id', FILTER_VALIDATE_INT);
            $key = postString('service_key');
            $title = postString('title');
            $heroImage = postString('hero_image');
            $heroText = postString('hero_text');
            $sortOrder = max(0, (int) ($_POST['sort_order'] ?? 0));
            $active = isset($_POST['is_active']);

            if ($groupIdPost) {
                ServiceManager::updateGroup((int) $groupIdPost, $key, $title, $heroImage, $heroText, $sortOrder, $active);
                Auth::audit(Auth::id(), 'update', 'service_group', (int) $groupIdPost, 'Updated service group: ' . $title);
                flash('success', 'Service group saved successfully.');
                redirect(adminUrl('services/group.php?id=' . (int) $groupIdPost));
            }

            $newId = ServiceManager::createGroup($key, $title, $heroImage, $heroText, $sortOrder, $active);
            Auth::audit(Auth::id(), 'create', 'service_group', $newId, 'Created service group: ' . $title);
            redirect(adminUrl('services/group.php?id=' . $newId));
        }

        if ($action === 'delete_group') {
            $groupIdPost = filter_input(INPUT_POST, 'group_id', FILTER_VALIDATE_INT);
            if (!$groupIdPost) throw new RuntimeException('Invalid service group.');
            $group = ServiceManager::group((int) $groupIdPost);
            if (!$group) throw new RuntimeException('Service group not found.');
            ServiceManager::deleteGroup((int) $groupIdPost);
            Auth::audit(Auth::id(), 'delete', 'service_group', (int) $groupIdPost, 'Deleted service group: ' . $group['title']);
            flash('success', 'Service group deleted.');
            redirect(adminUrl('services/'));
        }
    } catch (Throwable $e) {
        $error = APP_DEBUG ? $e->getMessage() : 'The service group could not be saved.';
    }
}

$group = $groupId ? ServiceManager::group((int) $groupId) : null;
if ($groupId && $group === null) redirect(adminUrl('services/'));
$categories = $group ? ServiceManager::categories((int) $group['id']) : [];
$pageTitle = $group ? 'Edit Service Group' : 'Add Service Group';
$activeNav = 'services';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
    <?php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
        ['label' => 'Services', 'url' => adminUrl('services/')],
        ['label' => $group ? 'Edit Group' : 'Add Group', 'url' => null],
    ];
    require __DIR__ . '/../partials/breadcrumbs.php';
    $heading = $group ? 'Edit Service Group' : 'Add Service Group';
    $description = 'This controls only service data; the existing frontend component remains unchanged.';
    $actionUrl = adminUrl('services/');
    $actionLabel = 'Back';
    require __DIR__ . '/../partials/page-heading.php';
    require __DIR__ . '/../partials/alerts.php';
    ?>
    <?php if ($error !== null): ?><div class="alert alert-error" role="alert"><?= e($error) ?></div><?php endif; ?>
    <section class="form-card">
        <form method="post" autocomplete="off">
            <?= CSRF::field() ?>
            <input type="hidden" name="form_action" value="save_group">
            <input type="hidden" name="group_id" value="<?= e((string) ($group['id'] ?? '')) ?>">
            <div class="form-grid">
                <div class="form-field"><label for="service_key">Group key</label><input id="service_key" name="service_key" type="text" maxlength="150" value="<?= e($group['service_key'] ?? '') ?>" required><small>Use the existing key for migrated groups. Do not change it casually.</small></div>
                <div class="form-field"><label for="title">Title</label><input id="title" name="title" type="text" maxlength="255" value="<?= e($group['title'] ?? '') ?>" required></div>
                <div class="form-field"><label for="hero_image">Hero image path</label><input id="hero_image" name="hero_image" type="text" maxlength="500" value="<?= e($group['hero_image'] ?? '') ?>"><small>Existing asset path, for example assets/images/services/service-eng-hero.jpg</small></div>
                <div class="form-field"><label for="sort_order">Sort order</label><input id="sort_order" name="sort_order" type="number" min="0" value="<?= e((string) ($group['sort_order'] ?? 0)) ?>"></div>
            </div>
            <div class="form-field"><label for="hero_text">Hero text</label><textarea id="hero_text" name="hero_text" rows="4"><?= e($group['hero_text'] ?? '') ?></textarea></div>
            <label class="permission-option"><input type="checkbox" name="is_active" value="1" <?= !isset($group['is_active']) || $group['is_active'] ? 'checked' : '' ?>><span><strong>Active</strong><small>Inactive groups are not shown publicly after database integration.</small></span></label>
            <div class="form-actions"><a class="button-link button-secondary" href="<?= e(adminUrl('services/')) ?>">Cancel</a><button type="submit" class="button-primary">Save Group</button></div>
        </form>
    </section>
    <?php if ($group): ?>
        <section class="content-panel">
            <div class="panel-heading">
                <div>
                    <h2>Categories</h2>
                    <p class="muted">Manage the second level of this service group.</p>
                </div><a class="button-link" href="<?= e(adminUrl('services/category.php?group_id=' . (int) $group['id'])) ?>">+ Add Category</a>
            </div>
            <?php foreach ($categories as $category): ?>
                <div class="service-category-row">
                    <div><strong><?= e($category['title']) ?></strong><small><?= e((string) ($category['category_key'] ?? '')) ?></small></div><a class="small-button" href="<?= e(adminUrl('services/category.php?id=' . (int) $category['id'])) ?>">Manage</a>
                </div>
            <?php endforeach; ?>
        </section>
        <section class="danger-zone">
            <h2>Danger zone</h2>
            <p>Deleting a group also deletes its categories, service items and features because of the existing foreign-key cascade.</p>
            <form method="post" onsubmit="return confirm('Delete this service group and all of its categories/items?');">
                <?= CSRF::field() ?><input type="hidden" name="form_action" value="delete_group"><input type="hidden" name="group_id" value="<?= e((string) $group['id']) ?>"><button class="danger-button" type="submit">Delete service group</button>
            </form>
        </section>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>