<!DOCTYPE html>
<?php
$page_title = "Media - State Corps";
include("includes/head.php");
include("includes/data/mediadata.php");

function parseMediaDate($date)
{
    $clean = str_replace(',', '', $date); // remove comma
    return strtotime($clean) ?: 0;
}
$active_tab = $_GET['tab'] ?? 'news';

// Building recents: merge all items, tag with type, sort newest-first, take 5
$all_recents = [];
foreach ($media as $type => $items) {
    foreach ($items as $item) {
        $item['_type'] = ucfirst($type);
        $all_recents[] = $item;
    }
}
usort($all_recents, function ($a, $b) {
    return parseMediaDate($b['date']) - parseMediaDate($a['date']);
});
$recents = array_slice($all_recents, 0, 5);
?>

<body>
    <?php include("includes/header.php"); ?>

    <main>
        <section class="media-page py-2">
            <div class="container">

                <div class="media-two-col">

                    <!-- ===== LEFT COLUMN: Tabs + Content ===== -->
                    <div class="media-left">

                        <!-- TABS NAV -->
                        <div class="media-menu-wrapper">
                            <ul class="media-menu">
                                <?php foreach ($media as $key => $tab): ?>
                                    <li class="<?php echo ($active_tab === $key) ? 'active' : '' ?>"
                                        data-tab="<?php echo $key ?>">
                                        <?php echo ucfirst($key) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- TAB CONTENTS -->
                        <div class="media-tab-content-wrapper">

                            <!-- NEWS -->
                            <div class="media-tab-content <?php echo ($active_tab === 'news') ? 'active' : '' ?>" id="tab-news">
                                <?php
                                $media_items = $media['news'];
                                $tab_key = 'news';
                                include("includes/components/mediasection.php");
                                ?>
                            </div>

                            <!-- EVENTS -->
                            <div class="media-tab-content <?php echo ($active_tab === 'events') ? 'active' : '' ?>" id="tab-events">
                                <?php
                                $media_items = $media['events'];
                                $tab_key = 'events';
                                include("includes/components/mediasection.php");
                                ?>
                            </div>

                            <!-- GALLERY -->
                            <div class="media-tab-content <?php echo ($active_tab === 'gallery') ? 'active' : '' ?>" id="tab-gallery">
                                <?php
                                $media_items = $media['gallery'];
                                $tab_key = 'gallery';
                                include("includes/components/mediasection.php");
                                ?>
                            </div>

                        </div>
                    </div>

                    <!-- ===== RIGHT COLUMN: Recents ===== -->
                    <div class="media-right">
                        <div class="media-recents">
                            <h4 class="media-recents__title">Recent</h4>
                            <div class="media-recents__list">
                                <?php foreach ($recents as $r): ?>
                                    <div class="media-recent-item">
                                        <span class="media-recent-item__date"><?php echo htmlspecialchars($r['date']) ?></span>
                                        <div class="media-recent-item__row">
                                            <span class="media-recent-item__type"><?php echo htmlspecialchars($r['_type']) ?></span>
                                            <p class="media-recent-item__name"><?php echo htmlspecialchars($r['title']) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                </div><!-- /.media-two-col -->

            </div>
        </section>
    </main>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/footerLink.php"); ?>

</body>