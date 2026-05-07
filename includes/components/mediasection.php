<?php
$media_items = isset($media_items) ? $media_items : [];
$tab_key     = isset($tab_key) ? $tab_key : 'items';

usort($media_items, function ($a, $b) {
    return parseMediaDate($b['date']) - parseMediaDate($a['date']);
});

$initial_show = 5;
?>

<div class="tab-main-list"
    id="list-<?php echo $tab_key ?>"
    data-tab="<?php echo $tab_key ?>"
    data-visible="<?php echo $initial_show ?>">

    <?php if (empty($media_items)): ?>
        <p class="no-items">No items available.</p>
    <?php else: ?>

        <?php foreach ($media_items as $i => $item): ?>
            <article class="media-card <?php echo $i >= $initial_show ? 'media-card--hidden' : '' ?>"
                data-index="<?php echo $i ?>">

                <!-- IMAGE -->
                <div class="media-card__img-wrap">
                    <img src="<?php echo htmlspecialchars($item['image']) ?>"
                        alt="<?php echo htmlspecialchars($item['title']) ?>"
                        class="media-card__img"
                        loading="lazy">

                    <?php if (!empty($item['tags'])): ?>
                        <div class="media-card__tags">
                            <?php foreach ($item['tags'] as $tag): ?>
                                <span class="media-card__tag"><?php echo htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- BODY -->
                <div class="media-card__body">

                    <span class="media-card__date">
                        <?php echo htmlspecialchars($item['date']) ?>
                    </span>

                    <h3 class="media-card__title">
                        <?php echo htmlspecialchars($item['title']) ?>
                    </h3>

                    <?php if (!empty($item['description'])): ?>
                        <p class="media-card__desc">
                            <?php echo htmlspecialchars($item['description']) ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($item['link'])): ?>
                        <div class="media-card__reference">
                            Reference:
                            <a href="<?php echo htmlspecialchars($item['link']) ?>" target="_blank">
                                🔗 View Source
                            </a>
                        </div>
                    <?php endif; ?>

                </div>

            </article>
        <?php endforeach; ?>

        <!-- SHOW MORE -->
        <?php if (count($media_items) > $initial_show): ?>
            <div class="media-show-more-wrap">
                <button class="media-show-more-btn"
                    data-tab="<?php echo $tab_key ?>">
                    Show More
                </button>
            </div>
        <?php endif; ?>

    <?php endif; ?>

</div>