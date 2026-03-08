@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative overflow-hidden" style="background: #000; padding: 120px 0 80px 0;">
    <img src="{{ asset('images/impact.jpg') }}" class="banner-img position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; z-index: 1; opacity: 0.6;" alt="Impact Header">
    <div class="overlay" style="z-index: 2; background: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(0,0,0,0.4));"></div>
    
    <div class="container text-center position-relative" style="z-index: 3;">
        <h5 class="text-white tracking-widest text-uppercase mb-3 opacity-90">What We Do</h5>
        <h1 class="text-white display-3 mb-4 fw-bold">Our Impact & Causes</h1>
        <p class="lead text-white opacity-90 mx-auto mb-4" style="max-width: 700px;">
            Transforming lives across Rwanda through dedicated programs in health, education, and community resilience.
        </p>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-white opacity-75 decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-pink fw-bold" aria-current="page">Our Impacts</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-fluid impact-section py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="brand-subtitle-centered mb-2">Our Mission In Action</h5>
            <h2 class="brand-title-dark display-5 mb-3">Sustaining Change</h2>
            <div class="title-line-center mx-auto mb-4"></div>
            <p class="text-muted">Every cause we support is a step toward a more self-reliant and empowered Rwanda. Explore the areas where your support makes a difference.</p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach ($causes as $cause)
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                <div class="impact-card h-100 shadow-sm border-0 glass-morphism">
                    <div class="impact-img-container position-relative overflow-hidden">
                        @if($cause->mainPhoto)
                            <img src="{{ asset('storage/'.$cause->mainPhoto->file_path) }}" class="img-fluid w-100" alt="{{ $cause->name }}" style="transition: transform 0.5s ease;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-hand-holding-heart fa-3x text-white-50"></i>
                            </div>
                        @endif
                        
                        <div class="impact-tag position-absolute top-0 start-0 m-3">
                            Cause
                        </div>

                        <div class="impact-overlay d-flex align-items-center justify-content-center">
                            <a href="/cause/{{ $cause->id }}" class="btn-impact-view text-decoration-none">
                                View Details <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1 bg-white rounded-bottom-custom">
                        <a href="/cause/{{ $cause->id }}" class="impact-card-title h5 mb-3 text-dark text-decoration-none fw-bold">
                            {{ $cause->name }}
                        </a>
                        
                        <div class="impact-text text-muted mb-4 small">
                            {!! Str::limit(strip_tags($cause->description), 110) !!}
                        </div>

                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <a href="/cause/{{ $cause->id }}" class="link-learn-more text-uppercase fw-bold" style="font-size: 0.75rem;">
                                Learn More <i class="fas fa-chevron-right ms-1"></i>
                            </a>
                            <span class="text-pink"><i class="fas fa-heart"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="container py-5 mb-5 rounded-custom shadow-lg text-center position-relative overflow-hidden" 
     style="background: var(--primary-purple); color: white;">
    <div class="position-absolute top-0 end-0 p-5 opacity-10">
        <i class="fas fa-quote-right fa-10x"></i>
    </div>
    <div class="position-relative" style="z-index: 2;">
        <h2 class="mb-4">Ready to make an impact?</h2>
        <p class="mb-5 opacity-90 mx-auto" style="max-width: 600px;">Your contribution, whether small or large, helps us continue our mission of building a healthier Rwanda.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="/donate" class="btn-modern-accent px-5 py-3">Donate Now</a>
            <a href="/contact" class="btn-modern bg-white text-purple px-5 py-3">Become a Volunteer</a>
        </div>
    </div>
</div>
@endsection