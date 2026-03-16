<?php
$stats = [
    ['number' => 20, 'suffix' => 'year', 'label' => 'Years of Excellence'],
    ['number' => 100, 'suffix' => '+', 'label' => 'Completed Projects'],
    ['number' => 600, 'suffix' => 'M+', 'label' => 'Total Project Value'],
    ['number' => 4, 'suffix' => '+', 'label' => 'Active Global Offices'],
];
?>

<section class="index-stats-section">

    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <div class="row g-4 stats-grid">
                    <?php foreach ($stats as $stat): ?>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-number">
                                    <span class="counter" data-target="<?= $stat['number'] ?>">0</span>
                                    <span class="suffix"><?= $stat['suffix'] ?></span>
                                </div>
                                <div class="stat-label">
                                    <?= $stat['label'] ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="stats-info-box">
                    <h3>
                        State Corps In Numbers
                    </h3>

                    <p>
                        State Corps is a leading infrastructure company in Afghanistan, delivering over 100 projects valued at $600M+ since 2007. With a strong focus on quality and client satisfaction, we have successfully completed a wide range of projects for government and international partners. Our commitment to excellence and innovation has established us as a trusted partner in shaping Afghanistan's infrastructure future.
                    </p>

                    <a href="#" class="stats-btn">
                        SEE MORE +
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>