<?php

declare(strict_types=1);
require_once __DIR__ . '/app/public_bootstrap.php';
require_once __DIR__ . '/app/core/ContactMessageManager.php';
require_once __DIR__ . '/app/core/NotificationManager.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}
try {
    $messageId = ContactMessageManager::create($_POST);
    try {
        NotificationManager::notifyAdmins('New contact message', 'A new contact form submission needs review.', 'info', 'scadmin/messages/view.php?id=' . $messageId, 'contact_message', $messageId);
    } catch (Throwable $notificationError) {
        error_log('StateCorps notification creation failed: ' . $notificationError->getMessage());
    }
    header('Location: contact.php?sent=1');
    exit;
} catch (Throwable $e) {
    error_log('StateCorps contact submission failed: ' . $e->getMessage());
    header('Location: contact.php?sent=0');
    exit;
}
