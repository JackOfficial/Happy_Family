@extends('layouts.app')
@section('title', 'Impacts | Happy Family Rwanda Organization')
@push('styles')
    <style>
    .impact-card:hover { transform: translateY(-10px); }
    .impact-card:hover img { transform: scale(1.1); }
    .impact-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.4);
        opacity: 0;
        transition: 0.3s;
    }
    .impact-card:hover .impact-overlay { opacity: 1; }
    .hover-primary:hover { color: var(--bs-primary) !important; }
    .rounded-custom { border-radius: 30px; }
</style>
@endpush
@section('content')
<div class="container-fluid position-relative overflow-hidden" style="background: #000; padding: 120px 0 80px 0;">
    {{-- Banner logic: Use a high-quality impact image or a specific asset --}}
    <img src="{{ asset('frontend/img/breadcrumb-bg.jpg') }}" class="banner-img position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; z-index: 1; opacity: 0.6;" alt="Impact Header">
    <div class="overlay" style="z-index: 2; background: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(0,0,0,0.4));"></div>
    
    <div class="container text-center position-relative" style="z-index: 3;">
        <h5 class="text-white tracking-widest text-uppercase mb-3 opacity-90">What We Do</h5>
        <h1 class="text-white display-3 mb-4 fw-bold">Our Impact & Causes</h1>
        <p class="lead text-white opacity-90 mx-auto mb-4" style="max-width: 700px;">
            Transforming lives across Rwanda through dedicated programs in health, education, and community resilience.
        </p>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-white opacity-75 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-info fw-bold" aria-current="page">Our Impacts</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid impact-section py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="text-uppercase text-primary mb-2">Our Mission In Action</h5>
            <h2 class="display-5 mb-3 text-dark">Sustaining Change</h2>
            <div class="mx-auto mb-4" style="width: 80px; height: 3px; background: var(--bs-primary);"></div>
            <p class="text-muted">Every cause we support is a step toward a more self-reliant and empowered Rwanda. Explore the areas where your support makes a difference.</p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach ($causes as $cause)
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="impact-card h-100 shadow-sm border-0 bg-white" style="border-radius: 20px; overflow: hidden; transition: 0.3s;">
                    <div class="impact-img-container position-relative overflow-hidden" style="height: 240px;">
                        @php 
                            $displayPhoto = $cause->mainPhoto ?? $cause->photos->first(); 
                        @endphp

                        @if($displayPhoto)
                            <img src="{{ asset('storage/'.$displayPhoto->file_path) }}" 
                                 class="img-fluid w-100 h-100" 
                                 alt="{{ $cause->name }}" 
                                 style="object-fit: cover; transition: transform 0.5s ease;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center w-100 h-100">
                                <i class="fas fa-hand-holding-heart fa-3x text-white-50"></i>
                            </div>
                        @endif
                        
                        <div class="impact-tag position-absolute top-0 start-0 m-3 badge bg-primary px-3 py-2">
                            Focus Area
                        </div>

                        <div class="impact-overlay d-flex align-items-center justify-content-center">
                            {{-- Updated to use slug-based route --}}
                            <a href="{{ route('causes.show', $cause->slug) }}" class="btn btn-light rounded-pill px-4 py-2 text-decoration-none fw-bold shadow">
                                View Details <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1">
                        {{-- Updated to use slug-based route --}}
                        <a href="{{ route('causes.show', $cause->slug) }}" class="h5 mb-3 text-dark text-decoration-none fw-bold hover-primary">
                            {{ $cause->name }}
                        </a>
                        
                        <div class="impact-text text-muted mb-4 small" style="line-height: 1.6;">
                            {!! Str::limit(strip_tags($cause->description), 120) !!}
                        </div>

                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            {{-- Updated to use slug-based route --}}
                            <a href="{{ route('causes.show', $cause->slug) }}" class="text-primary text-uppercase fw-bold text-decoration-none" style="font-size: 0.75rem; letter-spacing: 1px;">
                                Learn More <i class="fas fa-chevron-right ms-1"></i>
                            </a>
                            <span class="text-danger opacity-75"><i class="fas fa-heart"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination added to match the Controller's ->paginate(9) --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $causes->links() }}
        </div>
    </div>
</div>

{{-- Call to Action --}}
<div class="container py-5 mb-5 rounded-custom shadow-lg text-center position-relative overflow-hidden" 
     style="background: #6f42c1; color: white; border-radius: 30px;">
    <div class="position-absolute top-0 end-0 p-5 opacity-10">
        <i class="fas fa-quote-right fa-10x"></i>
    </div>
    <div class="position-relative" style="z-index: 2;">
        <h2 class="mb-4 fw-bold">Ready to make an impact?</h2>
        <p class="mb-5 opacity-90 mx-auto" style="max-width: 600px;">Your contribution, whether small or large, helps us continue our mission of building a healthier Rwanda.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="/donate" class="btn btn-warning rounded-pill px-5 py-3 fw-bold shadow">Donate Now</a>
            <a href="/contact" class="btn btn-outline-light rounded-pill px-5 py-3 fw-bold">Become a Volunteer</a>
        </div>
    </div>
</div>
@endsection