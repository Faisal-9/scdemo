<?php

declare(strict_types=1);

final class CSRF
{
    private const SESSION_KEY = '_csrf_token';

    public static function token(): string
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::SESSION_KEY];
    }

    public static function field(): string
    {
        $token = htmlspecialchars(
            self::token(),
            ENT_QUOTES,
            'UTF-8'
        );

        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    public static function verify(?string $token): void
    {
        $stored = $_SESSION[self::SESSION_KEY] ?? '';

        if (
            !is_string($token) ||
            $stored === '' ||
            !hash_equals($stored, $token)
        ) {
            http_response_code(419);
            exit('Invalid security token. Please reload the page and try again.');
        }
    }
}
