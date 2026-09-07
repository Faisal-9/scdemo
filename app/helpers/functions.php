<?php

declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars(
        (string) ($value ?? ''),
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

function redirect(string $url): never
{
    header('Location: ' . $url, true, 302);
    exit;
}

function postString(string $key): string
{
    return trim((string) ($_POST[$key] ?? ''));
}

function isPost(): bool
{
    return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }

    $value = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);

    return is_string($value) ? $value : null;
}

function clientIp(): string
{
    /* Do not trust X-Forwarded-For unless you explicitly configure a trusted proxy. */
    return substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
}
