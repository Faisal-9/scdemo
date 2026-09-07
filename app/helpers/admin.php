<?php

declare(strict_types=1);

function adminHasAccess(?string $permission = null): bool
{
    if (!Auth::check()) {
        return false;
    }

    if ($permission === null || Auth::isAdmin()) {
        return true;
    }

    return Auth::hasPermission($permission);
}

function adminFlash(string $key): ?string
{
    return flash($key);
}

function adminOld(string $key, mixed $default = ''): mixed
{
    return $_POST[$key] ?? $default;
}

function adminCurrentPage(): string
{
    return basename((string) ($_SERVER['PHP_SELF'] ?? ''));
}

function adminActive(string $key, string $activeNav = ''): string
{
    return $key === $activeNav ? 'active' : '';
}
