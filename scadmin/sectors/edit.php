<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_sectors');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) redirect(adminUrl('sectors/'));
$sector = SectorManager::find((int)$id);
if ($sector === null) { flash('error','Sector not found.'); redirect(adminUrl('sectors/')); }
$errors=[];

if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);
    $sector = array_merge($sector, $_POST);
    try {
        SectorManager::update((int)$id, normalizeSectorPost($sector));
        Auth::audit(Auth::id(),'update','sector',(int)$id,'Updated sector: '.$sector['title']);
        flash('success','Sector updated successfully.');
        redirect(adminUrl('sectors/edit.php?id='.(int)$id));
    } catch (Throwable $e) {
        $errors[] = APP_DEBUG ? $e->getMessage() : 'The sector could not be updated.';
    }
}

$pageTitle='Edit Sector'; $activeNav='sectors';
require __DIR__ . '/../partials/header.php'; require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'Sectors','url'=>adminUrl('sectors/')],['label'=>'Edit Sector','url'=>null]]; require __DIR__ . '/../partials/breadcrumbs.php'; $heading='Edit Sector'; $description='Edit the database content while keeping the public sector template unchanged.'; $actionUrl=null; $actionLabel=null; require __DIR__ . '/../partials/page-heading.php'; ?>
<?php require __DIR__ . '/../partials/alerts.php'; ?>
<?php $submitLabel='Save Changes'; require __DIR__ . '/form.php'; ?>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
<?php
function normalizeSectorPost(array $sector): array
{
    $description = trim((string) ($sector['description'] ?? ''));
    $paragraphs = preg_split('/\R\s*\R/', $description, -1, PREG_SPLIT_NO_EMPTY);
    if (count($paragraphs) > 1) $sector['description'] = array_values(array_map('trim', $paragraphs));
    $sector['stats'] = array_values((array) ($sector['stats'] ?? []));
    $sector['why'] = array_values((array) ($sector['why'] ?? []));
    $sector['areas'] = array_values((array) ($sector['areas'] ?? []));
    $sector['sections'] = normalizeSections((array) ($sector['sections'] ?? []));
    return $sector;
}
function normalizeSections(array $sections): array
{
    foreach ($sections as &$section) {
        $section['image'] = preg_split('/\R/', trim((string) ($section['images_text'] ?? '')), -1, PREG_SPLIT_NO_EMPTY);
        $section['stats'] = [];
        foreach (preg_split('/\R/', trim((string) ($section['stats_text'] ?? '')), -1, PREG_SPLIT_NO_EMPTY) as $line) {
            [$value,$label] = array_pad(explode('|',$line,2),2,'');
            $section['stats'][]=['value'=>trim($value),'label'=>trim($label)];
        }
        unset($section['images_text'],$section['stats_text']);
    }
    unset($section);
    return array_values($sections);
}
