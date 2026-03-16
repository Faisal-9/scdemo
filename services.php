<!DOCTYPE html>
<?php
$page_title = "Services - State Corps";
include("includes/head.php");
?>

<body>

    <?php include("includes/header.php"); ?>

    <section class="services-page">
        <div class="container">

            <!-- Sticky Navigation -->
            <div class="services-menu-wrapper">
                <ul class="services-menu">
                    <li class="active" data-target="planning">
                        Planning
                    </li>
                    <li data-target="designing">
                        Designing
                    </li>
                    <li data-target="tender">
                        Tender
                    </li>
                </ul>
            </div>
            <!-- Content Sections -->

            <div class="services-content">
                <div id="planning" class="service-section active">
                    <?php include("./includes/planningss.php"); ?>
                </div>
                <div id="designing" class="service-section">
                    <?php include("./includes/designss.php"); ?>
                </div>
                <div id="tender" class="service-section">
                    <?php include("./includes/tenderss.php"); ?>
                </div>
            </div>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/footerLink.php"); ?>
</body>

</html>