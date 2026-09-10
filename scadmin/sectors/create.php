<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_sectors');

$sector = [
    'sector_key' => '', 'title' => '', 'description' => '', 'sort_order' => count(SectorManager::all()), 'is_active' => 1,
    'hero_tag' => '', 'hero_headline' => '', 'hero_subtitle' => '', 'hero_cta_text' => '', 'hero_cta_link' => '', 'hero_image' => '',
    'featured_project_name' => '', 'featured_project_image' => '', 'featured_project_cta_text' => '', 'featured_project_cta_link' => '',
    'stats' => [], 'why' => [], 'areas' => [], 'sections' => [],
];
$errors=[];

if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);
    $sector = array_merge($sector, $_POST);
    try {
        $id = SectorManager::create(normalizeSectorPost($sector));
        Auth::audit(Auth::id(), 'create', 'sector', $id, 'Created sector: ' . $sector['title']);
        flash('success', 'Sector created successfully.');
        redirect(adminUrl('sectors/edit.php?id=' . $id));
    } catch (Throwable $e) {
        $errors[] = APP_DEBUG ? $e->getMessage() : 'The sector could not be created.';
    }
}

$pageTitle='Create Sector'; $activeNav='sectors';
require __DIR__ . '/../partials/header.php'; require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-content">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'Sectors','url'=>adminUrl('sectors/')],['label'=>'Create Sector','url'=>null]]; require __DIR__ . '/../partials/breadcrumbs.php'; $heading='Create Sector'; $description='Add a new sector using the existing public template structure.'; $actionUrl=null; $actionLabel=null; require __DIR__ . '/../partials/page-heading.php'; ?>
<?php $submitLabel='Create Sector'; require __DIR__ . '/form.php'; ?>
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
