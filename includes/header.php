<?php
require_once __DIR__ . '/../app/public_bootstrap.php';

$current_page = basename($_SERVER['PHP_SELF']);
$services_pages = ['services.php'];
$sectors_pages  = ['sectors.php'];
$media_pages    = ['media.php', 'news.php', 'events.php', 'gallery.php'];

$aboutSections = [];
foreach (AboutManager::sections() as $section) {
    if ((int)($section['is_active'] ?? 1) !== 1) {
        continue;
    }
    $aboutSections[] = [
        'id' => (string)($section['legacy_id'] ?? $section['id']),
        'data' => ['title' => (string)$section['title']],
    ];
}
$services = ServiceFrontend::all();
$sectors = SectorFrontend::all();
$projects = ProjectFrontend::all();
$opportunitiesLabel = (string)SiteSettings::get('header_opportunities_label', '');
$contactLabel = (string)SiteSettings::get('header_contact_label', '');
$siteLogo = (string)SiteSettings::get('site_logo', '');
$navLabels = [
    'home' => (string)SiteSettings::get('nav_home_label', ''),
    'about' => (string)SiteSettings::get('nav_about_label', ''),
    'services' => (string)SiteSettings::get('nav_services_label', ''),
    'expertise' => (string)SiteSettings::get('nav_expertise_label', ''),
    'projects' => (string)SiteSettings::get('nav_projects_label', ''),
    'media' => (string)SiteSettings::get('nav_media_label', ''),
];
$socialLinks = [
    ['url' => (string)SiteSettings::get('social_facebook_url', ''), 'icon' => 'fa-facebook'],
    ['url' => (string)SiteSettings::get('social_x_url', ''), 'icon' => 'fa-x-twitter'],
    ['url' => (string)SiteSettings::get('social_linkedin_url', ''), 'icon' => 'fa-linkedin-in'],
];
?>

<header class="header">
    <div class="header-inner">

        <!-- <div class="container"> -->
        <div class="main-navigation">

            <!-- FLOATING LOGO -->
            <div class="floating-logo">
                <a href="index.php" class="logo">
                    <img src="<?= e(baseUrl($siteLogo)) ?>" alt="<?= e((string)SiteSettings::get('site_name', '')) ?>" class="logo-img">
                </a>
            </div>

            <!-- MOBILE MENU BUTTON -->
            <div class="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="nav-rows">

                <!-- ================= TOP ROW ================= -->
                <div class="nav-row nav-row-top">
                    <div class="container">
                        <div class="nav-row-inner">

                            <nav class="nav-menu nav-menu-top">
                                <ul class="nav-list nav-list-top">

                                    <li class="nav-item-top <?php echo ($current_page == 'opportunities.php') ? 'active' : '' ?>">
                                        <a href="opportunities.php"
                                            class="nav-link-top <?php echo ($current_page == 'opportunities.php') ? 'active' : '' ?>">
                                            <?php echo e($opportunitiesLabel); ?>
                                        </a>
                                    </li>

                                    <li class="nav-item-top <?php echo ($current_page == 'contact.php') ? 'active' : '' ?>">
                                        <a href="contact.php"
                                            class="nav-link-top <?php echo ($current_page == 'contact.php') ? 'active' : '' ?>">
                                            <?php echo e($contactLabel); ?>
                                        </a>
                                    </li>

                                </ul>
                            </nav>

                            <div class="top-row-social">
                                <span class="social-divider"></span>

                                <?php foreach ($socialLinks as $social): ?>
                                    <?php if ($social['url'] === '') continue; ?>
                                    <a href="<?php echo e($social['url']); ?>" class="social-link-header" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands <?php echo e($social['icon']); ?>"></i>
                                    </a>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ================= BOTTOM ROW ================= -->
                <div class="nav-row nav-row-bottom">
                    <div class="container">
                        <div class="nav-row-inner">

                            <nav class="nav-menu nav-menu-bottom">
                                <ul class="nav-list nav-list-bottom">

                                    <!-- HOME -->
                                    <li class="nav-item <?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : '' ?>">
                                        <a href="index.php" class="nav-link">
                                            <span class="nav-text"><?= e($navLabels['home']) ?></span>
                                        </a>
                                    </li>

                                    <!-- ABOUT -->
                                    <li class="nav-item dropdown <?php echo ($current_page == 'about.php') ? 'active' : '' ?>">
                                        <a href="about.php" class="nav-link has-dropdown">
                                            <span class="nav-text"><?= e($navLabels['about']) ?></span>
                                            <span class="dropdown-arrow">▼</span>
                                        </a>

                                        <div class="dropdown-menu">
                                            <ul class="dropdown-list">
                                                <?php foreach ($aboutSections as $section): ?>
                                                    <li>
                                                        <a href="about.php#<?php echo $section['id']; ?>" class="dropdown-link">
                                                            <?php echo htmlspecialchars($section['data']['title']); ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>

                                    <!-- SERVICES -->
                                    <li class="nav-item dropdown <?php echo in_array($current_page, $services_pages) ? 'active' : '' ?>">
                                        <a href="services.php" class="nav-link has-dropdown">
                                            <span class="nav-text"><?= e($navLabels['services']) ?></span>
                                            <span class="dropdown-arrow">▼</span>
                                        </a>

                                        <div class="dropdown-menu mega-menu">
                                            <div class="mega-menu-content">
                                                <?php foreach ($services as $serviceKey => $service): ?>
                                                    <?php if (!isset($service['title'])) continue; ?>
                                                    <div class="mega-column">
                                                        <h4 class="mega-title">
                                                            <a href="services.php?tab=<?php echo urlencode($serviceKey) ?>" class="mega-title-link">
                                                                <?php echo htmlspecialchars($service['title']) ?>
                                                            </a>
                                                        </h4>

                                                        <ul class="dropdown-list">
                                                            <?php foreach ((isset($service['sub_services']) ? $service['sub_services'] : []) as $sub): ?>
                                                                <li>
                                                                    <a href="services.php?tab=<?php echo urlencode($serviceKey) ?>#<?php echo htmlspecialchars($serviceKey . '-' . $sub['id']) ?>" class="dropdown-link">
                                                                        <?php echo htmlspecialchars($sub['title']) ?>
                                                                    </a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- EXPERTISE -->
                                    <li class="nav-item dropdown <?php echo in_array($current_page, $sectors_pages) ? 'active' : '' ?>">
                                        <a href="sectors.php" class="nav-link has-dropdown">
                                            <span class="nav-text"><?= e($navLabels['expertise']) ?></span>
                                            <span class="dropdown-arrow">▼</span>
                                        </a>

                                        <div class="dropdown-menu">
                                            <ul class="dropdown-list">
                                                <?php foreach ($sectors as $sectorKey => $sector): ?>
                                                    <li>
                                                        <a href="sectors.php?tab=<?php echo $sectorKey ?>" class="dropdown-link">
                                                            <?php echo htmlspecialchars($sector['title']); ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>

                                    <!-- PROJECTS -->
                                    <li class="nav-item dropdown <?php echo ($current_page == 'projects.php') ? 'active' : '' ?>">
                                        <a href="projects.php" class="nav-link has-dropdown">
                                            <span class="nav-text"><?= e($navLabels['projects']) ?></span>
                                            <span class="dropdown-arrow">▼</span>
                                        </a>

                                        <div class="dropdown-menu">
                                            <ul class="dropdown-list">
                                                <li>
                                                    <a href="projects.php" class="dropdown-link">All Projects</a>
                                                </li>
                                                <?php
                                                // Get unique sectors from projects
                                                $projectSectors = array_unique(array_column($projects, 'sector'));
                                                foreach ($projectSectors as $sectorName): ?>
                                                    <li>
                                                        <a href="projects.php?sector=<?php echo urlencode($sectorName) ?>" class="dropdown-link">
                                                            <?php echo htmlspecialchars(ucfirst($sectorName)) ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>

                                    <!-- MEDIA -->
                                    <li class="nav-item dropdown <?php echo in_array($current_page, $media_pages) ? 'active' : '' ?>">
                                        <a href="media.php" class="nav-link has-dropdown">
                                            <span class="nav-text"><?= e($navLabels['media']) ?></span>
                                            <span class="dropdown-arrow">▼</span>
                                        </a>

                                        <div class="dropdown-menu">
                                            <ul class="dropdown-list">
                                                <li>
                                                    <a href="media.php?tab=news" class="dropdown-link">News</a>
                                                </li>
                                                <li>
                                                    <a href="media.php?tab=events" class="dropdown-link">Events</a>
                                                </li>
                                                <li>
                                                    <a href="media.php?tab=gallery" class="dropdown-link">Gallery</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</header>