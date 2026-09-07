<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requireAdmin();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    redirect(adminUrl('editors/'));
}

$editor = EditorManager::findEditor((int) $id);
if ($editor === null) {
    flash('error', 'Editor account not found.');
    redirect(adminUrl('editors/'));
}

$permissions = EditorManager::allPermissions();
$selectedPermissions = EditorManager::permissionIdsForEditor((int) $id);
$error = flash('error');
$success = flash('success');

if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);

    $username = postString('username');
    $displayName = postString('display_name');
    $status = postString('status');
    $password = (string) ($_POST['password'] ?? '');
    $passwordConfirm = (string) ($_POST['password_confirm'] ?? '');
    $permissionIds = is_array($_POST['permissions'] ?? null)
        ? $_POST['permissions']
        : [];

    if ($password !== '' && $password !== $passwordConfirm) {
        $error = 'The new passwords do not match.';
    } else {
        try {
            EditorManager::updateEditor(
                (int) $id,
                $username,
                $displayName,
                $status,
                $permissionIds,
                $password !== '' ? $password : null
            );

            Auth::audit(
                Auth::id(),
                'update',
                'editor',
                (int) $id,
                'Updated editor account: ' . strtolower(trim($username))
            );

            flash('success', 'Editor account updated successfully.');
            redirect(adminUrl('editors/edit.php?id=' . (int) $id));
        } catch (Throwable $e) {
            $error = APP_DEBUG
                ? $e->getMessage()
                : 'The editor account could not be updated.';
        }
    }

    $editor['username'] = $username;
    $editor['display_name'] = $displayName;
    $editor['status'] = $status;
    $selectedPermissions = array_values(array_unique(array_map('intval', $permissionIds)));
}
?>

$pageTitle = 'Edit Editor';
$activeNav = 'editors';

require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>

<main class="admin-content">
    <?php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
        ['label' => 'Editors', 'url' => adminUrl('editors/')],
        ['label' => 'Edit Editor', 'url' => null],
    ];
    require __DIR__ . '/../partials/breadcrumbs.php';

    $heading = 'Edit Editor';
    $description = 'Manage credentials, status and authorized CMS areas.';
    $actionUrl = adminUrl('editors/');
    $actionLabel = 'Back';
    require __DIR__ . '/../partials/page-heading.php';
    ?>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>
    <?php if ($error !== null): ?>
        <div class="alert alert-error" role="alert"><?= e($error) ?></div>
    <?php endif; ?>

    <section class="form-card">
        <form method="post" action="" autocomplete="off">
            <?= CSRF::field() ?>

            <div class="form-grid">
                <div class="form-field">
                    <label for="username">Username</label>
                    <input id="username" name="username" type="text" maxlength="100" pattern="[A-Za-z0-9._-]+" value="<?= e($editor['username']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="display_name">Display name</label>
                    <input id="display_name" name="display_name" type="text" maxlength="150" value="<?= e($editor['display_name']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="active" <?= $editor['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $editor['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                    <small>Inactive editors cannot sign in.</small>
                </div>

                <div class="form-field">
                    <label for="password">New password</label>
                    <input id="password" name="password" type="password" minlength="<?= e((string) PASSWORD_MIN_LENGTH) ?>" autocomplete="new-password">
                    <small>Leave blank to keep the current password.</small>
                </div>

                <div class="form-field">
                    <label for="password_confirm">Confirm new password</label>
                    <input id="password_confirm" name="password_confirm" type="password" minlength="<?= e((string) PASSWORD_MIN_LENGTH) ?>" autocomplete="new-password">
                </div>
            </div>

            <div class="permission-box">
                <h2>Editor permissions</h2>
                <p class="muted">Changes apply immediately after saving.</p>
                <div class="permission-grid">
                    <?php foreach ($permissions as $permission): ?>
                        <?php $permissionId = (int) $permission['id']; ?>
                        <label class="permission-option">
                            <input type="checkbox" name="permissions[]" value="<?= e((string) $permissionId) ?>" <?= in_array($permissionId, $selectedPermissions, true) ? 'checked' : '' ?>>
                            <span>
                                <strong><?= e($permission['permission_name']) ?></strong>
                                <?php if (!empty($permission['description'])): ?>
                                    <small><?= e($permission['description']) ?></small>
                                <?php endif; ?>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-actions">
                <a class="button-link button-secondary" href="<?= e(adminUrl('editors/')) ?>">Cancel</a>
                <button type="submit" class="button-primary">Save Changes</button>
            </div>
        </form>
    </section>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
