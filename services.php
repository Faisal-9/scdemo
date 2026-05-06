<!DOCTYPE html>
<?php
$page_title = "Services - State Corps";
include("includes/head.php");
include("includes/data/servicesdata.php");
?>

<body>

    <?php include("includes/header.php"); ?>

    <main>

        <section class="services-page">
            <div>
                <!-- CONTENT -->
                <div class="services-content">

                    <?php
                    $first = true;
                    foreach ($services as $key => $service):
                    ?>
                        <div id="<?php echo $key ?>" class="service-section <?php echo $first ? 'active' : '' ?>">

                            <?php include("includes/components/servicessection.php"); ?>

                        </div>
                    <?php
                        $first = false;
                    endforeach;
                    ?>

                </div>

            </div>
        </section>

    </main>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/footerLink.php"); ?>

</body>