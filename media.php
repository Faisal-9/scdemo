<!DOCTYPE html>
<?php
$page_title = "Media - State Corps";
include("includes/head.php");
include("includes/data/mediadata.php");
?>

<body>
    <?php include("includes/header.php"); ?>

    <main>

        <section class="media-page py-2">
            <div class="container">

                <!-- MEDIA TABS -->
                <div class="media-menu-wrapper">
                    <ul class="media-menu d-flex justify-content-center flex-wrap">
                        <?php
                        $first = true;
                        foreach ($media as $key => $tab):
                        ?>
                            <li class="<?= $first ? 'active' : '' ?>" data-tab="<?= $key ?>">
                                <?= ucfirst($key) ?>
                            </li>
                        <?php
                            $first = false;
                        endforeach;
                        ?>
                    </ul>
                </div>

                <!-- TAB CONTENTS -->
                <div class="media-tab-content-wrapper">
                    <!-- NEWS -->
                    <div class="media-tab-content active" id="tab-news">
                        <?php
                        $media_items = $media['news'];
                        include("includes/components/mediasection.php");
                        ?>
                    </div>

                    <!-- EVENTS -->
                    <div class="media-tab-content" id="tab-events">
                        <?php
                        $media_items = $media['events'];
                        include("includes/components/mediasection.php");
                        ?>
                    </div>

                    <!-- GALLERY -->
                    <div class="media-tab-content" id="tab-gallery">
                        <?php
                        $media_items = $media['gallery'];
                        include("includes/components/mediasection.php");
                        ?>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/footerLink.php"); ?>

</body>