<!-- jQuery (Required for some plugins) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

<!-- Bootstrap Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Swiper Slider -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Owl Carousel -->
<script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>

<!-- Magnific Popup -->
<script src="https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/jquery.magnific-popup.min.js"></script>

<!-- Lazy Load Images -->
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script>

<!-- Local public scripts -->
<?php
$assetVersion = $assetVersion ?? (defined('ASSET_VERSION') ? (string)constant('ASSET_VERSION') : '1.0.0');
$publicBaseUrl = function_exists('baseUrl') ? baseUrl() : '';
?>
<script src="<?php echo htmlspecialchars($publicBaseUrl . 'assets/js/navigation.js?v=' . urlencode($assetVersion), ENT_QUOTES, 'UTF-8'); ?>" defer></script>
<script src="<?php echo htmlspecialchars($publicBaseUrl . 'assets/js/main.js?v=' . urlencode($assetVersion), ENT_QUOTES, 'UTF-8'); ?>" defer></script>