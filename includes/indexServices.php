<?php
$indexservices = [
    [
        "image" => "/assets/images/8.jpg",
        "title" => "Planning",
        "desc" => [
            "Project Identification",
            "Reconnaissance Studies",
            "Master Plan/Pre-Feasibility",
            "Technical & Economical Feasibility",
            "Hydrological Studies",
            "Geological & Hydrogeological Studies",
            "Geotechnical Studies",
        ],
        "link" => "#"
    ],
    [
        "image" => "/assets/images/slider_03.jpg",
        "title" => "Design",
        "desc" => [
            "Conceptual Design",
            "Final / Detailed Design",
            "Design Reports",
            "Technical Specifications",
            "Tender Documents",
            "Bill of Quantities",
            "Cost Estimates",
        ],
        "link" => "#"
    ],
    [
        "image" => "/assets/images/service02.jpg",
        "title" => "Tender",
        "desc" => [
            "Tender Documentation",
            "Prequalification",
            "Preparation of Special Conditions",
            "Tender Evaluation",
            "Assistance to the Client During Contract Negotiations",
            "Contract Finalization",
        ],
        "link" => "#"
    ]
];
?>

<section class="services-section">
    <div class="container">

        <div class="section-header">
            <h2 class="section-title">
                Our Services
            </h2>
            <p class="section-desc">
                Engineering Solutions For Every Industry. From design to construction, we have you covered.
            </p>
        </div>

        <div class="row g-4">
            <?php foreach ($indexservices as $service): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100">
                        <div class="service-image">
                            <img src="<?= $service['image']; ?>" alt="<?= $service['title']; ?>" class="img-fluid" loading="lazy">
                        </div>
                        <div class="service-content">
                            <div class="service-title">
                                <?= htmlspecialchars($service['title']); ?>
                            </div>
                            <ul class="service-desc">
                                <?php foreach ($service['desc'] as $item): ?>
                                    <li><?= htmlspecialchars($item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <a href="<?= $service['link']; ?>" class="service-btn">
                                Read More +
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>