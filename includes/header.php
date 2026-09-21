<?php
require_once __DIR__ . '/../app/public_bootstrap.php';

$currentPage = basename((string)($_SERVER['PHP_SELF'] ?? ''));
$headerNavigation = Navigation::all('header');
$headerTop = array_values(array_filter(
    $headerNavigation,
    static fn(array $item): bool => $item['parent_id'] === null && (int)$item['sort_order'] < 100
));
$headerMain = array_values(array_filter(
    $headerNavigation,
    static fn(array $item): bool => $item['parent_id'] === null && (int)$item['sort_order'] >= 100
));
$headerSocialLinks = [
    ['url' => (string)SiteSettings::get('social_facebook_url', ''), 'icon' => 'fa-facebook'],
    ['url' => (string)SiteSettings::get('social_x_url', ''), 'icon' => 'fa-x-twitter'],
    ['url' => (string)SiteSettings::get('social_linkedin_url', ''), 'icon' => 'fa-linkedin-in'],
];
$siteLogoSetting = (string)SiteSettings::get('site_logo', '');
$siteLogo = AssetResolver::path($siteLogoSetting) ?: $siteLogoSetting;
$headerColor = static function (string $key, string $fallback): string {
    $value = (string)SiteSettings::get($key, $fallback);
    return preg_match('/^#[0-9a-fA-F]{6}$/', $value) ? $value : $fallback;
};
$headerStyle = sprintf(
    '--header-top-bg:%s;--header-top-text:%s;--header-bottom-bg:%s;--header-bottom-text:%s;--header-hover:%s;',
    $headerColor('header_top_background_color', '#ffffff'),
    $headerColor('header_top_text_color', '#0c1c3d'),
    $headerColor('header_bottom_background_color', '#0c1c3d'),
    $headerColor('header_bottom_text_color', '#ffffff'),
    $headerColor('header_hover_color', '#d4af37')
);

$navigationIsActive = static function (array $item) use ($currentPage): bool {
    return basename((string)parse_url((string)$item['url'], PHP_URL_PATH)) === $currentPage;
};

$renderNavigationItem = null;
$renderNavigationItem = static function (array $item, string $itemClass = 'nav-item') use (&$renderNavigationItem, $navigationIsActive): void {
    $children = is_array($item['children'] ?? null) ? $item['children'] : [];
    $hasChildren = $children !== [];
    $active = $navigationIsActive($item) ? ' active' : '';
    $dropdown = $hasChildren ? ' dropdown' : '';
    $target = (string)($item['target'] ?? '_self');
    $linkClass = $itemClass === 'nav-item-top'
        ? 'nav-link-top'
        : ($itemClass === 'nav-item-child' ? 'dropdown-link' : 'nav-link');
    if ($hasChildren) {
        $linkClass .= ' has-dropdown';
    }
    ?>
    <li class="<?= e($itemClass . $dropdown . $active) ?>">
        <a href="<?= e((string)$item['url']) ?>" class="<?= e($linkClass) ?>"<?= $target === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
            <span class="nav-text"><?= e((string)$item['label']) ?></span>
            <?php if ($hasChildren): ?><span class="dropdown-arrow">▼</span><?php endif; ?>
        </a>
        <?php if ($hasChildren): ?>
            <div class="dropdown-menu">
                <ul class="dropdown-list">
                    <?php foreach ($children as $child): ?>
                        <?php $renderNavigationItem($child, 'nav-item-child'); ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </li>
    <?php
};
?>

<header class="header" style="<?= e($headerStyle) ?>">
    <div class="header-inner">
        <div class="main-navigation">
            <div class="floating-logo">
                <a href="<?= e(baseUrl('index.php')) ?>" class="logo">
                    <img src="<?= e(baseUrl($siteLogo)) ?>" alt="<?= e((string)SiteSettings::get('site_name', '')) ?>" class="logo-img">
                </a>
            </div>

            <div class="mobile-menu-toggle">
                <span></span><span></span><span></span>
            </div>

            <div class="nav-rows">
                <div class="nav-row nav-row-top">
                    <div class="container">
                        <div class="nav-row-inner">
                            <nav class="nav-menu nav-menu-top">
                                <ul class="nav-list nav-list-top">
                                    <?php foreach ($headerTop as $item): ?>
                                        <?php $renderNavigationItem($item, 'nav-item-top'); ?>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                            <div class="top-row-social">
                                <span class="social-divider"></span>
                                <?php foreach ($headerSocialLinks as $social): ?>
                                    <?php if ($social['url'] === '') continue; ?>
                                    <a href="<?= e($social['url']) ?>" class="social-link-header" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands <?= e($social['icon']) ?>"></i>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nav-row nav-row-bottom">
                    <div class="container">
                        <div class="nav-row-inner">
                            <nav class="nav-menu nav-menu-bottom">
                                <ul class="nav-list nav-list-bottom">
                                    <?php foreach ($headerMain as $item): ?>
                                        <?php $renderNavigationItem($item); ?>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
