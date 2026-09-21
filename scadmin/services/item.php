<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_services');

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
$categoryIdQuery = filter_var($_GET['category_id'] ?? null, FILTER_VALIDATE_INT);
$parentIdQuery = filter_var($_GET['parent_id'] ?? null, FILTER_VALIDATE_INT);

$itemId = ($id !== false && $id !== null && $id > 0) ? (int) $id : null;

$serviceItem = $itemId !== null
    ? ServiceManager::item($itemId)
    : null;

if ($itemId !== null && $serviceItem === null) {
    redirect(adminUrl('services/'));
}

$categoryId = $serviceItem
    ? (int) $serviceItem['category_id']
    : (($categoryIdQuery !== false && $categoryIdQuery !== null && $categoryIdQuery > 0)
        ? (int) $categoryIdQuery
        : 0);
if ($categoryId <= 0) redirect(adminUrl('services/'));
$category = ServiceManager::category($categoryId);
if (!$category) redirect(adminUrl('services/'));
$parents = ServiceManager::items($categoryId);
$error = null;

if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);
    $action = postString('form_action');
    try {
        if ($action === 'save_item') {
            $postedId = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
            $parentId = filter_input(INPUT_POST, 'parent_id', FILTER_VALIDATE_INT);
            $parentId = $parentId ?: null;
            $key = postString('service_key');
            $title = postString('title');
            $image = postString('service_asset_id');
            $short = trim((string)($_POST['short_description'] ?? ''));
            $why = trim((string)($_POST['why_description'] ?? ''));
            $featuresText = (string) ($_POST['features_text'] ?? '');
            $features = preg_split('/\R/', $featuresText) ?: [];
            $sortOrder = max(0, (int)($_POST['sort_order'] ?? 0));
            $active = isset($_POST['is_active']);

            if ($postedId) {
                ServiceManager::updateItem((int)$postedId, $parentId, $key, $title, $image, $short, $why, $features, $sortOrder, $active);
                Auth::audit(Auth::id(), 'update', 'service_item', (int)$postedId, 'Updated service item: ' . $title);
                flash('success', 'Service item saved successfully.');
                redirect(adminUrl('services/item.php?id=' . (int)$postedId));
            }
            $newId = ServiceManager::createItem($categoryId, $parentId, $key, $title, $image, $short, $why, $features, $sortOrder, $active);
            Auth::audit(Auth::id(), 'create', 'service_item', $newId, 'Created service item: ' . $title);
            redirect(adminUrl('services/item.php?id=' . $newId));
        }
        if ($action === 'delete_item') {
            $postedId = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);

            if ($postedId === false || $postedId === null || $postedId <= 0) {
                throw new RuntimeException('Invalid service item ID.');
            }

            $existing = ServiceManager::item((int) $postedId);

            if ($existing === null) {
                throw new RuntimeException('Service item not found.');
            }

            $categoryIdAfterDelete = (int) $existing['category_id'];

            ServiceManager::deleteItem((int) $postedId);

            Auth::audit(
                Auth::id(),
                'delete',
                'service_item',
                (int) $postedId,
                'Deleted service item: ' . $existing['title']
            );

            flash(
                'success',
                'Service item "' . $existing['title'] . '" was deleted successfully.'
            );

            redirect(
                adminUrl(
                    'services/category.php?id=' . $categoryIdAfterDelete
                )
            );
        }
    } catch (Throwable $e) {
        error_log(
            'State Corps CMS service item error: ' .
                $e->getMessage()
        );

        $error = APP_DEBUG
            ? $e->getMessage()
            : 'The service item could not be saved.';
    }
}

$serviceItem = $itemId ? ServiceManager::item((int)$itemId) : null;
$features = $serviceItem ? array_map(static fn(array $f): string => (string)$f['feature_text'], ServiceManager::features((int)$serviceItem['id'])) : [];
$parentOptions = [];
$selectedParentId = $serviceItem ? (int)($serviceItem['parent_id'] ?? 0) : (int)($parentIdQuery ?: 0);
foreach ($parents as $parent) {
    if ($serviceItem && (int)$parent['id'] === (int)$serviceItem['id']) continue;
    $parentOptions[] = $parent;
}
$isEditing = $serviceItem !== null;
$pageTitle = $isEditing ? 'Edit Service Item' : 'Add Service Item';
$activeNav = 'services';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
    <?php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
        ['label' => 'Services', 'url' => adminUrl('services/')],
        ['label' => (string)$category['title'], 'url' => adminUrl('services/category.php?id=' . $categoryId)],
        ['label' => $isEditing ? 'Edit Item' : 'Add Item', 'url' => null],
    ];
    require __DIR__ . '/../partials/breadcrumbs.php';
    $heading = $isEditing ? 'Edit Service Item' : 'Add Service Item';
    $description = 'Child items use the same nested structure as the current frontend.';
    $actionUrl = adminUrl('services/category.php?id=' . $categoryId);
    $actionLabel = 'Back';
    require __DIR__ . '/../partials/page-heading.php';
    require __DIR__ . '/../partials/alerts.php';
    ?>
    <?php if ($error !== null): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <section class="form-card">
        <form method="post" autocomplete="off">
            <?= CSRF::field() ?><input type="hidden" name="form_action" value="save_item"><input type="hidden" name="item_id" value="<?= e((string)($serviceItem['id'] ?? '')) ?>">
            <div class="form-grid">
                <div class="form-field"><label for="service_key">Service key</label><input id="service_key" name="service_key" type="text" maxlength="150" value="<?= e($serviceItem['service_key'] ?? '') ?>"></div>
                <div class="form-field"><label for="title">Title</label><input id="title" name="title" type="text" maxlength="500" value="<?= e($serviceItem['title'] ?? '') ?>" required></div>
                <div class="form-field"><label for="parent_id">Parent item</label><select id="parent_id" name="parent_id">
                        <option value="">No parent (top-level item)</option><?php foreach ($parentOptions as $parent): ?><option value="<?= e((string)$parent['id']) ?>" <?= $selectedParentId === (int)$parent['id'] ? 'selected' : '' ?>><?= e($parent['title']) ?></option><?php endforeach; ?>
                    </select><small>Use this for the existing nested <code>subitems</code> structure.</small></div>
                <div class="form-field form-field-wide"><?php mediaPickerField('service_asset_id', (string) ($serviceItem['service_asset_id'] ?? ''), ['label' => 'Image']); ?></div>
                <div class="form-field"><label for="sort_order">Sort order</label><input id="sort_order" name="sort_order" type="number" min="0" value="<?= e((string)($serviceItem['sort_order'] ?? 0)) ?>"></div>
            </div>
            <div class="form-field"><label for="short_description">Short description</label><textarea id="short_description" name="short_description" rows="6"><?= e($serviceItem['short_description'] ?? '') ?></textarea></div>
            <div class="form-field"><label for="why_description">Why</label><textarea id="why_description" name="why_description" rows="5"><?= e($serviceItem['why_description'] ?? '') ?></textarea></div>
            <div class="permission-box">
                <h2>Features</h2>
                <p class="muted">Keep one feature per line. Existing empty items are not created.</p><textarea name="features_text" id="features_text" rows="8"><?php foreach ($features as $feature): ?><?= e($feature) . "\n" ?><?php endforeach; ?></textarea><input type="hidden" name="features_ready" value="1">
            </div>
            <label class="permission-option"><input type="checkbox" name="is_active" value="1" <?= !isset($serviceItem['is_active']) || $serviceItem['is_active'] ? 'checked' : '' ?>><span><strong>Active</strong><small>Inactive service items are excluded from the public adapter.</small></span></label>
            <div class="form-actions"><a class="button-link button-secondary" href="<?= e(adminUrl('services/category.php?id=' . $categoryId)) ?>">Cancel</a><button type="submit" class="button-primary">Save Service Item</button></div>
        </form>
    </section>

    <?php if ($serviceItem && isset($serviceItem['id']) && (int)$serviceItem['id'] > 0): ?>
        <?php $dangerItemId = (int) $serviceItem['id']; ?>

        <section class="danger-zone">
            <h2>Danger zone</h2>

            <p>
                Deleting this service item is permanent.
                Any child service items and their features will also be deleted.
            </p>

            <form
                method="post"
                action="<?= e(adminUrl('services/item.php?id=' . $dangerItemId)) ?>"
                onsubmit="return confirm('Delete this service item and all child items?');">
                <?= CSRF::field() ?>

                <input type="hidden" name="form_action" value="delete_item">
                <input type="hidden" name="item_id" value="<?= $dangerItemId ?>">

                <button type="submit" class="danger-button">
                    Delete service item
                </button>
            </form>
        </section>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>