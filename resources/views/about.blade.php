@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative overflow-hidden" style="background: #000; padding: 120px 0 80px 0;">
    <img src="{{ asset('images/about.jpg') }}" class="banner-img position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; z-index: 1;" alt="Header">
    <div class="overlay" style="z-index: 2;"></div>
    
    <div class="container text-center position-relative" style="z-index: 3;">
        <h5 class="text-white tracking-widest text-uppercase mb-3 opacity-90">About Our Journey</h5>
        <h1 class="text-white display-3 mb-4 fw-bold">Happy Family Rwanda Organization</h1>
        <p class="lead text-white opacity-90 mx-auto" style="max-width: 700px;">Together, we are building a healthy, educated, and self-reliant Rwanda through compassion and collective action.</p>
    </div>
</div>
<div class="container-fluid about-section py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="image-wrapper position-relative">
                    <img src="{{ asset('images/about.jpg') }}" class="img-fluid rounded-custom shadow-lg" alt="About Us">
                    <div class="experience-badge d-none d-md-block animate-bounce">
                        <span class="h2 d-block mb-0">HFRO</span>
                        <small class="text-uppercase fw-bold" style="font-size: 0.6rem; letter-spacing: 1px;">Community First</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h5 class="brand-subtitle mb-2">Who We Are</h5>
                <h2 class="brand-title display-5 mb-4">Founded on Love and Resilience</h2>
                <div class="tab-description text-muted">
                    {!! $organization->about !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid impact-section py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center flex-column-reverse flex-lg-row">
            <div class="col-lg-6">
                <h5 class="brand-subtitle mb-2">Our Mission</h5>
                <h2 class="brand-title-dark display-5 mb-4">A Purpose-Driven Mission</h2>
                <div class="tab-description text-muted">
                    {!! $organization->mission !!}
                </div>
                <div class="mt-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="benefit-icon me-3"><i class="fas fa-check"></i></div>
                        <span class="text-purple fw-bold">Health & Wellness Focus</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="benefit-icon me-3"><i class="fas fa-check"></i></div>
                        <span class="text-purple fw-bold">Educational Empowerment</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="image-wrapper position-relative">
                    <img src="{{ asset('images/about.jpg') }}" class="img-fluid rounded-custom shadow-lg" alt="Mission">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid about-section py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="volunteer-img-wrapper position-relative">
                    <img src="{{ asset('images/about.jpg') }}" class="img-fluid rounded-custom shadow-lg" alt="Vision">
                </div>
            </div>
            <div class="col-lg-6">
                <h5 class="brand-subtitle mb-2">Our Vision</h5>
                <h2 class="brand-title display-5 mb-4">The Future We Envision</h2>
                <div class="tab-description text-muted">
                    {!! $organization->vision !!}
                </div>
                <a href="{{ route('donate') }}" class="btn-modern-accent mt-4">Support Our Vision</a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-5" style="background: var(--primary-purple);">
    <div class="container text-center py-4">
        <h3 class="text-white mb-4 fw-bold">Together, we can make Rwanda a nation of healthy, empowered, and happy families.</h3>
        <div class="title-line-center mx-auto mb-4" style="background: var(--accent-pink);"></div>
        <a href="{{ route('contact') }}" class="btn-modern bg-white text-purple">Join Our Mission <i class="fas fa-heart ms-2 text-pink"></i></a>
    </div>
</div>
@endsection