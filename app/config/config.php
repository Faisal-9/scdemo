<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| State Corps CMS configuration
|--------------------------------------------------------------------------
|
| Local XAMPP:
|   C:\xampp\htdocs\publicV6\
|
| Public website:
|   http://localhost/publicV6/
|
| CMS:
|   http://localhost/publicV6/scadmin/
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
| Because publicV6 is directly inside htdocs, the base URL is:
|
|   /publicV6
|
| On production, when publicV6 itself becomes public_html:
|
|   ''
|
*/

const BASE_URL = '/publicV6';


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

const DB_HOST = 'localhost';
const DB_NAME = 'statecorps_db';
const DB_USER = 'root';
const DB_PASS = '';
const DB_CHARSET = 'utf8mb4';


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

const APP_DEBUG = true;


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