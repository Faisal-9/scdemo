<?php $current_year = date("Y"); ?>

<footer class="site-footer py-4">
    <div class="container">

        <!-- TOP SECTION -->
        <div class="footer-top row g-3 align-items-start">

            <!-- LEFT -->
            <div class="col-lg-5 col-12 footer-left text-center text-lg-start">
                <p class="footer-tagline">
                    ISO 9001:2015 Certified
                    <span class="divider-dot">|</span>
                    Building Afghanistan's Future
                </p>

                <div class="social-icons mt-3 justify-content-center justify-content-lg-start">
                    <a href="https://www.linkedin.com/company/statecorps" target="_blank" aria-label="LinkedIn">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.facebook.com/StateCorpsInc/" target="_blank" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/StateCorps" target="_blank" aria-label="Twitter">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-lg-7 col-12 footer-right">

                <div class="footer-links">
                    <ul>
                        <li><a href="sectors.php?tab=energy#energy-transmission">Transmission Lines</a></li>
                        <li><a href="sectors.php?tab=energy#energy-substations">Substations</a></li>
                        <li><a href="sectors.php?tab=structure#structure-roads">Roads &amp; Highways</a></li>
                        <li><a href="sectors.php?tab=energy#energy-hydropower">Hydropower</a></li>
                        <li><a href="sectors.php?tab=energy#energy-distribution">Distribution Networks</a></li>
                    </ul>
                </div>

            </div>

        </div>

        <!-- DIVIDER -->
        <div class="footer-divider"></div>

        <!-- BOTTOM -->
        <div class="footer-bottom">
            <div class="footer-bottom-left">
                <p>© <?= $current_year ?> State Corps. All rights reserved</p>
            </div>

            <div class="footer-bottom-right">
                <a href="#">Trademarks</a>
                <span>|</span>
                <a href="privacypolicy.php">Privacy Policy</a>
                <span>|</span>
                <a href="terms.php">Terms of Service</a>
            </div>
        </div>

    </div>
</footer>