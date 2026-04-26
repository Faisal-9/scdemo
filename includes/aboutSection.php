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
            <div class="col-lg-9">
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
                        <h2 class="text-center mb-4"><?= $milestones['title'] ?></h2>

                        <div class="row g-4 align-items-start">

                            <!-- TIMELINE -->
                            <div class="col-lg-5">
                                <div class="timeline-list">

                                    <?php foreach ($milestones['items'] as $i => $mile): ?>
                                        <div class="timeline-item <?= $i === 0 ? 'active' : '' ?>"
                                            data-index="<?= $i ?>"
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

                            <!-- DETAIL -->
                            <div class="col-lg-7">
                                <div class="timeline-detail">

                                    <img id="mileImg"
                                        src="assets/images/taloqan.jpg"
                                        class="img-fluid rounded-3 mb-3">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 id="mileTitle"><?= $milestones['items'][0]['title'] ?></h4>
                                        <span id="mileYear"><?= $milestones['items'][0]['year'] ?></span>
                                    </div>

                                    <p id="mileDesc"><?= $milestones['items'][0]['description'] ?></p>

                                </div>
                            </div>

                        </div>
                    </section>

                    <!-- CLIENTS -->
                    <section id="clients" class="about-section-block client-section about-panel py-1">
                        <h2 class="text-center mb-4"><?= $clients['title'] ?></h2>

                        <div class="row g-3 justify-content-center">

                            <?php foreach ($clients['items'] as $client): ?>
                                <div class="col-6 col-md-4 col-lg-2">

                                    <div class="client-card d-flex align-items-center justify-content-center bg-white rounded-3 p-3 h-100">

                                        <div class="client-logo">
                                            <img src="<?= $client['logo'] ?>" alt="Client Logo" class="img-fluid">
                                        </div>

                                    </div>

                                </div>
                            <?php endforeach; ?>

                        </div>
                    </section>

                    <!-- CERTIFICATES -->
                    <section id="certificates" class="about-section-block about-panel py-1">
                        <h2 class="text-center mb-4"><?= $certificates['title'] ?></h2>

                        <div class="row g-3 certificates-grid">

                            <?php foreach ($certificates['items'] as $cert): ?>
                                <div class="col-6 col-md-4 col-lg-4">
                                    <div class="certificate-card text-center p-3 bg-white rounded-3 h-100">

                                        <div class="certificate-img mb-2">
                                            <img src="<?= $cert['logo'] ?>" alt="<?= $cert['name'] ?>" class="img-fluid">
                                        </div>

                                        <h6 class="certificate-name">
                                            <?= $cert['name'] ?>
                                        </h6>

                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </section>

                    <!-- AWARDS -->
                    <section id="awards" class="about-section-block about-panel py-1">
                        <h2 class="text-center mb-4"><?= $awards['title'] ?></h2>

                        <div class="row g-3 awards-grid">

                            <?php foreach ($awards['items'] as $award): ?>
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="award-card text-center p-3 bg-white rounded-3 h-100">

                                        <div class="award-img mb-2">
                                            <img src="<?= $award['logo'] ?>" class="img-fluid">
                                        </div>

                                        <h6 class="award-title">
                                            <?= $award['name'] ?>
                                        </h6>

                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </section>

                    <!-- SISTER COMPANIES -->
                    <section id="sister" class="about-section-block about-panel py-1">
                        <div class="container">

                            <h2 class="text-center mb-4"><?= $sisterCompanies['title'] ?></h2>

                            <div class="row g-3">

                                <?php foreach ($sisterCompanies['items'] as $company): ?>
                                    <div class="col-6 col-md-4 col-lg-3">

                                        <div class="sister-card d-flex flex-column align-items-center justify-content-center text-center p-3 bg-white rounded-3 h-100">

                                            <div class="sister-logo mb-2">
                                                <img src="<?= $company['logo'] ?>"
                                                    alt="<?= $company['name'] ?>"
                                                    class="img-fluid">
                                            </div>

                                            <p class="sister-name fw-semibold mb-0">
                                                <?= $company['name'] ?>
                                            </p>

                                        </div>

                                    </div>
                                <?php endforeach; ?>

                            </div>

                        </div>
                    </section>

                </div>
            </div>

        </div>
    </div>
</section>