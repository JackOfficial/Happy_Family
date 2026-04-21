@extends('layouts.app')

<style>
    /* --- HERO SECTION REFINEMENTS --- */
.hero-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(180deg, rgba(13, 2, 17, 0.4) 0%, rgba(13, 2, 17, 0.85) 100%);
    z-index: 1;
}

.banner-img {
    object-fit: cover;
    filter: brightness(0.8) contrast(1.1);
    transform: scale(1.05); /* Slight zoom for cinematic feel */
    transition: transform 10s linear;
}

.carousel-item.active .banner-img {
    transform: scale(1); /* Ken Burns effect transition */
}

.hero-content-box {
    z-index: 2;
    max-width: 900px;
}

.hero-subtitle {
    max-width: 700px;
    font-weight: 300;
    letter-spacing: 0.5px;
}

/* Glass Outline Button */
.btn-outline-glass {
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 14px 35px;
    border-radius: var(--radius-pill);
    font-weight: 600;
    text-decoration: none;
    backdrop-filter: blur(5px);
    transition: var(--transition-smooth);
}

.btn-outline-glass:hover {
    background: white;
    color: var(--primary-color);
    border-color: white;
}

/* Custom Indicators */
.custom-indicators button {
    width: 12px !important;
    height: 12px !important;
    border-radius: 50% !important;
    margin: 0 8px !important;
    background-color: rgba(255, 255, 255, 0.4) !important;
    border: 2px solid transparent !important;
    transition: 0.3s !important;
}

.custom-indicators button.active {
    background-color: var(--accent-color) !important;
    transform: scale(1.3);
    border-color: white !important;
}

/* Premium Controls */
.hero-control-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    transition: var(--transition-smooth);
}

.hero-control-icon:hover {
    background: var(--grad-premium);
    border-color: transparent;
    transform: scale(1.1);
}

@media (max-width: 768px) {
    .display-2 { font-size: 2.5rem !important; }
    .hero-subtitle { font-size: 1rem !important; }
}

/* --- ABOUT SECTION ENHANCEMENTS --- */
.rounded-bento { border-radius: var(--radius-bento) !important; }

.bg-circle-gradient {
    position: absolute;
    top: -10%; right: -5%;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(236, 64, 158, 0.05) 0%, rgba(255,255,255,0) 70%);
    z-index: 0;
}

.image-border-decoration {
    position: absolute;
    top: -20px; left: -20px;
    width: 100px; height: 100px;
    border-top: 5px solid var(--accent-color);
    border-left: 5px solid var(--accent-color);
    border-radius: 15px 0 0 0;
    z-index: 0;
}

/* Premium Floating Badge */
.experience-badge-premium {
    position: absolute;
    bottom: 30px; right: -25px;
    background: var(--grad-premium);
    padding: 2px;
    border-radius: 20px;
    box-shadow: var(--shadow-premium);
    z-index: 10;
}

.experience-badge-premium .badge-inner {
    background: var(--dark-void);
    color: white;
    padding: 20px 30px;
    border-radius: 18px;
    text-align: center;
}

/* Modern Glass Pills */
.modern-glass-pills {
    background: rgba(99, 16, 132, 0.04);
    padding: 8px;
    border-radius: var(--radius-pill);
    display: inline-flex;
}

.modern-glass-pills .nav-link {
    border-radius: var(--radius-pill) !important;
    padding: 10px 25px;
    color: var(--primary-color);
    font-weight: 700;
    transition: var(--transition-smooth);
    border: none;
}

.modern-glass-pills .nav-link.active {
    background: var(--grad-premium) !important;
    color: white !important;
    box-shadow: 0 10px 20px rgba(236, 64, 158, 0.2);
}

.impact-tab-content {
    border: 1px solid rgba(99, 16, 132, 0.08);
}

.text-accent-pink { color: var(--accent-color); }

/* --- IMPACT CARD REFINEMENTS --- */
.impact-main-img {
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.impact-card:hover .impact-main-img {
    transform: scale(1.1);
}

.badge-active-cause {
    position: absolute;
    top: 15px;
    right: 15px;
    background: var(--glass-white);
    backdrop-filter: blur(5px);
    color: var(--primary-color);
    font-size: 0.65rem;
    font-weight: 800;
    text-transform: uppercase;
    padding: 6px 12px;
    border-radius: 50px;
    z-index: 3;
    letter-spacing: 1px;
    border: 1px solid rgba(99, 16, 132, 0.1);
}

.hover-accent-color {
    transition: color 0.3s ease;
}

.hover-accent-color:hover {
    color: var(--accent-color) !important;
}

/* Fix for the view detail button inside the image overlay */
.gallery-overlay .btn-outline-glass {
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

/* Soft Border for Card Separation */
.border-light {
    border-color: rgba(99, 16, 132, 0.05) !important;
}

/* --- STORY CARD SPECIFIC REFINEMENTS --- */
.bg-light-purple {
    background-color: #f8f2fc;
}

.opacity-20 { opacity: 0.2; }

/* Ensures the story content remains balanced */
.impact-card .display-font {
    letter-spacing: -0.02em;
}

/* Specific hover effect for the story link */
.link-learn-more-story {
    font-size: 0.75rem;
    letter-spacing: 1.5px;
    transition: var(--transition-smooth);
}

.link-learn-more-story:hover {
    padding-left: 10px;
    color: var(--accent-color);
}

/* Responsive adjustment for owl-carousel items */
@media (max-width: 991px) {
    .impact-carousel .item {
        padding: 15px;
    }
}

/* --- COUNTER SECTION MODERNIZATION --- */
.counter-section {
    position: relative;
    overflow: hidden;
}

.counter-parallax-bg {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    z-index: 0;
    filter: saturate(0.5) brightness(0.4);
}

.counter-overlay-gradient {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(135deg, rgba(99, 16, 132, 0.9) 0%, rgba(13, 2, 17, 0.95) 100%);
    z-index: 1;
}

.glass-counter-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-bento);
    padding: 40px 20px;
    transition: var(--transition-smooth);
    height: 100%;
}

.glass-counter-card:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-10px);
    border-color: var(--accent-color);
}

.counter-icon-circle {
    width: 65px;
    height: 65px;
    margin: 0 auto;
    background: var(--grad-premium);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 10px 20px rgba(236, 64, 158, 0.3);
}

.text-accent-pink {
    color: var(--accent-color) !important;
}

.z-index-2 { z-index: 2; }

/* --- PROJECT CARD SPECIFIC STYLES --- */
.project-progress-container {
    height: 5px;
    background: rgba(99, 16, 132, 0.05);
    width: 100%;
}

.project-progress-bar {
    height: 100%;
    background: var(--grad-premium);
    transition: width 1s ease-in-out;
}

.badge-status {
    font-size: 0.6rem;
    padding: 4px 10px;
    border-radius: 4px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background: rgba(99, 16, 132, 0.1);
    color: var(--primary-color);
}

.status-done {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.extra-small {
    font-size: 0.7rem;
}

.avatar-sm {
    font-size: 1.1rem;
}

/* Hover Accent for links */
.hover-accent-color:hover {
    color: var(--accent-color) !important;
}

/* --- BLOG/NEWS SECTION REFINEMENTS --- */
.blog-glass-meta {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(13, 2, 17, 0.6);
    backdrop-filter: blur(8px);
    padding: 5px 12px;
    border-radius: 50px;
    color: white;
    font-size: 0.7rem;
    font-weight: 600;
    z-index: 3;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.text-accent-pink {
    color: #ec409e !important;
}

/* Lightbox overlay fix */
.gallery-overlay .btn-outline-glass i {
    font-size: 0.9rem;
}

/* Consistent Row Height for News */
.blog .impact-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog .impact-card:hover {
    transform: translateY(-5px);
}

/* --- MODERN GALLERY UI --- */
.modern-pills .nav-link {
    background: #f8f9fa;
    color: var(--primary-purple);
    font-weight: 600;
    font-size: 0.85rem;
    border: 1px solid transparent;
    transition: all 0.3s ease;
}

.modern-pills .nav-link.active {
    background: var(--grad-premium) !important;
    color: white !important;
    box-shadow: 0 4px 15px rgba(236, 64, 158, 0.3) !important;
}

.gallery-card-modern {
    border-radius: 12px;
    transition: var(--transition-smooth);
}

.gallery-card-modern:hover {
    transform: scale(1.02);
}

.gallery-modern-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(13, 2, 17, 0.8);
    opacity: 0;
    transition: all 0.4s ease;
    z-index: 2;
}

.gallery-card-modern:hover .gallery-modern-overlay {
    opacity: 1;
}

.btn-glass-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.btn-glass-circle:hover {
    background: var(--accent-pink);
    color: white;
    transform: rotate(90deg);
}

.extra-small { font-size: 0.65rem; }

/* --- VOLUNTEER SECTION UI --- */
.volunteer-img-frame {
    position: relative;
    padding: 15px;
}

.volunteer-img-frame img {
    border-radius: 30px;
    transform: rotate(-3deg);
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.volunteer-img-frame:hover img {
    transform: rotate(0deg) scale(1.02);
}

.glass-floating-badge {
    position: absolute;
    bottom: 0px;
    right: 0px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(10px);
    padding: 15px 25px;
    border-radius: 20px;
    box-shadow: var(--shadow-premium);
    border: 1px solid rgba(255, 255, 255, 0.5);
    text-align: center;
    z-index: 5;
}

.check-icon-circle {
    width: 28px;
    height: 28px;
    background: var(--grad-premium);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    flex-shrink: 0;
}

/* Avatar Stack for Social Proof */
.avatar-stack .avatar-sm {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: 3px solid white;
    margin-right: -12px;
    object-fit: cover;
    transition: all 0.3s ease;
}

.avatar-stack:hover .avatar-sm {
    margin-right: 2px;
}

.bg-decoration-circle {
    position: absolute;
    top: -10%;
    left: -5%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(236, 64, 158, 0.05) 0%, transparent 70%);
    z-index: 0;
}

/* Animation for Floating Badge */
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

.animate-float {
    animation: float 4s ease-in-out infinite;
}

/* --- PARTNERS SECTION REFINEMENTS --- */
.partner-logo-wrapper {
    background: #ffffff;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    border-radius: 16px;
    transition: all 0.4s ease;
    border: 1px solid rgba(0,0,0,0.03);
}

.partner-logo-img {
    max-height: 70px;
    width: auto !important; /* Prevents Owl Carousel from stretching logos */
    filter: grayscale(100%);
    opacity: 0.6;
    transition: all 0.4s ease;
}

.partner-card:hover .partner-logo-wrapper {
    transform: translateY(-5px);
    border-color: var(--accent-pink);
    box-shadow: 0 10px 30px rgba(236, 64, 158, 0.15) !important;
}

.partner-card:hover .partner-logo-img {
    filter: grayscale(0%);
    opacity: 1;
    transform: scale(1.05);
}

.partner-meta h6 {
    transition: color 0.3s ease;
}

.partner-card:hover .partner-meta h6 {
    color: var(--primary-purple) !important;
}

.extra-small {
    font-size: 0.7rem;
    letter-spacing: 0.3px;
}

</style>
@section('content')

<div class="container-fluid carousel-header vh-100 px-0 overflow-hidden">
    <div id="heroCarousel" class="carousel slide carousel-fade vh-100" data-bs-ride="carousel" data-bs-interval="8000">
        
        <div class="carousel-indicators custom-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        </div>
        
        <div class="carousel-inner h-100">
            <div class="carousel-item active vh-100">
                <div class="hero-overlay"></div>
                <img src="{{ asset('images/banner1.png') }}" class="w-100 h-100 banner-img" alt="Building Awareness">
                <div class="carousel-caption d-flex align-items-center justify-content-center">
                    <div class="p-4 p-md-5 text-center hero-content-box" 
                         x-data="{ show: false }" 
                         x-init="setTimeout(() => show = true, 300)" 
                         x-show="show" 
                         x-transition:enter="transition ease-out duration-1000" 
                         x-transition:enter-start="opacity-0 translate-y-10">
                        
                        <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest animate__animated animate__fadeInDown">
                            Building Awareness
                        </span>
                        <h1 class="display-2 text-white fw-bold mb-4 display-font">
                            Empowering Youth,<br><span class="text-gradient">Preventing Pregnancies</span>
                        </h1>
                        <p class="mb-5 mx-auto text-light lead opacity-75 hero-subtitle">
                            Join us in spreading awareness and preventing teenage pregnancy through knowledge and empowerment. Every step counts toward a brighter future in Rwanda.
                        </p>
                        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center gap-4">
                            <a class="btn-premium" href="#">Get Involved</a>
                            <a class="btn-outline-glass" href="/causes">Learn More <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item vh-100">
                <div class="hero-overlay"></div>
                <img src="{{ asset('images/banner1.png') }}" class="w-100 h-100 banner-img" alt="Education">
                <div class="carousel-caption d-flex align-items-center justify-content-center">
                    <div class="p-4 p-md-5 text-center hero-content-box">
                        <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest">
                            Transforming Education
                        </span>
                        <h1 class="display-2 text-white fw-bold mb-4 display-font">Education is the <span class="text-gradient">Key</span></h1>
                        <p class="mb-5 mx-auto text-light lead opacity-75 hero-subtitle">
                            Our programs educate teens on reproductive health, making informed choices, and reclaiming their potential through academic support.
                        </p>
                        <div class="d-flex justify-content-center">
                            <a class="btn-premium" href="#">Support Our Mission</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="hero-control-icon"><i class="fas fa-long-arrow-alt-left"></i></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="hero-control-icon"><i class="fas fa-long-arrow-alt-right"></i></span>
        </button>
    </div>
</div>

<div class="container-fluid about-section py-5 position-relative overflow-hidden">
    <div class="bg-circle-gradient"></div>

    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-xl-5">
                <div class="image-wrapper position-relative">
                    <div class="image-border-decoration"></div>
                    <img src="{{ asset('images/banner1.png') }}" class="img-fluid rounded-bento shadow-premium position-relative z-index-1" alt="Happy Family Rwanda Welcome">
                    
                    <div class="experience-badge-premium d-none d-sm-block animate__animated animate__pulse animate__infinite">
                        <div class="badge-inner">
                            <span class="h2 d-block mb-0 fw-bold">100%</span>
                            <small class="text-uppercase tracking-widest fw-bold">Compassion</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="content-box ps-xl-5">
                    <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest">About Our Organization</span>
                    <h2 class="display-5 mb-4 display-font fw-bold">
                        Empowering Communities in <span class="text-gradient">Rwanda</span>
                    </h2>
                    
                    <p class="lead mb-4 text-muted opacity-90">
                        Happy Family Rwanda Organization (HFRO) is a compassionate NGO dedicated to creating positive change through collective action and empowerment.
                    </p>

                    <div class="custom-tabs-container">
                        <ul class="nav nav-pills modern-glass-pills mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-1" type="button">Our Story</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-2" type="button">Mission</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-3" type="button">Vision</button>
                            </li>
                        </ul>

                        <div class="tab-content impact-tab-content p-4 rounded-bento shadow-premium bg-white" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
                                <h5 class="mb-3 display-font fw-bold"><i class="fas fa-history me-2 text-accent-pink"></i>Who We Are</h5>
                                <div class="tab-description mb-4 text-muted">
                                    {!! $organization->about !!}
                                </div>
                                <a href="/about" class="btn-premium-sm text-decoration-none">
                                    Read Full Story <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>

                            <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                <h5 class="mb-3 display-font fw-bold"><i class="fas fa-bullseye me-2 text-accent-pink"></i>Our Purpose</h5>
                                <div class="tab-description mb-4 text-muted">
                                    {!! $organization->mission !!}
                                </div>
                                <a href="/contact" class="btn-premium-sm text-decoration-none">Learn More</a>
                            </div>

                            <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                <h5 class="mb-3 display-font fw-bold"><i class="fas fa-eye me-2 text-accent-pink"></i>Our Dream</h5>
                                <div class="tab-description mb-4 text-muted">
                                    {!! $organization->vision !!}
                                </div>
                                <a href="/donate" class="btn-premium-sm text-decoration-none">Get Involved Today</a>
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
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest">Our Impacts</span>
            <h2 class="display-5 fw-bold mb-3 display-font">Empowering Change, <span class="text-gradient">Transforming Lives</span></h2>
            <p class="text-muted lead">Transparent, data-driven results from our frontline work in Rwanda.</p>
        </div>

        <div class="row g-4">
            @foreach ($causes as $cause)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="impact-card h-100 shadow-premium">
                    <div class="impact-img-container position-relative overflow-hidden rounded-bento">
                        <img src="{{ asset('storage/'.$cause->mainPhoto->file_path) }}" 
                             class="img-fluid w-100 impact-main-img" 
                             alt="{{ $cause->name }}"
                             style="height: 220px; object-fit: cover;">
                        
                        <div class="gallery-overlay">
                             <a href="{{ route('causes.show', $cause->slug) }}" class="btn-outline-glass border-white btn-sm py-2 px-3">
                                <i class="fas fa-eye me-1"></i> View Impact
                             </a>
                        </div>
                        <span class="badge-active-cause">Active Cause</span>
                    </div>

                    <div class="impact-content d-flex flex-column flex-grow-1 pt-4">
                        <a href="{{ route('causes.show', $cause->slug) }}" class="text-decoration-none">
                            <h5 class="fw-bold text-dark mb-3 hover-accent-color">{{ $cause->name }}</h5>
                        </a>
                        
                        <p class="text-muted small mb-4 flex-grow-1">
                            {!! Str::limit(strip_tags($cause->description), 85) !!}
                        </p>

                        <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top border-light">
                            <a href="{{ route('causes.show', $cause->slug) }}" class="text-gradient text-decoration-none fw-bold small">
                                Learn More <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            <i class="fas fa-heart text-accent-pink opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>   
            @endforeach

            <div class="col-12 mt-5 text-center">
                <a class="btn-premium" href="{{ route('causes.index') }}">
                    Explore All Impacts <i class="fas fa-globe ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stories -->
<div class="container-fluid impact-section py-5 {{ $stories->count() > 0 ? '' : 'd-none' }}" 
     x-data="{ isMobile: window.innerWidth < 992 }" 
     x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 992)">
    
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest">Our Impact</span>
            <h2 class="display-5 fw-bold mb-3 display-font">Stories of <span class="text-gradient">Change</span></h2>
            <p class="text-muted lead">Discover how Happy Family is fostering resilience and making a real impact in local communities across Rwanda.</p>
        </div>
        
        <div class="row g-4 impact-carousel" :class="isMobile ? 'owl-carousel owl-theme' : ''">
            @foreach ($stories as $story)
            <div class="item" :class="!isMobile ? 'col-lg-4 col-md-6' : ''">
                <div class="impact-card h-100 shadow-premium border-0 overflow-hidden">
                    
                    <div class="impact-img-container position-relative overflow-hidden" style="height: 260px;">
                        @if($story->featuredPhoto)
                            <img src="{{ asset('storage/' . $story->featuredPhoto->file_path) }}" 
                                 alt="{{ $story->title }}" 
                                 class="w-100 h-100 object-fit-cover impact-main-img">
                        @else
                            <div class="bg-light-purple d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-quote-left fa-3x text-primary-color opacity-20"></i>
                            </div>
                        @endif
                        
                        <div class="badge-active-cause" style="background: var(--grad-premium); color: white;">
                            {{ $story->cause->name ?? 'Community' }}
                        </div>

                        <div class="gallery-overlay">
                            <a href="{{ route('stories.show', $story->slug) }}" class="btn-outline-glass border-white py-2 px-4">
                                Read Impact
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-4 d-flex flex-column flex-grow-1 bg-white">
                        <a href="{{ route('stories.show', $story->slug) }}" class="text-decoration-none">
                            <h4 class="fw-bold text-dark mb-3 display-font hover-accent-color" style="line-height: 1.3;">
                                {{ Str::limit($story->title, 50) }}
                            </h4>
                        </a>
                        
                        <p class="text-muted small mb-4 flex-grow-1 opacity-75">
                            {!! Str::limit(strip_tags($story->summary ?? $story->content), 110) !!}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top border-light d-flex justify-content-between align-items-center">
                            <a href="{{ route('stories.show', $story->slug) }}" class="text-gradient text-uppercase fw-bold small text-decoration-none tracking-widest">
                                Full Story <i class="fas fa-chevron-right ms-2" style="font-size: 0.7rem;"></i>
                            </a>
                            <span class="text-muted" style="font-size: 0.7rem;">
                                <i class="far fa-calendar-alt me-1"></i> {{ $story->created_at->format('M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-12 text-center mt-5">
            <a href="{{ route('stories.index') }}" class="btn-premium px-5">
                Explore More Stories <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>

<!-- Impacts -->
<div class="container-fluid counter-section py-5 position-relative">
    <div class="counter-parallax-bg" style="background-image: url('{{ asset('frontend/img/volunteers-bg.jpg') }}');"></div>
    <div class="counter-overlay-gradient"></div>

    <div class="container py-5 position-relative z-index-2">
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest text-white border-white">Achievements</span>
            <h2 class="display-4 text-white fw-bold mb-4 display-font">Our Impact in <span class="text-accent-pink">Numbers</span></h2>
            <p class="text-white opacity-75 lead">
                We take pride in the milestones we've reached through dedicated effort. Each success reflects our commitment and the invaluable support of our partners.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-3">
                <div class="glass-counter-card">
                    <div class="counter-icon-circle mb-4">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h5 class="text-white opacity-50 small text-uppercase tracking-widest mb-2">Projects</h5>
                    <div class="d-flex justify-content-center align-items-baseline">
                        <span class="display-4 fw-bold text-white counter-value" data-toggle="counter-up">100</span>
                        <span class="h2 fw-bold text-accent-pink ms-1">+</span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="glass-counter-card">
                    <div class="counter-icon-circle mb-4">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h5 class="text-white opacity-50 small text-uppercase tracking-widest mb-2">Funds Raised</h5>
                    <div class="d-flex justify-content-center align-items-baseline">
                        <span class="h4 fw-bold text-accent-pink me-1">$</span>
                        <span class="display-4 fw-bold text-white counter-value" data-toggle="counter-up">500</span>
                        <span class="display-4 fw-bold text-white">K</span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="glass-counter-card">
                    <div class="counter-icon-circle mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="text-white opacity-50 small text-uppercase tracking-widest mb-2">Volunteers</h5>
                    <div class="d-flex justify-content-center align-items-baseline">
                        <span class="display-4 fw-bold text-white counter-value" data-toggle="counter-up">416</span>
                        <span class="h2 fw-bold text-accent-pink ms-1">+</span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="glass-counter-card">
                    <div class="counter-icon-circle mb-4">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h5 class="text-white opacity-50 small text-uppercase tracking-widest mb-2">Events</h5>
                    <div class="d-flex justify-content-center align-items-baseline">
                        <span class="display-4 fw-bold text-white counter-value" data-toggle="counter-up">17</span>
                        <span class="h2 fw-bold text-accent-pink ms-1">+</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-center mt-5 pt-4">
            <a class="btn-premium px-5 py-3" href="#">
                JOIN OUR MISSION <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>

<!-- Projects -->
<div class="container-fluid impact-section py-5 {{ $projects->count() > 0 ? '' : 'd-none' }}">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest">Recent Projects</span>
            <h2 class="display-5 fw-bold mb-3 display-font">Our <span class="text-gradient">Transformative</span> Efforts</h2>
            <p class="text-muted lead">We are passionate about addressing the challenges faced by underprivileged communities in Rwanda through sustainable change.</p>
        </div>

        <div class="row g-4">
            @foreach($projects as $project)
            <div class="col-lg-6 col-md-6 col-xl-4">
                <div class="impact-card h-100 shadow-premium border-0 bg-white overflow-hidden">
                    
                    <div class="impact-img-container position-relative overflow-hidden">
                        <img src="{{ $project->featured_image_url }}" 
                             alt="{{ $project->title }}"
                             class="img-fluid impact-main-img w-100"
                             style="height: 260px; object-fit: cover;">
                        
                        <div class="badge-active-cause" style="background: var(--grad-premium); color: white; top: 15px; left: 15px; right: auto;">
                            {{ $project->causes->first()->name ?? 'General' }}
                        </div>

                        <div class="gallery-overlay d-flex flex-column justify-content-center align-items-center px-4 text-center">
                            <div class="mb-3">
                                <span class="d-block text-white small text-uppercase tracking-widest opacity-75">Target Goal</span>
                                <h4 class="text-white fw-bold">RWF {{ number_format($project->budget, 0) }}</h4>
                            </div>
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn-outline-glass btn-sm px-4">
                                Details <i class="fas fa-info-circle ms-1"></i>
                            </a>
                        </div>
                    </div>

                    <div class="project-progress-container">
                        <div class="project-progress-bar" style="width: {{ $project->progress }}%;"></div>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <i class="far fa-user-circle text-primary-color"></i>
                                </div>
                                <span class="text-muted extra-small fw-bold text-uppercase">{{ $project->creator->name ?? 'HFRO Admin' }}</span>
                            </div>
                            <span class="badge-status {{ $project->status == 'Completed' ? 'status-done' : 'status-active' }}">
                                {{ $project->status }}
                            </span>
                        </div>
                        
                        <a href="{{ route('projects.show', $project->slug) }}" class="text-decoration-none">
                            <h5 class="fw-bold text-dark mb-2 display-font hover-accent-color">{{ $project->title }}</h5>
                        </a>
                        
                        <p class="text-muted small mb-4 opacity-75">
                            {{ Str::limit(strip_tags($project->summary), 95) }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top border-light d-flex justify-content-between align-items-center">
                            <a href="{{ route('projects.show', $project->slug) }}" class="text-gradient fw-bold small text-decoration-none">
                                VIEW PROJECT <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            <a href="#" class="btn-premium-sm px-3 py-2 text-decoration-none" style="font-size: 0.75rem;">
                                DONATE NOW
                            </a>
                        </div>
                    </div>
                </div>
            </div> 
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('projects.index') }}" class="btn-premium px-5">
                EXPLORE ALL PROJECTS <i class="fas fa-th-large ms-2"></i>
            </a>
        </div>
    </div>
</div>

<!-- Events -->
<div class="container-fluid event-section py-5 {{ $events->count() > 0 ? '' : 'd-none' }}"
     x-data="{ count: {{ $events->count() }} }"
     x-init="
        $(document).ready(function(){
            $('.event-carousel').owlCarousel({
                loop: count > 3,
                margin: 24,
                nav: false,
                dots: true,
                autoplay: true,
                smartSpeed: 800,
                responsive:{
                    0:{ items:1 },
                    768:{ items:2 },
                    1200:{ items:3 }
                }
            });
        });
     ">
    
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest">Upcoming Events</span>
            <h2 class="display-5 fw-bold mb-3 display-font">Join Our <span class="text-gradient">Community</span></h2>
            <p class="text-muted lead">Participate in our upcoming initiatives. Together, we can create meaningful change on the ground in Rwanda.</p>
        </div>

        <div class="event-carousel owl-carousel owl-theme premium-dots">
            @foreach ($events as $event)
            <div class="item pb-4">
                <div class="impact-card h-100 shadow-premium border-0 bg-white overflow-hidden">
                    
                    <div class="impact-img-container position-relative overflow-hidden">
                        <div class="position-absolute" style="top: 15px; left: 15px; z-index: 10;">
                            @if($event->status === 'ongoing')
                                <span class="badge-status-pill bg-ongoing shadow-sm">
                                    <span class="pulse-dot"></span> Ongoing
                                </span>
                            @elseif($event->status === 'completed')
                                <span class="badge-status-pill bg-secondary shadow-sm text-white">
                                    Past Event
                                </span>
                            @else
                                <span class="badge-status-pill bg-upcoming shadow-sm text-white">
                                    Upcoming
                                </span>
                            @endif
                        </div>

                        @php 
                            $displayPhoto = $event->featuredPhoto ?? $event->event_photos->first(); 
                        @endphp
                        <img src="{{ $displayPhoto ? asset('storage/' . $displayPhoto->file_path) : asset('frontend/img/placeholder.jpg') }}" 
                             alt="{{ $event->event }}" 
                             class="w-100 impact-main-img"
                             style="height: 250px; object-fit: cover;">
                        
                        <div class="event-glass-date shadow-sm">
                            <span class="day">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                            <span class="month">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                        </div>

                        <div class="gallery-overlay">
                            <a href="{{ route('events.show', $event->slug ?? $event->id) }}" class="btn-outline-glass btn-sm px-4">
                                I'm Interested
                            </a>
                        </div>
                    </div>

                    <div class="p-4 d-flex flex-column" style="min-height: 280px;">
                        <div class="d-flex align-items-center mb-3 text-muted small fw-bold">
                            <span class="me-3"><i class="fas fa-map-marker-alt text-gradient-icon me-1"></i> {{ Str::limit($event->location, 20) }}</span>
                            <span><i class="fas fa-clock text-gradient-icon me-1"></i> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</span>
                        </div>

                        <a href="{{ route('events.show', $event->slug ?? $event->id) }}" class="text-decoration-none">
                            <h4 class="fw-bold text-dark mb-3 display-font hover-accent-color" style="line-height: 1.3;">
                                {{ Str::limit($event->event, 45) }}
                            </h4>
                        </a>

                        <p class="text-muted small mb-4 flex-grow-1 opacity-75">
                            {{ Str::limit(strip_tags($event->description), 100) }}
                        </p>

                        <div class="mt-auto">
                            <a class="btn-premium-outline-sm w-100 text-center" href="{{ route('events.show', $event->slug ?? $event->id) }}">
                                View Details <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>  
            @endforeach
        </div>
    </div>
</div>

<!-- News -->
<div class="container-fluid blog py-5 mb-5 {{ $blogs->count() > 0 ? '' : 'd-none' }}">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest">Latest News</span>
            <h2 class="display-5 fw-bold mb-3 display-font">Stay Updated with Our <span class="text-gradient">Stories</span></h2>
            <p class="text-muted lead">Insights, updates, and inspiring narratives from our mission across Rwanda.</p>
        </div>

        <div class="row g-4">
            @foreach ($blogs as $blog)
            <div class="col-lg-6 col-xl-3">
                <div class="impact-card h-100 shadow-premium border-0 bg-white overflow-hidden">
                    <div class="impact-img-container position-relative overflow-hidden" style="height: 200px;">
                        @if($blog->blogPhoto)
                            <img src="{{ asset('storage/'. $blog->blogPhoto->file_path) }}" 
                                 class="w-100 h-100 object-fit-cover impact-main-img" 
                                 alt="{{ $blog->title }}">
                        @else
                            <div class="bg-light-purple d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-newspaper fa-3x text-primary-color opacity-20"></i>
                            </div>
                        @endif
                        
                        <div class="blog-glass-meta">
                            <span class="me-2"><i class="fa fa-heart text-accent-pink me-1"></i>{{ $blog->likes->count() }}</span>
                            <span><i class="fa fa-comment text-white me-1"></i>{{ $blog->comments->count() }}</span>
                        </div>

                        <div class="gallery-overlay">
                            <a href="{{ asset('storage/'. ($blog->blogPhoto->file_path ?? '')) }}" 
                               data-lightbox="blog-gallery" 
                               class="btn-outline-glass btn-sm px-3 me-2">
                                <i class="fas fa-search-plus"></i>
                            </a>
                            <a href="/blog/{{ $blog->slug }}" class="btn-outline-glass btn-sm px-3">
                                <i class="fas fa-link"></i>
                            </a>
                        </div>
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <div class="mb-2">
                            <small class="text-gradient fw-bold text-uppercase tracking-wider" style="font-size: 0.7rem;">
                                <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('M d, Y') }}
                            </small>
                        </div>
                        
                        <a href="/blog/{{ $blog->slug }}" class="text-decoration-none">
                            <h5 class="fw-bold text-dark mb-3 hover-accent-color display-font" style="line-height: 1.4;">
                                {{ Str::limit($blog->title, 50) }}
                            </h5>
                        </a>
                        
                        <p class="text-muted small mb-4 flex-grow-1">
                            {{ Str::limit(strip_tags($blog->content), 90) }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top border-light">
                            <a class="text-dark fw-bold small text-decoration-none hover-accent-color" href="/blog/{{ $blog->slug }}">
                                READ ARTICLE <i class="fas fa-chevron-right ms-2" style="font-size: 0.7rem;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<! -- Gallery -->
<div class="container-fluid gallery py-5 my-5 {{ $gallery->count() > 0 ? '' : 'd-none' }}">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 900px;">
            <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest">Our Gallery</span>
            <h2 class="display-5 fw-bold mb-3 display-font">Capture the <span class="text-gradient">Magic</span> With Us</h2>
            <p class="text-muted lead">
                Explore our curated collection showcasing the vibrant experiences and community impact we create together in Rwanda.
            </p>
        </div>

        <div class="tab-class text-center">
            <ul class="nav nav-pills modern-pills d-inline-flex justify-content-center mb-5 gap-2">
                <li class="nav-item">
                    <a class="nav-link active px-4 py-2 rounded-pill shadow-sm" data-bs-toggle="pill" href="#GalleryTab-all">All</a>
                </li>
                @php
                    $categories = ['Volunteering', 'Entertainment', 'Workshop', 'Sport'];
                @endphp
                @foreach($categories as $category)
                <li class="nav-item">
                    <a class="nav-link px-4 py-2 rounded-pill shadow-sm" data-bs-toggle="pill" href="#{{ $category }}Tab">{{ $category }}</a>
                </li>
                @endforeach
            </ul>

            <div class="tab-content text-start"> {{-- Changed to text-start for card alignment --}}
                {{-- All Photos Tab --}}
                <div id="GalleryTab-all" class="tab-pane fade show active p-0">
                    <div class="row g-3">
                        @foreach ($gallery as $photo)
                        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                            {{-- Clean Laravel Component Syntax --}}
                            <x-partials.gallery-card :photo="$photo" tab="all" />
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Categorized Tabs --}}
                @foreach($categories as $category)
                <div id="{{ $category }}Tab" class="tab-pane fade p-0">
                    <div class="row g-3">
                        @foreach ($gallery->where('category', $category) as $photo)
                        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                            <x-partials.gallery-card :photo="$photo" :tab="$category" />
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

        <!-- Volunteers Start -->
<div class="container-fluid volunteer py-5 mt-5 impact-section overflow-hidden position-relative">
    {{-- Decorative Background Element --}}
    <div class="bg-decoration-circle"></div>

    <div class="container py-5">
        <div class="row g-5 align-items-center">
            {{-- Image Side --}}
            <div class="col-lg-5 position-relative">
                <div class="volunteer-img-frame">
                    <img src="{{ asset('frontend/img/Volunteers.jpg') }}" 
                         class="img-fluid premium-shadow transition-all" 
                         alt="Volunteers at Happy Family Rwanda">
                    
                    {{-- Floating Glass Badge --}}
                    <div class="glass-floating-badge animate-float">
                        <h4 class="text-gradient fw-bold mb-0">100%</h4>
                        <small class="text-dark fw-bold text-uppercase tracking-tighter" style="font-size: 9px;">Free to Join</small>
                    </div>
                </div>
            </div>

            {{-- Text Side --}}
            <div class="col-lg-7">
                <div class="ps-lg-4">
                    <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest">Become a Volunteer</span>
                    <h2 class="display-5 fw-bold mb-4 display-font">Together, we can make a <span class="text-gradient">lasting difference</span>.</h2>
                    
                    <p class="mb-4 text-muted lead">
                        True change happens when hearts and hands come together. At <strong>Happy Family Rwanda Organization</strong>, your energy and passion are the greatest gifts you can offer our community.
                    </p>

                    <div class="row mb-5">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center mb-3">
                                    <div class="check-icon-circle me-3"><i class="fa fa-check"></i></div>
                                    <span class="fw-medium text-dark">Warm, friendly community</span>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <div class="check-icon-circle me-3"><i class="fa fa-check"></i></div>
                                    <span class="fw-medium text-dark">Professional free training</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center mb-3">
                                    <div class="check-icon-circle me-3"><i class="fa fa-check"></i></div>
                                    <span class="fw-medium text-dark">No strict requirements</span>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <div class="check-icon-circle me-3"><i class="fa fa-check"></i></div>
                                    <span class="fw-medium text-dark">Impactful environments</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-4">
                        <a class="btn-premium-lg px-5 shadow-premium text-decoration-none" href="#">
                            JOIN OUR FAMILY <i class="fas fa-heart ms-2"></i>
                        </a>
                        
                        <div class="volunteer-stats-group">
                            <div class="avatar-stack d-flex me-3">
                                <img src="https://ui-avatars.com/api/?name=V1&background=ec409e&color=fff" class="avatar-sm" alt="v">
                                <img src="https://ui-avatars.com/api/?name=V2&background=6366f1&color=fff" class="avatar-sm" alt="v">
                                <img src="https://ui-avatars.com/api/?name=V3&background=8b5cf6&color=fff" class="avatar-sm" alt="v">
                                <div class="avatar-sm bg-dark text-white d-flex align-items-center justify-content-center" style="font-size: 10px;">+50</div>
                            </div>
                            <small class="text-muted fw-bold">Active Volunteers</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- Volunteers End -->

         <!-- Our Partners -->
<div class="container-fluid partners-section py-5 {{ $partners->count() > 0 ? '' : 'd-none' }}" style="background: #fafafa;">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <span class="badge-impact text-uppercase mb-3 d-inline-block tracking-widest">Our Partners</span>
            <h2 class="display-6 fw-bold mb-3 display-font">Building Impact <span class="text-gradient">Together</span></h2>
            <p class="text-muted lead">Our mission is made possible through the strategic collaboration and support of these visionary organizations.</p>
        </div>

        <div class="partner-carousel owl-carousel owl-theme premium-dots" 
             x-data="{ count: {{ $partners->count() }} }" 
             x-init="
                $(document).ready(function(){
                    $('.partner-carousel').owlCarousel({
                        loop: count > 5,
                        margin: 30,
                        autoplay: true,
                        autoplayTimeout: 4000,
                        smartSpeed: 1000,
                        dots: true,
                        nav: false,
                        responsive: {
                            0: { items: 2 },
                            600: { items: 3 },
                            1000: { items: 5 }
                        }
                    });
                });
             ">
            @forelse ($partners as $partner)
                <div class="item">
                    <a href="{{ $partner->website }}" target="_blank" class="partner-card text-decoration-none">
                        <div class="partner-logo-wrapper shadow-premium mb-3">
                            <img src="{{ asset('storage/' . $partner->logo) }}" 
                                 class="partner-logo-img" 
                                 alt="{{ $partner->name }}">
                        </div>
                        <div class="partner-meta text-center">
                            <h6 class="fw-bold text-dark mb-1 small">{{ Str::limit($partner->name, 25) }}</h6>
                            <p class="text-muted extra-small mb-0">{{ Str::limit($partner->description, 40) }}</p>
                        </div>
                    </a>
                </div> 
            @empty
                <div class="w-100 text-center py-5">
                    <p class="text-muted italic">Partnerships coming soon...</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
      
 @push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('impactSlider', () => ({
            $carousel: null,
            
            init() {
                // Ensure jQuery is available before running
                this.$carousel = $('.impact-carousel');
                
                // Use a debounce to prevent firing resize 100 times per second
                let resizeTimer;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(() => this.handleCarousel(), 250);
                });

                this.handleCarousel();
            },

            handleCarousel() {
                if (window.innerWidth < 992) {
                    if (!this.$carousel.hasClass('owl-loaded')) {
                        this.$carousel.owlCarousel({
                            items: 1,
                            margin: 20,
                            loop: true,
                            dots: true,
                            autoplay: true,
                            responsive: { 
                                0: { items: 1 }, 
                                768: { items: 2 } 
                            }
                        });
                    }
                } else {
                    // Properly destroy when scaling back to desktop
                    if (this.$carousel.hasClass('owl-loaded')) {
                        this.$carousel.trigger('destroy.owl.carousel').removeClass('owl-loaded owl-drag');
                        this.$carousel.find('.owl-stage-outer').children().unwrap();
                    }
                }
            }
        }));
    });

    // Standard Static Initializations
    $(document).ready(function() {
        $(".event-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            dots: true,
            loop: true,
            margin: 25,
            nav: true,
            navText: [
                '<i class="bi bi-arrow-left"></i>',
                '<i class="bi bi-arrow-right"></i>'
            ],
            responsive: {
                0: { items: 1 },
                768: { items: 2 },
                992: { items: 3 }
            }
        });
    });
</script>
@endpush
@endsection