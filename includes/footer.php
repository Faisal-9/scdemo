<?php
require_once __DIR__ . '/../app/public_bootstrap.php';
$footerContact = ContactFrontend::data()['head_office'];
$footerNavigation = Navigation::all('footer');
$footerServiceLinks = array_values(array_filter($footerNavigation, static fn(array $item): bool => (int)($item['sort_order'] ?? 0) < 100));
$footerCompanyLinks = array_values(array_filter($footerNavigation, static fn(array $item): bool => (int)($item['sort_order'] ?? 0) >= 100 && (int)($item['sort_order'] ?? 0) < 200));
$footerPolicyLinks = array_values(array_filter($footerNavigation, static fn(array $item): bool => (int)($item['sort_order'] ?? 0) >= 200));
$footerSocialLinks = [
    ['url' => (string)SiteSettings::get('social_linkedin_url', ''), 'icon' => 'fa-linkedin-in'],
    ['url' => (string)SiteSettings::get('social_facebook_url', ''), 'icon' => 'fa-facebook-f'],
    ['url' => (string)SiteSettings::get('social_x_url', ''), 'icon' => 'fa-x-twitter'],
];
?>
<footer class="site-footer">

    <div class="container">

        <!-- TOP FOOTER -->
        <div class="footer-main">

            <!-- COMPANY -->
            <div class="footer-col footer-company">

                <h2 class="footer-name"><?php echo e((string)SiteSettings::get('site_name', '')); ?></h2>

                <div class="footer-statement">
                    <?php echo nl2br(e((string)SiteSettings::get('footer_statement', ''))); ?>
                </div>

            </div>

            <!-- SERVICES -->
            <div class="footer-col">

                <h4><?php echo e((string)SiteSettings::get('footer_services_label', '')); ?></h4>

                <ul>
                    <?php foreach ($footerServiceLinks as $link): ?>
                        <li><a href="<?php echo e($link['url']); ?>"><?php echo e($link['label']); ?></a></li>
                    <?php endforeach; ?>
                </ul>

            </div>

            <!-- COMPANY -->
            <div class="footer-col">

                <h4><?php echo e((string)SiteSettings::get('footer_company_label', '')); ?></h4>

                <ul>

                    <?php foreach ($footerCompanyLinks as $link): ?>
                        <li><a href="<?php echo e($link['url']); ?>"><?php echo e($link['label']); ?></a></li>
                    <?php endforeach; ?>

                </ul>

            </div>

            <!-- CONTACT -->
            <div class="footer-col">

                <h4><?php echo e((string)SiteSettings::get('footer_contact_label', '')); ?></h4>

                <ul class="footer-contact">

                    <li>
                        <i class="fa-solid fa-location-dot"></i><?= e($footerContact['address']) ?>
                    </li>

                    <li>
                        <i class="fa-solid fa-phone"></i><?= e($footerContact['phone']) ?>
                    </li>

                    <li>
                        <i class="fa-solid fa-envelope"></i><?= e($footerContact['email']) ?>
                    </li>

                </ul>

                <div class="footer-social">

                    <?php foreach ($footerSocialLinks as $social): ?>
                        <?php if ($social['url'] === '') continue; ?>
                        <a href="<?php echo e($social['url']); ?>" target="_blank" rel="noopener noreferrer">
                            <i class="fab <?php echo e($social['icon']); ?>"></i>
                        </a>
                    <?php endforeach; ?>

                </div>

            </div>

        </div>

        <!-- FOOTER BOTTOM -->
        <div class="footer-bottom">

            <div class="footer-copyright">
                &copy; <?php echo date('Y'); ?> <?php echo e((string)SiteSettings::get('footer_copyright', '')); ?>. All Rights Reserved.
            </div>

            <div class="footer-policy">

                <?php foreach ($footerPolicyLinks as $link): ?>
                    <a href="<?php echo e($link['url']); ?>"><?php echo e($link['label']); ?></a>
                <?php endforeach; ?>

            </div>

        </div>

    </div>

</footer>