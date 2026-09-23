<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
Auth::requirePermission('manage_navigation');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Method Not Allowed'); }
CSRF::check($_POST['_csrf'] ?? '');
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(404); exit('Navigation item not found.'); }
try {
    $row = NavigationManager::find((int)$id);
    NavigationManager::delete((int)$id);
    Auth::audit(Auth::id(), 'delete', 'navigation', (int)$id, 'Deleted navigation item.');
    Session::flash('success', 'Navigation item deleted.');
    header('Location: ' . adminUrl('navigation/?location=' . urlencode((string)($row['location'] ?? 'header'))));
    exit;
} catch (Throwable $e) {
    Session::flash('error', $e->getMessage());
    header('Location: ' . adminUrl('navigation/'));
    exit;
}
