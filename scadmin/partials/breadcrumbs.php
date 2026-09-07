<?php
/** @var array<int, array{label:string,url:?string}> $breadcrumbs */
$breadcrumbs = $breadcrumbs ?? [];
?>

<?php if ($breadcrumbs !== []): ?>
    <nav class="breadcrumbs" aria-label="Breadcrumb">
        <?php foreach ($breadcrumbs as $index => $crumb): ?>
            <?php if ($index > 0): ?>
                <span class="breadcrumb-separator" aria-hidden="true">/</span>
            <?php endif; ?>

            <?php if (!empty($crumb['url'])): ?>
                <a href="<?= e($crumb['url']) ?>"><?= e($crumb['label']) ?></a>
            <?php else: ?>
                <span aria-current="page"><?= e($crumb['label']) ?></span>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>
