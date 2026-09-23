<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| State Corps CMS configuration
|--------------------------------------------------------------------------
|
| Local XAMPP:
|   C:\xampp\htdocs\scdemo\
|
| Public website:
|   http://localhost/scdemo/
|
| CMS:
|   http://localhost/scdemo/scadmin/
|
| Production later:
|   https://statecorps.com/
|
*/


const APP_NAME = 'State Corps CMS';


/*
|--------------------------------------------------------------------------
| Application URL
|--------------------------------------------------------------------------
|
| Because scdemo is directly inside htdocs, the base URL is:
|
|   /scdemo
|
| On production, when the project is served from the web root:
|
|   ''
|
*/

const BASE_URL = '/scdemo';


/*
|--------------------------------------------------------------------------
| CMS path
|--------------------------------------------------------------------------
*/

const ADMIN_PATH = '/scadmin';


/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

function configEnv(string $name, string $fallback): string
{
    $value = getenv($name);
    return $value === false ? $fallback : $value;
}

define('DB_HOST', configEnv('SC_DB_HOST', 'localhost'));
define('DB_NAME', configEnv('SC_DB_NAME', 'statecorps_db'));
define('DB_USER', configEnv('SC_DB_USER', 'root'));
define('DB_PASS', configEnv('SC_DB_PASS', ''));
define('DB_CHARSET', configEnv('SC_DB_CHARSET', 'utf8mb4'));


/*
|--------------------------------------------------------------------------
| Session
|--------------------------------------------------------------------------
*/

const SESSION_NAME = 'scadmin_session';

const SESSION_IDLE_TIMEOUT = 1800;      // 30 minutes
const SESSION_ABSOLUTE_TIMEOUT = 28800; // 8 hours


/*
|--------------------------------------------------------------------------
| Login protection
|--------------------------------------------------------------------------
*/

const LOGIN_MAX_ATTEMPTS = 20;
const LOGIN_WINDOW_SECONDS = 900; // 15 minutes


/*
|--------------------------------------------------------------------------
| Password policy
|--------------------------------------------------------------------------
*/

const PASSWORD_MIN_LENGTH = 12;


/*
|--------------------------------------------------------------------------
| Development / production
|--------------------------------------------------------------------------
|
| XAMPP:
|   true
|
| cPanel:
|   false
|
*/

define(
    'APP_DEBUG',
    filter_var(configEnv('SC_APP_DEBUG', 'true'), FILTER_VALIDATE_BOOLEAN)
);

define('ASSET_VERSION', configEnv('SC_ASSET_VERSION', '1.0.9'));
define('ANALYTICS_HASH_SALT', configEnv('SC_ANALYTICS_HASH_SALT', 'state-corps-local-analytics'));


/*
|--------------------------------------------------------------------------
| URL helpers
|--------------------------------------------------------------------------
*/

function baseUrl(string $path = ''): string
{
    $base = rtrim(BASE_URL, '/');
    $path = '/' . ltrim($path, '/');

    if ($path === '/') {
        return $base === ''
            ? '/'
            : $base . '/';
    }

    return $base . $path;
}


function adminUrl(string $path = ''): string
{
    $admin = trim(ADMIN_PATH, '/');
    $path = trim($path, '/');

    if ($path === '') {
        return baseUrl($admin);
    }

    return baseUrl($admin . '/' . $path);
}
