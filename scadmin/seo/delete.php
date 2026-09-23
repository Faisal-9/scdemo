<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_seo');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Method Not Allowed'); }
try { CSRF::verify($_POST['_csrf'] ?? ''); $id = (int)($_POST['id'] ?? 0); SeoManager::delete($id); Auth::audit(Auth::id(), 'delete', 'seo', $id, 'Deleted SEO record.'); Session::flash('success','SEO record deleted.'); }
catch (Throwable $e) { Session::flash('error',$e->getMessage()); }
redirect(adminUrl('seo/'));
