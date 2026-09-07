<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requirePermission('manage_projects');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    flash('error', 'Invalid project.');
    redirect(adminUrl('projects/'));
}

$project = ProjectManager::find((int) $id);
if ($project === null) {
    flash('error', 'Project not found.');
    redirect(adminUrl('projects/'));
}

$error = null;
$sectors = ProjectManager::sectors();
$success = flash('success');

if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);

    try {
        ProjectManager::save($_POST, (int) $id);

        Auth::audit(
            Auth::id(),
            'update',
            'project',
            (int) $id,
            'Updated project: ' . trim((string) ($_POST['name'] ?? ''))
        );

        flash('success', 'Project updated successfully.');
        redirect(adminUrl('projects/edit.php?id=' . (int) $id));
    } catch (Throwable $e) {
        $error = APP_DEBUG ? $e->getMessage() : 'The project could not be updated.';

        $project = array_merge($project, [
            'legacy_id' => $_POST['legacy_id'] ?? null,
            'name' => $_POST['name'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'sector_name' => $_POST['sector_name'] ?? null,
            'category' => $_POST['category'] ?? null,
            'status' => $_POST['status'] ?? null,
            'completion_year' => $_POST['completion_year'] ?? null,
            'location' => $_POST['location'] ?? null,
            'client' => $_POST['client'] ?? null,
            'description' => $_POST['description'] ?? null,
            'show_on_home' => !empty($_POST['show_on_home']) ? 1 : 0,
            'show_in_category_image' => !empty($_POST['show_in_category_image']) ? 1 : 0,
            'thumbnail_path' => $_POST['thumbnail_path'] ?? null,
            'published' => !empty($_POST['published']) ? 1 : 0,
            'sort_order' => $_POST['sort_order'] ?? $project['sort_order'],
            'images' => array_map(
                static fn($path) => ['image_path' => (string) $path, 'alt_text' => '', 'caption' => ''],
                is_array($_POST['images'] ?? null) ? $_POST['images'] : []
            ),
            'scope' => array_map(
                static fn($item) => ['scope_text' => (string) $item],
                is_array($_POST['scope'] ?? null) ? $_POST['scope'] : []
            ),
        ]);
    }
}

$pageTitle = 'Edit Project';
$activeNav = 'projects';

require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>

<main class="admin-content">
    <?php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
        ['label' => 'Projects', 'url' => adminUrl('projects/')],
        ['label' => 'Edit Project', 'url' => null],
    ];
    require __DIR__ . '/../partials/breadcrumbs.php';

    $heading = 'Edit Project';
    $description = 'Update the content used by the existing project template.';
    $actionUrl = adminUrl('projects/');
    $actionLabel = 'Back';
    require __DIR__ . '/../partials/page-heading.php';
    ?>

    <?php if ($success !== null): ?>
        <div class="alert alert-success" role="status"><?= e($success) ?></div>
    <?php endif; ?>

    <?php if ($error !== null): ?>
        <div class="alert alert-error" role="alert"><?= e($error) ?></div>
    <?php endif; ?>

    <?php require __DIR__ . '/form.php'; ?>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
