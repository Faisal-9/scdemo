<?php

$successMessage = flash('success');
$errorMessage   = flash('error');
$warningMessage = flash('warning');
$infoMessage    = flash('info');

?>

<?php if ($successMessage !== null): ?>
    <div class="alert alert-success" role="status">
        <?= e((string) $successMessage) ?>
    </div>
<?php endif; ?>

<?php if ($errorMessage !== null): ?>
    <div class="alert alert-error" role="alert">
        <?= e((string) $errorMessage) ?>
    </div>
<?php endif; ?>

<?php if ($warningMessage !== null): ?>
    <div class="alert alert-warning" role="status">
        <?= e((string) $warningMessage) ?>
    </div>
<?php endif; ?>

<?php if ($infoMessage !== null): ?>
    <div class="alert alert-info" role="status">
        <?= e((string) $infoMessage) ?>
    </div>
<?php endif; ?>