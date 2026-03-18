<?php

/* ================= MAJOR PROJECTS ================= */
$major_projects = [
    [
        'title' => 'ABC Infrastructure Project',
        'image' => 'assets/images/3.jpg'
    ],
    [
        'title' => 'Highway Construction Project',
        'image' => 'assets/images/4.jpg'
    ],
    [
        'title' => 'International Airport Development',
        'image' => 'assets/images/5.jpg'
    ],
    [
        'title' => 'Smart City Development',
        'image' => 'assets/images/6.jpg'
    ],
    [
        'title' => 'Hydropower Energy Project',
        'image' => 'assets/images/7.jpg'
    ],
    [
        'title' => 'Mega Bridge Construction',
        'image' => 'assets/images/8.jpg'
    ],
];

/* ================= HISTORY ================= */
$history = [
    ['year' => '2006', 'title' => 'Company Founded'],
    ['year' => '2011', 'title' => 'First International Project'],
    ['year' => '2016', 'title' => 'Expanded to Global Markets'],
    ['year' => '2018', 'title' => 'Smart Infrastructure Division'],
    ['year' => '2020', 'title' => 'Renewable Energy Projects'],
    ['year' => '2023', 'title' => 'Mega Bridge Construction'],
];

/* ================= TAB CONTENT ================= */
$about_tabs = [
    'mission' => [
        'title' => 'Our Mission',
        'text' => 'To be the leading and most trusted engineering and construction partner in the region, recognized for our technical expertise and transformative impact on infrastructure and energy development.',
        'image' => 'assets/images/12.jpg'
    ],
    'vision' => [
        'title' => 'Our Vision',
        'text' => 'To engineer a sustainable and empowered future for Afghanistan through reliable energy and robust infrastructure, delivering excellence, innovation, and value in every project we undertake.',
        'image' => 'assets/images/11.jpg'
    ]
];
?>

<section class="index-about-us py-5">
    <div class="container index-about-us-container">

        <!-- Tabs -->
        <ul class="nav nav-tabs border-0 mb-4">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#projects">
                    Major Projects
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#history">
                    Our History
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#mission">
                    Our Mission
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#vision">
                    Our Vision
                </button>
            </li>
        </ul>
        <div class="tab-content">

            <!-- ================= MAJOR PROJECTS ================= -->
            <div class="tab-pane fade show active" id="projects">
                <div class="row g-4">

                    <?php foreach ($major_projects as $project): ?>
                        <div class="col-md-3">
                            <div class="history-box project-card">

                                <img src="<?= $project['image'] ?>"
                                    alt="<?= $project['title'] ?>"
                                    class="project-img">

                                <div class="project-title">
                                    <?= $project['title'] ?>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <!-- ================= OUR HISTORY ================= -->
            <div class="tab-pane fade" id="history">
                <div class="row g-4">
                    <?php foreach ($history as $item): ?>
                        <div class="col-md-4">
                            <div class="history-box p-4">
                                <h5 class="year"><?= $item['year'] ?></h5>
                                <p><?= $item['title'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ================= MISSION + VISION ================= -->
            <?php foreach ($about_tabs as $id => $tab): ?>
                <div class="tab-pane fade" id="<?= $id ?>">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="text-orange"><?= $tab['title'] ?></h2>
                            <p><?= $tab['text'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <img src="<?= $tab['image'] ?>" class="img-fluid rounded">
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</section>