<!DOCTYPE html>
<?php
include("includes/head.php");
?>

<body>
    <!-- ================= HEADER ================= -->
    <?php include("includes/header.php"); ?>

    <!-- HOMEPAGE CONTENT -->
    <main>
        <?php include("includes/homesection.php"); ?>
    </main>

    <!-- ================= FOOTER ================= -->
    <?php include("includes/footer.php"); ?>

    <!-- ================= LINKS OF FOOTER ================= -->
    <?php include("includes/footerLink.php"); ?>


    <!-- GLOBAL IMAGE LIGHTBOX -->
    <div id="imgLightbox" class="img-lightbox">
        <button type="button" class="img-close" aria-label="Close image preview">&times;</button>
        <img class="img-lightbox-content" id="lightboxImg">
    </div>

</body>

</html>