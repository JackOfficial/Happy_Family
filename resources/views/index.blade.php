@extends('layouts.app')
@section('styles')

@endsection
@section('content')

<div class="container-fluid carousel-header vh-100 px-0">
    <div id="heroCarousel" class="carousel slide carousel-fade vh-100" data-bs-ride="carousel" data-bs-interval="6000">
        
        <div class="carousel-indicators custom-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        </div>
        
        <div class="carousel-inner h-100" role="listbox">
            <div class="carousel-item active vh-100">
                <div class="overlay"></div>
                <img src="{{ asset('images/banner1.png') }}" class="w-100 h-100 banner-img" alt="Building Awareness">
                <div class="carousel-caption d-flex align-items-center justify-content-center">
                    <div class="p-4 p-md-5 text-center hero-glass-card" 
                         x-data="{ show: false }" 
                         x-init="setTimeout(() => show = true, 300)" 
                         x-show="show" 
                         x-transition:enter="transition ease-out duration-1000" 
                         x-transition:enter-start="opacity-0 translate-y-5">
                        
                        <h4 class="text-accent-pink text-uppercase fw-bold mb-3 tracking-widest">Building Awareness</h4>
                        <h1 class="display-3 text-white fw-bold mb-4">Empowering Youth,<br>Preventing Pregnancies</h1>
                        <p class="mb-5 mx-auto text-light lead opacity-90 hero-subtitle">
                            Join us in spreading awareness and preventing teenage pregnancy through knowledge and empowerment. Every step counts toward a brighter future.
                        </p>
                        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center gap-3">
                            <a class="btn btn-primary btn-hero shadow-lg" href="#">Get Involved</a>
                            <a class="btn btn-outline-light btn-hero" href="/causes">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item vh-100">
                <div class="overlay"></div>
                <img src="{{ asset('images/banner1.png') }}" class="w-100 h-100 banner-img" alt="Education">
                <div class="carousel-caption d-flex align-items-center justify-content-center">
                    <div class="p-4 p-md-5 text-center hero-glass-card">
                        <h4 class="text-accent-pink text-uppercase fw-bold mb-3 tracking-widest">Transforming Education</h4>
                        <h1 class="display-4 text-white fw-bold mb-4">Education is the Key</h1>
                        <p class="mb-5 mx-auto text-light lead opacity-90 hero-subtitle">
                            Our programs educate teens on reproductive health, making informed choices, and reclaiming their potential.
                        </p>
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-primary btn-hero shadow-lg px-5" href="#">Support Our Mission</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="control-icon"><i class="fas fa-chevron-left"></i></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="control-icon"><i class="fas fa-chevron-right"></i></span>
        </button>
    </div>
</div>

  <div class="container-fluid about-section py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-xl-5">
                <div class="image-wrapper position-relative">
                    <img src="{{ asset('images/banner1.png') }}" class="img-fluid rounded-custom shadow-lg" alt="Happy Family Rwanda Welcome">
                    
                    <div class="experience-badge d-none d-sm-block animate-bounce">
                        <span class="h2 d-block mb-0">100%</span>
                        <small class="text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Compassion</small>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="content-box ps-xl-4">
                    <h5 class="brand-subtitle mb-2">About Our Organization</h5>
                    <h2 class="display-5 mb-4 brand-title">Empowering Communities in Rwanda</h2>
                    
                    <p class="lead mb-4 text-muted">
                        Happy Family Rwanda Organization (HFRO) is a compassionate NGO dedicated to creating positive change and 
                        making a lasting impact through collective action and empowerment.
                    </p>

                    <div class="custom-tabs-container">
                        <ul class="nav nav-pills modern-pills mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-story-tab" data-bs-toggle="pill" data-bs-target="#tab-1" type="button" role="tab">Our Story</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-mission-tab" data-bs-toggle="pill" data-bs-target="#tab-2" type="button" role="tab">Mission</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-vision-tab" data-bs-toggle="pill" data-bs-target="#tab-3" type="button" role="tab">Vision</button>
                            </li>
                        </ul>

                        <div class="tab-content impact-tab-content p-4 rounded-custom shadow-sm" id="pills-tabContent">
                            
                            <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
                                <h5 class="mb-3 text-purple"><i class="fas fa-history me-2 text-pink"></i>Who We Are</h5>
                                <div class="tab-description mb-4">
                                    {!! $organization->about !!}
                                </div>
                                <a href="/about" class="btn-modern-accent">
                                    Read Full Story <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>

                            <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                <h5 class="mb-3 text-purple"><i class="fas fa-bullseye me-2 text-pink"></i>Our Purpose</h5>
                                <div class="tab-description mb-4">
                                    {!! $organization->mission !!}
                                </div>
                                <a href="/contact" class="btn-modern-accent">Learn More</a>
                            </div>

                            <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                <h5 class="mb-3 text-purple"><i class="fas fa-eye me-2 text-pink"></i>Our Dream</h5>
                                <div class="tab-description mb-4">
                                    {!! $organization->vision !!}
                                </div>
                                <a href="donate" class="btn-modern-accent">Get Involved Today</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <div class="container-fluid impact-section py-5 {{ $causes->count() > 0 ? '' : 'd-none' }}">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 header-animate" style="max-width: 800px;">
            <h5 class="brand-subtitle-centered">Our Impacts</h5>
            <h1 class="display-5 brand-title-dark mb-0">Empowering Change, Transforming Lives</h1>
            <div class="title-line-center mx-auto mt-3"></div>
        </div>

        <div class="row g-4">
            @foreach ($causes as $cause)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="impact-card">
                    <div class="impact-img-container">
                        <img src="{{ asset('storage/'.$cause->mainPhoto->file_path) }}" class="img-fluid" alt="{{ $cause->cause }}">
                        <div class="impact-overlay">
                            <a href="/cause/{{ $cause->id }}" class="btn-impact-view">View Details</a>
                        </div>
                        <span class="impact-tag">Active Cause</span>
                    </div>

                    <div class="impact-content p-4">
                        <a href="/cause/{{ $cause->id }}" class="impact-card-title h5 d-block mb-3">
                            {{ $cause->name }}
                        </a>
                        <p class="impact-text mb-4">
                            {!! Str::limit(strip_tags($cause->description), 85) !!}
                        </p>
                        
                        <div class="impact-progress-wrapper mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Impact Progress</span>
                                <span class="text-purple font-weight-bold">75%</span>
                            </div>
                            <div class="progress impact-progress-bar">
                                <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <a href="/cause/{{ $cause->id }}" class="link-learn-more">
                            Learn More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>   
            @endforeach

            <div class="col-12 mt-5">
                <div class="text-center">
                    <a class="btn-modern-purple py-3 px-5 shadow-sm" href="/causes">
                        Explore All Impacts
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Stories -->
<div class="container-fluid impact-section py-5 {{ $stories->count() > 0 ? '' : 'd-none' }}" 
     x-data="{ isMobile: window.innerWidth < 992 }" 
     x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 992)">
    
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="brand-subtitle-centered mb-2">Our Impact</h5>
            <h2 class="brand-title-dark display-5 mb-3">Stories of Change</h2>
            <div class="title-line-center mx-auto mb-4"></div>
            <p class="mb-0 tab-description">Discover how Happy Family is fostering resilience and making a real impact in local communities.</p>
        </div>
        
        <div class="row g-4 impact-carousel" :class="isMobile ? 'owl-carousel owl-theme' : ''">
            @foreach ($stories as $story)
            <div class="item" :class="!isMobile ? 'col-lg-4 col-md-6' : ''">
                <div class="impact-card h-100">
                    <div class="impact-img-container">
                        @if($story->photo)
                            <img src="{{ asset('storage/' . $story->photo->file_path) }}" alt="{{ $story->title }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-image fa-3x text-muted opacity-50"></i>
                            </div>
                        @endif
                        <div class="impact-tag">{{ $story->cause->name ?? 'Community' }}</div>
                        <div class="impact-overlay">
                            <a href="{{ url('story/' . $story->slug) }}" class="btn-impact-view">View Story</a>
                        </div>
                    </div>
                    
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <a href="{{ url('story/' . $story->slug) }}" class="impact-card-title h4 mb-3">
                            {{ Str::limit($story->title, 50) }}
                        </a>
                        <p class="impact-text mb-4">
                            {!! Str::limit(strip_tags($story->summary ?? $story->content), 95) !!}
                        </p>
                        <div class="mt-auto pt-3 border-top">
                            <a href="{{ url('story/' . $story->slug) }}" class="link-learn-more">
                                READ FULL STORY <i class="fas fa-chevron-right ms-1 small"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-12 text-center mt-5">
            <a href="/stories" class="btn-modern-purple py-3 px-5">
                Explore More Stories <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>

       <div class="container-fluid counter py-5" style="background: linear-gradient(rgba(99, 16, 132, 0.8), rgba(99, 16, 132, 0.8)), url('frontend/img/volunteers-bg.jpg') center center no-repeat; background-size: cover; background-attachment: fixed;">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="brand-subtitle-centered text-white opacity-90 mb-2" style="letter-spacing: 3px;">Achievements</h5>
            <h2 class="display-5 text-white font-weight-bold mb-3">Our Impact in Numbers</h2>
            <div class="title-line-center mx-auto mb-4" style="background: var(--accent-pink);"></div>
            <p class="text-white opacity-90">
                We take pride in the milestones we've reached through our dedicated efforts. Each success reflects our commitment and the invaluable support of our partners and volunteers.
            </p>
        </div>

        <div class="row g-4">
            {{-- Item 1 --}}
            <div class="col-md-6 col-lg-3">
                <div class="counter-card text-center p-4">
                    <div class="counter-icon-wrap mb-3">
                        <i class="fas fa-thumbs-up fa-2x text-white"></i>
                    </div>
                    <h5 class="text-white opacity-70 small text-uppercase tracking-widest mb-3">Projects</h5>
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="display-4 fw-bold text-white" data-toggle="counter-up">3600</span>
                        <span class="display-4 fw-bold text-pink ml-1">+</span>
                    </div>
                </div>
            </div>

            {{-- Item 2 --}}
            <div class="col-md-6 col-lg-3">
                <div class="counter-card text-center p-4">
                    <div class="counter-icon-wrap mb-3">
                        <i class="fas fa-hand-holding-heart fa-2x text-white"></i>
                    </div>
                    <h5 class="text-white opacity-70 small text-uppercase tracking-widest mb-3">Funds Raised</h5>
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="h2 fw-bold text-pink mr-1">$</span>
                        <span class="display-4 fw-bold text-white" data-toggle="counter-up">100</span>
                        <span class="display-4 fw-bold text-white">K</span>
                    </div>
                </div>
            </div>

            {{-- Item 3 --}}
            <div class="col-md-6 col-lg-3">
                <div class="counter-card text-center p-4">
                    <div class="counter-icon-wrap mb-3">
                        <i class="fas fa-users fa-2x text-white"></i>
                    </div>
                    <h5 class="text-white opacity-70 small text-uppercase tracking-widest mb-3">Volunteers</h5>
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="display-4 fw-bold text-white" data-toggle="counter-up">50</span>
                        <span class="display-4 fw-bold text-pink ml-1">+</span>
                    </div>
                </div>
            </div>

            {{-- Item 4 --}}
            <div class="col-md-6 col-lg-3">
                <div class="counter-card text-center p-4">
                    <div class="counter-icon-wrap mb-3">
                        <i class="fas fa-calendar-check fa-2x text-white"></i>
                    </div>
                    <h5 class="text-white opacity-70 small text-uppercase tracking-widest mb-3">Events</h5>
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="display-4 fw-bold text-white" data-toggle="counter-up">17</span>
                        <span class="display-4 fw-bold text-pink ml-1">+</span>
                    </div>
                </div>
            </div>

            <div class="col-12 text-center mt-5">
                <a class="btn-modern-accent px-5 py-3 shadow-lg" href="#">
                    JOIN OUR MISSION <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid impact-section py-5 {{ $projects->count() > 0 ? '' : 'd-none' }}">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="brand-subtitle-centered mb-2">Recent Projects</h5>
            <h2 class="brand-title-dark display-5 mb-3">Our Transformative Efforts</h2>
            <div class="title-line-center mx-auto mb-4"></div>
            <p class="mb-0 tab-description">
                At Happy Family Rwanda Organization (HFRO), we are passionate about addressing the challenges faced by underprivileged communities. We strive to promote sustainable change.
            </p>
        </div>

        <div class="row g-4">
            @foreach($projects as $project)
            <div class="col-lg-6 col-md-6 col-xl-4">
                <div class="impact-card shadow-sm h-100 border-0 bg-white">
                    <div class="impact-img-container position-relative overflow-hidden">
                        <img src="{{ $project->featured_image_url }}" 
                             alt="{{ $project->title }}"
                             class="img-fluid transition-scale"
                             style="width: 100%; height: 260px; object-fit: cover;">
                        
                        <div class="impact-overlay p-3">
                            <div class="text-center w-100 px-3">
                                <div class="mb-3">
                                    <small class="text-white d-block mb-1">
                                        <i class="fas fa-bullseye text-pink me-2"></i> Goal: <strong>RWF {{ number_format($project->budget, 0) }}</strong>
                                    </small>
                                    <small class="text-white d-block">
                                        <i class="fa fa-heart text-pink me-2"></i> Status: {{ $project->status }}
                                    </small>
                                </div>
                                <a href="{{ route('projects.show', $project->slug) }}" class="btn-impact-view py-2 px-4 rounded-pill">View Details</a>
                            </div>
                        </div>

                        <div class="impact-tag position-absolute" style="top: 15px; left: 15px; background: var(--accent-pink); color: white; padding: 4px 15px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; z-index: 2;">
                            {{ $project->causes->first()->name ?? 'General' }}
                        </div>
                    </div>

                    <div class="impact-progress-bar w-100" style="height: 6px; background: #f0f0f0;">
                        <div class="progress-bar" 
                             role="progressbar" 
                             style="width: {{ $project->progress }}%; background-color: var(--accent-pink);" 
                             aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted" style="font-size: 0.8rem;">
                                <i class="far fa-user-circle me-1 text-primary"></i> {{ $project->creator->name ?? 'HFRO Admin' }}
                            </small>
                            <span class="badge" 
                                  style="background-color: {{ $project->status == 'Completed' ? '#28a745' : 'var(--primary-purple)' }}; color: white; border-radius: 4px; font-size: 0.65rem; padding: 4px 8px;">
                                {{ strtoupper($project->status) }}
                            </span>
                        </div>
                        
                        <a href="{{ route('projects.show', $project->slug) }}" class="impact-card-title h5 mb-2 text-decoration-none text-dark font-weight-bold">
                            {{ $project->title }}
                        </a>
                        
                        <p class="impact-text mb-4 text-muted" style="font-size: 0.85rem; line-height: 1.6;">
                            {{ Str::limit(strip_tags($project->summary), 100) }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('projects.show', $project->slug) }}" class="link-learn-more font-weight-bold text-uppercase text-decoration-none" style="font-size: 0.7rem; color: var(--primary-purple); letter-spacing: 0.5px;">
                                LEARN MORE <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            <a href="#" class="btn-modern-accent py-2 px-3 text-white border-0 shadow-sm" style="font-size: 0.8rem; background-color: var(--accent-pink); border-radius: 6px; font-weight: 600;">
                                DONATE
                            </a>
                        </div>
                    </div>
                </div>
            </div> 
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('projects.index') }}" class="btn btn-outline-primary px-5 py-3 rounded-pill font-weight-bold">
                EXPLORE ALL PROJECTS
            </a>
        </div>
    </div>
</div>

        <!-- Events Start -->
    <div class="container-fluid event py-5 impact-section {{ $events->count() > 0 ? '' : 'd-none' }}">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <h5 class="brand-subtitle-centered mb-2">Upcoming Events</h5>
            <h2 class="brand-title-dark display-5 mb-3">Join Our Community</h2>
            <div class="title-line-center mx-auto mb-4"></div>
            <p class="tab-description">
                At Happy Family Rwanda Organization (HFRO), we are excited to share upcoming initiatives. Join us in creating meaningful change.
            </p>
        </div>

       <div 
    x-data="{}" 
    x-init="
        $(document).ready(function(){
            $('.event-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: true,
                autoplay: true,
                responsive:{
                    0:{ items:1 },
                    600:{ items:2 },
                    1000:{ items:3 }
                }
            });
        });
    "
    class="event-carousel owl-carousel"
>
    @foreach ($events as $event)
    <div class="event-item impact-card mx-2">
        <div class="impact-img-container">
            {{-- Fixed photo reference --}}
            <img src="{{ asset('storage/' . $event->event_photos->first()->file_path) }}" alt="{{ $event->event }}">
            
            <div class="event-date-badge">
                <span class="day">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                <span class="month">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
            </div>

            <div class="impact-overlay">
                <a href="{{ route('events.show', $event->slug ?? $event->id) }}" class="btn-impact-view">Interested</a>
            </div>
        </div>

        <div class="event-content p-4 d-flex flex-column h-100">
            <div class="d-flex align-items-center mb-3 text-muted small font-weight-bold">
                <span class="mr-3"><i class="fas fa-map-marker-alt text-pink mr-1"></i> {{ Str::limit($event->location, 20) }}</span>
                <span><i class="fas fa-clock text-pink mr-1"></i> {{ \Carbon\Carbon::parse($event->date)->format('h:i A') }}</span>
            </div>

            <a href="{{ route('events.show', $event->slug ?? $event->id) }}" class="impact-card-title h4 mb-3">
                {{ Str::limit($event->event, 50) }}
            </a>

            <p class="impact-text mb-4">
                {!! Str::limit(strip_tags($event->description), 120) !!}
            </p>

            <div class="mt-auto">
                <a class="btn-modern-purple py-2 px-4 w-100 text-center" href="{{ route('events.show', $event->slug ?? $event->id) }}">
                    View Details <i class="fas fa-chevron-right ml-2 small"></i>
                </a>
            </div>
        </div>
    </div>  
    @endforeach
</div>
    </div>
</div>
        <!-- Events End -->

        <!-- Blog Start -->
        <div class="container-fluid blog py-5 mb-5 {{ $blogs->count() > 0 ? '' : 'd-none' }}">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                    <h5 class="text-uppercase text-primary">Latest News</h5>
                    <h1 class="mb-0">
                        Stay updated with our latest projects and inspiring stories.
                    </h1>
                </div>
                <div class="row g-4">
                    @foreach ($blogs as $blog)
                    <div class="col-lg-6 col-xl-3">
                        <div class="blog-item">
                            <div class="blog-img">
                                @if($blog->blogPhoto)
                                <img src="{{ asset('storage/'. $blog->blogPhoto->file_path) }}" class="img-fluid w-100" alt="{{ $blog->title }}">
                                @else
                                <div>No photo</div>
                                @endif
                                <div class="blog-info">
                                    <span><i class="fa fa-clock"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('M d, Y') }}</span>
                                    <div class="d-flex">
                                        <span class="me-3"> {{ $blog->likes->count() }} <i class="fa fa-heart"></i></span>
                                        <a href="#" class="text-white">{{ $blog->comments->count() }} <i class="fa fa-comment"></i></a>
                                    </div>
                                </div>
                                <div class="search-icon">
                                    <a href="{{ asset('storage/'. $blog->blogPhoto->file_path) }}" data-lightbox="Blog-1" class="my-auto"><i class="fas fa-search-plus btn-primary text-white p-3"></i></a>
                                </div>
                            </div>
                            <div class="text-dark border p-4 ">
                                <h4 class="mb-4">{{ $blog->title }}</h4>
                                <p class="mb-4">{{ Str::limit($blog->title, 200) }}</p>
                                <a class="btn-hover-bg btn btn-primary text-white py-2 px-4" href="/blog/{{ $blog->slug }}">Read More</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                   
                </div>
            </div>
        </div>
        <!-- Blog End -->

      <div class="container-fluid gallery py-5 my-5 {{ $gallery->count() > 0 ? '' : 'd-none' }}">
    <div class="container">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="brand-subtitle-centered mb-2">Our Gallery</h5>
            <h2 class="brand-title-dark display-5 mb-3">Capture the Magic With Us</h2>
            <div class="title-line-center mx-auto mb-4"></div>
            <p class="tab-description">
                Welcome to the Happy Family Gallery. Explore our curated collection of photos showcasing the vibrant experiences, talent, and community impact we create together.
            </p>
        </div>

        <div class="tab-class text-center">
            <ul class="nav nav-pills modern-pills d-inline-flex justify-content-center mb-5">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="pill" href="#GalleryTab-all">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#VolunteeringTab">Volunteering</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#EntertainmentTab">Entertainment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#WorkshopTab">Workshop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#SportTab">Sport</a>
                </li>
            </ul>

            <div class="tab-content">
                {{-- Tab Pane Template --}}
                @php
                    $categories = [
                        'all' => null, 
                        'Volunteering' => 'Volunteering', 
                        'Entertainment' => 'Entertainment', 
                        'Workshop' => 'Workshop', 
                        'Sport' => 'Sport'
                    ];
                @endphp

                @foreach($categories as $id => $category)
                <div id="{{ $id == 'all' ? 'GalleryTab-all' : $id.'Tab' }}" class="tab-pane fade show {{ $loop->first ? 'active' : '' }} p-0">
                    <div class="row g-3">
                        @foreach ($gallery as $photo)
                            @if (!$category || $photo->category == $category)
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                <div class="gallery-card impact-card">
                                    <div class="impact-img-container" style="height: 250px;">
                                        <img src="{{ asset('storage/' . ($photo->file_path ?? $photo->photo)) }}" class="img-fluid w-100 h-100" alt="Gallery Image">
                                        
                                        <div class="impact-overlay">
                                            <div class="text-center p-2">
                                                <a href="{{ asset('storage/' . ($photo->file_path ?? $photo->photo)) }}" 
                                                   data-lightbox="gallery-{{ $id }}" 
                                                   data-title="{{ $photo->caption ?? $photo->description }}"
                                                   class="btn-impact-view mb-2">
                                                    <i class="fas fa-search-plus"></i>
                                                </a>
                                                <small class="text-white d-block text-uppercase" style="font-size: 0.6rem; letter-spacing: 1px;">
                                                    {{ $photo->category }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    @if($photo->caption || $photo->description)
                                    <div class="gallery-caption-simple p-2 text-center">
                                        <small class="text-muted">{{ Str::limit($photo->caption ?? $photo->description, 20) }}</small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

        <!-- Volunteers Start -->
      <div class="container-fluid volunteer py-5 mt-5 impact-section overflow-hidden">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            {{-- Image Side with Modern Decoration --}}
            <div class="col-lg-5 position-relative">
                <div class="volunteer-img-wrapper">
                    <img src="{{ asset('frontend/img/Volunteers.jpg') }}" 
                         class="img-fluid rounded-lg shadow-lg" 
                         alt="Volunteers at Happy Family Rwanda"
                         style="border-radius: 20px; transform: rotate(-2deg); transition: 0.3s;"
                         onmouseover="this.style.transform='rotate(0deg)'"
                         onmouseout="this.style.transform='rotate(-2deg)'">
                    
                    {{-- Floating Badge --}}
                    <div class="floating-badge bg-white p-3 shadow text-center rounded animate-bounce" 
                         style="position: absolute; bottom: -20px; right: -10px; z-index: 5;">
                        <h4 class="text-pink mb-0 fw-bold">100%</h4>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 10px;">Free to Join</small>
                    </div>
                </div>
            </div>

            {{-- Text Side --}}
            <div class="col-lg-7">
                <h5 class="brand-subtitle mb-2">Become a Volunteer</h5>
                <h2 class="display-5 brand-title-dark mb-4">Together, we can make a <span class="text-pink">lasting difference</span>.</h2>
                
                <p class="mb-4 text-muted leading-relaxed">
                    We believe that true change happens when hearts and hands come together. At <strong>Happy Family Rwanda Organization</strong>, we rely on the energy and passion of volunteers to transform communities. Your time and talents are the greatest gifts you can offer.
                </p>

                <div class="volunteer-benefits row mb-5">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-3">
                                <div class="benefit-icon mr-2"><i class="fa fa-check"></i></div>
                                <span>Warm, friendly community</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <div class="benefit-icon mr-2"><i class="fa fa-check"></i></div>
                                <span>Professional free training</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <div class="benefit-icon mr-2"><i class="fa fa-check"></i></div>
                                <span>Impactful environments</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-3">
                                <div class="benefit-icon mr-2"><i class="fa fa-check"></i></div>
                                <span>No strict requirements</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <div class="benefit-icon mr-2"><i class="fa fa-check"></i></div>
                                <span>Zero joining fees</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center">
                    <a class="btn-modern-purple py-3 px-5 shadow-lg mr-4 mb-3" href="#">
                        JOIN OUR FAMILY <i class="fas fa-heart ml-2"></i>
                    </a>
                    <div class="volunteer-stats d-flex align-items-center mb-3">
                        <div class="avatar-group d-flex mr-2">
                            <div class="rounded-circle border border-white bg-light" style="width:30px; height:30px; margin-right: -10px;"></div>
                            <div class="rounded-circle border border-white bg-light" style="width:30px; height:30px; margin-right: -10px;"></div>
                            <div class="rounded-circle border border-white bg-light" style="width:30px; height:30px;"></div>
                        </div>
                        <small class="text-muted">+50 Active Volunteers</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- Volunteers End -->

         <!-- Our Team Start -->
 <div class="container-fluid partners-section py-5 {{ $partners->count() > 0 ? '' : 'd-none' }}" style="background: #fdfafd;">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <h5 class="brand-subtitle-centered mb-2">Our Partners</h5>
            <h2 class="brand-title-dark display-6 mb-3">Building Impact Together</h2>
            <div class="title-line-center mx-auto mb-4"></div>
            <p class="tab-description">
                We believe in the power of collaboration. Our mission is made possible through the support and strategic partnership of these incredible organizations.
            </p>
        </div>
<div class="partner-carousel owl-carousel" 
     x-data="{}" 
     x-init="
        $( $el ).owlCarousel({
            loop: true,
            margin: 20,
            autoplay: true,
            autoplayTimeout: 3000,
            dots: true,
            nav: false,
            responsive: {
                0: { items: 2 },
                600: { items: 3 },
                1000: { items: 5 }
            }
        });
     ">
    @forelse ($partners as $partner)
        <div class="partner-item p-4">
            <a href="{{ $partner->website }}" target="_blank" title="{{ $partner->name }}" class="d-block text-center">
                <div class="partner-logo-wrap mb-3 shadow-sm">
                    <img src="{{ asset('storage/' . $partner->logo) }}" 
                         class="partner-logo img-fluid mx-auto" 
                         alt="{{ $partner->name }}">
                </div>
                <div class="partner-info">
                    <h6 class="mb-1 text-purple fw-bold">{{ Str::limit($partner->name, 30) }}</h6>
                    <p class="text-muted small mb-0">{{ Str::limit($partner->description, 50) }}</p>
                </div>
            </a>
        </div> 
    @empty
        {{-- Note: If there are no partners, Owl Carousel won't initialize. 
             This h4 will display normally. --}}
        <div class="w-100 text-center py-5">
            <h4 class="text-muted">No Partners found</h4>
        </div>
    @endforelse
</div>
    </div>
</div>
      
<script>
    document.addEventListener('alpine:init', () => {
    Alpine.data('impactSlider', () => ({
        init() {
            this.handleCarousel();
            window.addEventListener('resize', () => this.handleCarousel());
        },
        handleCarousel() {
            const $el = $('.impact-carousel');
            if (window.innerWidth < 992) {
                if (!$el.hasClass('owl-loaded')) {
                    $el.owlCarousel({
                        items: 1,
                        margin: 20,
                        loop: true,
                        dots: true,
                        responsive: { 0: { items: 1 }, 768: { items: 2 } }
                    });
                }
            } else {
                if ($el.hasClass('owl-loaded')) {
                    $el.trigger('destroy.owl.carousel').removeClass('owl-loaded owl-drag');
                }
            }
        }
    }));
});
</script>
@endsection