<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/public_bootstrap.php';
require_once __DIR__ . '/../app/core/ContactFrontend.php';

$contact = ContactFrontend::data();
$page = $contact['page'];
$head_office = $contact['head_office'];
$international_offices = $contact['international_offices'];

$success = (isset($_GET['sent']) && $_GET['sent'] === '1') ? 'Your message has been sent successfully.' : '';
$error = (isset($_GET['sent']) && $_GET['sent'] !== '1') ? 'Something went wrong. Please try again.' : '';
$section_title = $page['section_title'] ?? 'Reach Us';
$form_title = $page['form_title'] ?? 'Drop Message';
$overseas_title = $page['overseas_title'] ?? 'Overseas Companies';
$overseas_subtitle = $page['overseas_subtitle'] ?? 'Contact our offices worldwide for assistance and support.';
$map_label = $page['map_label'] ?? 'Kart-e-Char, Kabul, Afghanistan';
$lat = (string)($page['map_lat'] ?? '34.50447374731745');
$lng = (string)($page['map_lng'] ?? '69.14093396440924');
$zoom = (int)($page['map_zoom'] ?? 14);
$map_src = 'https://maps.google.com/maps?q=' . rawurlencode($lat . ',' . $lng) . '&z=' . $zoom . '&output=embed';
?>

<section class="contact py-4">
    <div class="container contactcontainer rounded">

        <h1 class="contactheading text-center fw-bold mb-4 p-3"><?php echo htmlspecialchars($section_title, ENT_QUOTES, 'UTF-8'); ?></h1>

        <div class="text p-4 rounded shadow-sm">

            <div class="row g-4">

                <div class="col-lg-6">
                    <div class="p-4 rounded h-100">

                        <h2 class="fw-bold "><?php echo htmlspecialchars($head_office['title'], ENT_QUOTES, 'UTF-8'); ?></h2>

                        <p class="mb-2">
                            <strong>Phone:</strong>
                            <a href="tel:<?php echo htmlspecialchars($head_office['phone'], ENT_QUOTES, 'UTF-8'); ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($head_office['phone'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </p>

                        <?php if (!empty($head_office['whatsapp'])): ?>
                            <p class="mb-2">
                                <strong>WhatsApp:</strong>
                                <a href="https://wa.me/<?php echo preg_replace('/\D+/', '', (string)$head_office['whatsapp']); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                                    <?php echo htmlspecialchars($head_office['whatsapp'], ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </p>
                        <?php endif; ?>

                        <p class="mb-2">
                            <strong>Email:</strong>
                            <a href="mailto:<?php echo htmlspecialchars($head_office['email'], ENT_QUOTES, 'UTF-8'); ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($head_office['email'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </p>

                        <p class="mb-3">
                            <strong>Address:</strong><br>
                            <?php echo nl2br(htmlspecialchars($head_office['address'], ENT_QUOTES, 'UTF-8')); ?>
                        </p>

                        <div class="row text-center g-3 mt-3">
                            <?php foreach ($head_office['qr_codes'] as $qr): ?>
                                <div class="col-6">
                                    <div class="rounded shadow-sm">
                                        <img src="<?php echo htmlspecialchars($qr['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($qr['label'], ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid mb-2" style="max-height:100px;">
                                        <div class="small fw-semibold"><?php echo htmlspecialchars($qr['label'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="position-relative rounded overflow-hidden">

                        <div class="position-absolute top-end start-0 bg-black text-white px-3 py-1 small z-3">
                            <?php echo htmlspecialchars($map_label, ENT_QUOTES, 'UTF-8'); ?>
                        </div>

                        <iframe
                            src="<?php echo htmlspecialchars($map_src, ENT_QUOTES, 'UTF-8'); ?>"
                            class="w-100"
                            style="height: 400px; border:0;"
                            loading="lazy"
                            title="State Corps office map">
                        </iframe>

                    </div>
                </div>

            </div>

        </div>

        <div class="bg-white p-4 rounded shadow-sm mt-4 mx-4">

            <h3 class="text-center fw-bold mb-4"><?php echo htmlspecialchars($form_title, ENT_QUOTES, 'UTF-8'); ?></h3>

            <?php if ($success !== ''): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <?php if ($error !== ''): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form method="post" action="contact_submit.php">

                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Name" maxlength="255" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="phone" class="form-control" placeholder="Phone / WhatsApp" maxlength="100" required>
                    </div>

                    <div class="col-md-6">
                        <input type="email" name="email" class="form-control" placeholder="Email" maxlength="255" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="subject" class="form-control" placeholder="Subject" maxlength="500">
                    </div>

                    <div class="col-12">
                        <textarea name="message" class="form-control" rows="4" placeholder="Your Message..." required></textarea>
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                    </div>
                </div>

            </form>
        </div>

        <div class="international-offices p-5 rounded">

            <h3 class="text-white text-center fw-bold"><?php echo htmlspecialchars($overseas_title, ENT_QUOTES, 'UTF-8'); ?></h3>
            <p class="text-white text-center mb-4">
                <?php echo nl2br(htmlspecialchars($overseas_subtitle, ENT_QUOTES, 'UTF-8')); ?>
            </p>

            <div class="row g-4">
                <?php foreach ($international_offices as $office): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="office-card h-100 p-3 bg-white rounded shadow-sm">

                            <h5 class="text-center"><?php echo htmlspecialchars($office['title'], ENT_QUOTES, 'UTF-8'); ?></h5>

                            <?php if (!empty($office['phone'])): ?>
                                <p><strong>Phone:</strong>
                                    <a href="tel:<?php echo htmlspecialchars($office['phone'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($office['phone'], ENT_QUOTES, 'UTF-8'); ?></a>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($office['email'])): ?>
                                <p><strong>Email:</strong>
                                    <a href="mailto:<?php echo htmlspecialchars($office['email'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($office['email'], ENT_QUOTES, 'UTF-8'); ?></a>
                                </p>
                            <?php endif; ?>

                            <p><strong>Address:</strong><br>
                                <span class="serif-link"><?php echo nl2br(htmlspecialchars($office['address'], ENT_QUOTES, 'UTF-8')); ?></span>
                            </p>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </div>
</section>