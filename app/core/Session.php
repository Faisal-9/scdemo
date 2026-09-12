<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';


final class Session
{
    /*
    |--------------------------------------------------------------------------
    | Start session
    |--------------------------------------------------------------------------
    */

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }


        $isHttps = self::isHttps();


        /*
        |----------------------------------------------------------------------
        | Session cookie
        |----------------------------------------------------------------------
        |
        | The cookie needs to cover the CMS directory.
        |
        | Local:
        |   /publicV6/scadmin/
        |
        | Production:
        |   /scadmin/
        |
        */

        $sessionPath = baseUrl('/scadmin');


        session_name(SESSION_NAME);


        session_set_cookie_params([
            'lifetime' => 0,
            'path' => rtrim($sessionPath, '/') . '/',
            'secure' => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);


        /*
        |----------------------------------------------------------------------
        | PHP session security
        |----------------------------------------------------------------------
        */

        ini_set('session.use_only_cookies', '1');
        ini_set('session.use_strict_mode', '1');
        ini_set('session.cookie_httponly', '1');


        session_start();


        /*
        |----------------------------------------------------------------------
        | Initial session information
        |----------------------------------------------------------------------
        */

        if (!isset($_SESSION['_initialized_at'])) {

            $_SESSION['_initialized_at'] = time();

            $_SESSION['_last_activity'] = time();

            $_SESSION['_ua_hash'] = hash(
                'sha256',
                $_SERVER['HTTP_USER_AGENT'] ?? ''
            );
        }


        /*
        |----------------------------------------------------------------------
        | Security checks
        |----------------------------------------------------------------------
        */

        self::enforceTimeouts();

        self::enforceUserAgentBinding();
    }


    /*
    |--------------------------------------------------------------------------
    | Flash messages
    |--------------------------------------------------------------------------
    |
    | Flash messages are stored in the session temporarily.
    |
    | Example:
    |
    |   Session::flash('success', 'Updated successfully.');
    |
    | Then:
    |
    |   Session::getFlash('success');
    |
    | or:
    |
    |   Session::pullFlash();
    |
    */

    public static function flash(
        string $key,
        mixed $value
    ): void {
        self::start();


        if (
            !isset($_SESSION['_flash']) ||
            !is_array($_SESSION['_flash'])
        ) {
            $_SESSION['_flash'] = [];
        }


        $_SESSION['_flash'][$key] = $value;
    }


    /*
    |----------------------------------------------------------------------
    | Get one flash message
    |----------------------------------------------------------------------
    |
    | The message is removed after reading.
    |
    */

    public static function getFlash(
        string $key,
        mixed $default = null
    ): mixed {
        self::start();


        if (
            !isset($_SESSION['_flash']) ||
            !is_array($_SESSION['_flash']) ||
            !array_key_exists($key, $_SESSION['_flash'])
        ) {
            return $default;
        }


        $value = $_SESSION['_flash'][$key];


        unset($_SESSION['_flash'][$key]);


        if ($_SESSION['_flash'] === []) {
            unset($_SESSION['_flash']);
        }


        return $value;
    }


    /*
    |----------------------------------------------------------------------
    | Pull all flash messages
    |----------------------------------------------------------------------
    |
    | Returns all flash messages and removes them from the session.
    |
    */

    public static function pullFlash(): array
    {
        self::start();


        $messages = $_SESSION['_flash'] ?? [];


        if (!is_array($messages)) {
            $messages = [];
        }


        unset($_SESSION['_flash']);


        return $messages;
    }


    /*
    |--------------------------------------------------------------------------
    | Regenerate session ID
    |--------------------------------------------------------------------------
    */

    public static function regenerate(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            self::start();
        }


        session_regenerate_id(true);
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy session
    |--------------------------------------------------------------------------
    */

    public static function destroy(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return;
        }


        $_SESSION = [];


        $params = session_get_cookie_params();


        setcookie(
            session_name(),
            '',
            [
                'expires' => time() - 42000,
                'path' => $params['path'] ?? '/',
                'secure' => (bool) ($params['secure'] ?? false),
                'httponly' => (bool) ($params['httponly'] ?? true),
                'samesite' => $params['samesite'] ?? 'Lax',
            ]
        );


        session_destroy();
    }


    /*
    |--------------------------------------------------------------------------
    | Timeout enforcement
    |--------------------------------------------------------------------------
    */

    private static function enforceTimeouts(): void
    {
        $now = time();


        $lastActivity = (int) (
            $_SESSION['_last_activity'] ?? $now
        );


        $initializedAt = (int) (
            $_SESSION['_initialized_at'] ?? $now
        );


        /*
         * Idle timeout
         */

        if (
            ($now - $lastActivity) > SESSION_IDLE_TIMEOUT
        ) {

            self::destroy();

            self::start();

            return;
        }


        /*
         * Absolute session timeout
         */

        if (
            ($now - $initializedAt) > SESSION_ABSOLUTE_TIMEOUT
        ) {

            self::destroy();

            self::start();

            return;
        }


        $_SESSION['_last_activity'] = $now;
    }


    /*
    |--------------------------------------------------------------------------
    | User-agent binding
    |--------------------------------------------------------------------------
    */

    private static function enforceUserAgentBinding(): void
    {
        $current = hash(
            'sha256',
            $_SERVER['HTTP_USER_AGENT'] ?? ''
        );


        $stored = $_SESSION['_ua_hash'] ?? $current;


        if (!hash_equals((string) $stored, $current)) {

            self::destroy();

            self::start();

            return;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | HTTPS detection
    |--------------------------------------------------------------------------
    */

    private static function isHttps(): bool
    {
        if (
            !empty($_SERVER['HTTPS']) &&
            $_SERVER['HTTPS'] !== 'off'
        ) {
            return true;
        }


        return (int) (
            $_SERVER['SERVER_PORT'] ?? 0
        ) === 443;
    }
}
