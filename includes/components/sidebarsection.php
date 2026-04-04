<?php

$prefix = $prefix ?? "";
$sections = $sections ?? [];

?>

<section class="service-detail-page">

    <div class="container">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3 sidebarr">
                <nav id="<?= $prefix ?>-sidebar" class="about-sidebar">
                    <ul class="nav flex-column">
                        <?php foreach ($sections as $i => $section): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $i == 0 ? 'active' : '' ?>"
                                    href="#<?= $prefix . $section['id'] ?>">
                                    <?= $section['title'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9 contentt">
                <div
                    data-bs-spy="scroll"
                    data-bs-target="#<?= $prefix ?>-sidebar"
                    data-bs-offset="100"
                    tabindex="0"
                    class="about-content">

                    <?php foreach ($sections as $section): ?>

                        <section id="<?= $prefix . $section['id'] ?>" class="about-section-block p-3">

                            <!-- TITLE -->
                            <div class="text-center mb-1">
                                <h2 class="service-block-title"><?= $section['title'] ?></h2>
                                <?php if (!empty($section['small-title'])): ?>
                                    <p class="service-block-subtitle text-muted"><?= $section['small-title'] ?></p>
                                <?php endif; ?>
                                <hr class="service-title-line mx-auto">
                            </div>

                            <!-- TEXT + IMAGE ROW -->
                            <div class="row g-4 align-items-start">

                                <!-- LEFT: text + features -->
                                <div class="col-lg-6">

                                    <!-- <?php if (!empty($section['text'])): ?>
                                        <p class="service-block-text"><?= $section['text'] ?></p>
                                    <?php endif; ?> -->

                                    <?php if (!empty($section['features'])): ?>
                                        <h6 class="service-caps-title fw-bold mb-2">Key Capabilities</h6>
                                        <ul class="service-features-list">
                                            <?php foreach ($section['features'] as $feature): ?>
                                                <?php if ($feature): ?>
                                                    <li><?= $feature ?></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                </div>

                                <!-- RIGHT: image -->
                                <div class="col-lg-6">
                                    <?php if (!empty($section['image'][0])): ?>
                                        <img src="<?= $section['image'][0] ?>"
                                            alt="<?= $section['title'] ?>"
                                            class="img-fluid rounded-3 w-100 service-block-img">
                                    <?php endif; ?>
                                </div>

                            </div>

                        </section>

                    <?php endforeach; ?>

                </div>
            </div>

        </div>
    </div>

</section>