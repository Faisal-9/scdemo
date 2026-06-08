<?php
include("includes/data/aboutdata.php");

$aboutSections = [
    'general-info' => $generalInfo,
    'mission-vision' => $missionVision,
    'clients' => $clients,
    'certificates' => $certificates,
    'awards' => $awards,
    'sister' => $sisterCompanies,
    'hse' => $hse,
    'cprofile' => $cprofile,
];
?>

<section class="about-page-section py-4">
    <div class="container">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3 sidebarr">
                <nav id="aboutSidebar" class="about-sidebar">
                    <ul class="nav flex-column">
                        <?php $first = true;
                        foreach ($aboutSections as $id => $section): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $first ? 'active' : '' ?>"
                                    href="#"
                                    data-section="<?php echo $id ?>">
                                    <?php echo $section['title'] ?>
                                </a>
                            </li>
                        <?php $first = false;
                        endforeach; ?>
                    </ul>
                </nav>
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9">
                <div class="about-content">

                    <!-- COMPANY OVERVIEW -->
                    <section id="general-info" class="about-section-block about-panel active py-1">
                        <h2 class="text-center mb-3"><?php echo $generalInfo['title'] ?></h2>
                        <div class="general-info-content">
                            <p><?php echo $generalInfo['content'] ?></p>
                        </div>

                        <!-- GROWTH TIMELINE -->
                        <div class="mt-4">
                            <div class="row g-4 align-items-start">

                                <!-- TIMELINE LIST -->
                                <div class="col-lg-5">
                                    <div class="timeline-list">

                                        <?php foreach ($generalInfo['items'] as $i => $mile): ?>
                                            <div class="timeline-item <?php echo $i === 0 ? 'active' : '' ?>"
                                                data-index="<?php echo $i ?>"
                                                data-year="<?php echo htmlspecialchars($mile['year']) ?>"
                                                data-title="<?php echo htmlspecialchars($mile['title']) ?>"
                                                data-desc="<?php echo htmlspecialchars($mile['description']) ?>"
                                                data-img="<?php echo htmlspecialchars($mile['img']) ?>">

                                                <span class="year-badge"><?php echo $mile['year'] ?></span>
                                                <span class="title-text serif-link"><?php echo $mile['title'] ?></span>

                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>

                                <!-- DETAIL PANEL -->
                                <div class="col-lg-7">
                                    <div class="timeline-detail">

                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4 id="mileTitle"><?php echo $generalInfo['items'][0]['title'] ?></h4>
                                            <span id="mileYear" class="year-badge"><?php echo $generalInfo['items'][0]['year'] ?></span>
                                        </div>

                                        <p id="mileDesc"><?php echo $generalInfo['items'][0]['description'] ?></p>

                                        <img id="mileImg"
                                            src="<?php echo htmlspecialchars($generalInfo['items'][0]['img']) ?>"
                                            alt="<?php echo htmlspecialchars($generalInfo['items'][0]['title']) ?>"
                                            class="img-fluid rounded-3 mt-2 zoomable">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>

                    <!-- MISSION & VISION -->
                    <section id="mission-vision" class="about-section-block about-panel py-1">
                        <h2 class="text-center mb-4">Mission, Vision & Core Values</h2>

                        <!-- ROW 1: Mission — text left, image right -->
                        <div class="row align-items-center g-4 mb-5">
                            <div class="col-lg-6">
                                <div class="mv-text-block">
                                    <h3 class="mv-heading">Our Mission</h3>
                                    <p class="mv-text"><?php echo $missionVision['mission'] ?></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <img src="<?php echo $missionVision['mission_img'] ?>"
                                    alt="Mission"
                                    class="img-fluid rounded-3 mv-img zoomable">
                            </div>
                        </div>

                        <!-- ROW 2: Vision — image left, text right -->
                        <div class="row align-items-center g-4 mb-5">
                            <div class="col-lg-6">
                                <img src="<?php echo $missionVision['vision_img'] ?>"
                                    alt="Vision"
                                    class="img-fluid rounded-3 mv-img zoomable">
                            </div>
                            <div class="col-lg-6">
                                <div class="mv-text-block">
                                    <h3 class="mv-heading">Our Vision</h3>
                                    <p class="mv-text"><?php echo $missionVision['vision'] ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- ROW 3: Core Values — text left, image right -->
                        <div class="row align-items-center g-4">
                            <div class="col-lg-6">
                                <div class="mv-text-block">
                                    <h3 class="mv-heading">Core Values</h3>
                                    <ul class="mv-values-list">
                                        <?php foreach ($missionVision['core_values'] as $value): ?>
                                            <li>
                                                <span class="mv-value-dot"></span>
                                                <?php echo $value ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <img src="<?php echo $missionVision['core_values_img'] ?>"
                                    alt="Core Values"
                                    class="img-fluid rounded-3 mv-img zoomable">
                            </div>
                        </div>

                    </section>


                    <!-- CLIENTS -->
                    <section id="clients" class="about-section-block client-section about-panel py-1">
                        <h2 class="text-center mb-4"><?php echo $clients['title'] ?></h2>

                        <div class="row g-3 justify-content-center">

                            <?php foreach ($clients['items'] as $client): ?>
                                <div class="col-6 col-md-4 col-lg-2">

                                    <div class="client-card d-flex align-items-center justify-content-center bg-white rounded-3 p-3 h-100">

                                        <div class="client-logo">
                                            <img src="<?php echo $client['logo'] ?>" alt="Client Logo" class="img-fluid">
                                        </div>

                                    </div>

                                </div>
                            <?php endforeach; ?>

                        </div>
                    </section>

                    <!-- CERTIFICATES -->
                    <section id="certificates" class="about-section-block about-panel py-1">
                        <h2 class="text-center mb-4"><?php echo $certificates['title'] ?></h2>

                        <div class="row g-3 certificates-grid">

                            <?php foreach ($certificates['items'] as $cert): ?>
                                <div class="col-6 col-md-4 col-lg-4">
                                    <div class="certificate-card text-center p-3 bg-white rounded-3 h-100">

                                        <div class="certificate-img mb-2">
                                            <img src="<?php echo $cert['logo'] ?>" alt="<?php echo $cert['name'] ?>" class="img-fluid zoomable">
                                        </div>

                                        <h6 class="certificate-name">
                                            <?php echo $cert['name'] ?>
                                        </h6>

                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </section>

                    <!-- AWARDS -->
                    <section id="awards" class="about-section-block about-panel py-1">
                        <h2 class="text-center mb-4"><?php echo $awards['title'] ?></h2>

                        <div class="row g-3 awards-grid">

                            <?php foreach ($awards['items'] as $award): ?>
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="award-card text-center p-3 bg-white rounded-3 h-100">

                                        <div class="award-img mb-2">
                                            <img src="<?php echo $award['logo'] ?>" class="img-fluid zoomable">
                                        </div>

                                        <h6 class="award-title">
                                            <?php echo $award['name'] ?>
                                        </h6>

                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </section>

                    <!-- SISTER COMPANIES -->
                    <section id="sister" class="about-section-block about-panel py-1">
                        <div class="container">

                            <h2 class="text-center mb-4"><?php echo $sisterCompanies['title'] ?></h2>

                            <div class="row g-3">

                                <?php foreach ($sisterCompanies['items'] as $company): ?>
                                    <div class="col-6 col-md-4 col-lg-3">

                                        <div class="sister-card d-flex flex-column align-items-center justify-content-center text-center p-3 bg-white rounded-3 h-100">

                                            <div class="sister-logo mb-2">
                                                <img src="<?php echo $company['logo'] ?>"
                                                    alt="<?php echo $company['name'] ?>"
                                                    class="img-fluid">
                                            </div>

                                            <p class="sister-name fw-semibold mb-0">
                                                <?php echo $company['name'] ?>
                                            </p>

                                        </div>

                                    </div>
                                <?php endforeach; ?>

                            </div>

                        </div>
                    </section>

                    <!-- HEALTH, SAFETY & ENVIRONMENT -->
                    <section id="hse" class="about-section-block about-panel py-1">

                        <div class="container">
                            <h2 class="text-center mb-3"><?php echo $hse['title'] ?></h2>
                            <div class="hse-content text-center mb-4">
                                <p><?php echo $hse['content'] ?></p>
                            </div>
                        </div>
                    </section>


                    <!-- COMPANY PROFILE -->
                    <section id="cprofile" class="about-section-block about-panel py-1">
                        
                        <div class="container">
                            <h2 class="text-center mb-3">
                                <?php echo $cprofile['title']; ?>
                            </h2>
                            <div class="c-content text-center">
                                <p class="mb-4">
                                    <?php echo $cprofile['content']; ?>
                                </p>
                                <a href="<?php echo $cprofile['link']; ?>"
                                    class="btn btn-primary btn-lg"
                                    download>
                                    <i class="fas fa-download me-2"></i>
                                    Download Company Profile
                                </a>
                            </div>
                        </div>

                    </section>

                </div>
            </div>

        </div>
    </div>
</section>