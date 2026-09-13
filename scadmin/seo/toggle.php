<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_seo');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Method Not Allowed'); }
try { CSRF::verify($_POST['_csrf'] ?? ''); SeoManager::toggle((int)($_POST['id'] ?? 0)); Session::flash('success','SEO status updated.'); }
catch (Throwable $e) { Session::flash('error',$e->getMessage()); }
redirect(adminUrl('seo/'));
