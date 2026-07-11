<?php
include("includes/head.php");
include("includes/data/termsOfServicesData.php");
?>

<body>

    <?php include("includes/header.php"); ?>

    <main>

        <section class="policy-page py-4">
            <div class="container">

                <div class="row">
                    <!-- CONTENT -->
                    <div class="">

                        <?php foreach ($TermsOfService as $key => $policy): ?>

                            <div class="policy-content <?php echo $key === 'terms' ? 'active' : '' ?>" id="<?php echo $key ?>">

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