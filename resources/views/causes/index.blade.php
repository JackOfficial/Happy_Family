@extends('layouts.app')

@section('title', 'Impacts | Happy Family Rwanda Organization')

@section('content')
<div class="container-fluid position-relative overflow-hidden vh-75 d-flex align-items-center" style="background: var(--dark-void);">
    <img src="{{ asset('frontend/img/breadcrumb-bg.jpg') }}" class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; opacity: 0.5; z-index: 1;" alt="Impact Header">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, transparent, var(--dark-void)); z-index: 2;"></div>
    
    <div class="container text-center position-relative" style="z-index: 3;">
        <h5 class="text-accent-pink tracking-widest text-uppercase mb-3 fw-bold animate__animated animate__fadeInDown">What We Do</h5>
        <h1 class="text-white display-3 mb-4 fw-black">Our Impact & <span class="brand-text">Causes</span></h1>
        <p class="lead text-white opacity-75 mx-auto mb-5" style="max-width: 750px;">
            Transforming lives across Rwanda through dedicated programs in health, education, and community resilience.
        </p>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
                <li class="breadcrumb-item"><a href="/" class="text-white opacity-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-accent-pink fw-bold" aria-current="page">Our Impacts</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid py-100 bg-light">
    <div class="container">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="text-accent-pink fw-bold text-uppercase mb-2">Our Mission In Action</h5>
            <h2 class="display-5 mb-3 fw-black text-purple">Sustaining Change</h2>
            <div class="mx-auto mb-4" style="width: 80px; height: 4px; background: var(--grad-premium); border-radius: 2px;"></div>
            <p class="text-muted fs-5">Every cause we support is a step toward a more self-reliant and empowered Rwanda. Explore the areas where your support makes a difference.</p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach ($causes as $cause)
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="impact-card border-0 bg-white">
                    <div class="position-relative overflow-hidden" style="height: 260px; border-radius: 20px 20px 0 0;">
                        @php 
                            $displayPhoto = $cause->mainPhoto ?? $cause->photos->first(); 
                        @endphp

                        @if($displayPhoto)
                            <img src="{{ asset('storage/'.$displayPhoto->file_path) }}" 
                                 class="img-fluid w-100 h-100" 
                                 alt="{{ $cause->name }}" 
                                 style="object-fit: cover; transition: transform 0.6s ease;">
                        @else
                            <div class="bg-purple d-flex align-items-center justify-content-center w-100 h-100 opacity-25">
                                <i class="fas fa-hand-holding-heart fa-3x text-purple"></i>
                            </div>
                        @endif
                        
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge-impact">Focus Area</span>
                        </div>

                        <div class="gallery-overlay">
                            <a href="{{ route('causes.show', $cause->slug) }}" class="btn btn-light rounded-pill px-4 py-2 text-decoration-none fw-bold shadow-sm">
                                View Details <i class="fas fa-arrow-right ms-2 text-accent-pink"></i>
                            </a>
                        </div>
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <a href="{{ route('causes.show', $cause->slug) }}" class="h5 mb-3 text-purple text-decoration-none fw-black hover-accent">
                            {{ $cause->name }}
                        </a>
                        
                        <div class="text-muted mb-4 small flex-grow-1" style="line-height: 1.6;">
                            {!! Str::limit(strip_tags($cause->description), 110) !!}
                        </div>

                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('causes.show', $cause->slug) }}" class="text-accent-pink text-uppercase fw-bold text-decoration-none" style="font-size: 0.75rem; letter-spacing: 1px;">
                                Learn More <i class="fas fa-chevron-right ms-1"></i>
                            </a>
                            <span class="text-accent-pink opacity-75"><i class="fas fa-heart"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5 pagination-premium">
            {{ $causes->links() }}
        </div>
    </div>
</div>

<div class="container my-100 p-0 overflow-hidden shadow-premium" style="border-radius: var(--radius-bento);">
    <div class="row g-0">
        <div class="col-lg-8 p-5 p-md-5 d-flex flex-column justify-content-center" style="background: var(--grad-premium);">
            <div class="position-relative" style="z-index: 2;">
                <h2 class="text-white mb-4 fw-black display-5">Ready to make an impact?</h2>
                <p class="text-white opacity-90 mb-5 fs-5">Your contribution, whether small or large, helps us continue our mission of building a healthier Rwanda.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="/donate" class="btn btn-light rounded-pill px-5 py-3 fw-black text-purple shadow-lg">
                        DONATE NOW <i class="fas fa-heart ms-2 text-accent-pink"></i>
                    </a>
                    <a href="/contact" class="btn btn-outline-light rounded-pill px-5 py-3 fw-bold border-2">
                        BECOME A VOLUNTEER
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-none d-lg-block">
            <div class="h-100 w-100" style="background: url('{{ asset('images/volunteer.jpg') }}') center/cover;"></div>
        </div>
    </div>
</div>

@push('styles')
   <style>
    .py-100 { padding: 100px 0; }
    .my-100 { margin: 100px auto; }
    .fw-black { font-weight: 900; }
    .text-purple { color: var(--primary-color); }
    .hover-accent:hover { color: var(--accent-color) !important; }
    
    /* Luxury Pagination */
    .pagination-premium .page-link {
        border-radius: 50% !important;
        margin: 0 5px;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        border: 1px solid rgba(99, 16, 132, 0.1);
        font-weight: 700;
    }
    .pagination-premium .page-item.active .page-link {
        background: var(--grad-premium);
        border: none;
    }

    @media (max-width: 768px) {
        .display-3 { font-size: 2.8rem; }
        .py-100 { padding: 60px 0; }
    }
</style> 
@endpush
@endsection