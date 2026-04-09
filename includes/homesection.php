<?php
include("includes/data/homedata.php");
?>


<!-- ================= HERO SLIDER ================= -->
<section class="slider-one-sec">
    <div class="swiper heroSwiper">

        <div class="swiper-wrapper">
            <?php foreach ($heroSlides as $slide): ?>
                <div class="swiper-slide">

                    <div class="image-layer" style="background-image:url(<?= $slide['image'] ?>)"></div>
                    <div class="slider-overlay"></div>
                    <div class="container">
                        <div class="slider-content">
                            <h3><?= $slide['subtitle'] ?></h3>
                            <h1><?= $slide['title'] ?></h1>
                            <a href="<?= $slide['link'] ?>" class="hero-btn">
                                <?= $slide['button'] ?>
                            </a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

        <!-- Indicators -->
        <div class="hero-indicators">

            <?php foreach ($heroSlides as $index => $slide): ?>
                <div class="hero-indicator-item <?= $index == 0 ? 'active' : '' ?>" data-index="<?= $index ?>">

                    <div class="hero-indicator-progress"></div>
                    <span class="hero-indicator-num">
                        <?= str_pad($index + 1, 2, "0", STR_PAD_LEFT) ?>
                    </span>
                    <span class="hero-indicator-title">
                        <?= $slide['indicator'] ?>
                    </span>

                </div>
            <?php endforeach; ?>

        </div>

    </div>

</section>


<!-- ================= ABOUT US ================= -->
<section class="index-stats-section" style="background-image: linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)), url('<?= $statsBg ?>');">

    <div class="container">

        <div class="index-about-us-header text-center mb-4">
            <h2 class="fw-bold fs-2">
                About Us
            </h2>
        </div>
        <div class="row align-items-center">

            <div class="col-lg-3">
                <div class="row g-5">
                    <?php foreach ($stats as $stat): ?>
                        <div class="col-12">
                            <div class="stat-item">
                                <div class="stat-number">
                                    <span class="counter" data-target="<?= $stat['number'] ?>">0</span>
                                    <span class="suffix"><?= $stat['suffix'] ?></span>
                                </div>
                                <div class="stat-label">
                                    <?= $stat['label'] ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-9">
                <section class="index-about-us">
                    <div class="index-about-us-container">

                        <!-- Tabs -->
                        <ul class="nav nav-tabs border-0 mb-4">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#history">
                                    History & Milestones
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#mission">
                                    Our Mission
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#vision">
                                    Our Vision
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <!-- HISTORY & MILESTONES -->
                            <div class="tab-pane fade show active" id="history">
                                <div class="row g-2">
                                    <?php foreach ($history as $item): ?>
                                        <div class="col-md-3">
                                            <div class="history-box p-4">
                                                <h5 class="year"><?= $item['year'] ?></h5>
                                                <p><?= $item['title'] ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- MISSION + VISION -->
                            <?php foreach ($about_tabs as $id => $tab): ?>
                                <div class="tab-pane fade" id="<?= $id ?>">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h2 class="text-orange"><?= $tab['title'] ?></h2>
                                            <p><?= $tab['text'] ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <img src="<?= $tab['image'] ?>" class="img-fluid rounded">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>

</section>


<!-- ================= OUR SERVICES ================= -->
<section class="services-section">
    <div class="container">

        <div class="section-header text-center mb-4">
            <h2 class="fw-bold fs-2">
                Our Services
            </h2>
        </div>

        <div class="row g-4">
            <?php foreach ($indexservices as $service): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100">
                        <div class="service-image">
                            <img src="<?= $service['image']; ?>" alt="<?= $service['title']; ?>" class="img-fluid" loading="lazy">
                        </div>
                        <div class="service-content">
                            <div class="service-title">
                                <?= htmlspecialchars($service['title']); ?>
                            </div>
                            <ul class="service-desc">
                                <?php foreach ($service['desc'] as $item): ?>
                                    <li><?= htmlspecialchars($item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <a href="<?= $service['link']; ?>" class="service-btn">
                                Read More +
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>



<!-- ================= MAJOR PROJECTS ================= -->
<section class="major-projects-section py-5">
    <div class="container major-projects-container">
        <div class="row g-4">
            <div class="text-center mb-4">
                <h2 class="fw-bold fs-2">
                    Our Key Projects
                </h2>
            </div>
            <?php foreach ($major_projects as $project): ?>
                <div class="col-md-3">
                    <div class="major-project-card">
                        <img src="<?= $project['image'] ?>"
                            alt="<?= $project['title'] ?>"
                            class="major-project-img">
                        <div class="major-project-title">
                            <?= $project['title'] ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>



<!-- ================= LATEST NEWS ================= -->
<section class="index-news-section section-padding">
    <div class="container">
        <div class="index-news-header">
            <h2 class="index-news-head">Recent Activities</h2>
        </div>

        <div class="row g-4">

            <?php foreach ($newsItems as $news): ?>
                <div class="col-lg-4 col-md-6">
                    <article class="index-news-card">
                        <div class="index-news-image">
                            <img src="<?= $news['image']; ?> " alt="<?= $news['title']; ?>" class="img-fluid lazy" loading="lazy">
                        </div>
                        <div class="index-news-content">
                            <div class="index-news-meta">
                                <span>
                                    <i class="fa-regular fa-user"></i>
                                    Posted by: <?= $news['author']; ?>
                                </span>
                                <span>
                                    <i class="fa-regular fa-calendar-check"></i>
                                    <?= $news['comments']; ?>
                                </span>
                            </div>
                            <h3 class="index-news-title">
                                <a href="#">
                                    <?= htmlspecialchars($news['title']); ?>
                                </a>
                            </h3>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>

        </div>

    </div>
</section>



<!-- ================= CLIENTS ================= -->
<section class="clients-section">

    <div class="container">
        <div class="container clients-container">
            <div class="text-center my-3">
                <h2 class="fw-bold fs-2">
                    Clients
                </h2>
            </div>
            <div class="clients-slider">
                <?php foreach (array_merge($clients, $clients) as $logo): ?>
                    <div class="client-item">
                        <img src="<?= $logo ?>" alt="Client Logo">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</section>



<!-- ================= CONTACT QUICK SECTION ================= -->
<section class="index-contact-section py-4">

    <div class="container">

        <!-- Title -->
        <div class="text-center mb-2">
            <h2 class="contact-title">
                <span>Get In</span> Touch
            </h2>
        </div>

        <div class="row text-center g-2">

            <!-- Phone -->
            <div class="col-lg-4 col-md-3">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>

                    <p class="contact-text">
                        +93 700 000 000
                    </p>
                </div>
            </div>

            <!-- Address -->
            <div class="col-lg-4 col-md-3">
                <div class="contact-item">

                    <div class="contact-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <h6 class="mb-2">Corporate Office</h6>

                    <p class="contact-text">
                        Kabul, Afghanistan <br>
                        State Corps Headquarters
                    </p>

                </div>
            </div>

            <!-- Email -->
            <div class="col-lg-4 col-md-3">
                <div class="contact-item">

                    <div class="contact-icon">
                        <i class="fa-regular fa-envelope"></i>
                    </div>

                    <p class="contact-text">
                        info@statecorps.com <br>
                        hr@statecorps.com
                    </p>

                </div>
            </div>

        </div>

        <!-- Button -->
        <div class="text-center mt-5">
            <a href="contact.php" class="contact-btn">
                CONTACT US
            </a>
        </div>

    </div>

</section>