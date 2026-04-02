<?php
// head.php - Optimized CDN Version

if (!isset($page_title))
    $page_title = "State Corps | Engineering Afghanistan's Infrastructure Future";

if (!isset($page_description))
    $page_description = "Leading infrastructure company delivering 100+ projects valued at $600M+ for government and international partners since 2007";
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title><?php echo htmlspecialchars($page_title); ?></title>

    <!-- SEO -->
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="keywords" content="statecorps, state corps, tl in afghanistan, transmission line in afghanistan, infrastructure, engineering, Afghanistan, construction, energy, designing for constructions, transportation, government contractor">
    <meta name="author" content="State Corps Engineering">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://statecorps.com/">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta property="og:image" content="https://statecorps.com/images/og-image.jpg">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://statecorps.com/">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="twitter:image" content="https://statecorps.com/images/twitter-image.jpg">

    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon1.png" sizes="32x32">
    <link rel="apple-touch-icon" href="assets/images/apple-touch-icon.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Libraries (CDN) -->

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/navigation.css">

    <!-- Preload Important Logo -->
    <link rel="preload" as="image" href="assets/images/logo.png">

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXXXXXXX"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'UA-XXXXXXXXX');
    </script>

</head>