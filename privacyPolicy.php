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
                                    <li class="policy-tab <?= $key === 'privacy' ? 'active' : '' ?>"
                                        data-tab="<?= $key ?>">
                                        <?= $policy['title'] ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="col-lg-9">

                        <?php foreach ($policies as $key => $policy): ?>

                            <div class="policy-content <?= $key === 'privacy' ? 'active' : '' ?>" id="<?= $key ?>">

                                <h2><?= $policy['title'] ?></h2>

                                <?php foreach ($policy['sections'] as $section): ?>

                                    <h3><?= $section['title'] ?></h3>

                                    <?php if (!empty($section['content'])): ?>
                                        <p><?= $section['content'] ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($section['list'])): ?>
                                        <ul>
                                            <?php foreach ($section['list'] as $item): ?>
                                                <li><?= $item ?></li>
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