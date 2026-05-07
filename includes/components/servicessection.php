<?php
if (empty($service) || !is_array($service)): return;
endif;

if (!function_exists('renderServiceDetailPanel')) {
    function renderServiceDetailPanel(array $item, string $panelId, string $activeClass = '')
    {
?>
        <div class="detail-panel <?php echo $activeClass ?>" id="<?php echo htmlspecialchars($panelId) ?>">
            <img src="<?php echo htmlspecialchars($item['image']) ?>" class="img-fluid mb-3 zoomable service-detail-img" alt="<?php echo htmlspecialchars($item['title']) ?>">
            <h3 class="service-detail-title"><?php echo htmlspecialchars($item['title']) ?></h3>
            <p class="service-short-desc"><?php echo htmlspecialchars($item['short_desc']) ?></p>
            <div class="service-why">
                <h5 class="services-why-heading">Why Choose Our <?php echo htmlspecialchars($item['title']) ?> Service?</h5>
                <p class="service-why-text"><?php echo htmlspecialchars($item['why']) ?></p>
            </div>
            <h5>Key Features</h5>
            <ul>
                <?php foreach ($item['features'] as $feature): ?>
                    <li><?php echo htmlspecialchars($feature) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }

    function renderServiceSubMenu(array $items, string $tabId, bool &$hasActive = false)
    {
        foreach ($items as $i => $item) {
            if (isset($item['subitems']) || isset($item['items'])) {
                $groupTitle = isset($item['title']) ? $item['title'] : (isset($item['subitems']) ? 'Subitems' : 'Items');
        ?>
                <li class="group-title"><?php echo htmlspecialchars($groupTitle) ?></li>
                <ul class="group-list">
                    <?php
                    $children = isset($item['subitems']) ? $item['subitems'] : $item['items'];
                    foreach ($children as $j => $child):
                        $panelId = $tabId . '-' . $i . '-' . $j;
                        $active = $hasActive ? '' : 'active';
                        if (!$hasActive) {
                            $hasActive = true;
                        }
                    ?>
                        <li class="<?php echo $active ?>" data-target="<?php echo htmlspecialchars($panelId) ?>">
                            <?php echo htmlspecialchars($child['title']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php
            } else {
                $panelId = $tabId . '-' . $i;
                $active = $hasActive ? '' : 'active';
                if (!$hasActive) {
                    $hasActive = true;
                }
            ?>
                <li class="<?php echo $active ?>" data-target="<?php echo htmlspecialchars($panelId) ?>">
                    <?php echo htmlspecialchars($item['title']) ?>
                </li>
<?php
            }
        }
    }

    function renderServiceDetailPanels(array $items, string $tabId, bool &$hasActive = false)
    {
        foreach ($items as $i => $item) {
            if (isset($item['subitems']) || isset($item['items'])) {
                $children = isset($item['subitems']) ? $item['subitems'] : $item['items'];
                foreach ($children as $j => $child) {
                    $panelId = $tabId . '-' . $i . '-' . $j;
                    $active = $hasActive ? '' : 'active';
                    if (!$hasActive) {
                        $hasActive = true;
                    }
                    renderServiceDetailPanel($child, $panelId, $active);
                }
            } else {
                $panelId = $tabId . '-' . $i;
                $active = $hasActive ? '' : 'active';
                if (!$hasActive) {
                    $hasActive = true;
                }
                renderServiceDetailPanel($item, $panelId, $active);
            }
        }
    }
}
?>
<section class="service-page">

    <!-- ================= HERO ================= -->
    <div class="service-hero" style="background-image:url('<?php echo htmlspecialchars($service['hero_image']) ?>')">
        <div class="overlay">
            <div class="container text-center text-white">
                <h1><?php echo htmlspecialchars($service['title']) ?></h1>
                <p><?php echo htmlspecialchars($service['hero_text']) ?></p>
            </div>
        </div>
    </div>

    <!-- ================= SUB-SERVICE TABS ================= -->
    <?php
    $serviceKey = isset($key)
        ? $key
        : (isset($service['slug']) ? $service['slug'] : preg_replace('/[^a-z0-9\-]+/i', '-', strtolower(isset($service['title']) ? $service['title'] : 'service')));
    $subServices = isset($service['sub_services']) ? $service['sub_services'] : [];
    ?>

    <div class="subservice-tabs">
        <?php foreach ($subServices as $i => $sub): ?>
            <?php
            $tabId = $serviceKey . '-' . $sub['id'];
            ?>
            <button class="sub-tab <?php echo $i === 0 ? 'active' : '' ?>"
                data-sub="<?php echo htmlspecialchars($tabId) ?>">
                <?php echo htmlspecialchars($sub['title']) ?>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- ================= MAIN CONTENT ================= -->
    <div class="container mt-4">

        <?php foreach ($subServices as $sIndex => $sub): ?>
            <?php $tabId = $serviceKey . '-' . $sub['id']; ?>

            <div class="subservice-content <?php echo $sIndex === 0 ? 'active' : '' ?>"
                id="<?php echo htmlspecialchars($tabId) ?>">

                <div class="row">

                    <!-- LEFT MENU -->
                    <div class="col-lg-4 sub-sub-menu">
                        <ul class="sub-sub-list">
                            <?php $menuActive = false;
                            renderServiceSubMenu(isset($sub['items']) ? $sub['items'] : (isset($sub['subitems']) ? $sub['subitems'] : []), $tabId, $menuActive); ?>
                        </ul>
                    </div>

                    <!-- RIGHT CONTENT -->
                    <div class="col-lg-8">
                        <?php $panelActive = false;
                        renderServiceDetailPanels(isset($sub['items']) ? $sub['items'] : (isset($sub['subitems']) ? $sub['subitems'] : []), $tabId, $panelActive); ?>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>

</section>