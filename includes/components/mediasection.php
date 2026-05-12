<?php
$media_items = isset($media_items) ? $media_items : [];
$tab_key     = isset($tab_key) ? $tab_key : 'items';

/* SORT LATEST FIRST */
usort($media_items, function ($a, $b) {

    $dateA = strtotime(trim(str_replace(',', ' ', $a['date'] ?? '')));
    $dateB = strtotime(trim(str_replace(',', ' ', $b['date'] ?? '')));

    return $dateB <=> $dateA;
});
?>

<?php if (empty($media_items)): ?>
    <p class="no-items">No items available.</p>

<?php else: ?>

    <div class="media-split">

        <!-- LEFT SIDE -->
        <div class="media-split__list">

            <?php foreach ($media_items as $i => $item): ?>

                <div class="media-list-item <?php echo (
                                                (!empty($active_id) && $active_id === $item['id']) ||
                                                (empty($active_id) && $i === 0)
                                            ) ? 'active' : '' ?>"
                    data-target="<?php echo $tab_key . '-' . $i; ?>"
                    data-tab="<?php echo $tab_key; ?>"
                    data-id="<?php echo htmlspecialchars($item['id']); ?>">>

                    <!-- THUMBNAIL -->
                    <div class="media-list-item__thumb">

                        <img
                            src="<?php echo htmlspecialchars($item['image']); ?>"
                            alt="<?php echo htmlspecialchars($item['title']); ?>">

                    </div>

                    <!-- CONTENT -->
                    <div class="media-list-item__content">

                        <div class="media-list-item__meta">

                            <span class="media-list-item__date">
                                <?php echo htmlspecialchars($item['date']); ?>
                            </span>

                            <?php if (!empty($item['tags'][0])): ?>
                                <span class="media-list-item__first-tag">
                                    <?php echo htmlspecialchars($item['tags'][0]); ?>
                                </span>
                            <?php endif; ?>

                        </div>

                        <p class="media-list-item__title">
                            <?php echo htmlspecialchars($item['title']); ?>
                        </p>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

        <!-- RIGHT SIDE -->
        <div class="media-split__detail-wrap">

            <?php foreach ($media_items as $i => $item): ?>

                <div class="media-detail-panel <?php echo (
                                                    (!empty($active_id) && $active_id === $item['id']) ||
                                                    (empty($active_id) && $i === 0)
                                                ) ? 'active' : '' ?>"
                    id="<?php echo $tab_key . '-' . $i; ?>">

                    <div class="media-split__detail">

                        <div class="media-detail__img-wrap">
                            <img
                                src="<?php echo htmlspecialchars($item['image']); ?>"
                                alt="<?php echo htmlspecialchars($item['title']); ?>"
                                class="media-detail__img">
                        </div>

                        <div class="media-detail__body">

                            <div class="media-detail__meta">

                                <span class="media-detail__date">
                                    <?php echo htmlspecialchars($item['date']); ?>
                                </span>

                                <div class="media-detail__tags">

                                    <?php if (!empty($item['tags'])): ?>

                                        <?php foreach ($item['tags'] as $tag): ?>

                                            <span class="media-detail__tag">
                                                <?php echo htmlspecialchars($tag); ?>
                                            </span>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </div>

                            </div>

                            <h3 class="media-detail__title">
                                <?php echo htmlspecialchars($item['title']); ?>
                            </h3>

                            <div class="media-detail__desc">

                                <?php if (is_array($item['description'])): ?>

                                    <?php foreach ($item['description'] as $paragraph): ?>

                                        <p>
                                            <?php echo htmlspecialchars($paragraph); ?>
                                        </p>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <p>
                                        <?php echo htmlspecialchars($item['description']); ?>
                                    </p>

                                <?php endif; ?>

                            </div>

                            <?php if (!empty($item['link'])): ?>

                                <div class="media-detail__link">

                                    <a
                                        href="<?php echo htmlspecialchars($item['link']); ?>"
                                        target="_blank"
                                        rel="noopener"
                                        class="media-detail__ref-link">

                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">

                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                            <polyline points="15 3 21 3 21 9" />
                                            <line x1="10" y1="14" x2="21" y2="3" />

                                        </svg>

                                        View Source

                                    </a>

                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

<?php endif; ?>