<?php
include("includes/data/aboutdata.php");

$aboutSections = [
    'general-info' => $generalInfo,
    'mission-vision' => $missionVision,
    'milestones' => $milestones,
    'clients' => $clients,
    'certificates' => $certificates,
    'awards' => $awards,
    'sister' => $sisterCompanies,
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
                                <a class="nav-link <?= $first ? 'active' : '' ?>"
                                    href="#"
                                    data-section="<?= $id ?>">
                                    <?= $section['title'] ?>
                                </a>
                            </li>
                        <?php $first = false;
                        endforeach; ?>
                    </ul>
                </nav>
            </div>

            <!-- CONTENT -->
            <div class="container-fluid col-lg-9 min-vh-60">
                <div class="about-content">

                    <!-- COMPANY OVERVIEW -->
                    <section id="general-info" class="about-section-block about-panel active py-1">
                        <h2 class="text-center mb-3">Company Overview</h2>
                        <div class="general-info-content">
                            <p><?= $generalInfo['content'] ?></p>
                        </div>
                        <?php if (!empty($generalInfo['image'])): ?>
                            <div class="general-info-image mt-4">
                                <img src="<?= $generalInfo['image'] ?>"
                                    alt="State Corps Company Overview"
                                    class="img-fluid rounded-3 w-100 center center">
                            </div>
                        <?php endif; ?>
                    </section>

                    <!-- MISSION & VISION -->
                    <section id="mission-vision" class="about-section-block about-panel py-1">
                        <h2 class="text-center mb-3">Mission, Vision & Core Values</h2>

                        <!-- ROW 1: Mission — text left, image right -->
                        <div class="row align-items-center g-4 mb-5">
                            <div class="col-lg-6">
                                <div class="mv-text-block">
                                    <h3 class="mv-heading">Our Mission</h3>
                                    <p class="mv-text"><?= $missionVision['mission'] ?></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <img src="<?= $missionVision['mission_img'] ?>"
                                    alt="Mission"
                                    class="img-fluid rounded-3 mv-img">
                            </div>
                        </div>

                        <!-- ROW 2: Vision — image left, text right -->
                        <div class="row align-items-center g-4 mb-5">
                            <div class="col-lg-6">
                                <img src="<?= $missionVision['vision_img'] ?>"
                                    alt="Vision"
                                    class="img-fluid rounded-3 mv-img">
                            </div>
                            <div class="col-lg-6">
                                <div class="mv-text-block">
                                    <h3 class="mv-heading">Our Vision</h3>
                                    <p class="mv-text"><?= $missionVision['vision'] ?></p>
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
                                                <?= $value ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <img src="<?= $missionVision['core_values_img'] ?>"
                                    alt="Core Values"
                                    class="img-fluid rounded-3 mv-img">
                            </div>
                        </div>

                    </section>

                    <!-- GROWTH -->
                    <section id="milestones" class="about-section-block about-panel py-1">
                        <h2 class="text-center mb-3"><?= $milestones['title'] ?></h2>

                        <div class="row">
                            <!-- LEFT SIDE -->
                            <div class="col-lg-5">
                                <div class="timeline-list">
                                    <?php foreach ($milestones['items'] as $i => $mile): ?>
                                        <div class="timeline-item <?= $i === 0 ? 'active' : '' ?>"
                                            onclick="showMilestone(this)"
                                            data-year="<?= $mile['year'] ?>"
                                            data-title="<?= $mile['title'] ?>"
                                            data-desc="<?= $mile['description'] ?>"
                                            data-img="assets/images/taloqan.jpg">
                                            <span class="year-badge"><?= $mile['year'] ?></span>
                                            <span class="title-text"><?= $mile['title'] ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- RIGHT SIDE -->
                            <div class="col-lg-7">
                                <div class="timeline-detail">
                                    <img id="mileImg" src="assets/images/taloqan.jpg" class="img-fluid rounded-3 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <h4 id="mileTitle"><?= $milestones['items'][0]['title'] ?></h4>
                                        <span id="mileYear"><?= $milestones['items'][0]['year'] ?></span>
                                    </div>
                                    <p id="mileDesc">
                                        <?= $milestones['items'][0]['description'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </section>

                    <!-- CLIENTS -->
                    <section id="clients" class="about-section-block client-section about-panel py-1">
                        <h2 class="text-center mb-3"><?= $clients['title'] ?></h2>
                        <div class="row g-3 justify-content-center">
                            <?php foreach ($clients['items'] as $client): ?>
                                <div class="col-lg-2 col-md-3 col-4">
                                    <div class="client-card">
                                        <img src="<?= $client['logo'] ?>" alt="Client Logo">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <!-- CERTIFICATES -->
                    <section id="certificates" class="about-section-block about-panel py-1">
                        <h2 class="text-center mb-3"><?= $certificates['title'] ?></h2>
                        <div class="row g-4 justify-content-center">
                            <?php foreach ($certificates['items'] as $cert): ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="certificate-card">
                                        <div class="certificate-img">
                                            <img src="<?= $cert['logo'] ?>" alt="<?= $cert['name'] ?>">
                                        </div>
                                        <h5 class="certificate-name"><?= $cert['name'] ?></h5>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <!-- AWARDS -->
                    <section id="awards" class="about-section-block about-panel py-1">
                        <div class="container">
                            <h2 class="text-center mb-3"><?= $awards['title'] ?></h2>

                            <div class="row g-4 align-items-stretch">
                                <?php foreach ($awards['items'] as $award): ?>
                                    <div class="col-lg-4 col-md-6 d-flex">
                                        <div class="award-card w-100 d-flex flex-column text-center p-3 bg-white rounded-3">

                                            <div class="award-img d-flex align-items-center justify-content-center">
                                                <img src="<?= $award['logo'] ?>" alt="<?= $award['name'] ?>" class="img-fluid">
                                            </div>

                                            <h5 class="award-name mt-3 mb-0">
                                                <?= $award['name'] ?>
                                            </h5>

                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>

                    <!-- SISTER COMPANIES -->
                    <section id="sister" class="about-section-block about-sister-slider about-panel py-1">

                        <div class="container">
                            <h2 class="text-center mb-3"><?= $sisterCompanies['title'] ?></h2>

                            <div class="swiper sisterSwiper">
                                <div class="swiper-wrapper">

                                    <?php foreach ($sisterCompanies['items'] as $company): ?>
                                        <div class="swiper-slide d-flex">

                                            <!-- Card -->
                                            <div class="sister-card w-100 d-flex flex-column align-items-center justify-content-center text-center p-4 bg-white rounded-3">

                                                <!-- Logo -->
                                                <div class="sister-logo d-flex align-items-center justify-content-center mb-3">
                                                    <img src="<?= $company['logo'] ?>"
                                                        alt="<?= $company['name'] ?>"
                                                        class="img-fluid">
                                                </div>

                                                <!-- Name -->
                                                <p class="sister-name fw-semibold mb-0">
                                                    <?= $company['name'] ?>
                                                </p>

                                            </div>

                                        </div>
                                    <?php endforeach; ?>

                                </div>

                                <!-- Navigation -->
                                <div class="clients-nav">
                                    <div class="swiper-button-prev sister-prev"></div>
                                    <div class="swiper-button-next sister-next"></div>
                                </div>
                            </div>
                        </div>

                    </section>

                </div>
            </div>

        </div>
    </div>
</section>