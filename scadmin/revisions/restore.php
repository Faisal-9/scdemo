<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_revisions');
if (!isPost()) redirect(adminUrl('revisions/'));
CSRF::verify($_POST['csrf_token'] ?? null);

$revisionId = filter_var($_POST['revision_id'] ?? null, FILTER_VALIDATE_INT);
try {
    $revision = $revisionId ? RevisionManager::find((int)$revisionId) : null;
    if (!$revision || !in_array($revision['entity_type'], ['project', 'media', 'media_item', 'navigation', 'redirect', 'seo', 'setting'], true)) {
        throw new RuntimeException('This content type does not have a restore adapter yet.');
    }
    $snapshot = json_decode((string)$revision['snapshot_json'], true);
    if (!is_array($snapshot)) throw new RuntimeException('The selected revision is invalid.');
    $entityType = (string)$revision['entity_type'];
    $entityId = (int)$revision['entity_id'];
    switch ($entityType) {
        case 'project': ProjectManager::save($snapshot, $entityId); break;
        case 'media':
        case 'media_item': MediaManager::save($snapshot, $entityId); break;
        case 'navigation': NavigationManager::save($entityId, $snapshot); break;
        case 'redirect': RedirectManager::save($entityId, $snapshot); break;
        case 'seo': SeoManager::save($entityId, $snapshot); break;
        case 'setting': SiteSettingsManager::save($entityId, (string)($snapshot['setting_value'] ?? '')); break;
    }
    RevisionManager::record($entityType, $entityId, $snapshot, 'draft', 'Restored revision #' . (int)$revision['id']);
    Auth::audit(Auth::id(), 'restore', $entityType, $entityId, 'Restored ' . $entityType . ' revision #' . (int)$revision['id']);
    flash('success', 'Revision restored as a new draft version.');
} catch (Throwable $e) {
    flash('error', APP_DEBUG ? $e->getMessage() : 'The revision could not be restored.');
}
redirect(adminUrl('revisions/'));
