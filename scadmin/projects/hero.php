<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requirePermission('manage_projects');

$rows = SiteSettingsManager::rowsForSection('projects');
$settings = [];
foreach ($rows as $row) {
    $settings[(string)$row['setting_key']] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRF::check($_POST['_csrf'] ?? '');
    try {
    $action = (string)($_POST['action'] ?? 'save');
    if ($action === 'add_stat') {
      $statIndexes = [];
      foreach (array_keys($settings) as $key) {
        if (preg_match('/^projects_hero_stat_(\d+)_(?:count|label)$/', $key, $matches)) {
          $statIndexes[] = (int)$matches[1];
        }
      }
      $nextIndex = $statIndexes === [] ? 1 : max($statIndexes) + 1;
      SiteSettingsManager::addProjectsHeroStat($nextIndex);
      Auth::audit(Auth::id(), 'create', 'projects_hero_stat', $nextIndex, 'Added Projects hero statistic.');
      Session::flash('success', 'Projects hero statistic added.');
    } elseif ($action === 'delete_stat') {
      $statIndex = filter_var($_POST['stat_index'] ?? null, FILTER_VALIDATE_INT);
      if (!$statIndex) {
        throw new InvalidArgumentException('Invalid statistic selected.');
      }
      SiteSettingsManager::deleteProjectsHeroStat((int)$statIndex);
      Auth::audit(Auth::id(), 'delete', 'projects_hero_stat', (int)$statIndex, 'Deleted Projects hero statistic.');
      Session::flash('success', 'Projects hero statistic deleted.');
    } else {
      SiteSettingsManager::saveManyForSection('projects', $_POST['setting'] ?? []);
      Auth::audit(Auth::id(), 'update', 'projects_hero', null, 'Updated Projects page hero.');
      Session::flash('success', 'Projects hero updated successfully.');
    }
    } catch (Throwable $e) {
        Session::flash('error', $e->getMessage());
    }
    redirect(adminUrl('projects/hero.php'));
}

$pageTitle = 'Projects Hero';
$heading = $pageTitle;
$description = 'Manage the hero image, messaging, and statistics shown on the public Projects page.';
$activeNav = 'projects-hero';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main management-page">
  <?php
  $breadcrumbs = [
      ['label' => 'Dashboard', 'url' => adminUrl('dashboard.php')],
      ['label' => 'Projects', 'url' => adminUrl('projects/')],
      ['label' => 'Hero', 'url' => null],
  ];
  require __DIR__ . '/../partials/breadcrumbs.php';
  require __DIR__ . '/../partials/alerts.php';
  require __DIR__ . '/../partials/page-heading.php';
  ?>
  <div class="admin-card settings-form-card">
    <form method="post">
      <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">

      <?php if (isset($settings['projects_hero_background'])): ?>
        <?php $row = $settings['projects_hero_background']; ?>
        <div class="form-group">
          <?php mediaPickerField('setting[' . (int)$row['id'] . ']', (string)$row['setting_value'], ['label' => 'Hero Background']); ?>
          <?php if (!empty($row['description'])): ?><div class="muted"><?= e($row['description']) ?></div><?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if (isset($settings['projects_hero_title'])): ?>
        <?php $row = $settings['projects_hero_title']; ?>
        <div class="form-group">
          <label for="projects-hero-title">Hero Title</label>
          <textarea id="projects-hero-title" name="setting[<?= (int)$row['id'] ?>]" class="form-control" rows="3"><?= e((string)$row['setting_value']) ?></textarea>
          <div class="muted">Supports the existing inline HTML used to emphasize part of the title.</div>
        </div>
      <?php endif; ?>

      <?php if (isset($settings['projects_hero_subtitle'])): ?>
        <?php $row = $settings['projects_hero_subtitle']; ?>
        <div class="form-group">
          <label for="projects-hero-subtitle">Hero Subtitle</label>
          <textarea id="projects-hero-subtitle" name="setting[<?= (int)$row['id'] ?>]" class="form-control" rows="4"><?= e((string)$row['setting_value']) ?></textarea>
          <?php if (!empty($row['description'])): ?><div class="muted"><?= e($row['description']) ?></div><?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="management-toolbar">
        <div>
          <h2>Hero Statistics</h2>
          <p class="muted">Add, edit, or remove the statistic cards shown below the hero.</p>
        </div>
        <button class="btn btn-secondary" type="submit" name="action" value="add_stat">Add Statistic</button>
      </div>
      <div class="projects-hero-stats-admin">
        <?php
        $statIndexes = [];
        foreach (array_keys($settings) as $key) {
            if (preg_match('/^projects_hero_stat_(\d+)_(?:count|label)$/', $key, $matches)) {
                $statIndexes[(int)$matches[1]] = true;
            }
        }
        ksort($statIndexes);
        ?>
        <?php foreach (array_keys($statIndexes) as $statIndex): ?>
          <?php $countKey = 'projects_hero_stat_' . $statIndex . '_count'; $labelKey = 'projects_hero_stat_' . $statIndex . '_label'; ?>
          <?php if (!isset($settings[$countKey], $settings[$labelKey])): continue; endif; ?>
          <fieldset class="content-panel">
            <legend>Statistic <?= (int)$statIndex ?></legend>
            <div class="form-group">
              <label for="<?= e($countKey) ?>">Value</label>
              <input id="<?= e($countKey) ?>" type="text" name="setting[<?= (int)$settings[$countKey]['id'] ?>]" class="form-control" value="<?= e((string)$settings[$countKey]['setting_value']) ?>">
            </div>
            <div class="form-group">
              <label for="<?= e($labelKey) ?>">Label</label>
              <input id="<?= e($labelKey) ?>" type="text" name="setting[<?= (int)$settings[$labelKey]['id'] ?>]" class="form-control" value="<?= e((string)$settings[$labelKey]['setting_value']) ?>">
            </div>
            <button class="btn btn-danger btn-sm" type="submit" name="action" value="delete_stat" onclick="this.form.elements['stat_index'].value='<?= (int)$statIndex ?>'; return confirm('Delete this hero statistic?');">Delete Statistic</button>
          </fieldset>
        <?php endforeach; ?>
      </div>

      <div class="admin-actions">
        <input type="hidden" name="stat_index" value="">
        <button class="btn btn-primary" type="submit">Save Projects Hero</button>
        <a class="btn btn-secondary" href="<?= e(adminUrl('projects/')) ?>">Back to Projects</a>
      </div>
    </form>
  </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
