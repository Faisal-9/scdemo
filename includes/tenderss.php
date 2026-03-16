<?php

$planningSections = [
    [
        "id" => "project-identification",
        "title" => "Project Identification",
        "content" => "Identification of potential infrastructure and energy projects that align with national development priorities."
    ],
    [
        "id" => "reconnaissance",
        "title" => "Reconnaissance Studies",
        "content" => "Initial surveys and assessments to evaluate feasibility and determine project scope."
    ],
    [
        "id" => "feasibility",
        "title" => "Technical & Economical Feasibility",
        "content" => "Comprehensive evaluation of project viability including technical, environmental and financial aspects."
    ],
    [
        "id" => "hydrological",
        "title" => "Hydrological Studies",
        "content" => "Detailed water resource and hydrology analysis for energy and infrastructure projects."
    ],
];
?>

<section class="service-detail-page py-5">

    <div class="container">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3">
                <nav class="about-sidebar">
                    <ul class="nav flex-column">
                        <?php foreach ($planningSections as $i => $section): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $i == 0 ? 'active' : '' ?>" href="#<?= $section['id'] ?>">
                                    <?= $section['title'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9">
                <div data-bs-spy="scroll"
                    data-bs-target=".about-sidebar"
                    data-bs-offset="100"
                    tabindex="0"
                    class="about-content">
                    <?php foreach ($planningSections as $section): ?>
                        <section id="<?= $section['id'] ?>" class="about-section-block py-4">
                            <h2><?= $section['title'] ?></h2>
                            <p><?= $section['content'] ?></p>
                        </section>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

</section>