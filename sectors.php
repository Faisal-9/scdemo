<!DOCTYPE html>
<?php
$page_title = "Sectors - State Corps";
include("includes/head.php");
include("includes/data/sectorsdata.php");
?>

<body>

    <?php include("includes/header.php"); ?>

    <main>

        <section class="sectors-page">
            <div class="container">

                <!-- SECTOR MENU -->
                <div class="sectors-menu-wrapper">
                    <ul class="sectors-menu">
                        <?php
                        $first = true;
                        foreach ($sectors as $key => $sector):
                        ?>
                            <li class="<?= $first ? 'active' : '' ?>"
                                data-target="<?= $key ?>">
                                <?= $sector['title'] ?>
                            </li>
                        <?php
                            $first = false;
                        endforeach;
                        ?>
                    </ul>
                </div>

                <!-- SECTOR CONTENT -->
                <div class="sectors-content">
                    <?php
                    $first = true;
                    foreach ($sectors as $key => $sector):
                    ?>
                        <div id="<?= $key ?>" class="sector-section <?= $first ? 'active' : '' ?>">
                            <?php
                            $prefix = $key . "-";
                            $sections = $sector["sections"];
                            include("includes/components/sectorsection.php");
                            $first = false;
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>
    </main>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/footerLink.php"); ?>

</body>