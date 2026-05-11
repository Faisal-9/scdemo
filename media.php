<!DOCTYPE html>
<?php
$page_title = "Media - State Corps";
include("includes/head.php");
include("includes/data/mediadata.php");

function parseMediaDate($date)
{
    $clean = preg_replace('/\s*,\s*/', ' ', trim((string)$date));
    return strtotime($clean) ?: 0;
}

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'news';
if (!array_key_exists($active_tab, $media)) {
    $active_tab = 'news';
}
?>

<body>
    <?php include("includes/header.php"); ?>

    <main>
        <section class="media-page py-2">
            <div class="container">

                <div class="media-tabs-center">
                    <ul class="media-menu">
                        <?php foreach ($media as $key => $tab): ?>
                            <li class="<?php echo ($active_tab === $key) ? 'active' : '' ?>"
                                data-tab="<?php echo htmlspecialchars($key, ENT_QUOTES) ?>">
                                <?php echo ucfirst($key) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="media-tab-content-wrapper">

                    <div class="media-tab-content <?php echo ($active_tab === 'news') ? 'active' : '' ?>" id="tab-news">
                        <?php
                        $media_items = $media['news'];
                        $tab_key = 'news';
                        include("includes/components/mediasection.php");
                        ?>
                    </div>

                    <div class="media-tab-content <?php echo ($active_tab === 'events') ? 'active' : '' ?>" id="tab-events">
                        <?php
                        $media_items = $media['events'];
                        $tab_key = 'events';
                        include("includes/components/mediasection.php");
                        ?>
                    </div>

                    <div class="media-tab-content <?php echo ($active_tab === 'gallery') ? 'active' : '' ?>" id="tab-gallery">
                        <?php
                        $media_items = $media['gallery'];
                        $tab_key = 'gallery';
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