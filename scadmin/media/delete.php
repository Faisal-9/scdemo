<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_media');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: '.adminUrl('media/')); exit; }
try { CSRF::verify($_POST['csrf_token'] ?? ''); MediaManager::delete((int)($_POST['id']??0)); Session::flash('success','Media item deleted.'); } catch(Throwable $e) { Session::flash('error',$e->getMessage()); }
header('Location: '.adminUrl('media/')); exit;
