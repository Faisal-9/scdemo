@extends('public.layout')
@section('title', "State Corps - Engineering Afghanistan's Infrastructure Future")
@section('content')
<main>
    @if(count($heroSlides))
    <section class="slider-one-sec">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                @foreach($heroSlides as $slide)
                <div class="swiper-slide">
                    <div class="image-layer" style="background-image:url('{{ asset($slide['image'] ?? '') }}')"></div>
                    <div class="slider-overlay"></div>
                    <div class="container">
                        <div class="slider-content">
                            <h1>{{ $slide['title'] ?? '' }}</h1>
                            <p class="hero-desc">{{ $slide['desc'] ?? '' }}</p>
                            <a href="{{ route('projects.index') }}" class="hero-btn">Explore Projects</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="hero-indicators">
                @foreach($heroSlides as $index => $slide)
                <div class="hero-indicator-item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                    <div class="hero-indicator-progress"></div>
                    <span class="hero-indicator-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="hero-indicator-title">{{ $slide['title'] ?? '' }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(count($stats))
    <section class="index-stats-section py-4" style="background-image: linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)), url('{{ asset($statsBackground) }}');">
        <div class="container">
            <div class="index-about-us-header text-center mb-4">
                <h2>Why State Corps</h2>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-12">
                    <div class="row g-4 text-center text-lg-start mt-3">
                        @foreach($stats as $stat)
                        <div class="col-6 col-sm-6 col-md-3 col-lg-12">
                            <div class="stat-item">
                                <div class="stat-number">
                                    @if(!empty($stat['prefix']))<span class="prefix">{{ $stat['prefix'] }}</span>@endif
                                    <span class="counter" data-target="{{ $stat['number'] ?? 0 }}">0</span>
                                    @if(!empty($stat['suffix']))<span class="suffix">{{ $stat['suffix'] }}</span>@endif
                                </div>
                                <div class="stat-label">{{ $stat['label'] ?? '' }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @if(count($whyStateCorps))
                <div class="col-lg-9 col-md-8 d-none d-md-flex">
                    <section class="index-about-us">
                        <div class="index-about-us-container">
                            <ul class="nav nav-tabs border-0 mb-4">@foreach($whyStateCorps as $id => $item)<li class="nav-item"><button class="nav-link serif-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#why{{ $id }}">{{ $item['tabname'] ?? '' }}</button></li>@endforeach</ul>
                            <div class="tab-content text-center">@foreach($whyStateCorps as $id => $item)<div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="why{{ $id }}">
                                    <div class="row align-items-stretch g-4">
                                        @if(!empty($item['text']))<div class="{{ !empty($item['image']) ? 'col-md-6' : 'col-md-12' }} d-flex">
                                            <div class="tab-content-box w-100">
                                                <ul class="list-unstyled mt-3">@foreach((array) $item['text'] as $point)<li class="d-flex align-items-start mb-3"><span class="me-2 text-orange"><i class="fa-solid fa-hand-point-right"></i></span><span>{{ $point }}</span></li>@endforeach</ul>
                                            </div>
                                        </div>@endif
                                        @if(!empty($item['image']))<div class="{{ !empty($item['text']) ? 'col-md-6' : 'col-md-12' }} d-flex">
                                            <div class="tab-image-box"><img src="{{ asset($item['image']) }}" class="zoomable tab-img" alt="{{ $item['title'] ?? 'State Corps' }}" loading="lazy"></div>
                                        </div>@endif
                                    </div>
                                </div>@endforeach</div>
                        </div>
                    </section>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    @if($services->count())
    <section class="services-section py-4">
        <div class="container">
            <div class="section-header text-center mb-4">
                <h2>Services</h2>
            </div>
            <div class="row g-4">
                @foreach($services as $service)<div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="service-card h-100">
                        <div class="service-image"><img src="{{ asset($service->hero_image ?: 'assets/images/default.jpg') }}" alt="{{ $service->title }}" class="img-fluid" loading="lazy"></div>
                        <div class="service-content">
                            <h3 class="service-title">{{ $service->title }}</h3>
                            <ul class="service-desc">@foreach($service->items->take(6) as $item)<li>{{ $item->title }}</li>@endforeach</ul><a href="{{ url('/services') }}" class="service-btn serif-link">Read More +</a>
                        </div>
                    </div>
                </div>@endforeach
            </div>
        </div>
    </section>
    @endif

    @if($projects->count())
    <section class="major-projects-section py-4">
        <div class="container major-projects-container">
            <div class="text-center mb-4">
                <h2>Featured Projects</h2>
            </div>
            <div class="row g-4">
                @foreach($projects->take(4) as $project)<div class="col-12 col-md-6 col-lg-3">
                    <div class="category-project-card card border-0 h-100">
                        <div class="card-body p-2 d-flex flex-column">
                            <h3 class="card-title text-center mb-3">{{ $project->category ?: 'Project' }}</h3>
                            <div class="category-card-image mb-3"><img src="{{ asset($project->thumbnail ?: 'assets/images/default.jpg') }}" alt="{{ $project->title }}" class="img-fluid rounded"></div>
                            <div class="category-choice mb-3"><strong class="category-choice-header">{{ $project->title }}</strong>
                                <p>{{ $project->location }}</p>
                            </div><a href="{{ route('projects.show', $project) }}" class="service-btn serif-link">View Project +</a>
                        </div>
                    </div>
                </div>@endforeach
            </div>
            <div class="text-center mt-4"><a href="{{ route('projects.index') }}" class="service-btn serif-link">View All Projects +</a></div>
        </div>
    </section>
    @endif

    @if(count($clients))<section class="clients-section py-4">
        <div class="container">
            <div class="clients-container">
                <div class="text-center mb-4">
                    <h2>Our Clients</h2>
                </div>
                <div class="clients-slider">
                    <div class="clients-track" id="clientsTrack">@foreach(array_merge($clients, $clients) as $client)<div class="client-item">
                            <div class="client-logo-box"><img src="{{ asset($client['logo'] ?? '') }}" alt="Client Logo"></div>
                        </div>@endforeach</div>
                </div>
            </div>
        </div>
    </section>@endif

    @if($activities->count())<section class="index-news-section py-4">
        <div class="container">
            <div class="index-news-header text-center mb-4">
                <h2 class="index-news-head">Recent Activities</h2>
            </div>
            <div class="row g-4">@foreach($activities as $activity)<div class="col-lg-4 col-md-6 col-12">
                    <article class="index-news-card">
                        <div class="index-news-image"><img src="{{ asset($activity->featured_image ?: 'assets/images/default.jpg') }}" alt="{{ $activity->title }}" class="img-fluid" loading="lazy"></div>
                        <div class="index-news-content">
                            <div class="index-news-meta"><span><i class="fa-regular fa-calendar-check"></i> {{ optional($activity->event_date)->format('F j, Y') }}</span></div>
                            <h3 class="index-news-title serif-link">{{ $activity->title }}</h3>
                        </div>
                    </article>
                </div>@endforeach</div>
            <div class="text-center mt-4"><a href="#" class="service-btn serif-link">View More</a></div>
        </div>
    </section>@endif
</main>
@endsection