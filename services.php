<?php
$page_title = "Services - State Corps";
include("includes/head.php");
include("includes/data/servicesdata.php");
?>

<body>

    <?php include("includes/header.php"); ?>

    <section class="services-page">
        <div class="container">

            <!-- MENU -->
            <div class="services-menu-wrapper">
                <ul class="services-menu">
                    <?php
                    $first = true;
                    foreach ($services as $key => $service):
                    ?>
                        <li class="<?= $first ? 'active' : '' ?>"
                            data-target="<?= $key ?>">
                            <?= $service['title'] ?>
                        </li>
                    <?php $first = false;
                    endforeach; ?>
                </ul>
            </div>

            <!-- CONTENT -->
            <div class="services-content service-gallery">
                <?php
                $first = true;
                foreach ($services as $key => $service):
                ?>
                    <div id="<?= $key ?>" class="service-section <?= $first ? 'active' : '' ?>">
                        <?php
                        $prefix = $key . "-";
                        $sections = $service["sections"];
                        include("includes/components/sidebarsection.php");
                        ?>
                    </div>
                <?php
                    $first = false;
                endforeach;
                ?>
            </div>
        </div>

    </section>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/footerLink.php"); ?>

</body>