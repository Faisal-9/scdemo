<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requirePermission('manage_projects');

if (!isPost()) {
    redirect(adminUrl('projects/'));
}

CSRF::verify($_POST['csrf_token'] ?? null);

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$published = filter_input(INPUT_POST, 'published', FILTER_VALIDATE_INT);

if (!$id || !in_array($published, [0, 1], true)) {
    flash('error', 'Invalid project status change.');
    redirect(adminUrl('projects/'));
}

$project = ProjectManager::find((int) $id);
if ($project === null) {
    flash('error', 'Project not found.');
    redirect(adminUrl('projects/'));
}

try {
    ProjectManager::setPublished((int) $id, (bool) $published);

    Auth::audit(
        Auth::id(),
        $published === 1 ? 'publish' : 'unpublish',
        'project',
        (int) $id,
        ($published === 1 ? 'Published: ' : 'Unpublished: ') . $project['name']
    );

    flash('success', $published === 1 ? 'Project published.' : 'Project unpublished.');
} catch (Throwable $e) {
    flash('error', APP_DEBUG ? $e->getMessage() : 'The project status could not be changed.');
}

redirect(adminUrl('projects/'));
