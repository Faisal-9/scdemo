<?php
$current_page = basename($_SERVER['PHP_SELF']);

$services_pages = ['services.php'];
$sectors_pages  = ['sectors.php'];
$media_pages    = ['media.php', 'news.php', 'events.php', 'gallery.php'];

include_once("includes/data/aboutdata.php");
include_once("includes/data/servicesdata.php");
include_once("includes/data/sectorsdata.php");
?>

<header class="header">
    <div class="container px-3 px-lg-4">
        <div class="main-navigation">
            <div class="nav-wrapper">

                <!-- Logo -->
                <div class="logo-container">
                    <a href="index.php" class="logo">
                        <img src="assets/images/logo.png" alt="State Corps Logo" class="logo-img">
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle d-lg-none" aria-label="Toggle menu">
                    <span class="toggle-bar"></span>
                    <span class="toggle-bar"></span>
                    <span class="toggle-bar"></span>
                </button>

                <!-- Main Navigation -->
                <nav class="nav-menu">
                    <ul class="nav-list">

                        <!-- Home -->
                        <li class="nav-item <?= ($current_page == 'index.php' || $current_page == '') ? 'active' : '' ?>">
                            <a href="index.php" class="nav-link">
                                <span class="nav-text">Home</span>
                            </a>
                        </li>

                        <!-- About Us -->
                        <li class="nav-item dropdown <?= ($current_page == 'about.php') ? 'active' : '' ?>">
                            <a href="about.php" class="nav-link has-dropdown">
                                <span class="nav-text">About</span>
                                <span class="dropdown-arrow">▼</span>
                            </a>
                            <div class="dropdown-menu">
                                <ul class="dropdown-list">
                                    <?php foreach ($aboutSections as $section): ?>
                                        <li>
                                            <a href="about.php#<?= $section['id']; ?>" class="dropdown-link">
                                                <?= htmlspecialchars($section['data']['title']); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>

                        <!-- Services -->
                        <li class="nav-item dropdown <?= in_array($current_page, $services_pages) ? 'active' : '' ?>">
                            <a href="services.php" class="nav-link has-dropdown">
                                <span class="nav-text">Services</span>
                                <span class="dropdown-arrow">▼</span>
                            </a>
                            <div class="dropdown-menu mega-menu">
                                <div class="mega-menu-content">
                                    <?php foreach ($services as $serviceKey => $service): ?>
                                        <div class="mega-column">
                                            <h4 class="mega-title">
                                                <a href="services.php?tab=<?= $serviceKey ?>" class="mega-title-link">
                                                    <?= $service['title'] ?>
                                                </a>
                                            </h4>
                                            <ul class="mega-list">
                                                <?php foreach ($service['sections'] as $section): ?>
                                                    <li>
                                                        <a href="services.php?tab=<?= $serviceKey ?>#<?= $serviceKey ?>-<?= $section['id'] ?>"
                                                            class="mega-link">
                                                            <?= $section['title'] ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </li>

                        <!-- Sectors -->
                        <li class="nav-item dropdown <?= in_array($current_page, $sectors_pages) ? 'active' : '' ?>">
                            <a href="sectors.php" class="nav-link has-dropdown">
                                <span class="nav-text">Expertise</span>
                                <span class="dropdown-arrow">▼</span>
                            </a>
                            <div class="dropdown-menu mega-menu">
                                <div class="mega-menu-content">
                                    <?php foreach ($sectors as $sectorKey => $sector): ?>
                                        <div class="mega-column">
                                            <h4 class="mega-title">
                                                <a href="sectors.php?tab=<?= $sectorKey ?>" class="mega-title-link">
                                                    <?= $sector['title'] ?>
                                                </a>
                                            </h4>
                                            <ul class="mega-list">
                                                <?php foreach ($sector['sections'] as $section): ?>
                                                    <li>
                                                        <a href="sectors.php?tab=<?= $sectorKey ?>#<?= $sectorKey ?>-<?= $section['id'] ?>"
                                                            class="mega-link">
                                                            <?= $section['title'] ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </li>

                        <!-- Projects -->
                        <li class="nav-item <?= ($current_page == 'projects.php') ? 'active' : '' ?>">
                            <a href="projects.php" class="nav-link">
                                <span class="nav-text">Projects</span>
                            </a>
                        </li>

                        <!-- Media -->
                        <li class="nav-item dropdown <?= in_array($current_page, $media_pages) ? 'active' : '' ?>">
                            <a href="media.php" class="nav-link has-dropdown">
                                <span class="nav-text">Media</span>
                                <span class="dropdown-arrow">▼</span>
                            </a>
                            <div class="dropdown-menu">
                                <ul class="dropdown-list">
                                    <li><a href="news.php" class="dropdown-link <?= ($current_page == 'news.php')   ? 'active' : '' ?>">News</a></li>
                                    <li><a href="events.php" class="dropdown-link <?= ($current_page == 'events.php') ? 'active' : '' ?>">Events &amp; Exhibitions</a></li>
                                    <li><a href="gallery.php" class="dropdown-link <?= ($current_page == 'gallery.php') ? 'active' : '' ?>">Gallery</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- Contact Us -->
                        <li class="nav-item <?= ($current_page == 'contact.php') ? 'active' : '' ?>">
                            <a href="contact.php" class="nav-link">
                                <span class="nav-text">Contact Us</span>
                            </a>
                        </li>

                    </ul>
                </nav>

                <!-- Social Media -->
                <div class="social-media-desktop d-none d-lg-flex align-items-center gap-3">
                    <a href="https://www.facebook.com/StateCorpsInc/" class="social-link-header" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="https://twitter.com/StateCorps" class="social-link-header" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/statecorps" class="social-link-header" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</header>