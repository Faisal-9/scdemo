<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requirePermission('manage_projects');

$perPage = 20;
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
$page = $page && $page > 0 ? $page : 1;

$search = trim((string) ($_GET['q'] ?? ''));
$sector = trim((string) ($_GET['sector'] ?? ''));
$status = trim((string) ($_GET['status'] ?? ''));

$total = ProjectManager::count($search, $sector, $status);
$totalPages = max(1, (int) ceil($total / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$projects = ProjectManager::all($search, $sector, $status, $perPage, $offset);
$sectors = ProjectManager::sectors();
$statuses = ProjectManager::statuses();

$pageTitle = 'Projects';
$activeNav = 'projects';

require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>

<main class="admin-content">
    <?php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
        ['label' => 'Projects', 'url' => null],
    ];
    require __DIR__ . '/../partials/breadcrumbs.php';

    $heading = 'Projects';
    $description = 'Manage project content without changing the existing public design.';
    $actionUrl = adminUrl('projects/create.php');
    $actionLabel = '+ Add Project';
    require __DIR__ . '/../partials/page-heading.php';
    ?>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <section class="content-panel project-filter-panel">
        <form method="get" class="filter-form">
            <div class="filter-field filter-search">
                <label for="q">Search</label>
                <input id="q" name="q" type="search" value="<?= e($search) ?>" placeholder="Project, client, location or category">
            </div>

            <div class="filter-field">
                <label for="sector">Sector</label>
                <select id="sector" name="sector">
                    <option value="">All sectors</option>
                    <?php foreach ($sectors as $item): ?>
                        <option value="<?= e((string) $item) ?>" <?= $sector === $item ? 'selected' : '' ?>><?= e((string) $item) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-field">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">All statuses</option>
                    <?php foreach ($statuses as $item): ?>
                        <option value="<?= e((string) $item) ?>" <?= $status === $item ? 'selected' : '' ?>><?= e((string) $item) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="filter-submit">Filter</button>
                <a class="button-link button-secondary" href="<?= e(adminUrl('projects/')) ?>">Reset</a>
            </div>
        </form>
    </section>

    <section class="table-card">
        <div class="table-toolbar">
            <span><?= e((string) $total) ?> project<?= $total === 1 ? '' : 's' ?></span>
            <span class="muted">Page <?= e((string) $page) ?> of <?= e((string) $totalPages) ?></span>
        </div>

        <div class="table-wrap">
            <table class="admin-table project-table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Sector</th>
                        <th>Status</th>
                        <th>Year</th>
                        <th>Published</th>
                        <th>Home</th>
                        <th>Order</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($projects === []): ?>
                        <tr>
                            <td colspan="8" class="empty-state">No projects matched your filters.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td>
                                    <strong><?= e($project['name']) ?></strong>
                                    <small class="table-secondary-line">
                                        ID: <?= e((string) ($project['legacy_id'] ?? $project['id'])) ?>
                                    </small>
                                </td>
                                <td><?= e((string) ($project['sector_name'] ?? '—')) ?></td>
                                <td><?= e((string) ($project['status'] ?? '—')) ?></td>
                                <td><?= e((string) ($project['completion_year'] ?? '—')) ?></td>
                                <td>
                                    <span class="status-badge <?= (int) $project['published'] === 1 ? 'status-active' : 'status-inactive' ?>">
                                        <?= (int) $project['published'] === 1 ? 'Yes' : 'No' ?>
                                    </span>
                                </td>
                                <td><?= (int) $project['show_on_home'] === 1 ? 'Yes' : 'No' ?></td>
                                <td><?= e((string) $project['sort_order']) ?></td>
                                <td class="actions-cell">
                                    <a class="small-button" href="<?= e(adminUrl('projects/edit.php?id=' . (int) $project['id'])) ?>">Edit</a>

                                    <form method="post" action="<?= e(adminUrl('projects/toggle.php')) ?>" class="inline-form">
                                        <?= CSRF::field() ?>
                                        <input type="hidden" name="id" value="<?= e((string) $project['id']) ?>">
                                        <input type="hidden" name="published" value="<?= (int) $project['published'] === 1 ? '0' : '1' ?>">
                                        <button type="submit" class="small-button">
                                            <?= (int) $project['published'] === 1 ? 'Unpublish' : 'Publish' ?>
                                        </button>
                                    </form>

                                    <form method="post" action="<?= e(adminUrl('projects/delete.php')) ?>" class="inline-form" onsubmit="return confirm('Delete this project and its gallery/scope data? This cannot be undone.');">
                                        <?= CSRF::field() ?>
                                        <input type="hidden" name="id" value="<?= e((string) $project['id']) ?>">
                                        <button type="submit" class="small-button small-button-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="pagination" aria-label="Projects pagination">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <?php
                    $query = [
                        'page' => $p,
                        'q' => $search,
                        'sector' => $sector,
                        'status' => $status,
                    ];
                    $query = array_filter($query, static fn($value) => $value !== '');
                    $url = adminUrl('projects/') . '?' . http_build_query($query);
                    ?>
                    <a class="pagination-link <?= $p === $page ? 'active' : '' ?>" href="<?= e($url) ?>"><?= e((string) $p) ?></a>
                <?php endfor; ?>
            </nav>
        <?php endif; ?>
    </section>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>