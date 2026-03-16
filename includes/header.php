<?php
// Get current page for active state
$current_page = basename($_SERVER['PHP_SELF']);

// Define page groups for active state in dropdowns - this can be expanded as needed

$about_pages = [
    'about.php',
    'general-information.php',
    'mission-vision.php',
    'milestones.php',
    'clients.php',
    'SisterCompany.php',
    'awards-rewards.php',
    'certificates.php'
];

$services_pages = [
    'services.php',
    'transmission.php',
    'substation.php',
    'distribution.php',
    'hydropowerdam.php',
    'logistic.php'
];

$sectors_pages = [
    'sectors.php',
    'commercialbuilding.php',
    'residential.php',
    'industrial.php',
    'roadhighway.php',
    'airport.php',
    'transportation.php',
    'water-infrastructure.php',
    'mining.php'
];

$media_pages = [
    'media.php',
    'news.php',
    'events.php',
    'gallery.php'
];
?>
<header class="header">
    <div class="container ">
        <div class="main-navigation">
            <div class="nav-wrapper">
                <!-- Logo Container -->
                <div class="logo-container">
                    <a href="index.php" class="logo">
                        <img src="assets/images/logo.png" alt="State Corps Logo" class="logo-img">
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" aria-label="Toggle menu">
                    <span class="toggle-bar"></span>
                    <span class="toggle-bar"></span>
                    <span class="toggle-bar"></span>
                </button>

                <!-- Main Navigation Menu -->
                <nav class="nav-menu">
                    <ul class="nav-list">
                        <!-- Home -->
                        <li class="nav-item <?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : ''; ?>">
                            <a href="index.php" class="nav-link">
                                <span class="nav-text">Home</span>
                            </a>
                        </li>

                        <!-- About Us Dropdown -->
                        <li class="nav-item dropdown <?php echo in_array($current_page, $about_pages) ? 'active' : ''; ?>">
                            <a href="about.php" class="nav-link has-dropdown">
                                <span class="nav-text">About Us</span>
                                <span class="dropdown-arrow">▼</span>
                            </a>
                            <div class="dropdown-menu">
                                <ul class="dropdown-list">
                                    <li>
                                        <a href="/about.php#general-info" class="dropdown-link">General Information</a>
                                    </li>
                                    <li>
                                        <a href="/about.php#mission-vision" class="dropdown-link">Mission - Vision</a>
                                    </li>
                                    <li>
                                        <a href="/about.php#milestones" class="dropdown-link">Milestones</a>
                                    </li>

                                    <li>
                                        <a href="/about.php#clients" class="dropdown-link">Clients</a>
                                    </li>
                                    <li>
                                        <a href="/about.php#sister" class="dropdown-link">Sister Companies</a>
                                    </li>
                                    <li>
                                        <a href="/about.php#awards" class="dropdown-link">Awards & Recognitions</a>
                                    </li>
                                    <li>
                                        <a href="/about.php#certificates" class="dropdown-link">Certificates</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Services Dropdown -->
                        <li class="nav-item dropdown <?php echo in_array($current_page, $services_pages) ? 'active' : ''; ?>">
                            <a href="services.php" class="nav-link has-dropdown">
                                <span class="nav-text">Services</span>
                                <span class="dropdown-arrow">▼</span>
                            </a>

                            <!-- Services Mega Menu -->
                            <div class="dropdown-menu mega-menu">
                                <div class="mega-menu-content">

                                    <!-- Column 1: Design -->
                                    <div class="mega-column">
                                        <h4 class="mega-title">Planning</h4>
                                        <ul class="mega-list">
                                            <li><a href="substation.php" class="mega-link <?php echo ($current_page == 'substation.php') ? 'active' : ''; ?>">Designing & Modeling</a></li>
                                            <li><a href="distribution.php" class="mega-link <?php echo ($current_page == 'distribution.php') ? 'active' : ''; ?>">Mechanical</a></li>
                                            <li><a href="distribution.php" class="mega-link <?php echo ($current_page == 'distribution.php') ? 'active' : ''; ?>">Civil</a></li>
                                            <li><a href="transmission.php" class="mega-link <?php echo ($current_page == 'transmission.php') ? 'active' : ''; ?>">Electrical System Design</a></li>
                                            <li><a href="hydropowerdam.php" class="mega-link <?php echo ($current_page == 'hydropowerdam.php') ? 'active' : ''; ?>">Transportation & Distribution</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 2: Energy -->
                                    <div class="mega-column">
                                        <h4 class="mega-title">Designing</h4>
                                        <ul class="mega-list">
                                            <li><a href="transmission.php" class="mega-link <?php echo ($current_page == 'transmission.php') ? 'active' : ''; ?>">Engineering, Procurement, and Construction services</a></li>
                                            <li><a href="substation.php" class="mega-link <?php echo ($current_page == 'substation.php') ? 'active' : ''; ?>">Turnkey energy infrastructure projects</a></li>
                                            <li><a href="distribution.php" class="mega-link <?php echo ($current_page == 'distribution.php') ? 'active' : ''; ?>">Project management and supervision</a></li>
                                            <li><a href="hydropowerdam.php" class="mega-link <?php echo ($current_page == 'hydropowerdam.php') ? 'active' : ''; ?>">Quality assurance and HSE management</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 3: Operations & Maintenance -->
                                    <div class="mega-column">
                                        <h4 class="mega-title">Tender</h4>
                                        <ul class="mega-list">
                                            <li><a href="transmission.php" class="mega-link <?php echo ($current_page == 'transmission.php') ? 'active' : ''; ?>">Transmission Lines</a></li>
                                            <li><a href="substation.php" class="mega-link <?php echo ($current_page == 'substation.php') ? 'active' : ''; ?>">Substations</a></li>
                                            <li><a href="distribution.php" class="mega-link <?php echo ($current_page == 'distribution.php') ? 'active' : ''; ?>">Distribution Networks</a></li>
                                            <li><a href="hydropowerdam.php" class="mega-link <?php echo ($current_page == 'hydropowerdam.php') ? 'active' : ''; ?>">Hydro Power Dams</a></li>
                                            <li><a href="logistic.php" class="mega-link <?php echo ($current_page == 'logistic.php') ? 'active' : ''; ?>">Logistics</a></li>
                                        </ul>
                                    </div>


                                </div>
                            </div>
                        </li>

                        <!-- Sectors -->
                        <li class="nav-item dropdown <?php echo in_array($current_page, $sectors_pages) ? 'active' : ''; ?>">
                            <a href="sectors.php" class="nav-link has-dropdown">
                                <span class="nav-text">Sectors</span>
                                <span class="dropdown-arrow">▼</span>
                            </a>

                            <!-- Sectors Mega Menu -->
                            <div class="dropdown-menu mega-menu">
                                <div class="mega-menu-content">

                                    <!-- Column 1: Energy -->
                                    <div class="mega-column">
                                        <h4 class="mega-title">Energy</h4>
                                        <ul class="mega-list">
                                            <li><a href="transmission.php" class="mega-link <?php echo ($current_page == 'transmission.php') ? 'active' : ''; ?>">Transmission Lines</a></li>
                                            <li><a href="substation.php" class="mega-link <?php echo ($current_page == 'substation.php') ? 'active' : ''; ?>">Substations</a></li>
                                            <li><a href="distribution.php" class="mega-link <?php echo ($current_page == 'distribution.php') ? 'active' : ''; ?>">Distribution Networks</a></li>
                                            <li><a href="hydropowerdam.php" class="mega-link <?php echo ($current_page == 'hydropowerdam.php') ? 'active' : ''; ?>">Hydro Power Dams</a></li>
                                            <li><a href="hydropowerdam.php#renewable" class="mega-link">Renewable Energy</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 2: Construction -->
                                    <div class="mega-column">
                                        <h4 class="mega-title">Construction</h4>
                                        <ul class="mega-list">
                                            <li class="sub-dropdown">
                                                <a href="#" class="mega-link has-submenu">Vertical Construction</a>
                                                <ul class="sub-menu">
                                                    <li><a href="commercialbuilding.php" class="sub-link <?php echo ($current_page == 'commercialbuilding.php') ? 'active' : ''; ?>">Commercial Buildings</a></li>
                                                    <li><a href="residential.php" class="sub-link <?php echo ($current_page == 'residential.php') ? 'active' : ''; ?>">Residential/Military Buildings</a></li>
                                                    <li><a href="industrial.php" class="sub-link <?php echo ($current_page == 'industrial.php') ? 'active' : ''; ?>">Industrial</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="roadhighway.php" class="mega-link <?php echo ($current_page == 'roadhighway.php') ? 'active' : ''; ?>">Roads and Highways</a></li>
                                            <li><a href="airport.php" class="mega-link <?php echo ($current_page == 'airport.php') ? 'active' : ''; ?>">Airports Infrastructure</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 3: Transportation -->
                                    <div class="mega-column">
                                        <h4 class="mega-title">Transportation</h4>
                                        <ul class="mega-list">
                                            <li><a href="transportation.php" class="mega-link <?php echo ($current_page == 'transportation.php') ? 'active' : ''; ?>">Railways</a></li>
                                            <li><a href="roadhighway.php" class="mega-link <?php echo ($current_page == 'roadhighway.php') ? 'active' : ''; ?>">Roads and Highways</a></li>
                                            <li><a href="airport.php" class="mega-link <?php echo ($current_page == 'airport.php') ? 'active' : ''; ?>">Airports</a></li>
                                            <li><a href="logistic.php" class="mega-link <?php echo ($current_page == 'logistic.php') ? 'active' : ''; ?>">Logistics</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 4: Water Infrastructure -->
                                    <div class="mega-column">
                                        <h4 class="mega-title">Water Infrastructure</h4>
                                        <ul class="mega-list">
                                            <li><a href="water-infrastructure.php" class="mega-link <?php echo ($current_page == 'water-infrastructure.php') ? 'active' : ''; ?>">Water Supply</a></li>
                                            <li><a href="water-infrastructure.php" class="mega-link">Sewage Systems</a></li>
                                            <li><a href="water-infrastructure.php" class="mega-link">Flood Control</a></li>
                                            <li><a href="hydropowerdam.php" class="mega-link <?php echo ($current_page == 'hydropowerdam.php') ? 'active' : ''; ?>">Dams</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 5: Mining -->
                                    <div class="mega-column">
                                        <h4 class="mega-title">Mining</h4>
                                        <ul class="mega-list">
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Exploration</a></li>
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Exploitation</a></li>
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Processing</a></li>
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Export Services</a></li>
                                        </ul>
                                    </div>
                                    <!-- Column 5: Mining -->
                                    <div class="mega-column">
                                        <h4 class="mega-title">designing</h4>
                                        <ul class="mega-list">
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Exploration</a></li>
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Exploitation</a></li>
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Processing</a></li>
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Export Services</a></li>
                                        </ul>
                                    </div>
                                    <!-- Column 5: Mining -->
                                    <div class="mega-column">
                                        <h4 class="mega-title">designing</h4>
                                        <ul class="mega-list">
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Exploration</a></li>
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Exploitation</a></li>
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Processing</a></li>
                                            <li><a href="mining.php" class="mega-link <?php echo ($current_page == 'mining.php') ? 'active' : ''; ?>">Export Services</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Media -->
                        <li class="nav-item dropdown <?php echo in_array($current_page, $media_pages) ? 'active' : ''; ?>">
                            <a href="media.php" class="nav-link has-dropdown">
                                <span class="nav-text">Media</span>
                                <span class="dropdown-arrow">▼</span>
                            </a>
                            <div class="dropdown-menu">
                                <ul class="dropdown-list">
                                    <li><a href="news.php" class="dropdown-link <?php echo ($current_page == 'news.php') ? 'active' : ''; ?>">News</a></li>
                                    <li><a href="events.php" class="dropdown-link <?php echo ($current_page == 'events.php') ? 'active' : ''; ?>">Events & Exhibitions</a></li>
                                    <li><a href="gallery.php" class="dropdown-link <?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>">Gallery</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- Contact Us -->
                        <li class="nav-item cta-item <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">
                            <a href="contact.php" class="nav-link ">
                                <span class="nav-text">Contact Us</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Social Media (Desktop Only) -->
                <div class="social-media-desktop">
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