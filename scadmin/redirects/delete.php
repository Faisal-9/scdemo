<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_redirects');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
try { CSRF::verify($_POST['_csrf'] ?? ''); $id = (int)($_POST['id'] ?? 0); RedirectManager::delete($id); Auth::audit(Auth::id(), 'delete', 'redirect', $id, 'Deleted redirect.'); } catch (Throwable $e) { $_SESSION['flash_error'] = $e->getMessage(); }
header('Location: ' . adminUrl('redirects/index.php')); exit;
