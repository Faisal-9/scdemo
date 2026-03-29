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

                            <div class="row justify-content-center">

                                <div class="col-lg-12 text-center">

                                    <!-- TITLE -->
                                    <h2><?= $section['title'] ?></h2>

                                    <?php if (!empty($section['small-title'])): ?>
                                        <p class="small-title"><?= $section['small-title'] ?></p>
                                    <?php endif; ?>

                                    <!-- TEXT -->
                                    <?php if (!empty($section['text'])): ?>
                                        <p class="service-text"><?= $section['text'] ?></p>
                                    <?php endif; ?>

                                    <!-- FEATURES -->
                                    <?php if (!empty($section['features'])): ?>
                                        <h5 class="features-title">Key Capabilities</h5>

                                        <div class="service-features">
                                            <?php foreach ($section['features'] as $feature): ?>
                                                <span class="feature-pill"><?= $feature ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- IMAGES -->
                                    <?php if (!empty($section['image'])): ?>
                                        <?php
                                        $images = $section['image'];
                                        $count = count($images);

                                        $col = match ($count) {
                                            1 => "col-md-8",
                                            2 => "col-md-6",
                                            3 => "col-md-4",
                                            4 => "col-md-3",
                                            default => "col-md-3"
                                        };
                                        ?>

                                        <div class="row g-3 mt-4 justify-content-center">
                                            <?php foreach ($images as $img): ?>
                                                <div class="<?= $col ?>">
                                                    <img src="<?= $img ?>"
                                                        class="img-fluid rounded shadow-sm w-100"
                                                        alt="<?= $section['title'] ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
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