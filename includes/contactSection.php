<?php
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $to = "comms@statecorps.com";
    $subject = "New Contact Message";

    $body = "
Name: $name
Phone: $phone
Email: $email
Message: $message
";

    $headers = "From: $email";
    if (mail($to, $subject, $body, $headers)) {
        $success = "Your message has been sent successfully.";
    } else {
        $error = "Something went wrong. Please try again.";
    }
}

$head_office = [
    'title' => 'Headquarters - State Corps Afghanistan',
    'phone' => '+93 791 811 968',
    'whatsapp' => '+93 791 811 968',
    'email' => 'comms@statecorps.com',
    'address' => 'Kart-e-char, D#3, Kabul Afghanistan',
    'qr_codes' => [
        // [
        //     'image' => 'assets/images/WA-QR-Code.jpg',
        //     'label' => 'WeChat'
        // ],
        [
            'image' => 'assets/images/WA-QR-Code.jpg',
            'label' => 'WhatsApp'
        ]
    ]
];

$international_offices = [
    [
        'title' => 'State Corps Turkey',
        'phone' => '+90 212 123 4567',
        'email' => 'info@statecorps.com.tr',
        'address' => 'İnşaat Sanayi ve Ticaret A.Ş. Kuçukbakkalkoy Mah. Kuçuk Setli Sk. No:5-9 İç Kapı No:4 Ataşehir Istanbul, Türkiye 34750',
    ],
    [
        'title' => 'State Corps USA',
        'phone' => '+1 123-456-7890',
        'email' => 'hq@statecorps.com',
        'address' => '42426 Benfold Square Brambleton, VA 20148 United States',
    ],
    [
        'title' => 'State Corps Uzbekistan',
        'phone' => '+971 4 123 4567',
        'email' => 'uzbekistan@statecorps.com',
        'address' => 'abc Street, Tashkent, Uzbekistan',
    ],
];
?>

<section class="contact py-4">
    <div class="container contactcontainer rounded">

        <h1 class="contactheading text-center fw-bold mb-4 p-3">Reach Us</h1>

        <div class="text p-4 rounded shadow-sm">

            <!-- TOP ROW -->
            <div class="row g-4">

                <!-- LEFT -->
                <div class="col-lg-6">
                    <div class="p-4 rounded h-100">

                        <h2 class="fw-bold "><?php echo $head_office['title'] ?></h2>

                        <p class="mb-2">
                            <strong>Phone:</strong>
                            <a href="tel:<?php echo $head_office['phone'] ?>" class="text-decoration-none">
                                <?php echo $head_office['phone'] ?>
                            </a>
                        </p>

                        <p class="mb-2">
                            <strong>WhatsApp:</strong>
                            <a href="https://wa.me/<?php echo $head_office['whatsapp'] ?>" target="_blank" class="text-decoration-none">
                                <?php echo $head_office['whatsapp'] ?>
                            </a>
                        </p>

                        <p class="mb-2">
                            <strong>Email:</strong>
                            <a href="mailto:<?php echo $head_office['email'] ?>" class="text-decoration-none">
                                <?php echo $head_office['email'] ?>
                            </a>
                        </p>

                        <p class="mb-3">
                            <strong>Address:</strong><br>
                            <?php echo $head_office['address'] ?>
                        </p>

                        <div class="row text-center g-3 mt-3">
                            <?php foreach ($head_office['qr_codes'] as $qr): ?>
                                <div class="col-6">
                                    <div class="rounded shadow-sm">
                                        <img src="<?php echo $qr['image'] ?>" class="img-fluid mb-2" style="max-height:100px;">
                                        <div class="small fw-semibold"><?php echo $qr['label'] ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>

                <!-- RIGHT -->
                <div class="col-lg-6">
                    <div class="position-relative rounded overflow-hidden">

                        <div class="position-absolute top-end start-0 bg-black text-white px-3 py-1 small z-3">
                            Kart-e-Char, Kabul, Afghanistan
                        </div>

                        <iframe
                            src="https://maps.google.com/maps?q=34.50447374731745,69.14093396440924&z=14&output=embed"
                            class="w-100"
                            style="height: 400px; border:0;">
                        </iframe>

                    </div>
                </div>

            </div>

        </div>

        <!-- FORM -->
        <div class="bg-white p-4 rounded shadow-sm mt-4 mx-4">

            <h3 class="text-center fw-bold mb-4">Drop Message</h3>

            <?php if ($success != "") { ?>
                <div class="alert alert-success"><?php echo $success ?></div>
            <?php } ?>

            <?php if ($error != "") { ?>
                <div class="alert alert-danger"><?php echo $error ?></div>
            <?php } ?>

            <form method="post">

                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="phone" class="form-control" placeholder="Phone / WhatsApp" required>
                    </div>

                    <div class="col-md-6">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="subject" class="form-control" placeholder="Subject">
                    </div>

                    <div class="col-12">
                        <textarea name="message" class="form-control" rows="4" placeholder="Your Message..." required></textarea>
                    </div>

                    <div class="col-12 text-end">
                        <button class="btn btn-primary px-4">Submit</button>
                    </div>
                </div>

            </form>
        </div>

        <!-- INTERNATIONAL OFFICES -->
        <div class="international-offices p-5 rounded">

            <h3 class="text-white text-center fw-bold">Overseas Companies</h3>
            <p class="text-white text-center mb-4">
                Contact our offices worldwide for assistance and support.
            </p>

            <div class="row g-4">
                <?php foreach ($international_offices as $office): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="office-card h-100 p-3 bg-white rounded shadow-sm">

                            <h5 class="text-center"><?php echo $office['title'] ?></h5>

                            <p><strong>Phone:</strong>
                                <a href="tel:<?php echo $office['phone'] ?>"><?php echo $office['phone'] ?></a>
                            </p>

                            <p><strong>Email:</strong>
                                <a href="mailto:<?php echo $office['email'] ?>"><?php echo $office['email'] ?></a>
                            </p>

                            <p><strong>Address:</strong><br>
                                <span class="serif-link"><?php echo $office['address'] ?></span>
                            </p>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </div>
</section>