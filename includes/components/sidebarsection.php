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
                        <section id="<?= $prefix . $section['id'] ?>" class="about-section-block py-4">
                            <h2><?= $section['title'] ?></h2>
                            <p><?= $section['content'] ?></p>
                        </section>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

</section>