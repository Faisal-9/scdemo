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

                        <?php $filterCategory = strtolower($section['category'] ?? ''); ?>

                        <section id="<?= $prefix . $section['id'] ?>" class="about-section-block sector-block p-3">

                            <!-- TITLE -->
                            <div class="text-center mb-3">
                                <h2 class="service-block-title"><?= $section['title'] ?></h2>
                                <?php if (!empty($section['small-title'])): ?>
                                    <p class="service-block-subtitle text-muted"><?= $section['small-title'] ?></p>
                                <?php endif; ?>
                                <hr class="service-title-line mx-auto">
                            </div>

                            <!-- TEXT + IMAGE ROW -->
                            <div class="row g-4 align-items-stretch mb-4">

                                <!-- LEFT: text + button -->
                                <div class="col-lg-6 d-flex flex-column">

                                    <?php if (!empty($section['text'])): ?>
                                        <p class="service-block-text"><?= $section['text'] ?></p>
                                    <?php elseif (!empty($section['content'])): ?>
                                        <p class="service-block-text"><?= $section['content'] ?></p>
                                    <?php endif; ?>

                                    <!-- Projects Button pinned to bottom -->
                                    <div class="mt-auto pt-3">
                                        <a href="projects.php?category=<?= urlencode($filterCategory) ?>"
                                            class="btn sector-projects-btn">
                                            Projects
                                        </a>
                                    </div>

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

                            <!-- STATS ROW -->
                            <?php if (!empty($section['stats'])): ?>
                                <div class="sector-stats-row">
                                    <?php foreach ($section['stats'] as $stat): ?>
                                        <div class="sector-stat-item">
                                            <span class="sector-stat-value"><?= $stat['value'] ?></span>
                                            <span class="sector-stat-label"><?= $stat['label'] ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                        </section>

                    <?php endforeach; ?>

                </div>
            </div>

        </div>
    </div>
</section>