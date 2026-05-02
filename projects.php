<!DOCTYPE html>
<?php
$page_title = "Projects - State Corps";
include("includes/head.php");
include("includes/data/projectsdata.php");

$urlCategory = isset($_GET['category']) ? strtolower($_GET['category']) : 'all';
$urlSector   = isset($_GET['sector'])   ? strtolower($_GET['sector'])   : 'all';
?>

<body>
    <?php include("includes/header.php"); ?>

    <main>

        <!-- ================= HERO ================= -->
        <section class="projects-hero"
            style="background-image: url('<?= $projecthero['background'] ?>');">
            <div class="projects-hero-overlay"></div>

            <div class="container position-relative z-2">
                <span class="hero-sub">OUR PROJECTS</span>
                <h1><?= $projecthero['title'] ?></h1>
                <p><?= $projecthero['subtitle'] ?></p>
                <div class="hero-stats">

                    <?php foreach ($projecthero['stats'] as $stat): ?>
                        <div>
                            <strong><?= $stat['count'] ?></strong>
                            <span><?= $stat['label'] ?></span>
                        </div>
                    <?php endforeach; ?>

                </div>

            </div>
        </section>


        <!-- ================= FILTERS ================= -->
        <section class="projects-page py-3">
            <div class="container">

                <div class="filters-box">

                    <div class="row mb-3 align-items-center">
                        <div class="col-lg-10">
                            <div class="btn-group project-filters flex-wrap gap-2">

                                <button class="btn btn-outline-dark active" data-sector="all">All</button>

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

                        <div class="col-lg-2">
                            <select class="statusfilter form-select" id="statusFilter">
                                <option value="all">All Status</option>
                                <?php
                                $statuses = array_unique(array_map('strtolower', array_column($projects, 'status')));
                                foreach ($statuses as $status):
                                ?>
                                    <option value="<?= $status ?>"><?= ucfirst($status) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>


                <!-- ================= CATEGORY SECTIONS ================= -->

                <?php
                $grouped = [];
                foreach ($projects as $p) {
                    $grouped[strtolower($p['sector'])][] = $p;
                }
                ?>

                <div id="projectsContainer">

                    <?php foreach ($grouped as $sector => $items): ?>
                        <section class="project-category-section"
                            data-sector="<?= $sector ?>">

                            <div class="d-flex justify-content-between align-items-end mb-3">
                                <h2><?= ucfirst($sector) ?></h2>
                                <span class="project-count"><?= count($items) ?> Projects</span>
                            </div>

                            <div class="project-masonry">

                                <?php foreach ($items as $index => $project): ?>
                                    <a href="projectdetails.php?id=<?= $project['id'] ?>"
                                        class="project-card <?= $index === 0 ? 'big' : '' ?> project-item"
                                        data-sector="<?= strtolower($project['sector']) ?>"
                                        data-status="<?= strtolower($project['status']) ?>"
                                        data-category="<?= strtolower($project['category']) ?>"
                                        data-year="<?= $project['completion-year'] ?>"
                                        style="background-image:url('<?= $project['thumbnail'] ?: 'assets/images/default.jpg' ?>')">

                                        <div class="overlay"></div>

                                        <div class="content">
                                            <span class="location"><?= $project['location'] ?></span>
                                            <h3 class="serif-link"><?= $project['name'] ?></h3>
                                        </div>

                                    </a>
                                <?php endforeach; ?>

                            </div>

                        </section>
                    <?php endforeach; ?>

                </div>

            </div>
        </section>

    </main>


    <script>
        const urlSector = "<?= htmlspecialchars($urlSector) ?>";
        const urlCategory = "<?= htmlspecialchars($urlCategory) ?>";
    </script>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/footerLink.php"); ?>

</body>