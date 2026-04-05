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
    'title' => 'Head Office - Afghanistan',
    'contact_heading' => 'CONTACT US',
    'phone' => '+93 791 811 968',
    'whatsapp' => '+93 791 811 968',
    'email' => 'comms@statecorps.com',
    'address' => 'Kart-e-char, D#3, Kabul Afghanistan',
    'qr_codes' => [
        [
            'image' => 'assets/images/WA-QR-Code.jpg',
            'label' => 'WeChat'
        ],
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
        'business-hours' => 'Monday to Friday: 9:00 - 19:00',
    ],
    [
        'title' => 'State Corps USA',
        'phone' => '+1 123-456-7890',
        'email' => 'hq@statecorps.com',
        'address' => '42426 Benfold Square Brambleton, VA 20148 United States',
        'business-hours' => 'Monday to Friday: 9:00 - 17:00',
    ],
    [
        'title' => 'State Corps Uzbekistan',
        'phone' => '+971 4 123 4567',
        'email' => 'uzbekistan@statecorps.com',
        'address' => 'abc Street, Tashkent, Uzbekistan',
        'business-hours' => 'Monday to Friday: 9:00 - 17:00',
    ],
];
?>

<section class="contact">
    <div class="container">

        <div class="contact-wrapper">

            <div class="contact-left">
                <h2><?= $head_office['title'] ?></h2>
                <h4><?= $head_office['contact_heading'] ?></h4>
                <p>Phone: <a href="tel:<?= $head_office['whatsapp'] ?>"><?= $head_office['whatsapp'] ?></a></p>
                <p>WhatsApp:<a href="https://wa.me/+93791811968" target="_blank"><?= $head_office['phone'] ?></a></p>
                <p>Email: <a href="mailto:<?= $head_office['email'] ?>"><?= $head_office['email'] ?></a></p>
                <p>Address: <?= $head_office['address'] ?></p>

                <div class="qr-box">
                    <?php foreach ($head_office['qr_codes'] as $qr): ?>
                        <div>
                            <img src="<?= $qr['image'] ?>">
                            <span><?= $qr['label'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="contact-right">
                <?php if ($success != "") { ?>
                    <p style="color:green;"><?php echo $success; ?></p>
                <?php } ?>
                <?php if ($error != "") { ?>
                    <p style="color:red;"><?php echo $error; ?></p>
                <?php } ?>
                <form class="contact-form" method="post">
                    <input type="text" name="name" placeholder="Name" required>
                    <div class="form-row">
                        <input type="text" name="phone" placeholder="Whatsapp / Tel *" required>
                        <input type="email" name="email" placeholder="Email *" required>
                    </div>
                    <textarea name="message" placeholder="Message content *" required></textarea>
                    <button class="submit-btn">Submit Message</button>
                </form>
            </div>
        </div>

        <!-- INTERNATIONAL OFFICES -->
        <div class="international-offices">
            <h2>Oversees Branches</h2>
            <p>Contact our offices worldwide for assistance and support.</p>
            <div class="office-cards">
                <?php foreach ($international_offices as $office): ?>
                    <div class="office-card">
                        <h3><?= $office['title'] ?></h3>
                        <p><b>Phone:</b> <a href="tel:<?= $office['phone'] ?>"><?= $office['phone'] ?></a></p>
                        <p><b>Email:</b> <a href="mailto:<?= $office['email'] ?>"><?= $office['email'] ?></a></p>
                        <p><b>Address:</b> <?= $office['address'] ?></p>
                        <p><b>Business Hours:</b> <?= $office['business-hours'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>