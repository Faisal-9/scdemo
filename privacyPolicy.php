<?php
include("includes/head.php");
include("includes/data/privacypolicydata.php");
?>

<body>

    <?php include("includes/header.php"); ?>

    <main>

        <section class="policy-page py-4">
            <div class="container">

                <div class="row">

                    <!-- SIDEBAR -->
                    <div class="col-lg-3">
                        <div class="policy-sidebar">
                            <ul>
                                <?php foreach ($policies as $key => $policy): ?>
                                    <li class="policy-tab <?php echo $key === 'privacy' ? 'active' : '' ?>"
                                        data-tab="<?php echo $key ?>">
                                        <?php echo $policy['title'] ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="col-lg-9">

                        <?php foreach ($policies as $key => $policy): ?>

                            <div class="policy-content <?php echo $key === 'privacy' ? 'active' : '' ?>" id="<?php echo $key ?>">

                                <h2><?php echo $policy['title'] ?></h2>

                                <?php foreach ($policy['sections'] as $section): ?>

                                    <h3><?php echo $section['title'] ?></h3>

                                    <?php if (!empty($section['content'])): ?>
                                        <p><?php echo $section['content'] ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($section['list'])): ?>
                                        <ul>
                                            <?php foreach ($section['list'] as $item): ?>
                                                <li><?php echo $item ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                <?php endforeach; ?>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            </div>
        </section>

    </main>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/footerLink.php"); ?>

</body>