<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requireAdmin();

if (EditorManager::editorCount() >= 3) {
    flash('error', 'The maximum of 3 editor accounts has already been reached.');
    redirect(adminUrl('editors/'));
}

$permissions = EditorManager::allPermissions();
$error = null;

if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);

    $username = postString('username');
    $displayName = postString('display_name');
    $password = (string) ($_POST['password'] ?? '');
    $passwordConfirm = (string) ($_POST['password_confirm'] ?? '');
    $permissionIds = is_array($_POST['permissions'] ?? null)
        ? $_POST['permissions']
        : [];

    if ($password !== $passwordConfirm) {
        $error = 'The passwords do not match.';
    } else {
        try {
            $editorId = EditorManager::createEditor(
                $username,
                $displayName,
                $password,
                $permissionIds
            );

            Auth::audit(
                Auth::id(),
                'create',
                'editor',
                $editorId,
                'Created editor account: ' . strtolower(trim($username))
            );

            flash('success', 'Editor account created successfully.');
            redirect(adminUrl('editors/edit.php?id=' . $editorId));
        } catch (Throwable $e) {
            $error = APP_DEBUG
                ? $e->getMessage()
                : 'The editor account could not be created. Please check the entered information.';
        }
    }
}
?>

$pageTitle = 'Create Editor';
$activeNav = 'editors';

require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>

<main class="admin-content">
    <?php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
        ['label' => 'Editors', 'url' => adminUrl('editors/')],
        ['label' => 'Create Editor', 'url' => null],
    ];
    require __DIR__ . '/../partials/breadcrumbs.php';

    $heading = 'Create Editor';
    $description = 'You can create up to 3 editor accounts.';
    $actionUrl = adminUrl('editors/');
    $actionLabel = 'Back';
    require __DIR__ . '/../partials/page-heading.php';
    ?>

    <?php if ($error !== null): ?>
        <div class="alert alert-error" role="alert"><?= e($error) ?></div>
    <?php endif; ?>

    <section class="form-card">
        <form method="post" action="" autocomplete="off">
            <?= CSRF::field() ?>

            <div class="form-grid">
                <div class="form-field">
                    <label for="username">Username</label>
                    <input id="username" name="username" type="text" maxlength="100" pattern="[A-Za-z0-9._-]+" value="<?= e($_POST['username'] ?? '') ?>" required>
                    <small>3–100 characters. Letters, numbers, dots, underscores and hyphens.</small>
                </div>

                <div class="form-field">
                    <label for="display_name">Display name</label>
                    <input id="display_name" name="display_name" type="text" maxlength="150" value="<?= e($_POST['display_name'] ?? '') ?>" required>
                </div>

                <div class="form-field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" minlength="<?= e((string) PASSWORD_MIN_LENGTH) ?>" autocomplete="new-password" required>
                    <small>Minimum <?= e((string) PASSWORD_MIN_LENGTH) ?> characters.</small>
                </div>

                <div class="form-field">
                    <label for="password_confirm">Confirm password</label>
                    <input id="password_confirm" name="password_confirm" type="password" minlength="<?= e((string) PASSWORD_MIN_LENGTH) ?>" autocomplete="new-password" required>
                </div>
            </div>

            <div class="permission-box">
                <h2>Editor permissions</h2>
                <p class="muted">Choose which CMS areas this editor can access.</p>
                <div class="permission-grid">
                    <?php $postedPermissions = array_map('intval', (array) ($_POST['permissions'] ?? [])); ?>
                    <?php foreach ($permissions as $permission): ?>
                        <?php $permissionId = (int) $permission['id']; ?>
                        <label class="permission-option">
                            <input type="checkbox" name="permissions[]" value="<?= e((string) $permissionId) ?>" <?= in_array($permissionId, $postedPermissions, true) ? 'checked' : '' ?>>
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
                <button type="submit" class="button-primary">Create Editor</button>
            </div>
        </form>
    </section>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
