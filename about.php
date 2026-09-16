<!DOCTYPE html>
<?php
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
        <button type="button" class="img-close" aria-label="Close image preview">&times;</button>
        <img class="img-lightbox-content" id="lightboxImg">
    </div>

</body>

</html>