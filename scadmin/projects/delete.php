<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requirePermission('manage_projects');

if (!isPost()) {
    redirect(adminUrl('projects/'));
}

CSRF::verify($_POST['csrf_token'] ?? null);

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    flash('error', 'Invalid project.');
    redirect(adminUrl('projects/'));
}

$project = ProjectManager::find((int) $id);

if ($project === null) {
    flash('error', 'Project not found.');
    redirect(adminUrl('projects/'));
}

try {
    ProjectManager::delete((int) $id);

    Auth::audit(
        Auth::id(),
        'delete',
        'project',
        (int) $id,
        'Deleted project: ' . $project['name']
    );

    flash('success', 'Project deleted successfully.');
} catch (Throwable $e) {
    flash('error', APP_DEBUG ? $e->getMessage() : 'The project could not be deleted.');
}

redirect(adminUrl('projects/'));
