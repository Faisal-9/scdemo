<?php

$prefix = $prefix ?? "";
$sections = $sections ?? [];

?>

<section class="service-detail-page">

    <div class="container">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3">
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
            <div class="col-lg-9">
                <div
                    data-bs-spy="scroll"
                    data-bs-target="#<?= $prefix ?>-sidebar"
                    data-bs-offset="100"
                    tabindex="0"
                    class="about-content">
                    <?php foreach ($sections as $section): ?>

                        <section id="<?= $prefix . $section['id'] ?>" class="about-section-block p-3">
                            <div class="row align-items-start">
                                <!-- TEXT -->
                                <div class="col-lg-7">
                                    <h2><?= $section['title'] ?></h2>
                                    <?php if (!empty($section['small-title'])): ?>
                                        <p class="small-title"><?= $section['small-title'] ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($section['text'])): ?>
                                        <p><?= $section['text'] ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-5">
                                    <?php if (!empty($section['features'])): ?>
                                        <ul class="service-features">
                                            <?php foreach ($section['features'] as $feature): ?>
                                                <li><?= $feature ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>

                                <!-- IMAGE -->
                                <?php if (!empty($section['image'])): ?>
                                    <?php
                                    $images = $section['image'];
                                    $count = count($images);

                                    $col = match ($count) {
                                        1, 2 => "col-lg-6",
                                        3 => "col-lg-4",
                                        4 => "col-lg-3",
                                        default => "col-lg-3 col-md-4"
                                    };
                                    ?>
                                    <div class="col-12">
                                        <div class="row g-3 mt-3">
                                            <?php foreach ($images as $img): ?>
                                                <div class="<?= $col ?>">
                                                    <img src="<?= $img ?>"
                                                        class="img-fluid rounded shadow-sm w-100"
                                                        alt="<?= $section['title'] ?? 'Service image' ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </section>
                    <?php endforeach; ?>

                </div>
            </div>

        </div>
    </div>

</section>