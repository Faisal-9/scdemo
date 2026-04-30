<?php
include("includes/data/homedata.php");
include_once("includes/data/servicesdata.php");
include_once("includes/data/aboutdata.php");
?>


<!-- ================= HERO SLIDER ================= -->
<section class="slider-one-sec">
    <div class="swiper heroSwiper">

        <div class="swiper-wrapper">
            <?php foreach ($heroSlides as $slide): ?>
                <div class="swiper-slide">

                    <div class="image-layer" style="background-image:url(<?= $slide['image'] ?> )"></div>
                    <div class="slider-overlay"></div>
                    <div class="container">
                        <div class="slider-content">
                            <h1><?= $slide['title'] ?></h1>
                            <p class="hero-desc">
                                <?= $slide['desc'] ?>
                            </p>
                            <a href="<?= $slide['link'] ?>" class="hero-btn">
                                Explore Projects
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
<section class="index-stats-section py-4" style="background-image: linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)), url('<?= $statsBg ?>');">
    <div class="container">

        <div class="index-about-us-header text-center mb-4">
            <h2 class="fw-bold fs-2">Why State Corps</h2>
        </div>

        <div class="row align-items-center">

            <div class="col-lg-3 col-md-12">
                <div class="row g-4 text-center text-lg-start">

                    <?php foreach ($stats as $stat): ?>
                        <div class="col-6 col-sm-6 col-md-3 col-lg-12">
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

            <div class="col-lg-9 col-md-8 d-none d-md-flex">

                <section class="index-about-us">
                    <div class="index-about-us-container">
                        <!-- TABS -->
                        <ul class="nav nav-tabs border-0 mb-4">
                            <?php $first = true; ?>

                            <?php foreach ($whySC as $id => $item): ?>

                                <?php
                                $hasAny = !empty($item['tabname'] ?? null);

                                if (!$hasAny) continue;

                                $label = $item['tabname'] ?? 'Section ' . $id;
                                ?>

                                <li class="nav-item ">
                                    <button
                                        class="nav-link serif-link <?= $first ? 'active' : '' ?>"
                                        data-bs-toggle="tab"
                                        data-bs-target="#why<?= $id ?>">
                                        <?= htmlspecialchars($label) ?>
                                    </button>
                                </li>

                                <?php $first = false; ?>

                            <?php endforeach; ?>
                        </ul>

                        <!-- TAB CONTENT -->
                        <div class="tab-content">
                            <?php $first = true; ?>

                            <?php foreach ($whySC as $id => $item): ?>

                                <?php
                                $hasTitle = !empty($item['title'] ?? null);
                                $hasText  = !empty($item['text'] ?? null);
                                $hasImage = !empty($item['image'] ?? null);

                                $hasContent = $hasTitle || $hasText;
                                ?>

                                <div class="tab-pane fade <?= $first ? 'show active' : '' ?>" id="why<?= $id ?>">
                                    <div class="row align-items-center">

                                        <?php if ($hasContent): ?>
                                            <div class="<?= $hasImage ? 'col-md-6' : 'col-md-12' ?>">

                                                <?php if ($hasTitle): ?>
                                                    <h2 class="text-orange">
                                                        <?= htmlspecialchars($item['title']) ?>
                                                    </h2>
                                                <?php endif; ?>

                                                <?php if ($hasText): ?>
                                                    <p>
                                                        <?= htmlspecialchars($item['text']) ?>
                                                    </p>
                                                <?php endif; ?>

                                            </div>
                                        <?php endif; ?>


                                        <?php if ($hasImage): ?>
                                            <div class="<?= $hasContent ? 'col-md-6' : 'col-md-12' ?>">
                                                <img
                                                    src="<?= htmlspecialchars($item['image']) ?>"
                                                    class="zoomable img-fluid rounded"
                                                    alt="<?= htmlspecialchars($item['title'] ?? 'image') ?>">
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>

                                <?php $first = false; ?>

                            <?php endforeach; ?>

                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

</section>


<!-- ================= OUR SERVICES ================= -->
<section class="services-section py-4">
    <div class="container">

        <div class="section-header text-center mb-4">
            <p class="text-muted fs-5">
                Delivering end-to-end engineering, project execution, and Mining solutions tailored to your industry's demands.
            </p>
        </div>

        <div class="row g-4">
            <?php foreach ($services as $serviceKey => $service): ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="service-card h-100">

                        <div class="service-image">
                            <img src="<?= $service['image'] ?>"
                                alt="<?= $service['title'] ?>"
                                class="img-fluid"
                                loading="lazy">
                        </div>

                        <div class="service-content">
                            <div class="service-title">
                                <?= htmlspecialchars($service['title']) ?>
                            </div>

                            <ul class="service-desc">
                                <?php foreach (array_slice($service['sections'], 0, 6) as $section): ?>
                                    <li><?= htmlspecialchars($section['title']) ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <a href="services.php?tab=<?= $serviceKey ?>"
                                class="service-btn serif-link">
                                Read More +
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>



<!-- ================= FEATURED PROJECTS ================= -->
<section class="major-projects-section py-4">
    <div class="container major-projects-container">


        <div class="text-center mb-4">
            <h2 class="fw-bold fs-2">
                Featured Projects
            </h2>
        </div>
        <div class="row g-4">
            <?php foreach ($major_projects as $project): ?>
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="major-project-card">
                        <img src="<?= $project['image'] ?>"
                            alt="<?= $project['title'] ?>"
                            class="major-project-img zoomable">

                        <div class="major-project-overlay">
                            <div class="major-project-title">
                                <?= $project['title'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>



<!-- ================= CLIENTS ================= -->
<section class="clients-section py-4">

    <div class="container">
        <div class="clients-container">

            <div class="text-center mb-4">
                <h2 class="fw-bold fs-2">Our Clients</h2>
            </div>

            <div class="clients-slider">
                <div class="clients-track" id="clientsTrack">
                    <?php $logos = array_merge($clients["items"], $clients["items"]); ?>
                    <?php foreach ($logos as $client): ?>
                        <div class="client-item">
                            <div class="client-logo-box">
                                <img src="<?= htmlspecialchars($client['logo']) ?>" class="zoomable" alt="Client Logo">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

</section>


<!-- ================= LATEST NEWS ================= -->
<section class="index-news-section py-4">
    <div class="container">

        <div class="index-news-header text-center mb-4">
            <h2 class="index-news-head fw-bold fs-2">Recent Activities</h2>
        </div>

        <div class="row g-4">

            <?php foreach (array_slice($newsItems, 0, 3) as $index => $news): ?>
                <div class="col-lg-4 col-md-6 col-12 <?= $index >= 1 ? 'd-none d-md-block' : '' ?>">
                    <article class="index-news-card">

                        <div class="index-news-image">
                            <img src="<?= $news['image']; ?>"
                                alt="<?= $news['title']; ?>"
                                class="img-fluid lazy"
                                loading="lazy">
                        </div>

                        <div class="index-news-content">

                            <div class="index-news-meta">
                                <span>
                                    <i class="fa-regular fa-calendar-check"></i>
                                    <?= $news['comments']; ?>
                                </span>
                            </div>

                            <h3 class="index-news-title serif-link">
                                <a href="#">
                                    <?= htmlspecialchars($news['title']); ?>
                                </a>
                            </h3>

                        </div>

                    </article>
                </div>
            <?php endforeach; ?>

        </div>

        <!-- View All Button -->
        <div class="text-center mt-4">
            <a href="media.php" class="index-news-btn serif-link">
                View More
            </a>
        </div>

    </div>
</section>




<!-- ================= CONTACT QUICK SECTION ================= -->
<!-- <section class="index-contact-section py-4">

    <div class="container">

        // Title 
        <div class="text-center mb-2">
            <h2 class="contact-title fw-bold fs-2">
                <span>Get In</span> Touch
            </h2>
        </div>
        <div class="row">
            <div class="col-lg-10 text-center g-2">

                // Phone 
                <div class="contact-item d-flex align-items-center justify-content-center gap-2">
                    <div class="contact-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>

                    <p class="contact-text mb-0">
                        +93 700 000 000
                    </p>
                </div>

                // Address
                <div class="contact-item d-flex align-items-center justify-content-center gap-2 mt-2">
                    <div class="contact-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <div>
                        <h6 class="mb-1">Corporate Office</h6>
                        <p class="contact-text mb-0">
                            Kart-e-Char D#3, Kabul Afghanistan <br>
                            State Corps Headquarters
                        </p>
                    </div>
                </div>

                // Email 
                <div class="contact-item d-flex align-items-center justify-content-center gap-2 mt-2">
                    <div class="contact-icon">
                        <i class="fa-regular fa-envelope"></i>
                    </div>

                    <p class="contact-text mb-0">
                        comms@statecorps.com
                    </p>
                </div>

            </div>

            // Button 
            <div class="col-lg-2 text-center mt-5">
                <a href="contact.php" class="contact-btn">
                    CONTACT US
                </a>
            </div>
        </div>
    </div>

</section> -->