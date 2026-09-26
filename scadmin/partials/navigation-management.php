<?php
/** @var string $navigationLocation */
/** @var array<int, array<string, mixed>> $navigationRows */
/** @var array<string, mixed>|null $navigationEditing */
/** @var array<int, array<string, mixed>> $navigationParents */
/** @var int|false|null $navigationId */
/** @var string|null $navigationError */

$navigationLocation = $navigationLocation ?? 'header';
$navigationRows = $navigationRows ?? [];
$navigationEditing = $navigationEditing ?? null;
$navigationParents = $navigationParents ?? [];
$navigationId = $navigationId ?? null;
$navigationError = $navigationError ?? null;
$isEditingNavigation = $navigationId || isset($_GET['add_nav']);
$navigationLabel = ucfirst($navigationLocation);
$navigationValues = $navigationEditing ?: [
    'label' => '',
    'url' => '#',
    'target' => '_self',
    'icon_class' => '',
    'sort_order' => 0,
    'is_active' => 1,
    'parent_id' => '',
];
$navigationAction = 'save_' . $navigationLocation . '_nav';
$navigationBaseUrl = adminUrl($navigationLocation . '/');
?>
<section class="admin-card management-card navigation-management-card">
    <div class="management-toolbar">
        <div>
            <span class="management-kicker"><?= e($navigationLabel) ?> links</span>
            <p class="management-summary">Manage labels, URLs, dropdown parents, icons, order, and visibility from this page.</p>
        </div>
        <a class="btn btn-primary" href="<?= e($navigationBaseUrl . '?add_nav=1') ?>">Add <?= e($navigationLabel) ?> Link</a>
    </div>

    <?php if ($navigationError !== null): ?><div class="alert alert-error"><?= e($navigationError) ?></div><?php endif; ?>

    <?php if ($isEditingNavigation): ?>
        <form method="post" class="navigation-editor-form">
            <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
            <input type="hidden" name="action" value="<?= e($navigationAction) ?>">
            <input type="hidden" name="nav_id" value="<?= e((string)($navigationId ?: '')) ?>">
            <div class="navigation-editor-grid">
                <div class="form-group"><label>Label</label><input class="form-control" name="label" maxlength="150" required value="<?= e((string)$navigationValues['label']) ?>"></div>
                <div class="form-group"><label>URL</label><input class="form-control" name="url" maxlength="500" required value="<?= e((string)$navigationValues['url']) ?>"></div>
                <div class="form-group"><label>Parent</label><select name="parent_id" class="form-control"><option value="">Top level</option><?php foreach ($navigationParents as $parent): ?><option value="<?= (int)$parent['id'] ?>" <?= (string)$navigationValues['parent_id'] === (string)$parent['id'] ? 'selected' : '' ?>><?= e($parent['label']) ?></option><?php endforeach; ?></select></div>
                <div class="form-group"><label>Target</label><select name="target" class="form-control"><option value="_self" <?= $navigationValues['target'] === '_self' ? 'selected' : '' ?>>Same tab</option><option value="_blank" <?= $navigationValues['target'] === '_blank' ? 'selected' : '' ?>>New tab</option></select></div>
                <?php if ($navigationLocation === 'header'): ?><div class="form-group"><label>Icon Class <span class="muted">(optional)</span></label><input class="form-control" name="icon_class" maxlength="150" value="<?= e((string)$navigationValues['icon_class']) ?>"></div><?php endif; ?>
                <div class="form-group"><label>Sort order</label><input type="number" min="0" class="form-control" name="sort_order" value="<?= e((string)$navigationValues['sort_order']) ?>"></div>
            </div>
            <label class="permission-option"><input type="checkbox" name="is_active" value="1" <?= !empty($navigationValues['is_active']) ? 'checked' : '' ?>><span><strong>Active</strong><small>Hidden links remain saved but are not shown publicly.</small></span></label>
            <div class="admin-actions"><button class="btn btn-primary" type="submit">Save <?= e($navigationLabel) ?> Link</button><a class="btn btn-secondary" href="<?= e($navigationBaseUrl) ?>">Cancel</a></div>
        </form>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="admin-table navigation-management-table">
            <thead><tr><th>Order</th><th>Label</th><th>URL</th><th>Parent</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($navigationRows as $navigation): ?><tr>
                <td><?= (int)$navigation['sort_order'] ?></td>
                <td><strong><?= e($navigation['label']) ?></strong><?php if (!empty($navigation['icon_class'])): ?><div class="muted"><?= e($navigation['icon_class']) ?></div><?php endif; ?></td>
                <td><code><?= e($navigation['url']) ?></code></td>
                <td><?= e((string)($navigation['parent_label'] ?? '—')) ?></td>
                <td><span class="status-badge <?= (int)$navigation['is_active'] === 1 ? 'status-active' : 'status-inactive' ?>"><?= (int)$navigation['is_active'] === 1 ? 'Active' : 'Hidden' ?></span></td>
                <td class="navigation-actions">
                    <a class="btn btn-sm btn-primary" href="<?= e($navigationBaseUrl . '?nav_id=' . (int)$navigation['id']) ?>">Edit</a>
                    <form method="post"><input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>"><input type="hidden" name="action" value="toggle_<?= e($navigationLocation) ?>_nav"><input type="hidden" name="nav_id" value="<?= (int)$navigation['id'] ?>"><button class="btn btn-sm btn-secondary" type="submit"><?= (int)$navigation['is_active'] === 1 ? 'Hide' : 'Show' ?></button></form>
                    <form method="post" onsubmit="return confirm('Delete this <?= e(strtolower($navigationLabel)) ?> link?');"><input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>"><input type="hidden" name="action" value="delete_<?= e($navigationLocation) ?>_nav"><input type="hidden" name="nav_id" value="<?= (int)$navigation['id'] ?>"><button class="btn btn-sm btn-danger" type="submit">Delete</button></form>
                </td>
            </tr><?php endforeach; ?>
            <?php if (!$navigationRows): ?><tr><td colspan="6">No <?= e(strtolower($navigationLabel)) ?> links exist yet.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
