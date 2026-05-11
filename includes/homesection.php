<?php
include("includes/data/homedata.php");
include_once("includes/data/projectsdata.php");
include_once("includes/data/servicesdata.php");
include_once("includes/data/aboutdata.php");
include_once("includes/data/mediadata.php");

function parseMediaDate($date)
{
    $clean = str_replace(',', '', $date);
    return strtotime($clean) ?: 0;
}

$latestActivityItems = [];
foreach (['news', 'events'] as $type) {
    if (isset($media[$type]) && is_array($media[$type])) {
        foreach ($media[$type] as $item) {
            $item['_type'] = ucfirst($type);
            $latestActivityItems[] = $item;
        }
    }
}
usort($latestActivityItems, function ($a, $b) {
    return parseMediaDate($b['date']) - parseMediaDate($a['date']);
});
$latestActivityItems = array_slice($latestActivityItems, 0, 3);
?>


<!-- ================= HERO SLIDER ================= -->
<section class="slider-one-sec">
    <div class="swiper heroSwiper">

        <div class="swiper-wrapper">
            <?php foreach ($heroSlides as $slide): ?>
                <div class="swiper-slide">

                    <div class="image-layer" style="background-image:url(<?php echo $slide['image'] ?> )"></div>
                    <div class="slider-overlay"></div>
                    <div class="container">
                        <div class="slider-content">
                            <h1><?php echo $slide['title'] ?></h1>
                            <p class="hero-desc">
                                <?php echo $slide['desc'] ?>
                            </p>
                            <a href="<?php echo $slide['link'] ?>" class="hero-btn">
                                Explore Projects
                            </a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

        <!-- Indicators -->
        <div class="hero-indicators">

            <?php foreach ($heroSlides as $index => $slide): ?>
                <div class="hero-indicator-item <?php echo $index == 0 ? 'active' : '' ?>" data-index="<?php echo $index ?>">
                    <div class="hero-indicator-progress"></div>
                    <span class="hero-indicator-num">
                        <?php echo str_pad($index + 1, 2, "0", STR_PAD_LEFT) ?>
                    </span>
                    <span class="hero-indicator-title">
                        <?php echo $slide['indicator'] ?>
                    </span>

                </div>
            <?php endforeach; ?>

        </div>

    </div>

</section>


<!-- ================= ABOUT US ================= -->
<section class="index-stats-section py-4" style="background-image: linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)), url('<?php echo $statsBg ?>');">
    <div class="container">

        <div class="index-about-us-header text-center mb-4">
            <h2 class="fw-bold fs-2">Why State Corps</h2>
        </div>

        <div class="row align-items-center">

            <!-- STATS -->
            <div class="col-lg-3 col-md-12">
                <div class="row g-4 text-center text-lg-start">

                    <?php foreach ($stats as $stat): ?>
                        <div class="col-6 col-sm-6 col-md-3 col-lg-12">
                            <div class="stat-item">

                                <div class="stat-number">
                                    <span class="counter" data-target="<?php echo $stat['number'] ?>">0</span>
                                    <span class="suffix"><?php echo $stat['suffix'] ?></span>
                                </div>

                                <div class="stat-label">
                                    <?php echo $stat['label'] ?>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- TABS AREA -->
            <div class="col-lg-9 col-md-8 d-none d-md-flex">

                <section class="index-about-us">
                    <div class="index-about-us-container">

                        <!-- TABS -->
                        <ul class="nav nav-tabs border-0 mb-4">
                            <?php $first = true; ?>

                            <?php foreach ($whySC as $id => $item): ?>

                                <?php
                                if (empty($item['tabname'])) continue;
                                $label = $item['tabname'];
                                ?>

                                <li class="nav-item">
                                    <button
                                        class="nav-link serif-link <?php echo $first ? 'active' : '' ?>"
                                        data-bs-toggle="tab"
                                        data-bs-target="#why<?php echo $id ?>">

                                        <?php echo htmlspecialchars($label) ?>

                                    </button>
                                </li>

                                <?php $first = false; ?>

                            <?php endforeach; ?>
                        </ul>

                        <!-- TAB CONTENT -->
                        <div class="tab-content">

                            <?php $first = true; ?>

                            <?php foreach ($whySC as $id => $item): ?>

                                <?php
                                $hasTitle = !empty($item['title']);
                                $hasText  = !empty($item['text']);
                                $hasImage = !empty($item['image']);
                                $hasContent = $hasTitle || $hasText;
                                ?>

                                <div class="tab-pane fade <?php echo $first ? 'show active' : '' ?>" id="why<?php echo $id ?>">

                                    <div class="row align-items-stretch g-4">

                                        <?php if ($hasContent): ?>
                                            <div class="<?php echo $hasImage ? 'col-md-6' : 'col-md-12' ?> d-flex">

                                                <div class="tab-content-box w-100">

                                                    <?php if ($hasTitle): ?>
                                                        <h2 class="text-orange mb-3">
                                                            <?php echo htmlspecialchars($item['title']) ?>
                                                        </h2>
                                                    <?php endif; ?>

                                                    <?php if ($hasText): ?>

                                                        <?php if (is_array($item['text'])): ?>

                                                            <ul class="list-unstyled mt-3">

                                                                <?php foreach ($item['text'] as $point): ?>
                                                                    <li class="d-flex align-items-start mb-3">

                                                                        <span class="me-2 text-orange">
                                                                            <i class="fa-solid fa-hand-point-right"></i>
                                                                        </span>

                                                                        <span>
                                                                            <?php echo htmlspecialchars($point) ?>
                                                                        </span>

                                                                    </li>
                                                                <?php endforeach; ?>

                                                            </ul>

                                                        <?php else: ?>

                                                            <p>
                                                                <?php echo htmlspecialchars($item['text']) ?>
                                                            </p>

                                                        <?php endif; ?>

                                                    <?php endif; ?>

                                                </div>

                                            </div>
                                        <?php endif; ?>

                                        <?php if ($hasImage): ?>
                                            <div class="<?php echo $hasContent ? 'col-md-6' : 'col-md-12' ?> d-flex">

                                                <div class="tab-image-box w-100">

                                                    <img
                                                        src="<?php echo htmlspecialchars($item['image']) ?>"
                                                        class="zoomable tab-img"
                                                        alt="<?php echo htmlspecialchars($item['title'] ?? 'image') ?>">

                                                </div>

                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>

                                <?php $first = false; ?>

                            <?php endforeach; ?>

                        </div>

                    </div>
                </section>

            </div>

        </div>

    </div>
</section>


<!-- ================= OUR SERVICES ================= -->
<section class="services-section py-4">
    <div class="container">

        <div class="section-header text-center mb-4">
            <p class="text-muted fs-5">
                Delivering end-to-end engineering, project execution, and Mining solutions tailored to your industry's demands.
            </p>
        </div>

        <div class="row g-4">
            <?php foreach ($services as $serviceKey => $service): ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="service-card h-100">

                        <div class="service-image">
                            <img src="<?php echo htmlspecialchars(isset($service['image']) ? $service['image'] : (isset($service['hero_image']) ? $service['hero_image'] : 'assets/images/default.jpg')) ?>"
                                alt="<?php echo htmlspecialchars($service['title']) ?>"
                                class="img-fluid"
                                loading="lazy">
                        </div>

                        <div class="service-content">
                            <div class="service-title">
                                <?php echo htmlspecialchars($service['title']) ?>
                            </div>

                            <ul class="service-desc">
                                <?php foreach (array_slice(isset($service['sub_services']) ? $service['sub_services'] : [], 0, 6) as $sub): ?>
                                    <li><?php echo htmlspecialchars($sub['title']) ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <a href="services.php?tab=<?php echo $serviceKey ?>"
                                class="service-btn serif-link">
                                Read More +
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>



<!-- ================= FEATURED PROJECTS ================= -->
<?php
$homepageCategories = [
    'substation' => 'Substation',
    'transmission line' => 'Transmission',
    'vertical construction' => 'Building',
    'mineral processing' => 'Mining',
];
$categoryGroups = [];
foreach ($homepageCategories as $categoryKey => $categoryLabel) {
    $categoryGroups[$categoryKey] = [
        'label' => $categoryLabel,
        'projects' => [],
        'chosen' => [],
    ];
}
if (isset($projects) && is_array($projects)) {
    foreach ($projects as $project) {
        if (!is_array($project) || !isset($project['category'])) {
            continue;
        }
        $projectCategory = strtolower(trim($project['category']));
        if (!isset($categoryGroups[$projectCategory])) {
            continue;
        }
        $categoryGroups[$projectCategory]['projects'][] = $project;
        if (isset($project['inhome']) && $project['inhome'] === 'yes') {
            $categoryGroups[$projectCategory]['chosen'][] = $project;
        }
    }
}
?>
<section class="major-projects-section py-4">
    <div class="container major-projects-container">

        <div class="text-center mb-4">
            <h2 class="fw-bold fs-2">Featured Projects</h2>
        </div>

        <div class="row g-4">
            <?php foreach ($categoryGroups as $group): ?>
                <?php if (empty($group['projects'])): ?>
                    <?php continue; ?>
                <?php endif; ?>
                <?php
                $catImageProject = null;
                foreach ($group['projects'] as $proj) {
                    if (isset($proj['catimage']) && $proj['catimage'] === 'yes') {
                        $catImageProject = $proj;
                        break;
                    }
                }
                $heroProject = $catImageProject ?: (!empty($group['chosen']) ? $group['chosen'][0] : $group['projects'][0]);
                $heroImage = isset($heroProject['thumbnail']) && trim($heroProject['thumbnail']) !== ''
                    ? $heroProject['thumbnail']
                    : 'assets/images/default.jpg';
                ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="category-project-card card border-0 h-100">
                        <div class="card-body p-2 d-flex flex-column">
                            <h3 class="card-title text-center mb-3"><?php echo htmlspecialchars($group['label']); ?></h3>
                            <div class="category-card-image mb-3">
                                <img src="<?php echo htmlspecialchars($heroImage); ?>"
                                    alt="<?php echo htmlspecialchars($heroProject['name']); ?>"
                                    class="img-fluid rounded">
                            </div>
                            <div class="category-choice mb-3">
                                <strong class="category-choice-header">Relevant Projects:</strong>
                                <?php if (!empty($group['chosen'])): ?>
                                    <ul class="mb-0 ps-3">
                                        <?php foreach ($group['chosen'] as $chosenProject): ?>
                                            <li class="chosen-project-item">
                                                <a href="projectdetails.php?id=<?php echo urlencode($chosenProject['id']); ?>"
                                                    class="text-decoration-none">
                                                    <?php echo htmlspecialchars($chosenProject['name']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <span>No chosen project</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- View All Projects Button -->
        <div class="text-center mt-4">
            <a href="projects.php" class="service-btn serif-link">
                View All Projects +
            </a>
        </div>
    </div>
</section>


<!-- ================= CLIENTS ================= -->
<section class="clients-section py-4">

    <div class="container">
        <div class="clients-container">

            <div class="text-center mb-4">
                <h2 class="fw-bold fs-2">Our Clients</h2>
            </div>

            <div class="clients-slider">
                <div class="clients-track" id="clientsTrack">
                    <?php $logos = array_merge($clients["items"], $clients["items"]); ?>
                    <?php foreach ($logos as $client): ?>
                        <div class="client-item">
                            <div class="client-logo-box">
                                <img src="<?php echo htmlspecialchars($client['logo']) ?>" class="zoomable" alt="Client Logo">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

</section>


<!-- ================= LATEST NEWS ================= -->
<section class="index-news-section py-4">
    <div class="container">

        <div class="index-news-header text-center mb-4">
            <h2 class="index-news-head fw-bold fs-2">Recent Activities</h2>
        </div>

        <div class="row g-4">

            <?php foreach ($latestActivityItems as $index => $news): ?>
                <div class="col-lg-4 col-md-6 col-12 <?php echo $index >= 1 ? 'd-none d-md-block' : '' ?>">
                    <article class="index-news-card">

                        <div class="index-news-image">
                            <img src="<?php echo htmlspecialchars($news['image']); ?>"
                                alt="<?php echo htmlspecialchars($news['title']); ?>"
                                class="img-fluid lazy"
                                loading="lazy">
                        </div>

                        <div class="index-news-content">

                            <div class="index-news-meta">
                                <span>
                                    <i class="fa-regular fa-calendar-check"></i>
                                    <?php echo htmlspecialchars($news['date']); ?>
                                </span>
                            </div>

                            <h3 class="index-news-title serif-link">
                                <a href="<?php echo isset($news['link']) ? htmlspecialchars($news['link']) : 'media.php?tab=' . strtolower(htmlspecialchars($news['_type'])); ?>">
                                    <?php echo htmlspecialchars($news['title']); ?>
                                </a>
                            </h3>

                        </div>

                    </article>
                </div>
            <?php endforeach; ?>

        </div>

        <!-- View All Button -->
        <div class="text-center mt-4">
            <a href="media.php" class="service-btn serif-link">
                View More
            </a>
        </div>

    </div>
</section>




<!-- ================= CONTACT QUICK SECTION ================= -->
<!-- <section class="index-contact-section py-4">

    <div class="container">

        // Title 
        <div class="text-center mb-2">
            <h2 class="contact-title fw-bold fs-2">
                <span>Get In</span> Touch
            </h2>
        </div>
        <div class="row">
            <div class="col-lg-10 text-center g-2">

                // Phone 
                <div class="contact-item d-flex align-items-center justify-content-center gap-2">
                    <div class="contact-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>

                    <p class="contact-text mb-0">
                        +93 700 000 000
                    </p>
                </div>

                // Address
                <div class="contact-item d-flex align-items-center justify-content-center gap-2 mt-2">
                    <div class="contact-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <div>
                        <h6 class="mb-1">Corporate Office</h6>
                        <p class="contact-text mb-0">
                            Kart-e-Char D#3, Kabul Afghanistan <br>
                            State Corps Headquarters
                        </p>
                    </div>
                </div>

                // Email 
                <div class="contact-item d-flex align-items-center justify-content-center gap-2 mt-2">
                    <div class="contact-icon">
                        <i class="fa-regular fa-envelope"></i>
                    </div>

                    <p class="contact-text mb-0">
                        comms@statecorps.com
                    </p>
                </div>

            </div>

            // Button 
            <div class="col-lg-2 text-center mt-5">
                <a href="contact.php" class="contact-btn">
                    CONTACT US
                </a>
            </div>
        </div>
    </div>

</section> -->