<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requirePermission('manage_projects');

$error = null;
$sectors = ProjectManager::sectors();

if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);

    try {
        $projectId = ProjectManager::save($_POST);

        Auth::audit(
            Auth::id(),
            'create',
            'project',
            $projectId,
            'Created project: ' . trim((string) ($_POST['name'] ?? ''))
        );

        flash('success', 'Project created successfully.');
        redirect(adminUrl('projects/edit.php?id=' . $projectId));
    } catch (Throwable $e) {
        $error = APP_DEBUG ? $e->getMessage() : 'The project could not be created.';
    }
}

$pageTitle = 'Create Project';
$activeNav = 'projects';

require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>

<main class="admin-content">
    <?php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
        ['label' => 'Projects', 'url' => adminUrl('projects/')],
        ['label' => 'Create Project', 'url' => null],
    ];
    require __DIR__ . '/../partials/breadcrumbs.php';

    $heading = 'Create Project';
    $description = 'Create a new project record. The public design remains unchanged.';
    $actionUrl = adminUrl('projects/');
    $actionLabel = 'Back';
    require __DIR__ . '/../partials/page-heading.php';
    ?>

    <?php if ($error !== null): ?>
        <div class="alert alert-error" role="alert"><?= e($error) ?></div>
    <?php endif; ?>

    <?php require __DIR__ . '/form.php'; ?>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
