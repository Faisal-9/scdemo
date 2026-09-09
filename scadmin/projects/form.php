<?php

$project = $project ?? [
    'legacy_id' => '',
    'name' => '',
    'slug' => '',
    'sector_name' => '',
    'category' => '',
    'status' => '',
    'completion_year' => '',
    'location' => '',
    'client' => '',
    'description' => '',
    'show_on_home' => 0,
    'show_in_category_image' => 0,
    'thumbnail_path' => '',
    'published' => 1,
    'sort_order' => 0,
    'images' => [],
    'scope' => [],
];

$imageRows = $project['images'] ?? [];
$scopeRows = $project['scope'] ?? [];
?>

<section class="form-card">
    <form method="post" action="" class="project-form" autocomplete="off">
        <?= CSRF::field() ?>

        <div class="form-section">
            <div class="form-section-heading">
                <h2>Basic information</h2>
                <p class="muted">These fields map directly to the current project data model.</p>
            </div>

            <div class="form-grid">
                <div class="form-field form-field-wide">
                    <label for="name">Project name *</label>
                    <input id="name" name="name" type="text" maxlength="500" value="<?= e($project['name']) ?>" required>
                </div>

                <div class="form-field">
                    <label for="legacy_id">Current project ID</label>
                    <input id="legacy_id" name="legacy_id" type="text" maxlength="50" value="<?= e((string) $project['legacy_id']) ?>">
                    <small>Keep the existing ID when editing migrated projects.</small>
                </div>

                <div class="form-field">
                    <label for="slug">Slug *</label>
                    <input id="slug" name="slug" type="text" maxlength="500" value="<?= e($project['slug']) ?>" required>
                    <small>Changing a migrated slug can affect the public URL after frontend database integration.</small>
                </div>

                <div class="form-field">
                    <label for="sector_name">Sector</label>
                    <input id="sector_name" name="sector_name" list="sector-options" type="text" maxlength="255" value="<?= e((string) $project['sector_name']) ?>">
                    <datalist id="sector-options">
                        <?php foreach ($sectors as $sector): ?>
                            <option value="<?= e((string) $sector) ?>">
                            <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-field">
                    <label for="category">Category</label>
                    <input id="category" name="category" type="text" maxlength="255" value="<?= e((string) $project['category']) ?>">
                </div>

                <div class="form-field">
                    <label for="status">Status</label>
                    <input id="status" name="status" type="text" maxlength="100" value="<?= e((string) $project['status']) ?>">
                </div>

                <div class="form-field">
                    <label for="completion_year">Completion year</label>
                    <input id="completion_year" name="completion_year" type="text" inputmode="numeric" maxlength="4" pattern="[0-9]{4}" value="<?= e((string) $project['completion_year']) ?>">
                </div>

                <div class="form-field">
                    <label for="location">Location</label>
                    <input id="location" name="location" type="text" maxlength="255" value="<?= e((string) $project['location']) ?>">
                </div>

                <div class="form-field">
                    <label for="client">Client</label>
                    <input id="client" name="client" type="text" maxlength="255" value="<?= e((string) $project['client']) ?>">
                </div>

                <div class="form-field form-field-wide">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="10"><?= e((string) $project['description']) ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-heading">
                <h2>Images</h2>
                <p class="muted">Use paths already present under the publicV6 assets directory. Upload/media-library integration comes in a later phase.</p>
            </div>

            <div class="form-field">
                <label for="thumbnail_path">Thumbnail path</label>
                <input id="thumbnail_path" name="thumbnail_path" type="text" maxlength="500" value="<?= e((string) $project['thumbnail_path']) ?>" placeholder="assets/images/projects/01-logar-gardiz-1.jpg">
            </div>

            <div class="repeatable-header">
                <div>
                    <h3>Gallery images</h3>
                    <p class="muted">One path per row. Existing gallery paths are preserved.</p>
                </div>
                <button type="button" class="secondary-button" data-add-row="imageRows">+ Add image</button>
            </div>

            <div id="imageRows" class="repeatable-list">
                <?php if ($imageRows === []): ?>
                    <div class="repeatable-row">
                        <input type="text" name="images[]" value="" placeholder="assets/images/projects/example.jpg">
                        <button type="button" class="remove-row" data-remove-row>Remove</button>
                    </div>
                <?php else: ?>
                    <?php foreach ($imageRows as $image): ?>
                        <div class="repeatable-row">
                            <input type="text" name="images[]" value="<?= e((string) ($image['image_path'] ?? '')) ?>" placeholder="assets/images/projects/example.jpg">
                            <button type="button" class="remove-row" data-remove-row>Remove</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <template id="imageRowsTemplate">
                <div class="repeatable-row">
                    <input type="text" name="images[]" value="" placeholder="assets/images/projects/example.jpg">
                    <button type="button" class="remove-row" data-remove-row>Remove</button>
                </div>
            </template>
        </div>

        <div class="form-section">
            <div class="repeatable-header">
                <div>
                    <h2>Project scope</h2>
                    <p class="muted">Each row becomes one existing scope item.</p>
                </div>
                <button type="button" class="secondary-button" data-add-row="scopeRows">+ Add scope item</button>
            </div>

            <div id="scopeRows" class="repeatable-list">
                <?php if ($scopeRows === []): ?>
                    <div class="repeatable-row repeatable-row-scope">
                        <input type="text" name="scope[]" value="" placeholder="Scope item">
                        <button type="button" class="remove-row" data-remove-row>Remove</button>
                    </div>
                <?php else: ?>
                    <?php foreach ($scopeRows as $scope): ?>
                        <div class="repeatable-row repeatable-row-scope">
                            <input type="text" name="scope[]" value="<?= e((string) ($scope['scope_text'] ?? '')) ?>" placeholder="Scope item">
                            <button type="button" class="remove-row" data-remove-row>Remove</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <template id="scopeRowsTemplate">
                <div class="repeatable-row repeatable-row-scope">
                    <input type="text" name="scope[]" value="" placeholder="Scope item">
                    <button type="button" class="remove-row" data-remove-row>Remove</button>
                </div>
            </template>
        </div>

        <div class="form-section">
            <div class="form-section-heading">
                <h2>Visibility and ordering</h2>
            </div>

            <div class="check-grid">
                <label class="check-option">
                    <input type="checkbox" name="published" value="1" <?= !empty($project['published']) ? 'checked' : '' ?>>
                    <span><strong>Published</strong><small>Controls whether the project will be available to the public after frontend integration.</small></span>
                </label>

                <label class="check-option">
                    <input type="checkbox" name="show_on_home" value="1" <?= !empty($project['show_on_home']) ? 'checked' : '' ?>>
                    <span><strong>Show on homepage</strong><small>Preserves the existing homepage-project flag.</small></span>
                </label>

                <label class="check-option">
                    <input type="checkbox" name="show_in_category_image" value="1" <?= !empty($project['show_in_category_image']) ? 'checked' : '' ?>>
                    <span><strong>Show in category image</strong><small>Preserves the existing category-image flag.</small></span>
                </label>

                <div class="form-field">
                    <label for="sort_order">Sort order</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" step="1" value="<?= e((string) $project['sort_order']) ?>">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a class="button-link button-secondary" href="<?= e(adminUrl('projects/')) ?>">Cancel</a>
            <button type="submit" class="button-primary">Save Project</button>
        </div>
    </form>
</section>