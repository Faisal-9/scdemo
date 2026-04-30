<!DOCTYPE html>
<?php
$page_title = "Sectors - State Corps";
include("includes/head.php");
include("includes/data/sectorsdata.php");
$activeTab = $_GET['tab'] ?? array_key_first($sectors);
?>

<body>

    <?php include("includes/header.php"); ?>

    <main>

        <section class="sectors-page">
            <div class="">

                <!-- SECTOR CONTENT -->
                <div class="sectors-content">
                    <?php foreach ($sectors as $key => $sector): ?>
                        <div id="<?= $key ?>" class="sector-section <?= ($key === $activeTab) ? 'active' : '' ?>">
                            <?php
                            $prefix = $key . "-";
                            include("includes/components/sectorsection.php");
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