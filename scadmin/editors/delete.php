<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requireAdmin();

if (!isPost()) {
    redirect(adminUrl('editors/'));
}

CSRF::verify($_POST['csrf_token'] ?? null);

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    flash('error', 'Invalid editor account.');
    redirect(adminUrl('editors/'));
}

$editor = EditorManager::findEditor((int) $id);

if ($editor === null) {
    flash('error', 'Editor account not found.');
    redirect(adminUrl('editors/'));
}

try {
    EditorManager::deleteEditor((int) $id);

    Auth::audit(
        Auth::id(),
        'delete',
        'editor',
        (int) $id,
        'Deleted editor account: ' . $editor['username']
    );

    flash('success', 'Editor account deleted successfully.');
} catch (Throwable $e) {
    flash(
        'error',
        APP_DEBUG ? $e->getMessage() : 'The editor account could not be deleted.'
    );
}

redirect(adminUrl('editors/'));
