@extends('layouts.app')
@section('styles')
<style>
    .project-card {
    transition: transform 0.3s, box-shadow 0.3s;
    border-radius: 12px;
}
.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.project-card .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    opacity: 0;
    transition: opacity 0.3s;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}
.project-card:hover .overlay {
    opacity: 1;
}
.btn-hover-bg:hover {
    background-color: #0056b3 !important;
    color: #fff !important;
}
.progress {
    border-radius: 0;
    margin-bottom: 0;
}

    /* Hero Image Effects */
    .banner-img {
        object-fit: cover;
        filter: brightness(0.65); /* Darkens image for text readability */
    }

    /* Gradient Overlay for extra readability */
    .carousel-item::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
    }

    .carousel-caption {
        bottom: 0;
        left: 0;
        right: 0;
        top: 0;
        z-index: 10;
    }

    /* Custom Typography */
    .tracking-widest { letter-spacing: 4px; }
    .display-3 { font-size: calc(1.5rem + 3.5vw); line-height: 1.1; }
    .opacity-90 { opacity: 0.9; }

    /* Modern Buttons */
    .btn-modern {
        border-radius: 50px;
        padding: 15px 40px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    /* Custom Indicators */
    .custom-indicators li {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 8px;
        background-color: rgba(255,255,255,0.5);
        border: none;
    }
    .custom-indicators li.active {
        background-color: var(--primary);
        width: 30px;
        border-radius: 10px;
    }

    /* Control Icons */
    .control-icon {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
        transition: 0.3s;
    }
    .control-icon:hover {
        background: var(--primary);
        color: white;
    }

    .about-section {
        background-color: #ffffff;
    }

    .rounded-custom {
        border-radius: 12px;
    }

    /* Image Wrapper Decor */
    .image-wrapper::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border: 2px solid var(--accent-pink);
        top: 20px;
        left: -20px;
        z-index: -1;
        border-radius: 12px;
    }

    .experience-badge {
        position: absolute;
        bottom: -20px;
        right: -10px;
        background: var(--primary-purple);
        color: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(99, 16, 132, 0.3);
    }

    /* Titles */
    .brand-subtitle {
        color: var(--accent-pink);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .brand-title {
        color: var(--primary-purple);
        font-weight: 800;
    }

    .text-purple { color: var(--primary-purple); font-weight: 700; }

    /* Modern Tabs UI */
    .modern-pills .nav-link {
        border: 1px solid #eee;
        background: white;
        color: #666;
        margin-right: 10px;
        font-weight: 600;
        padding: 10px 25px;
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .modern-pills .nav-link.active {
        background: var(--primary-purple) !important;
        color: white !important;
        border-color: var(--primary-purple);
    }

    .impact-tab-content {
        background: #fcfaff; /* Soft Purple Tint */
        border-left: 5px solid var(--accent-pink);
    }

    .tab-description {
        color: #555;
        font-size: 1rem;
        line-height: 1.7;
    }

    /* Brand Button */
    .btn-modern-accent {
        display: inline-block;
        background: var(--accent-pink);
        color: white;
        padding: 10px 25px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-modern-accent:hover {
        background: var(--primary-purple);
        color: white;
        transform: translateY(-3px);
    }

        /* Section Styling */
    .impact-section {
        background-color: #fcfaff; /* Subtle purple-tinted background */
    }

    .brand-subtitle-centered {
        color: var(--accent-pink);
        text-transform: uppercase;
        letter-spacing: 3px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .brand-title-dark {
        color: var(--primary-purple);
        font-weight: 800;
    }

    .title-line-center {
        width: 60px;
        height: 4px;
        background: var(--accent-pink);
        border-radius: 10px;
    }

    /* Impact Card Design */
    .impact-card {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
    }

    .impact-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(99, 16, 132, 0.12);
    }

    /* Image & Overlay */
    .impact-img-container {
        position: relative;
        overflow: hidden;
        height: 220px;
    }

    .impact-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .impact-card:hover .impact-img-container img {
        transform: scale(1.1);
    }

    .impact-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(99, 16, 132, 0.7); /* Brand Purple with opacity */
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: 0.4s;
        z-index: 2;
    }

    .impact-card:hover .impact-overlay {
        background: rgba(99, 16, 132, 0.7);
        opacity: 1;
    }

    .btn-impact-view {
        color: white;
        border: 2px solid white;
        padding: 8px 20px;
        border-radius: 50px;
        text-decoration: none !important;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-impact-view:hover {
        background: white;
        color: var(--primary-purple);
    }

    .impact-tag {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--accent-pink);
        color: white;
        font-size: 0.7rem;
        padding: 4px 12px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Content Styling */
    .impact-card-title {
        color: var(--primary-purple);
        font-weight: 700;
        text-decoration: none !important;
        transition: 0.3s;
    }

    .impact-card-title:hover {
        color: var(--accent-pink);
    }

    .impact-text {
        color: #6c757d;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Progress Bar */
    .impact-progress-bar {
        height: 6px;
        border-radius: 10px;
        background-color: #eee;
    }

    .impact-progress-bar .progress-bar {
        background-color: var(--accent-pink);
        border-radius: 10px;
    }

    .link-learn-more {
        color: var(--primary-purple);
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none !important;
        transition: 0.3s;
    }

    .link-learn-more:hover {
        color: var(--accent-pink);
        padding-left: 5px;
    }

    /* Footer Button */
  .btn-modern-purple {
    background: var(--primary-purple);
    color: #ffffff !important; /* Force white text */
    border-radius: 8px;
    padding: 12px 25px; /* Added padding for button shape */
    font-weight: 700;
    border: 2px solid var(--primary-purple); /* Border prevents it blending into white */
    box-shadow: 0 4px 15px rgba(99, 16, 132, 0.2); /* Subtle purple glow */
    transition: 0.3s;
}

.btn-modern-purple:hover {
    background: var(--accent-pink);
    border-color: var(--accent-pink);
    color: white;
}

    @media (max-width: 768px) {
        .display-3 { font-size: 2.5rem; }
    }
</style>
@endsection
@section('content')

<div class="container-fluid carousel-header vh-100 px-0">
    <div id="carouselId" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators custom-indicators">
            <li data-target="#carouselId" data-slide-to="0" class="active"></li>
            <li data-target="#carouselId" data-slide-to="1"></li>
            <li data-target="#carouselId" data-slide-to="2"></li>
        </ol>
        
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active vh-100">
                <img src="{{ asset('images/banner1.png') }}" class="w-100 h-100 banner-img" alt="Building Awareness">
                <div class="carousel-caption d-flex align-items-center justify-content-center">
                    <div class="p-3 text-center hero-content" x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" x-show="show" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translateY-50">
                        <h4 class="text-primary text-uppercase font-weight-bold mb-3 tracking-widest">Building Awareness</h4>
                        <h1 class="display-3 text-white font-weight-bold mb-4">Empowering Youth,<br>Preventing Pregnancies</h1>
                        <p class="mb-5 mx-auto text-light opacity-90 lead" style="max-width: 700px;">
                            Join us in spreading awareness and preventing teenage pregnancy through knowledge and empowerment. Every step counts toward a brighter future.
                        </p>
                        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center">
                            <a class="btn btn-primary btn-modern shadow-lg mx-2 mb-3 mb-sm-0" href="#">Get Involved</a>
                            <a class="btn btn-outline-light btn-modern mx-2 mb-3 mb-sm-0" href="/causes">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item vh-100">
                <img src="{{ asset('storage/carousel/Happy Family Rwanda Survey.jpeg') }}" class="w-100 h-100 banner-img" alt="Education">
                <div class="carousel-caption d-flex align-items-center justify-content-center">
                    <div class="p-3 text-center hero-content">
                        <h4 class="text-primary text-uppercase font-weight-bold mb-3 tracking-widest">Transforming Education</h4>
                        <h1 class="display-3 text-white font-weight-bold mb-4">Education is the Key</h1>
                        <p class="mb-5 mx-auto text-light opacity-90 lead" style="max-width: 700px;">
                            Our programs educate teens on reproductive health, making informed choices, and reclaiming their potential.
                        </p>
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-primary btn-modern shadow-lg" href="#">Support Our Mission</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
            <span class="control-icon"><i class="fas fa-chevron-left"></i></span>
        </a>
        <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
            <span class="control-icon"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

      <div class="container-fluid about-section py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-xl-5">
                <div class="image-wrapper position-relative">
                    <img src="{{ asset('images/welcome photo.png') }}" class="img-fluid rounded-custom shadow-lg" alt="Happy Family Rwanda Welcome">
                    <div class="experience-badge d-none d-sm-block">
                        <span class="h2 d-block mb-0">100%</span>
                        <small>Compassion</small>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="content-box ps-xl-4">
                    <h5 class="brand-subtitle">About Our Organization</h5>
                    <h1 class="display-5 mb-4 brand-title">Empowering Communities in Rwanda</h1>
                    <p class="lead mb-4 text-muted">
                        Happy Family Rwanda Organization (HFRO) is a compassionate NGO dedicated to creating positive change and 
                        making a lasting impact through collective action and empowerment.
                    </p>

                    <div class="custom-tabs-container">
                        <ul class="nav nav-pills modern-pills mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-1" type="button">Our Story</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-2" type="button">Mission</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-target="#tab-3" type="button">Vision</button>
                            </li>
                        </ul>

                        <div class="tab-content impact-tab-content p-4 rounded-custom" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="tab-1">
                                <h5 class="mb-3 text-purple">Who We Are</h5>
                                <div class="tab-description">
                                    {!! $organization->about !!}
                                </div>
                                <a href="#" class="btn-modern-accent mt-3">Read Full Story <i class="fas fa-arrow-right ml-2"></i></a>
                            </div>
                            <div class="tab-pane fade" id="tab-2">
                                <h5 class="mb-3 text-purple">Our Purpose</h5>
                                <div class="tab-description">
                                    {!! $organization->mission !!}
                                </div>
                                <a href="#" class="btn-modern-accent mt-3">Learn More</a>
                            </div>
                            <div class="tab-pane fade" id="tab-3">
                                <h5 class="mb-3 text-purple">Our Dream</h5>
                                <div class="tab-description">
                                    {!! $organization->vision !!}
                                </div>
                                <a href="#" class="btn-modern-accent mt-3">Get Involved</a>
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
                        Explore All Causes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Stories -->
       <div class="container-fluid impact-section py-5 {{ $stories->count() > 0 ? '' : 'd-none' }}">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="brand-subtitle-centered mb-2">Our Impact</h5>
            <h2 class="brand-title-dark display-5 mb-3">Stories of Change</h2>
            <div class="title-line-center mx-auto mb-4"></div>
            <p class="mb-0 tab-description">Discover how Happy Family is fostering resilience and making a real impact in local communities. Join us in building a brighter future together.</p>
        </div>
        
        <div class="row g-4">
            @foreach ($stories as $story)
            <div class="col-lg-4 col-md-6">
                <div class="impact-card">
                    <div class="impact-img-container">
                        @if($story->photo)
                            <img src="{{ asset('storage/' . $story->photo->file_path) }}" alt="{{ $story->title }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-image fa-3x text-muted opacity-50"></i>
                            </div>
                        @endif
                        
                        <div class="impact-tag">
                            {{ $story->cause->name ?? 'Community' }}
                        </div>

                        <div class="impact-overlay">
                            <a href="{{ url('story/' . $story->slug) }}" class="btn-impact-view">
                                View Story
                            </a>
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
                                READ FULL STORY <i class="fas fa-chevron-right ml-1 small"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="col-12 text-center mt-5">
                <a href="/stories" class="btn-modern-purple py-3 px-5">
                    Explore More Stories <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

        <!-- Counter Start -->
        <div class="container-fluid counter py-5" style="background: linear-gradient(rgba(0, 0, 0, .4), rgba(0, 0, 0, 0.4)), url(frontend/img/volunteers-bg.jpg) center center; background-size: cover;">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                    <h5 class="text-uppercase text-primary">Achievements</h5>
                    <p class="text-white mb-0">
                        We take pride in the milestones we've reached through our dedicated efforts. From expanding our programs to impacting countless lives, our achievements highlight the positive change we're creating. Each success reflects our commitment and the invaluable support of our partners and volunteers. We are excited to build on these accomplishments as we continue our mission to make a difference.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter-item text-center border shadow p-5">
                            <i class="fas fa-thumbs-up fa-4x text-white"></i>
                            <h3 class="text-white my-4">Successful Projects</h3>
                            <div class="counter-counting">
                                <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">3600</span>
                                <span class="h1 fw-bold text-primary">+</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter-item text-center border p-5">
                            <i class="fas fa-file-invoice-dollar fa-4x text-white"></i>
                            <h3 class="text-white my-4">Funds Collected</h3>
                            <div class="counter-counting text-center border-white w-100" style="border-style: dotted; font-size: 30px;">
                                <span class="h1 fw-bold text-primary">$</span>
                                <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">100,000</span>
                             </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter-item text-center border p-5">
                            <i class="fas fa-user fa-4x text-white"></i>
                            <h3 class="text-white my-4">Volunteers</h3>
                            <div class="counter-counting text-center border-white w-100" style="border-style: dotted; font-size: 30px;">
                                <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">50</span>
                                <span class="h1 fw-bold text-primary">+</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter-item text-center border p-5">
                            <i class="fas fa-heart fa-4x text-white"></i>
                            <h3 class="text-white my-4">Events</h3>
                            <div class="counter-counting text-center border-white w-100" style="border-style: dotted; font-size: 30px;">
                                <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">17</span>
                                <span class="h1 fw-bold text-primary">+</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn-hover-bg btn btn-primary text-white py-2 px-4" href="#">Join With Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Counter End -->

        <!-- Causes Start -->
        <div class="container-fluid causes py-5 {{ $projects->count() > 0 ? '' : 'd-none' }}">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                    <h5 class="text-uppercase text-primary">Recent Projects</h5>
                    <h1 class="mb-4">Our Transformative Efforts</h1>
                    <p class="mb-0">
                        At Happy Family Rwanda Organization (HFRO), we are passionate about addressing the challenges faced by underprivileged communities around the world. Through our various programs and initiatives, we strive to make a positive impact in the lives of individuals and promote sustainable change.
                    </p>
                </div>
                <div class="row g-4">
                    @foreach($projects as $project)
                    <div class="col-lg-6 col-md-6 col-xl-4 mb-4">
    <div class="card shadow-sm border-0 h-100 overflow-hidden project-card">
        <!-- Project Image with Overlay -->
        <div class="position-relative">
            <img src="{{ $project->project_photo?->file_path ? asset('storage/' . $project->project_photo->file_path) : asset('images/default.png') }}" 
                class="card-img-top img-fluid" alt="{{ $project->title }}">
            
            <div class="overlay d-flex flex-column justify-content-between p-3">
                <div>
                    <small class="text-white d-block">
                        <i class="fas fa-chart-bar text-primary me-2"></i> Goal: {{ $project->budget ? number_format($project->budget, 2) : '-' }}
                    </small>
                    <small class="text-white d-block">
                        <i class="fa fa-thumbs-up text-primary me-2"></i> Raised: 0
                    </small>
                </div>
                <div class="text-end">
                    <a href="#" class="btn btn-sm btn-primary text-white py-1 px-3 btn-hover-bg">Donate Now</a>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="progress" style="height:6px;">
            <div class="progress-bar {{ $project->progress == 100 ? 'bg-success' : 'bg-info' }}" 
                 role="progressbar" style="width: {{ $project->progress }}%;" 
                 aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>

        <!-- Project Content -->
        <div class="card-body p-4 d-flex flex-column">
            <h5 class="card-title mb-2">{{ $project->title }}</h5>
            <p class="card-text text-muted mb-4">{{ Str::limit(strip_tags($project->summary), 120) }}</p>
            <div class="mt-auto d-flex justify-content-between align-items-center">
                <span class="badge {{ $project->progress == 100 ? 'bg-success' : 'bg-warning' }}">
                    {{ $project->progress == 100 ? 'Completed' : ucfirst($project->status) }}
                </span>
                <a href="{{ url('project/'.$project->id) }}" class="btn btn-sm btn-outline-primary btn-hover-bg">
                    Read More
                </a>
            </div>
        </div>
    </div>
</div> 
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Causes End -->

        <!-- Events Start -->
        <div class="container-fluid event py-5 {{ $events->count() > 0 ? '' : 'd-none' }}">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5" style="max-width: 800px;">
                    <h4 class="text-uppercase text-primary">Upcoming Events</h4>
                    <h5 class="mb-0">At Happy Family Rwanda Organization (HFRO), We are excited to share with you the upcoming events and activities that aim to make a positive impact in our community. Join us in creating meaningful change and be part of these inspiring initiatives</h5>
                </div>
                <div class="event-carousel owl-carousel">
                    @foreach ($events as $event)
                    <div class="event-item">
                        <img src="{{ asset('storage/'.$event->photo) }}" class="img-fluid w-100" alt="Image">
                        <div class="event-content p-4">
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-body"><i class="fas fa-map-marker-alt me-2"></i>{{ Str::limit($event->location, 20) }}</span>
                                <span class="text-body"><i class="fas fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($event->date)->format('d M, Y') }}</span>
                            </div>
                            <h4 class="mb-4">{{ Str::limit($event->event, 50) }}</h4>
                            <p class="mb-4">{!! Str::limit(strip_tags($event->description), 200) !!}</p>
                            <a class="btn-hover-bg btn btn-primary text-white py-2 px-4" href="/events/{{ $event->event }}">Read More</a>
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

        <!-- Gallery Start -->
        <div class="container-fluid gallery py-5 my-5 {{ $gallery->count() > 0 ? '' : 'd-none' }}">
            <div class="mx-auto text-center mb-5" style="max-width: 900px;">
                <h5 class="text-uppercase text-primary">Our Gallery</h5>
                <h1 class="mb-4">Capture the Magic with us</h1>
                <p class="mb-0">
                    Welcome to the Happy Family Gallery, where moments of inspiration, talent, and adventure come to life. Explore our curated collection of photos and videos showcasing the vibrant experiences we create.
                </p>
            </div>
            <div class="tab-class text-center">
                <ul class="nav nav-pills d-inline-flex justify-content-center mb-5">
                    <li class="nav-item">
                        <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill active" data-bs-toggle="pill" href="#GalleryTab-1">
                            <span class="text-dark" style="width: 150px;">All</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex py-2 mx-3 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#VolunteeringTab">
                            <span class="text-dark" style="width: 150px;">Volunteering</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#EntertainmentTab">
                            <span class="text-dark" style="width: 150px;">Entertainment</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#WorkshopTab">
                            <span class="text-dark" style="width: 150px;">Workshop</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#SportTab">
                            <span class="text-dark" style="width: 150px;">Sport</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="GalleryTab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-2">
                            @foreach ($gallery as $photo)
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2">
                                <div class="gallery-item h-100">
                                    <img src="{{ asset('storage/' . $photo->file_path) }}" class="img-fluid w-100 h-100 rounded" alt="Image">
                                    <div class="gallery-content">
                                        <div class="gallery-info">
                                            <h5 class="text-white text-uppercase mb-2">{{ Str::limit($photo->caption, 50) }}</h5>
                                            <a href="#" class="btn-hover text-white">View more <i class="fa fa-arrow-right ms-2"></i></a>
                                        </div>
                                    </div>
                                    <div class="gallery-plus-icon">
                                        <a href="{{ asset('storage/' . $photo->file_path) }}" data-lightbox="gallery-1" class="my-auto"><i class="fas fa-plus fa-2x text-white"></i></a>
                                    </div>
                                </div>
                            </div> 
                            @endforeach
                        </div>
                    </div>
                    <div id="VolunteeringTab" class="tab-pane fade show p-0">
                        <div class="row g-2">
                            @foreach ($gallery as $photo)
                            @if ($photo->category == 'Volunteering')
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2">
                                <div class="gallery-item h-100">
                                    <img src="{{ asset('storage/' . $photo->photo) }}" class="img-fluid w-100 h-100 rounded" alt="Image">
                                    <div class="gallery-content">
                                        <div class="gallery-info">
                                            <h5 class="text-white text-uppercase mb-2">{{ Str::limit($photo->description, 50) }}</h5>
                                            <a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>
                                        </div>
                                    </div>
                                    <div class="gallery-plus-icon">
                                        <a href="{{ asset('storage/' . $photo->photo) }}" data-lightbox="gallery-1" class="my-auto"><i class="fas fa-plus fa-2x text-white"></i></a>
                                    </div>
                                </div>
                            </div>   
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div id="EntertainmentTab" class="tab-pane fade show p-0">
                        <div class="row g-2">
                            @foreach ($gallery as $photo)
                            @if ($photo->category == 'Entertainment')
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2">
                                <div class="gallery-item h-100">
                                    <img src="{{ asset('storage/' . $photo->photo) }}" class="img-fluid w-100 h-100 rounded" alt="Image">
                                    <div class="gallery-content">
                                        <div class="gallery-info">
                                            <h5 class="text-white text-uppercase mb-2">{{ Str::limit($photo->description, 50) }}</h5>
                                            <a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>
                                        </div>
                                    </div>
                                    <div class="gallery-plus-icon">
                                        <a href="{{ asset('storage/' . $photo->photo) }}" data-lightbox="gallery-1" class="my-auto"><i class="fas fa-plus fa-2x text-white"></i></a>
                                    </div>
                                </div>
                            </div>   
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div id="WorkshopTab" class="tab-pane fade show p-0">
                        <div class="row g-2">
                            @foreach ($gallery as $photo)
                            @if ($photo->category == 'Workshop')
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2">
                                <div class="gallery-item h-100">
                                    <img src="{{ asset('storage/' . $photo->photo) }}" class="img-fluid w-100 h-100 rounded" alt="Image">
                                    <div class="gallery-content">
                                        <div class="gallery-info">
                                            <h5 class="text-white text-uppercase mb-2">{{ Str::limit($photo->description, 50) }}</h5>
                                            <a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>
                                        </div>
                                    </div>
                                    <div class="gallery-plus-icon">
                                        <a href="{{ asset('storage/' . $photo->photo) }}" data-lightbox="gallery-1" class="my-auto"><i class="fas fa-plus fa-2x text-white"></i></a>
                                    </div>
                                </div>
                            </div>   
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div id="SportTab" class="tab-pane fade show p-0">
                        <div class="row g-2">
                            @foreach ($gallery as $photo)
                            @if ($photo->category == 'Sport')
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2">
                                <div class="gallery-item h-100">
                                    <img src="{{ asset('storage/' . $photo->photo) }}" class="img-fluid w-100 h-100 rounded" alt="Image">
                                    <div class="gallery-content">
                                        <div class="gallery-info">
                                            <h5 class="text-white text-uppercase mb-2">{{ Str::limit($photo->description, 50) }}</h5>
                                            <a href="#" class="btn-hover text-white">View All Place <i class="fa fa-arrow-right ms-2"></i></a>
                                        </div>
                                    </div>
                                    <div class="gallery-plus-icon">
                                        <a href="{{ asset('storage/' . $photo->photo) }}" data-lightbox="gallery-1" class="my-auto"><i class="fas fa-plus fa-2x text-white"></i></a>
                                    </div>
                                </div>
                            </div>   
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery End -->

        <!-- Volunteers Start -->
        <div class="container-fluid volunteer py-5 mt-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-5">
                        <img src="{{ asset('frontend/img/Volunteers.jpg') }}" class="w-100" />
                        </div>
                    <div class="col-lg-7">
                        <h5 class="text-uppercase text-primary">Become a Volunteer</h5>
                        <h1 class="mb-4">Together, we can make a difference.</h1>
                        <p class="mb-4">
                            Together, let's build a better future, empower those in need, and create a world where everyone can thrive.
                            We cannot achieve our goals alone. We rely on the support and generosity of individuals, corporations, and foundations to continue our life-changing work. Your contributions, whether through financial donations, in-kind support, or volunteering, make a real difference in the lives of those we serve. Together, we can bring hope and transform communities, one step at a time.
                        </p>
                        <p class="text-dark"><i class=" fa fa-check text-primary me-2"></i> We are friendly to each other.</p>
                        <p class="text-dark"><i class=" fa fa-check text-primary me-2"></i> If you join with us,We will give you free training.</p>
                        <p class="text-dark"><i class=" fa fa-check text-primary me-2"></i> Its an opportunity to help poor Environments.</p>
                        <p class="text-dark"><i class=" fa fa-check text-primary me-2"></i> No goal requirements.</p>
                        <p class="text-dark mb-5"><i class=" fa fa-check text-primary me-2"></i> Joining is tottaly free. We dont need any money from you.</p>
                        <a class="btn-hover-bg btn btn-primary text-white py-2 px-4" href="#">Join With Us</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Volunteers End -->

         <!-- Our Team Start -->
         <div class="container-fluid event py-5 {{ $partners->count() > 0 ? '' : 'd-none' }}">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5" style="max-width: 800px;">
                    <h4 class="text-uppercase text-primary">Our Partners</h4>
                    <h5 class="mb-0">We understand the importance of networking, partnership and affiliations, We are currently partnering with</h5>
                </div>
                <div class="event-carousel owl-carousel">
                    @foreach ($partners as $partner)
                    <div class="event-item border border-rounded shadow pt-4">
                        <img src="{{ asset('storage/'.$partner->logo) }}" class="img-fluid w-50 mx-auto" alt="{{ $partner->partner }}">
                        <div class="event-content bg-white text-center p-4">
                            <div class="d-flex justify-content-between mb-4 d-none">
                                <span class="text-body"><i class="fas fa-map-marker-alt me-2"></i>{{ Str::limit($partner->location, 20) }}</span>
                                <span class="text-body"><i class="fas fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($partner->date)->format('d M, Y') }}</span>
                            </div>
                            <h4 class="mb-4">{{ Str::limit($partner->partner, 50) }}</h4>
                            <p class="mb-4">{{ Str::limit($partner->title, 200) }}</p>
                            <a href="{{ $partner->link }}" target="__blank" class="btn btn-primary rounded-pill">Visit</a>
                          </div>
                    </div>  
                    @endforeach
                   
                </div>
            </div>
        </div>
        
@endsection