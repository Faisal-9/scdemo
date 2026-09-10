<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_sectors');
if (!isPost()) redirect(adminUrl('sectors/'));
CSRF::verify($_POST['csrf_token'] ?? null);
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if (!$id) { flash('error','Invalid sector.'); redirect(adminUrl('sectors/')); }
$sector = SectorManager::find((int)$id);
if ($sector === null) { flash('error','Sector not found.'); redirect(adminUrl('sectors/')); }
try { SectorManager::delete((int)$id); Auth::audit(Auth::id(),'delete','sector',(int)$id,'Deleted sector: '.$sector['title']); flash('success','Sector deleted successfully.'); }
catch(Throwable $e) { flash('error', APP_DEBUG ? $e->getMessage() : 'The sector could not be deleted.'); }
redirect(adminUrl('sectors/'));
