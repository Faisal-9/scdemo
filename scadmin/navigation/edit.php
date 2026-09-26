<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_navigation');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$row = $id ? NavigationManager::find((int)$id) : null;
if ($id && !$row) { http_response_code(404); exit('Navigation item not found.'); }

$location = (string)($row['location'] ?? ($_GET['location'] ?? 'header'));
if (!in_array($location, ['header', 'footer'], true)) { $location = 'header'; }
if ($location === 'footer') {
    redirect(adminUrl('footer/' . ($id ? '?nav_id=' . (int)$id : '?add_nav=1')));
}
redirect(adminUrl('header/' . ($id ? '?nav_id=' . (int)$id : '?add_nav=1')));
$parents = NavigationManager::parents($location, $id ? (int)$id : null);

$values = [
  'label' => (string)($row['label'] ?? ''),
  'url' => (string)($row['url'] ?? '#'),
  'target' => (string)($row['target'] ?? '_self'),
  'icon_class' => (string)($row['icon_class'] ?? ''),
  'sort_order' => (string)($row['sort_order'] ?? '0'),
  'is_active' => (int)($row['is_active'] ?? 1),
  'parent_id' => (string)($row['parent_id'] ?? ''),
  'location' => $location,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::check($_POST['_csrf'] ?? '');
    try {
        $savedId = NavigationManager::save($id ? (int)$id : null, [
            'location' => $_POST['location'] ?? 'header',
            'label' => $_POST['label'] ?? '',
            'url' => $_POST['url'] ?? '#',
            'target' => $_POST['target'] ?? '_self',
            'icon_class' => $_POST['icon_class'] ?? '',
            'sort_order' => $_POST['sort_order'] ?? 0,
            'is_active' => isset($_POST['is_active']),
            'parent_id' => $_POST['parent_id'] ?? '',
        ]);
        Auth::audit(Auth::id(), $id ? 'update' : 'create', 'navigation', $savedId, ($id ? 'Updated' : 'Created') . ' navigation item: ' . (string)($_POST['label'] ?? ''));
        Session::flash('success', 'Navigation item saved successfully.');
        header('Location: ' . adminUrl('navigation/?location=' . urlencode((string)($_POST['location'] ?? 'header'))));
        exit;
    } catch (Throwable $e) {
        Session::flash('error', $e->getMessage());
        $values = array_merge($values, $_POST);
        $values['location'] = (string)($values['location'] ?? 'header');
        $parents = NavigationManager::parents($values['location'], $id ? (int)$id : null);
    }
}

$pageTitle = $id ? 'Edit Navigation Item' : 'Add Navigation Item';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
<?php require __DIR__ . '/../partials/alerts.php'; ?>
<?php require __DIR__ . '/../partials/page-heading.php'; ?>
<div class="admin-card settings-form-card">
<form method="post">
<input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
<div class="form-group"><label>Location</label><select name="location" class="form-control"><option value="header" <?= $values['location'] === 'header' ? 'selected' : '' ?>>Header</option><option value="footer" <?= $values['location'] === 'footer' ? 'selected' : '' ?>>Footer</option></select></div>
<div class="form-group"><label>Label</label><input class="form-control" name="label" maxlength="150" required value="<?= e((string)$values['label']) ?>"></div>
<div class="form-group"><label>URL</label><input class="form-control" name="url" maxlength="500" required value="<?= e((string)$values['url']) ?>"></div>
<div class="form-group"><label>Parent</label><select name="parent_id" class="form-control"><option value="">Top level</option><?php foreach ($parents as $parent): ?><option value="<?= (int)$parent['id'] ?>" <?= (string)$values['parent_id'] === (string)$parent['id'] ? 'selected' : '' ?>><?= e($parent['label']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Target</label><select name="target" class="form-control"><option value="_self" <?= (string)$values['target'] === '_self' ? 'selected' : '' ?>>Same tab</option><option value="_blank" <?= (string)$values['target'] === '_blank' ? 'selected' : '' ?>>New tab</option></select></div>
<div class="form-group"><label>Icon Class <span class="muted">(optional)</span></label><input class="form-control" name="icon_class" maxlength="150" value="<?= e((string)$values['icon_class']) ?>"></div>
<div class="form-group"><label>Sort Order</label><input type="number" min="0" class="form-control" name="sort_order" value="<?= e((string)$values['sort_order']) ?>"></div>
<div class="form-group"><label><input type="checkbox" name="is_active" value="1" <?= !empty($values['is_active']) ? 'checked' : '' ?>> Active</label></div>
<div class="admin-actions"><button class="btn btn-primary" type="submit">Save</button><a class="btn btn-secondary" href="<?= e(adminUrl('navigation/?location=' . urlencode($location))) ?>">Cancel</a></div>
</form>
</div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
