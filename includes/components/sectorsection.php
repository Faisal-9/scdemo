<?php
$sector = $sector ?? [];
?>

<section class="sector-modern">

    <!-- HERO -->
    <div class="sector-hero" style="background-image:url('<?= $sector['hero']['image'] ?? 'assets/images/default.jpg' ?>')">
        <div class="overlay">
            <div class="container">
                <p class="tag"><?= $sector['hero']['tag'] ?? '' ?></p>
                <h1><?= $sector['hero']['headline'] ?? '' ?></h1>
                <p class="sub"><?= $sector['hero']['sub'] ?? '' ?></p>

                <?php if (!empty($sector['hero']['cta_text'])): ?>
                    <a href="<?= $sector['hero']['cta_link'] ?>" class="btn-cta">
                        <?= $sector['hero']['cta_text'] ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- STATS -->
    <div class="container">
        <?php if (!empty($sector['stats'])): ?>
            <div class="sector-stats">
                <?php foreach ($sector['stats'] as $s): ?>
                    <div class="stat">
                        <h3><?= $s['value'] ?></h3>
                        <p><?= $s['label'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>


    <div class="container">
        <div class="sector-mid">

            <!-- LEFT COLUMN -->
            <div class="sector-left">

                <?php if (!empty($sector['why'])): ?>
                    <div class="why">
                        <h3>Why Choose Us</h3>
                        <ul>
                            <?php foreach ($sector['why'] as $w): ?>
                                <li><?= $w ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($sector['areas'])): ?>
                    <div class="areas">
                        <h3>Areas of Expertise</h3>
                        <ul>
                            <?php foreach ($sector['areas'] as $a): ?>
                                <li><?= $a ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>

            <!-- RIGHT COLUMN -->
            <?php if (!empty($sector['project'])): ?>
                <div class="sector-project-card">
                    <h4><?= $sector['project']['name'] ?></h4>
                    <img src="<?= $sector['project']['image'] ?>" alt="">
                    <a href="<?= $sector['project']['cta_link'] ?>" class="btn-cta small">
                        <?= $sector['project']['cta_text'] ?>
                    </a>
                </div>
            <?php endif; ?>

        </div>


        <!-- DESCRIPTION -->
        <?php if (!empty($sector['description'])): ?>
            <div class="sector-desc container">
                <p><?= $sector['description'] ?></p>
            </div>
        <?php endif; ?>

    </div>

</section>