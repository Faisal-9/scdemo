<?php
$sector = $sector ?? [];
?>

<section class="sector-modern">

    <!-- HERO -->
    <div class="sector-hero" style="background-image:url('<?php echo $sector['hero']['image'] ?? 'assets/images/default.jpg' ?>')">
        <div class="overlay">
            <div class="container">
                <p class="tag"><?php echo $sector['hero']['tag'] ?? '' ?></p>
                <h1><?php echo $sector['hero']['headline'] ?? '' ?></h1>
                <p class="sub"><?php echo $sector['hero']['sub'] ?? '' ?></p>

                <?php if (!empty($sector['hero']['cta_text'])): ?>
                    <a href="<?php echo $sector['hero']['cta_link'] ?>" class="btn-cta">
                        <?php echo $sector['hero']['cta_text'] ?>
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
                        <h3><?php echo $s['value'] ?></h3>
                        <p><?php echo $s['label'] ?></p>
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
                        <h4>Why Choose Us</h4>
                        <ul>
                            <?php foreach ($sector['why'] as $w): ?>
                                <li><?php echo $w ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($sector['areas'])): ?>
                    <div class="areas">
                        <h4>Areas of Expertise</h4>
                        <ul>
                            <?php foreach ($sector['areas'] as $a): ?>
                                <li><?php echo $a ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>

            <!-- RIGHT COLUMN -->
            <?php if (!empty($sector['project'])): ?>
                <div class="sector-project-card">
                    <h4><?php echo $sector['project']['name'] ?></h4>
                    <img src="<?php echo $sector['project']['image'] ?>" alt="">
                    <a href="<?php echo $sector['project']['cta_link'] ?>" class="btn-cta small">
                        <?php echo $sector['project']['cta_text'] ?>
                    </a>
                </div>
            <?php endif; ?>

        </div>


        <!-- DESCRIPTION -->
        <?php if (!empty($sector['description'])): ?>
            <div class="sector-desc container">
                <p><?php echo $sector['description'] ?></p>
            </div>
        <?php endif; ?>

    </div>

</section>
