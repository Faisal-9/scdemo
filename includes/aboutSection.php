<?php

$generalInfo = [
    'general_info-image' => '/assets/images/growth.jpg',
    'general_info-content' => 'Over the past two decade, we have grown into one of Afghanistan\'s largest and most valuable companies — with offices in USA, Turkey, and Uzbekistan and an expanding global presence — built on a commitment to delivering complete, high-quality project solutions that improve the communities we serve. 
    Starting with multi-million dollar construction projects for the U.S. Army Corps of Engineers (USACE), we expanded into the energy sector, where we now specialize in high-voltage transmission lines, substations, and power distribution networks. With few Afghan companies capable of operating at this scale, energy is our core focus — and with a proven track record, skilled workforce, and unwavering commitment to quality, we are on course to become Afghanistan\'s leading energy company.'
];

$mission_vision = [
    'mission_img' => '/assets/images/growth.jpg',
    'mission' => "State Corps' mission is to strengthen Afghanistan's future by delivering high-impact projects across transportation, manufacturing, energy, and mining — creating lasting economic value and advancing the nation toward self-reliance and sustainable growth.",
    'vision_img' => '/assets/images/growth.jpg',
    'vision' => "State Corps aspires to be Afghanistan's leading strategic investor and developer — advancing progress across Transportation, Manufacturing, Energy, and Mining through innovation, strategic partnerships, and responsible investment."
];

$milestones = [
    ['year' => '2007', 'text' => 'State Corps Established', 'description' => 'Establishment of the company in Afghanistan.'],
    ['year' => '2010', 'text' => 'First Major Project', 'description' => 'Completion of
    significant energy infrastructure project.'],
    ['year' => '2014', 'text' => 'International Expansion', 'description' => 'Established headquarters in Türkiye and USA.'],
    ['year' => '2021', 'text' => 'Project Milestone', 'description' => 'Completed over 60 projects valued more than 400 million in USD.'],
    ['year' => '2024', 'text' => 'MOEW &  DABS Recognition Award ', 'description' => 'Awarded for having successful Projects.'],
    ['year' => '2025', 'text' => 'UZBEK-AFGHAN Projects', 'description' => 'MEW TL, SS & Distribution.'],
];

$clientData = [
    ['logo' => '/assets/images/clients/client_ABC_resized.png'],
    ['logo' => '/assets/images/clients/client_ADB_resized.png'],
    ['logo' => '/assets/images/clients/client_dabs_resized.png'],
    ['logo' => '/assets/images/clients/client_fao_resized.png'],
    ['logo' => '/assets/images/clients/client_metq_resized.png'],
    ['logo' => '/assets/images/clients/client_mew_resized.png'],
    ['logo' => '/assets/images/clients/client_unops_resized.png'],
    ['logo' => '/assets/images/clients/client_usace_resized.png'],
    ['logo' => '/assets/images/clients/client_worldbank_resized.png'],
    ['logo' => '/assets/images/clients/client_wfp.png']
];

$sisterCompanies = [
    [
        'name' => 'AryaMineral',
        'logo' => '/assets/images/Scompany/Scom_aryamineral.png',
        'description' => 'Professional exploration, expliotation, processing and trading of minerals in Afghanistan'
    ],
    [
        'name' => 'Aeroparcel',
        'logo' => '/assets/images/Scompany/Scom_aeroparcel.png',
        'description' => 'Worldwide agents Aeroparcel offer access to a smarter, simpler and global supply chain'
    ],
    [
        'name' => 'Petropool',
        'logo' => '/assets/images/Scompany/Scom_petropool.png',
        'description' => 'Operates a number of well-located, finest-quality motor fuel services all across Afghanistan'
    ],
];

$awards = [
    [
        'name' => 'Quality Management Systems',
        'logo' => '/assets/images/awards/1_Cert.jpg'
    ],
    [
        'name' => 'Enviromental Management Systems',
        'logo' => '/assets/images/awards/2_Cert.jpg'
    ],
    [
        'name' => 'Health & Safety Management Systems',
        'logo' => '/assets/images/awards/3_Cert.jpg'
    ],
];

$certificates = [
    [
        'name' => 'Quality Management Systems',
        'logo' => '/assets/images/ISO_Certificates/ISO1.jpg'
    ],
    [
        'name' => 'Enviromental Management Systems',
        'logo' => '/assets/images/ISO_Certificates/ISO2.jpg'
    ],
    [
        'name' => 'Health & Safety Management Systems',
        'logo' => '/assets/images/ISO_Certificates/ISO3.jpg'
    ],
];
?>

<section class="about-page-section py-5">

    <div class="container">
        <div class="row">

            <!-- SIDEBAR -->

            <div class="col-lg-3">

                <nav id="aboutSidebar" class="about-sidebar">

                    <ul class="nav flex-column">

                        <li class="nav-item"><a class="nav-link active" href="#general-info">General Information</a></li>
                        <li class="nav-item"><a class="nav-link" href="#mission-vision">Mission - Vision</a></li>
                        <li class="nav-item"><a class="nav-link" href="#milestones">Milestones</a></li>
                        <li class="nav-item"><a class="nav-link" href="#clients">Clients</a></li>
                        <li class="nav-item"><a class="nav-link" href="#sister">Sister Companies</a></li>
                        <li class="nav-item"><a class="nav-link" href="#awards">Awards & Recognitions</a></li>
                        <li class="nav-item"><a class="nav-link" href="#certificates">Certificates</a></li>
                    </ul>
                </nav>
            </div>

            <!-- CONTENT -->

            <div class="col-lg-9">
                <div data-bs-spy="scroll"
                    data-bs-target="#aboutSidebar"
                    data-bs-offset="100"
                    tabindex="0"
                    class="about-content">

                    <!-- WELCOMMING Information -->
                    <section id="general-info" class="about-section-block about-section-general py-4">
                        <div class="container">

                            <div class="row align-items-center g-4">
                                <h2 class="mb-1 text-center">Welcome to State Corps</h2>
                                <div class="col-lg-6">
                                    <div class="general-info-content">
                                        <p><?= $generalInfo['general_info-content'] ?></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="general-info-image">
                                        <img src="<?= $generalInfo['general_info-image'] ?>" alt="Welcome Information">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>

                    <!-- Mission Vision -->
                    <section id="mission-vision" class="about-section-block about-section-mv py-4">
                        <div class="container">
                            <h2 class="text-center">Mission & Vision</h2>
                            <div class="mv-horizontal-container">
                                <!-- Mission -->
                                <div class="mv-panel"
                                    style="background-image:url('<?= $mission_vision['mission_img'] ?>')">
                                    <div class="mv-panel-header">
                                        <h4>Mission</h4>
                                    </div>
                                    <div class="mv-panel-content">
                                        <p><?= $mission_vision['mission'] ?></p>
                                    </div>
                                </div>
                                <!-- Vision -->
                                <div class="mv-panel active"
                                    style="background-image:url('<?= $mission_vision['vision_img'] ?>')">
                                    <div class="mv-panel-header">
                                        <h4>Vision</h4>
                                    </div>
                                    <div class="mv-panel-content">
                                        <p><?= $mission_vision['vision'] ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </section>

                    <!-- Milestones -->
                    <section id="milestones" class="about-section-block about-section-miles py-4">
                        <div class="container">
                            <h2 class="text-center">Milestones</h2>
                            <div class="row g-4 align-items-start">

                                <!-- Accordion -->
                                <div class="col-12 col-lg-6">
                                    <div class="d-flex flex-column gap-2" id="milestoneAccordion">
                                        <?php foreach ($milestones as $i => $mile): ?>
                                            <div class="mile-card <?= $i === 0 ? 'active' : '' ?>">
                                                <div class="mile-header" onclick="mileToggle(this)">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span class="mile-year"><?= htmlspecialchars($mile['year']) ?></span>
                                                        <p class="mile-title"><?= htmlspecialchars($mile['text']) ?></p>
                                                    </div>
                                                    <div class="mile-icon">
                                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round">
                                                            <line x1="7" y1="2" x2="7" y2="12" />
                                                            <line x1="2" y1="7" x2="12" y2="7" class="h-line" <?= $i === 0 ? 'style="display:none"' : '' ?> />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="mile-body">
                                                    <p><?= htmlspecialchars($mile['description']) ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <!-- Image -->
                                <div class="col-12 col-lg-6">
                                    <div class="ms-img">
                                        <img src="/assets/images/taloqan.jpg" alt="Milestones" class="img-fluid rounded-3">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>

                    <!-- Clients -->
                    <section id="clients" class="about-section-block client-section py-3">

                        <div class="container">
                            <h2 class="client-title text-center mb-4">
                                CLIENTS
                            </h2>
                            <div class="row g-3 justify-content-center">
                                <?php foreach ($clientData as $client): ?>
                                    <div class="col-lg-2 col-md-3 col-2">
                                        <div class="client-card">
                                            <img src="<?= $client['logo'] ?>" alt="Client Logo">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </section>

                    <!-- Sister Companies -->
                    <section id="sister" class="about-section-block about-sister-slider py-3">
                        <div class="container">
                            <h2 class="mb-4 text-center">Sister Companies</h2>
                            <div class="swiper sisterSwiper">
                                <div class="swiper-wrapper">
                                    <?php foreach ($sisterCompanies as $company): ?>
                                        <div class="swiper-slide">
                                            <div class="client-card">
                                                <div class="client-logo">
                                                    <img src="<?= $company['logo'] ?>" alt="<?= $company['name'] ?>">
                                                </div>
                                                <h4 class="client-name"><?= $company['name'] ?></h4>
                                                <?php if (isset($company['description'])): ?>
                                                    <p class="client-description"><?= $company['description'] ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="clients-nav">
                                    <div class="swiper-button-prev sister-prev"></div>
                                    <div class="swiper-button-next sister-next"></div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Awards -->
                    <section id="awards" class="about-section-block py-2">
                        <div class="container">
                            <h2 class="mb-4 text-center">Awards & Recognitions</h2>
                            <div class="row g-4">
                                <?php foreach ($awards as $award): ?>
                                    <div class="col-lg-4 col-md-6 col-12 d-flex">
                                        <div class="award-card flex-fill">
                                            <div class="award-img">
                                                <img src="<?= $award['logo'] ?>" alt="<?= $award['name'] ?>">
                                            </div>
                                            <h5 class="award-name">
                                                <?= $award['name'] ?>
                                            </h5>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>

                    <!-- Certificates -->
                    <section id="certificates" class="about-section-block py-2">
                        <div class="container">
                            <h2 class="mb-4 text-center">Certificates</h2>
                            <div class="row g-4" justify-content-center>
                                <?php foreach ($certificates as $cert): ?>
                                    <div class="col-lg-4 col-md-6 col-12 d-flex">
                                        <div class="certificate-card flex-fill">
                                            <div class="certificate-img">
                                                <img src="<?= $cert['logo'] ?>" alt="<?= $cert['name'] ?>">
                                            </div>
                                            <h5 class="certificate-name"><?= $cert['name'] ?></h5>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>

                </div>
            </div>

        </div>

    </div>

</section>