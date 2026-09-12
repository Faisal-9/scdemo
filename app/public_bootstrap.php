<?php

declare(strict_types=1);

/*
 * Lightweight bootstrap for public pages.
 *
 * Deliberately does NOT start the /scadmin session.
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/core/ProjectFrontend.php';
require_once __DIR__ . '/core/ServiceFrontend.php';
require_once __DIR__ . '/core/SectorFrontend.php';
require_once __DIR__ . '/core/HomeFrontend.php';
require_once __DIR__ . '/core/AboutFrontend.php';
require_once __DIR__ . '/core/MediaFrontend.php';
require_once __DIR__ . '/core/LegalFrontend.php';
