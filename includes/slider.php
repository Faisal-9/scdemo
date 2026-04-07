<?php
include("includes/data/indexdata.php");
?>

<section class="slider-one-sec">
    <div class="swiper heroSwiper">

        <div class="swiper-wrapper">
            <?php foreach ($heroSlides as $slide): ?>
                <div class="swiper-slide">

                    <div class="image-layer" style="background-image:url(<?= $slide['image'] ?>)"></div>
                    <div class="slider-overlay"></div>
                    <div class="container">
                        <div class="slider-content">
                            <h3><?= $slide['subtitle'] ?></h3>
                            <h1><?= $slide['title'] ?></h1>
                            <a href="<?= $slide['link'] ?>" class="hero-btn">
                                <?= $slide['button'] ?>
                            </a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

        <!-- Indicators -->
        <div class="hero-indicators">

            <?php foreach ($heroSlides as $index => $slide): ?>
                <div class="hero-indicator-item <?= $index == 0 ? 'active' : '' ?>" data-index="<?= $index ?>">

                    <div class="hero-indicator-progress"></div>
                    <span class="hero-indicator-num">
                        <?= str_pad($index + 1, 2, "0", STR_PAD_LEFT) ?>
                    </span>
                    <span class="hero-indicator-title">
                        <?= $slide['indicator'] ?>
                    </span>

                </div>
            <?php endforeach; ?>

        </div>

    </div>

</section>