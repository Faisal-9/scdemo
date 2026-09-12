<?php

declare(strict_types=1);
require_once __DIR__ . '/app/public_bootstrap.php';
require_once __DIR__ . '/app/core/ContactMessageManager.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}
try {
    ContactMessageManager::create($_POST);
    header('Location: contact.php?sent=1');
    exit;
} catch (Throwable $e) {
    error_log('StateCorps contact submission failed: ' . $e->getMessage());
    header('Location: contact.php?sent=0');
    exit;
}
