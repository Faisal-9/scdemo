<?php
$clients = [
    "/assets/images/clients/client_ABC_resized.png",
    "/assets/images/clients/client_ADB_resized.png",
    "/assets/images/clients/client_dabs_resized.png",
    "/assets/images/clients/client_fao_resized.png",
    "/assets/images/clients/client_metq_resized.png",
    "/assets/images/clients/client_mew_resized.png",
    "/assets/images/clients/client_unops_resized.png",
    "/assets/images/clients/client_usace_resized.png",
    "/assets/images/clients/client_wfp_resized.png",
    "/assets/images/clients/client_worldbank_resized.png",
];
?>

<section class="clients-section">

    <div class="container">
        <div class="container clients-container">
            <div class="clients-slider">
                <?php foreach (array_merge($clients, $clients) as $logo): ?>
                    <div class="client-item">
                        <img src="<?= $logo ?>" alt="Client Logo">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</section>