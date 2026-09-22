<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/AboutManager.php';
Auth::requirePermission('manage_about');

$section = trim((string)($_GET['section'] ?? ''));
$allowed = ['overview', 'mission', 'hse', 'profile'];
if (!in_array($section, $allowed, true)) {
    redirect(adminUrl('about/'));
}

$record = null;
$timelineRows = [];
if ($section === 'overview') {
    $record = AboutManager::generalInfo();
    $timelineRows = AboutManager::timeline();
    $title = 'Overview';
    $save = [AboutManager::class, 'saveGeneralInfo'];
} elseif ($section === 'mission') {
    $record = AboutManager::missionVision();
    $title = 'Mission, Vision & Core Values';
    $save = [AboutManager::class, 'saveMissionVision'];
} elseif ($section === 'hse') {
    $record = AboutManager::hse();
    $title = 'HSE';
    $save = [AboutManager::class, 'saveHse'];
} else {
    $record = AboutManager::companyProfile();
    $title = 'Company Profile';
    $save = [AboutManager::class, 'saveCompanyProfile'];
}

$error = null;
if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);
    try {
        call_user_func($save, $_POST);
        Auth::audit(Auth::id(), 'update', 'about_' . $section, null, 'Updated About ' . $title);
        flash('success', $title . ' saved.');
        redirect(adminUrl('about/content.php?section=' . $section));
    } catch (Throwable $e) {
        $error = APP_DEBUG ? $e->getMessage() : 'The About content could not be saved.';
        $record = array_merge((array)$record, $_POST);
    }
}

$pageTitle = $title;
$activeNav = 'about';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
    <?php $breadcrumbs = [['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')], ['label' => 'About', 'url' => adminUrl('about/')], ['label' => $title, 'url' => null]];
    require __DIR__ . '/../partials/breadcrumbs.php';
    $heading = $title;
    $description = 'Edit the current content only; the public About markup remains unchanged.';
    $actionUrl = adminUrl('about/');
    $actionLabel = 'Back';
    require __DIR__ . '/../partials/page-heading.php';
    require __DIR__ . '/../partials/alerts.php';
    if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>

    <section class="form-card">
        <form method="post"><?= CSRF::field() ?>
            <?php if ($section === 'overview'): ?>
                <div class="form-grid">
                    <div class="form-field form-field-wide"><label>Title</label><input name="title" value="<?= e($record['title'] ?? '') ?>" required></div>
                    <div class="form-field form-field-wide"><label>Overview content</label><textarea name="content" rows="8" required><?= e($record['content'] ?? '') ?></textarea></div>
                </div>
                <section class="content-panel">
                    <div class="panel-heading">
                        <div>
                            <h2>Growth Timeline</h2>
                            <p class="muted">Manage the milestones shown below the overview text.</p>
                        </div>
                        <a class="button-link" href="<?= e(adminUrl('about/items.php?type=timeline&edit=1')) ?>">+ Add milestone</a>
                    </div>
                    <div class="table-wrap">
                        <table class="admin-table">
                            <thead><tr><th>Order</th><th>Year</th><th>Title</th><th>Image</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                <?php foreach ($timelineRows as $row): ?><tr>
                                    <td><?= e((string)$row['sort_order']) ?></td>
                                    <td><?= e((string)$row['year']) ?></td>
                                    <td><?= e((string)$row['title']) ?></td>
                                    <td><?= e((string)($row['image_path'] ?? '')) ?></td>
                                    <td><span class="status-badge status-<?= $row['is_active'] ? 'active' : 'inactive' ?>"><?= $row['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                                    <td><a class="small-button" href="<?= e(adminUrl('about/items.php?type=timeline&edit=1&id=' . (int)$row['id'])) ?>">Edit</a></td>
                                </tr><?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            <?php elseif ($section === 'mission'): ?>
                <div class="form-grid">
                    <div class="form-field form-field-wide"><label>Section title</label><input name="title" value="<?= e($record['title'] ?? '') ?>" required></div>
                    <div class="form-field form-field-wide"><label>Mission</label><textarea name="mission" rows="6" required><?= e($record['mission'] ?? '') ?></textarea></div>
                    <div class="form-field form-field-wide"><?php mediaPickerField('mission_asset_id', (string) ($record['mission_asset_id'] ?? ''), ['label' => 'Mission image', 'required' => true]); ?></div>
                    <div class="form-field form-field-wide"><label>Vision</label><textarea name="vision" rows="6" required><?= e($record['vision'] ?? '') ?></textarea></div>
                    <div class="form-field form-field-wide"><?php mediaPickerField('vision_asset_id', (string) ($record['vision_asset_id'] ?? ''), ['label' => 'Vision image', 'required' => true]); ?></div>
                    <div class="form-field form-field-wide"><?php mediaPickerField('core_values_asset_id', (string) ($record['core_values_asset_id'] ?? ''), ['label' => 'Core values image', 'required' => true]); ?></div>
                </div>
                <p class="form-note">Core values are managed as individual records.</p>
                <p><a class="button-link button-secondary" href="<?= e(adminUrl('about/items.php?type=values')) ?>">Manage Core Values</a></p>
            <?php elseif ($section === 'hse'): ?>
                <div class="form-grid">
                    <div class="form-field form-field-wide"><label>Title</label><input name="title" value="<?= e($record['title'] ?? '') ?>" required></div>
                    <div class="form-field form-field-wide"><label>Content</label><textarea name="content" rows="8" required><?= e($record['content'] ?? '') ?></textarea></div>
                </div>
            <?php else: ?>
                <div class="form-grid">
                    <div class="form-field form-field-wide"><label>Title</label><input name="title" value="<?= e($record['title'] ?? '') ?>" required></div>
                    <div class="form-field form-field-wide"><label>Content</label><textarea name="content" rows="8" required><?= e($record['content'] ?? '') ?></textarea></div>
                    <div class="form-field form-field-wide"><?php mediaPickerField('profile_asset_id', (string) ($record['profile_asset_id'] ?? ''), ['label' => 'Company profile file', 'type' => 'document', 'required' => true]); ?></div>
                </div>
            <?php endif; ?>
            <div class="form-actions"><a class="button-link button-secondary" href="<?= e(adminUrl('about/')) ?>">Cancel</a><button class="button-primary" type="submit">Save</button></div>
        </form>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>