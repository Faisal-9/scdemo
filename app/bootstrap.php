<?php

declare(strict_types=1);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Session.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/SiteGlobals.php';
require_once __DIR__ . '/core/CSRF.php';
require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/helpers/admin.php';
require_once __DIR__ . '/core/Auth.php';
require_once __DIR__ . '/core/SiteSettings.php';
require_once __DIR__ . '/core/SiteSettingsManager.php';
require_once __DIR__ . '/core/EditorManager.php';
require_once __DIR__ . '/core/ProjectManager.php';
require_once __DIR__ . '/core/ServiceManager.php';
require_once __DIR__ . '/core/SectorManager.php';
require_once __DIR__ . '/core/HomeManager.php';
require_once __DIR__ . '/core/AboutManager.php';
require_once __DIR__ . '/core/MediaManager.php';
require_once __DIR__ . '/core/LegalManager.php';
require_once __DIR__ . '/core/ContactMessageManager.php';
require_once __DIR__ . '/core/Navigation.php';
require_once __DIR__ . '/core/NavigationManager.php';
require_once __DIR__ . '/core/Seo.php';
require_once __DIR__ . '/core/SeoManager.php';
require_once __DIR__ . '/core/Redirect.php';
require_once __DIR__ . '/core/RedirectManager.php';
require_once __DIR__ . '/core/AssetManager.php';
require_once __DIR__ . '/core/ActivityLogManager.php';

Session::start();
