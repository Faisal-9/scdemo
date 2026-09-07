<?php

declare(strict_types=1);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Session.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/CSRF.php';
require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/helpers/admin.php';
require_once __DIR__ . '/core/Auth.php';
require_once __DIR__ . '/core/EditorManager.php';

Session::start();
