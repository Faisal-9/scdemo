<?php
/** @var string $heading */
/** @var string|null $description */
/** @var string|null $actionUrl */
/** @var string|null $actionLabel */
$heading = $heading ?? '';
$description = $description ?? null;
$actionUrl = $actionUrl ?? null;
$actionLabel = $actionLabel ?? null;
?>

<div class="page-heading-row">
    <div>
        <h1><?= e($heading) ?></h1>
        <?php if ($description !== null && $description !== ''): ?>
            <p class="muted"><?= e($description) ?></p>
        <?php endif; ?>
    </div>

    <?php if ($actionUrl !== null && $actionLabel !== null): ?>
        <a class="button-link" href="<?= e($actionUrl) ?>">
            <?= e($actionLabel) ?>
        </a>
    <?php endif; ?>
</div>
