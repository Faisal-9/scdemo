<?php

declare(strict_types=1);

if (!function_exists('mediaPickerField')) {
  function mediaPickerField(string $name, string|int|null $value = '', array $options = []): void
  {
    $id = preg_replace('/[^A-Za-z0-9_-]/', '_', $name) . '_' . bin2hex(random_bytes(3));
    $type = (($options['type'] ?? 'image') === 'document') ? 'document' : 'image';
    $label = (string)($options['label'] ?? ucfirst(str_replace('_', ' ', $name)));
    $required = !empty($options['required']) ? ' required' : '';
    $assetId = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $preview = $assetId ? AssetResolver::path($assetId) : '';
?>
    <div class="media-picker-field" data-media-picker data-media-picker-type="<?= e($type) ?>">
      <label><?= e($label) ?></label>
      <div class="media-picker-row">
        <input type="hidden" id="<?= e($id) ?>" name="<?= e($name) ?>" value="<?= e($assetId ? (string)$assetId : '') ?>" data-media-picker-input<?= $required ?> autocomplete="off">
        <button type="button" class="btn btn-secondary" data-media-picker-open>Choose</button>
      </div>
      <div class="media-picker-current" data-media-picker-current>
        <?php if ($preview && $type === 'image'): ?><img src="<?= e(function_exists('baseUrl') ? baseUrl($preview) : $preview) ?>" alt="" loading="lazy"><?php endif; ?>
        <span data-media-picker-current-name><?= e($preview ?: 'No asset selected') ?></span>
      </div>
    </div>
<?php
  }
}
