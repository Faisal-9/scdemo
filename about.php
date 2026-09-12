<!DOCTYPE html>
<?php
$page_title = "About State Corps";
include("includes/head.php");
?>

<body>

    <?php include("includes/header.php"); ?>

    <main>
        <?php require_once __DIR__ . '/app/public_bootstrap.php';
        extract(AboutFrontend::data(), EXTR_OVERWRITE);
        include("includes/aboutSection.php"); ?>
    </main>

    <?php include("includes/footer.php"); ?>

    <?php include("includes/footerLink.php"); ?>

    <!-- GLOBAL IMAGE LIGHTBOX -->
    <div id="imgLightbox" class="img-lightbox">
        <span class="img-close">&times;</span>
        <img class="img-lightbox-content" id="lightboxImg">
    </div>

</body>

</html>