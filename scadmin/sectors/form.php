<?php

/** @var array $sector */
/** @var array $errors */
/** @var string $submitLabel */
?>
<?php if ($errors !== []): ?>
  <div class="alert alert-error" role="alert">
    <?php foreach ($errors as $error): ?><div><?= e($error) ?></div><?php endforeach; ?>
  </div>
<?php endif; ?>
<form method="post" action="" class="sector-form" autocomplete="off">
  <?= CSRF::field() ?>
  <div class="form-card">
    <h2>Basic information</h2>
    <div class="form-grid">
      <div class="form-field"><label for="sector_key">Sector key</label><input id="sector_key" name="sector_key" maxlength="100" value="<?= e($sector['sector_key'] ?? '') ?>" required><small>Keep existing keys unchanged after migration unless you intentionally change public URL/filter identifiers.</small></div>
      <div class="form-field"><label for="title">Title</label><input id="title" name="title" maxlength="255" value="<?= e($sector['title'] ?? '') ?>" required></div>
      <div class="form-field"><label for="sort_order">Sort order</label><input id="sort_order" name="sort_order" type="number" min="0" value="<?= e((string) ($sector['sort_order'] ?? 0)) ?>"></div>
      <div class="form-field"><label for="is_active">Status</label><select id="is_active" name="is_active">
          <option value="1" <?= !empty($sector['is_active']) ? 'selected' : '' ?>>Active</option>
          <option value="0" <?= empty($sector['is_active']) ? 'selected' : '' ?>>Inactive</option>
        </select></div>
    </div>
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="8"><?= e(is_array($sector['description'] ?? null) ? implode("\n\n", $sector['description']) : ($sector['description'] ?? '')) ?></textarea>
    <small class="form-note">For multi-paragraph content, separate paragraphs with a blank line. The migration adapter preserves the existing Mining description array.</small>
  </div>

  <div class="form-card">
    <h2>Hero</h2>
    <div class="form-grid">
      <div class="form-field"><label>Tag</label><input name="hero_tag" value="<?= e($sector['hero_tag'] ?? '') ?>"></div>
      <div class="form-field"><label>Headline</label><input name="hero_headline" value="<?= e($sector['hero_headline'] ?? '') ?>"></div>
      <div class="form-field"><label>Subtitle</label><input name="hero_subtitle" value="<?= e($sector['hero_subtitle'] ?? '') ?>"></div>
      <div class="form-field"><label>CTA text</label><input name="hero_cta_text" value="<?= e($sector['hero_cta_text'] ?? '') ?>"></div>
      <div class="form-field"><label>CTA link</label><input name="hero_cta_link" value="<?= e($sector['hero_cta_link'] ?? '') ?>"></div>
      <div class="form-field form-field-wide"><?php mediaPickerField('hero_asset_id', (string) ($sector['hero_asset_id'] ?? ''), ['label' => 'Hero image']); ?></div>
    </div>
  </div>

  <div class="form-card">
    <h2>Featured project</h2>
    <div class="form-grid">
      <div class="form-field"><label>Name</label><input name="featured_project_name" value="<?= e($sector['featured_project_name'] ?? '') ?>"></div>
      <div class="form-field form-field-wide"><?php mediaPickerField('featured_project_asset_id', (string) ($sector['featured_project_asset_id'] ?? ''), ['label' => 'Featured project image']); ?></div>
      <div class="form-field"><label>CTA text</label><input name="featured_project_cta_text" value="<?= e($sector['featured_project_cta_text'] ?? '') ?>"></div>
      <div class="form-field"><label>CTA link</label><input name="featured_project_cta_link" value="<?= e($sector['featured_project_cta_link'] ?? '') ?>"></div>
    </div>
  </div>

  <div class="form-card">
    <h2>Statistics</h2>
    <div id="sector-stats-list">
      <?php foreach (($sector['stats'] ?? []) as $index => $stat): ?><div class="repeat-row"><input name="stats[<?= $index ?>][value]" value="<?= e($stat['value_text'] ?? $stat['value'] ?? '') ?>" placeholder="Value"><input name="stats[<?= $index ?>][label]" value="<?= e($stat['label'] ?? '') ?>" placeholder="Label"><button type="button" class="small-button small-button-danger remove-row">Remove</button></div><?php endforeach; ?>
    </div><button type="button" class="small-button" data-add-template="stat">+ Add statistic</button>
  </div>

  <div class="form-card">
    <h2>Why State Corps</h2>
    <div id="sector-why-list">
      <?php foreach (($sector['why'] ?? []) as $index => $text): ?><div class="repeat-row single"><input name="why[<?= $index ?>]" value="<?= e(is_array($text) ? '' : $text) ?>" placeholder="Why item"><button type="button" class="small-button small-button-danger remove-row">Remove</button></div><?php endforeach; ?>
    </div><button type="button" class="small-button" data-add-template="why">+ Add reason</button>
  </div>

  <div class="form-card">
    <h2>Areas</h2>
    <div id="sector-areas-list">
      <?php foreach (($sector['areas'] ?? []) as $index => $text): ?><div class="repeat-row single"><input name="areas[<?= $index ?>]" value="<?= e($text) ?>" placeholder="Area"><button type="button" class="small-button small-button-danger remove-row">Remove</button></div><?php endforeach; ?>
    </div><button type="button" class="small-button" data-add-template="area">+ Add area</button>
  </div>

  <div class="form-actions"><a class="button-link button-secondary" href="<?= e(adminUrl('sectors/')) ?>">Cancel</a><button type="submit"><?= e($submitLabel) ?></button></div>
</form>
<script>
  (function() {
    let counters = {
      stat: <?= count($sector['stats'] ?? []) ?>,
      why: <?= count($sector['why'] ?? []) ?>,
      area: <?= count($sector['areas'] ?? []) ?>
    };
    const configs = {
      stat: {
        list: 'sector-stats-list',
        html: function(i) {
          return '<div class="repeat-row"><input name="stats[' + i + '][value]" placeholder="Value"><input name="stats[' + i + '][label]" placeholder="Label"><button type="button" class="small-button small-button-danger remove-row">Remove</button></div>';
        }
      },
      why: {
        list: 'sector-why-list',
        html: function(i) {
          return '<div class="repeat-row single"><input name="why[' + i + ']" placeholder="Why item"><button type="button" class="small-button small-button-danger remove-row">Remove</button></div>';
        }
      },
      area: {
        list: 'sector-areas-list',
        html: function(i) {
          return '<div class="repeat-row single"><input name="areas[' + i + ']" placeholder="Area"><button type="button" class="small-button small-button-danger remove-row">Remove</button></div>';
        }
      }
    };
    document.querySelectorAll('[data-add-template]').forEach(function(btn) {
      btn.addEventListener('click', function() {
        const key = btn.dataset.addTemplate;
        const c = configs[key];
        document.getElementById(c.list).insertAdjacentHTML('beforeend', c.html(counters[key]++));
      });
    });
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('remove-row')) e.target.closest('.repeat-row').remove();
    });
  })();
</script>