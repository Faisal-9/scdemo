<?php
$current_page = basename($_SERVER['PHP_SELF']);
$services_pages = ['services.php'];
$sectors_pages  = ['sectors.php'];
$media_pages    = ['media.php', 'news.php', 'events.php', 'gallery.php'];

include_once("includes/data/aboutdata.php");
include_once("includes/data/servicesdata.php");
include_once("includes/data/sectorsdata.php");
include_once("includes/data/projectsdata.php");
?>

<header class="header">
    <div class="header-inner">

        <!-- <div class="container"> -->
        <div class="main-navigation">

            <!-- FLOATING LOGO -->
            <div class="floating-logo">
                <a href="index.php" class="logo">
                    <img src="assets/images/logo.png" alt="Logo" class="logo-img">
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
                                            Opportunities
                                        </a>
                                    </li>

                                    <li class="nav-item-top <?php echo ($current_page == 'contact.php') ? 'active' : '' ?>">
                                        <a href="contact.php"
                                            class="nav-link-top <?php echo ($current_page == 'contact.php') ? 'active' : '' ?>">
                                            Contact Us
                                        </a>
                                    </li>

                                </ul>
                            </nav>

                            <div class="top-row-social">
                                <span class="social-divider"></span>

                                <a href="https://www.facebook.com/StateCorpsInc/" class="social-link-header" target="_blank">
                                    <i class="fa-brands fa-facebook"></i>
                                </a>

                                <a href="https://twitter.com/StateCorps" class="social-link-header" target="_blank">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>

                                <a href="https://www.linkedin.com/company/state-corps" class="social-link-header" target="_blank">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
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
                                            <span class="nav-text">Home</span>
                                        </a>
                                    </li>

                                    <!-- ABOUT -->
                                    <li class="nav-item dropdown <?php echo ($current_page == 'about.php') ? 'active' : '' ?>">
                                        <a href="about.php" class="nav-link has-dropdown">
                                            <span class="nav-text">About</span>
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
                                            <span class="nav-text">Services</span>
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
                                        <div class="nav-link has-dropdown">
                                            <span class="nav-text">Expertise</span>
                                            <span class="dropdown-arrow">▼</span>
                                        </div>

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
                                        <div class="nav-link has-dropdown">
                                            <span class="nav-text">Projects</span>
                                            <span class="dropdown-arrow">▼</span>
                                        </div>

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
                                            <span class="nav-text">Media</span>
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