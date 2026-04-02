<!DOCTYPE html>
<?php

include("includes/head.php");
include("includes/data/projectsdata.php");

$id = $_GET['id'] ?? '';

$project = null;

foreach ($projects as $p) {
    if ($p['id'] === $id) {
        $project = $p;
        break;
    }
}

if (!$project) {
    echo "<h2>Project not found</h2>";
    exit;
}

?>

<body>

    <?php include("includes/header.php"); ?>

    <section class="project-details py-3">
        <div class="container">

            <!-- TITLE -->
            <div class="project-title-box d-flex justify-content-center">
                <h1 class="project-main-title"><?= $project['name'] ?></h1>
            </div>

            <!-- DESCRIPTION -->
            <div class="project-description-box p-2">
                <p><?= $project['description'] ?></p>
            </div>

            <!-- TWO COLUMNS -->
            <div class="row g-4">

                <!-- LEFT: Meta + Scope -->
                <div class="col-lg-4">
                    <div class="project-info-box">

                        <!-- Client Meta -->
                         <h3 class="scope-title"> Project Information</h3>
                        <ul class="project-meta">
                            <li><b>Client:</b> <?= $project['client'] ?></li>
                            <li><b>Location:</b> <?= $project['location'] ?></li>
                            <li><b>Status:</b> <?= ucfirst($project['status']) ?></li>
                            <li><b>Sector:</b> <?= ucfirst($project['sector']) ?></li>
                            <li><b>Category:</b> <?= ucfirst($project['category']) ?></li>
                        </ul>

                        <!-- Scope of Work -->
                        <h3 class="scope-title">Project Scope</h3>
                        <ul class="scope-list">
                            <?php foreach ($project['scope'] as $s): ?>
                                <?php if ($s): ?>
                                    <li><?= $s ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>

                    </div>
                </div>

                <!-- RIGHT: Image Slider -->
                <div class="col-lg-8">
                    <div class="swiper project-gallery">
                        <div class="swiper-wrapper">
                            <?php foreach ($project['images'] as $img): ?>
                                <div class="swiper-slide">
                                    <img src="<?= $img ?>" class="img-fluid rounded">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="swiper-button-next project-next"></div>
                        <div class="swiper-button-prev project-prev"></div>
                        <div class="swiper-pagination project-pagination"></div>
                    </div>
                </div>

            </div><!-- end row -->

        </div>
    </section>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/footerLink.php"); ?>

</body>