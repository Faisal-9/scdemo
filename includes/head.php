<?php
// head.php - Optimized CDN Version

require_once __DIR__ . '/../app/public_bootstrap.php';
$assetVersion = defined('ASSET_VERSION') ? (string)constant('ASSET_VERSION') : '1.0.0';

if (!isset($page_title))
    $page_title = (string)SiteSettings::get('site_name', '');

if (!isset($page_description))
    $page_description = (string)SiteSettings::get('site_description', '');

$seoPageKeys = [
    'index.php' => 'home',
    'about.php' => 'about',
    'projects.php' => 'projects',
    'projectdetails.php' => 'project-details',
    'services.php' => 'services',
    'sectors.php' => 'sectors',
    'media.php' => 'media',
    'contact.php' => 'contact',
    'policies.php' => 'policies',
    'termsOfServices.php' => 'terms-of-service',
];
$seoFallback = [
    'title' => $page_title,
    'description' => $page_description,
    'keywords' => (string)SiteSettings::get('site_keywords', ''),
    'canonical_url' => '',
    'robots' => 'index,follow',
    'og_title' => $page_title,
    'og_description' => $page_description,
    'og_image' => (string)SiteSettings::get('site_logo', ''),
    'twitter_card' => 'summary_large_image',
];
$seo = $seoFallback;
$pageKey = $seoPageKeys[basename((string)($_SERVER['PHP_SELF'] ?? 'index.php'))] ?? null;
if ($pageKey !== null) {
    try {
        $seo = Seo::meta($pageKey, $seoFallback);
    } catch (Throwable $e) {
        error_log('SEO lookup unavailable: ' . $e->getMessage());
    }
}
$page_title = (string)($seo['title'] ?: $page_title);
$page_description = (string)($seo['description'] ?: $page_description);
$page_keywords = (string)($seo['keywords'] ?: $seoFallback['keywords']);
$canonical_url = (string)($seo['canonical_url'] ?: '');
$og_title = (string)($seo['og_title'] ?: $page_title);
$og_description = (string)($seo['og_description'] ?: $page_description);
$og_image = (string)($seo['og_image'] ?: $seoFallback['og_image']);
$twitter_card = (string)($seo['twitter_card'] ?: $seoFallback['twitter_card']);
AnalyticsTracker::track($page_title, $pageKey);
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title><?php echo htmlspecialchars($page_title); ?></title>

    <!-- SEO -->
    <meta name="description" content="<?php echo htmlspecialchars($page_description, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="author" content="<?php echo htmlspecialchars((string)SiteSettings::get('site_author', ''), ENT_QUOTES, 'UTF-8'); ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <?php if ($canonical_url !== ''): ?>
        <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($og_title, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($og_description, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8'); ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="<?php echo htmlspecialchars($twitter_card, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:url" content="<?php echo htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($og_title, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($og_description, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8'); ?>">

    <?php $publicBaseUrl = function_exists('baseUrl') ? baseUrl() : ''; ?>

    <!-- Favicon -->
    <link rel="icon" href="<?php echo htmlspecialchars($publicBaseUrl . 'assets/images/favicon1.png', ENT_QUOTES, 'UTF-8'); ?>" sizes="32x32">
    <link rel="apple-touch-icon" href="<?php echo htmlspecialchars($publicBaseUrl . 'assets/images/apple-touch-icon.png', ENT_QUOTES, 'UTF-8'); ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600&display=swap" rel="stylesheet">

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
    <link rel="stylesheet" href="<?php echo htmlspecialchars($publicBaseUrl . 'assets/css/navigation.css?v=' . urlencode($assetVersion), ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($publicBaseUrl . 'assets/css/styles.css?v=' . urlencode($assetVersion), ENT_QUOTES, 'UTF-8'); ?>">
    <!-- <link rel="stylesheet" href="assets/css/responsive.css?v=<?php echo time() ?>"> -->

    <!-- Preload Important Logo -->
    <link rel="preload" as="image" href="<?php echo htmlspecialchars($publicBaseUrl . (string)SiteSettings::get('site_logo', ''), ENT_QUOTES, 'UTF-8'); ?>">

</head>