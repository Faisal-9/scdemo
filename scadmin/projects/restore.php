<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requireAnyPermission(['edit_projects', 'manage_projects']);
if (!isPost()) redirect(adminUrl('projects/'));
CSRF::verify($_POST['csrf_token'] ?? null);
$revisionId = filter_var($_POST['revision_id'] ?? null, FILTER_VALIDATE_INT);
try {
    $revision = $revisionId ? RevisionManager::find((int)$revisionId) : null;
    if (!$revision || $revision['entity_type'] !== 'project') throw new RuntimeException('Project revision not found.');
    $snapshot = json_decode((string)$revision['snapshot_json'], true);
    if (!is_array($snapshot)) throw new RuntimeException('Project revision is invalid.');
    ProjectManager::save($snapshot, (int)$revision['entity_id']);
    RevisionManager::record('project', (int)$revision['entity_id'], $snapshot, 'draft', 'Restored revision #' . (int)$revision['id']);
    Auth::audit(Auth::id(), 'restore', 'project', (int)$revision['entity_id'], 'Restored project revision #' . (int)$revision['id']);
    flash('success', 'Project revision restored as a new draft version.');
    redirect(adminUrl('projects/edit.php?id=' . (int)$revision['entity_id']));
} catch (Throwable $e) {
    flash('error', APP_DEBUG ? $e->getMessage() : 'The project revision could not be restored.');
    redirect(adminUrl('projects/'));
}