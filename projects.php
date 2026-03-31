<?php
$page_title = "Projects - State Corps";
include("includes/head.php");
include("includes/data/projectsdata.php");
?>

<body>
    <?php include("includes/header.php"); ?>

    <section class="projects-page py-5">
        <div class="container">

            <!-- FILTERS -->
            <div class="row mb-4 align-items-center">
                <div class="col-lg-6">
                    <div class="btn-group project-filters flex-wrap gap-2">

                        <button class="btn btn-outline-dark active" data-sector="all">
                            All
                        </button>

                        <?php
                        $sectors = array_unique(array_map('strtolower', array_column($projects, 'sector')));
                        foreach ($sectors as $sector):
                        ?>
                            <button class="btn btn-outline-dark" data-sector="<?= $sector ?>">
                                <?= ucfirst($sector) ?>
                            </button>
                        <?php endforeach; ?>

                    </div>
                </div>

                <div class="col-lg-3">
                    <select class="form-select" id="statusFilter">
                        <option value="all">All Status</option>
                        <?php
                        $statuses = array_unique(array_map('strtolower', array_column($projects, 'status')));
                        foreach ($statuses as $status):
                        ?>
                            <option value="<?= $status ?>"><?= ucfirst($status) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-lg-3">
                    <select class="form-select" id="sortProjects">
                        <option value="newest">Newest</option>
                        <option value="oldest">Oldest</option>
                    </select>
                </div>
            </div>


            <!-- PROJECTS GRID -->
            <div class="row g-4" id="projectsGrid">
                <?php foreach ($projects as $project): ?>

                    <div class="col-lg-4 col-md-6 project-item"
                        data-sector="<?= strtolower($project['sector']) ?>"
                        data-status="<?= strtolower($project['status']) ?>"
                        data-year="<?= $project['completion-year'] ?>">

                        <a href="projectdetails.php?id=<?= $project['id'] ?>"
                            class="project-page-card d-block text-decoration-none rounded-3 overflow-hidden position-relative"
                            style="background-image: url('<?= $project['thumbnail'] ?>'); height: 260px; background-size: cover; background-position: center;">

                            <!-- Dark overlay -->
                            <div class="project-overlay"></div>


                            <!-- Top-left: location + badges -->
                            <div class="position-absolute top-0 start-0 p-3 z-3">
                                <span class="d-block text-white text-uppercase mb-2 project-location">
                                    <?= $project['location'] ?>
                                </span>
                                <div class="d-flex gap-2 flex-wrap">
                                    <span class="badge bg-secondary"><?= ucfirst($project['sector']) ?></span>
                                    <span class="badge bg-success"><?= ucfirst($project['status']) ?></span>
                                </div>
                            </div>

                            <!-- Bottom: gradient + title -->
                            <div class="position-absolute bottom-0 start-0 end-0 p-3 z-2 project-bottom-overlay">
                                <h5 class="text-white fw-semibold mb-0 fs-6 text-center">
                                    <?= $project['name'] ?>
                                </h5>
                            </div>

                        </a>

                    </div>

                <?php endforeach; ?>
            </div>

        </div>

    </section>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/footerLink.php"); ?>

</body>