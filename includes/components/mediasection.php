<?php
$media_items = $media_items ?? [];
$tab_key     = $tab_key ?? 'items';

usort($media_items, function ($a, $b) {
    return parseMediaDate($b['date']) - parseMediaDate($a['date']);
});

$initial_show = 5;
?>

<div class="tab-main-list"
    id="list-<?= $tab_key ?>"
    data-tab="<?= $tab_key ?>"
    data-visible="<?= $initial_show ?>">

    <?php if (empty($media_items)): ?>
        <p class="no-items">No items available.</p>
    <?php else: ?>

        <?php foreach ($media_items as $i => $item): ?>
            <article class="media-card <?= $i >= $initial_show ? 'media-card--hidden' : '' ?>"
                data-index="<?= $i ?>">

                <!-- IMAGE -->
                <div class="media-card__img-wrap">
                    <img src="<?= htmlspecialchars($item['image']) ?>"
                        alt="<?= htmlspecialchars($item['title']) ?>"
                        class="media-card__img"
                        loading="lazy">

                    <?php if (!empty($item['tags'])): ?>
                        <div class="media-card__tags">
                            <?php foreach ($item['tags'] as $tag): ?>
                                <span class="media-card__tag"><?= htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- BODY -->
                <div class="media-card__body">

                    <span class="media-card__date">
                        <?= htmlspecialchars($item['date']) ?>
                    </span>

                    <h3 class="media-card__title">
                        <?= htmlspecialchars($item['title']) ?>
                    </h3>

                    <?php if (!empty($item['description'])): ?>
                        <p class="media-card__desc">
                            <?= htmlspecialchars($item['description']) ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($item['link'])): ?>
                        <div class="media-card__reference">
                            Reference:
                            <a href="<?= htmlspecialchars($item['link']) ?>" target="_blank">
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
                    data-tab="<?= $tab_key ?>">
                    Show More
                </button>
            </div>
        <?php endif; ?>

    <?php endif; ?>

</div>