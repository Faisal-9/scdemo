<?php
$media_items = $media_items ?? [];
$items_per_page = 5;
$total = count($media_items);
$featured = $media_items[0] ?? null;
$sidebar_items = array_slice($media_items, 1);
$sidebar_pages = ceil(count($sidebar_items) / $items_per_page);
?>

<?php if ($featured): ?>
    <div class="media-layout">

        <!-- LEFT: Featured item -->
        <div class="media-featured">
            <div class="media-featured-img-wrap">
                <img src="<?= $featured['image'] ?>" alt="<?= $featured['title'] ?>" class="media-featured-img">
                <span class="media-featured-date"><?= $featured['date'] ?></span>
            </div>
            <div class="media-featured-body">
                <h2 class="media-featured-title"><?= $featured['title'] ?></h2>
                <p class="media-featured-desc"><?= $featured['description'] ?></p>
                <?php if (!empty($featured['tags'])): ?>
                    <div class="media-tags">
                        <?php foreach ($featured['tags'] as $tag): ?>
                            <span class="media-tag"><?= $tag ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- RIGHT: Sidebar list -->
        <div class="media-sidebar">

            <div class="media-sidebar-list" id="mediaSidebarList" data-items-per-page="<?= $items_per_page ?>">
                <?php foreach ($sidebar_items as $i => $item): ?>
                    <div class="media-sidebar-item <?= $i >= $items_per_page ? 'd-none media-hidden' : '' ?>"
                        data-page="<?= floor($i / $items_per_page) ?>"
                        data-image="<?= $item['image'] ?>"
                        data-desc='<?= htmlspecialchars($item['description'], ENT_QUOTES) ?>'
                        data-tags='<?= json_encode($item['tags'] ?? []) ?>'>
                        <span class="media-sidebar-date"><?= $item['date'] ?></span>
                        <h5 class="media-sidebar-title"><?= $item['title'] ?></h5>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Prev / Next -->
            <?php if ($sidebar_pages > 1): ?>
                <div class="media-sidebar-nav">
                    <button class="media-nav-btn" id="mediaPrev" onclick="mediaPage(-1)" disabled>Prev</button>
                    <button class="media-nav-btn" id="mediaNext" onclick="mediaPage(1)">Next</button>
                </div>
            <?php endif; ?>

        </div>

    </div>
<?php endif; ?>