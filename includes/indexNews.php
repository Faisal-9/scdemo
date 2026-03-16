<?php

$newsItems = [
    [
        'image' => 'assets/images/gardez.jpg',
        'author' => 'Mayar',
        'comments' => '2 Sep, 2025',
        'title' => 'Completion of named project'
    ],
    [
        'image' => 'assets/images/gardiz.jpg',
        'author' => 'Mayar',
        'comments' => '2 Sep, 2025',
        'title' => 'A look to our 70% completed project'
    ],
    [
        'image' => 'assets/images/gulbahar.jpg',
        'author' => 'Mayar',
        'comments' => '2 Sep, 2025',
        'title' => 'Afghanistan 6th International EXRO Participation'
    ]
];
?>


<section class="index-news-section section-padding">
    <div class="container">
        <div class="index-news-header">
            <h2 class="index-news-head">Recent Activities</h2>
        </div>

        <div class="row g-4">

            <?php foreach ($newsItems as $news): ?>
                <div class="col-lg-4 col-md-6">
                    <article class="index-news-card">
                        <div class="index-news-image">
                            <img src="<?= $news['image']; ?> " alt="<?= $news['title']; ?>" class="img-fluid lazy" loading="lazy">
                        </div>
                        <div class="index-news-content">
                            <div class="index-news-meta">
                                <span>
                                    <i class="fa-regular fa-user"></i>
                                    Posted by: <?= $news['author']; ?>
                                </span>
                                <span>
                                    <i class="fa-regular fa-calendar-check"></i>
                                    <?= $news['comments']; ?>
                                </span>
                            </div>
                            <h3 class="index-news-title">
                                <a href="#">
                                    <?= htmlspecialchars($news['title']); ?>
                                </a>
                            </h3>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>

        </div>

    </div>
</section>