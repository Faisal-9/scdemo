<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_sectors');
if (!isPost()) redirect(adminUrl('sectors/'));
CSRF::verify($_POST['csrf_token'] ?? null);
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
$active = ($_POST['active'] ?? '0') === '1';
if (!$id) { flash('error','Invalid sector.'); redirect(adminUrl('sectors/')); }
try { SectorManager::toggle((int)$id,$active); Auth::audit(Auth::id(),$active?'enable':'disable','sector',(int)$id,$active?'Enabled sector':'Disabled sector'); flash('success',$active?'Sector enabled.':'Sector disabled.'); }
catch(Throwable $e) { flash('error',APP_DEBUG ? $e->getMessage() : 'The sector status could not be changed.'); }
redirect(adminUrl('sectors/'));
