<!DOCTYPE html>
<?php
$page_title = "Projects - State Corps";
include("includes/head.php");
include("includes/data/projectsdata.php");

$urlCategory = isset($_GET['category']) ? strtolower($_GET['category']) : 'all';
$urlSector = isset($_GET['sector']) ? strtolower(trim($_GET['sector'])) : 'all';
?>

<body>
    <?php include("includes/header.php"); ?>

    <main>

        <!-- ================= HERO ================= -->
        <section class="projects-hero"
            style="background-image: url('<?php echo $projecthero['background'] ?>');">
            <div class="projects-hero-overlay"></div>

            <div class="container position-relative z-2">
                <span class="hero-sub">OUR PROJECTS</span>
                <h1><?php echo $projecthero['title'] ?></h1>
                <p><?php echo $projecthero['subtitle'] ?></p>
                <div class="hero-stats">

                    <?php foreach ($projecthero['stats'] as $stat): ?>
                        <div>
                            <strong><?php echo $stat['count'] ?></strong>
                            <span><?php echo $stat['label'] ?></span>
                        </div>
                    <?php endforeach; ?>

                </div>

            </div>
        </section>


        <!-- ================= FILTERS ================= -->
        <section class="projects-page py-3">
            <div class="container">

                <div class="filters-box">

                    <div class="row align-items-center">
                        <div class="col-lg-10">
                            <div class="btn-group project-filters flex-wrap gap-2">

                                <button class="btn project-filter-btn active" data-sector="all">All</button>

                                <?php
                                $sectors = array_unique(array_map('strtolower', array_column($projects, 'sector')));
                                foreach ($sectors as $sector): ?>
                                    <button class="btn project-filter-btn" data-sector="<?php echo $sector ?>">
                                        <?php echo ucfirst($sector) ?>
                                    </button>
                                <?php endforeach; ?>

                            </div>
                        </div>

                        <div class="col-lg-2">
                            <select class="statusfilter form-select" id="statusFilter">
                                <option class="statusfilter-options" value="all">All Status</option>
                                <?php
                                $statuses = array_unique(array_map('strtolower', array_column($projects, 'status')));
                                foreach ($statuses as $status):
                                ?>
                                    <option class="statusfilter-options" value="<?php echo $status ?>"><?php echo ucfirst($status) ?></option>
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
                            data-sector="<?php echo $sector ?>">

                            <div class="d-flex justify-content-between align-items-end mb-3">
                                <h2><?php echo ucfirst($sector) ?></h2>
                                <span class="project-count"><?php echo count($items) ?> Projects</span>
                            </div>

                            <div class="project-masonry">

                                <?php foreach ($items as $index => $project): ?>
                                    <a href="projectdetails.php?id=<?php echo $project['id'] ?>"
                                        class="project-card <?php echo $index === 0 ? 'big' : '' ?> project-item"
                                        data-sector="<?php echo strtolower($project['sector']) ?>"
                                        data-status="<?php echo strtolower($project['status']) ?>"
                                        data-category="<?php echo strtolower($project['category']) ?>"
                                        data-year="<?php echo $project['completion-year'] ?>"
                                        style="background-image:url('<?php echo $project['thumbnail'] ?: 'assets/images/default.jpg' ?>')">

                                        <div class="overlay"></div>

                                        <div class="content">
                                            <span class="location"><?php echo $project['location'] ?></span>
                                            <h3 class="serif-link"><?php echo $project['name'] ?></h3>
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
        const urlSector = "<?php echo htmlspecialchars($urlSector) ?>";
        const urlCategory = "<?php echo htmlspecialchars($urlCategory) ?>";
    </script>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/footerLink.php"); ?>

</body>