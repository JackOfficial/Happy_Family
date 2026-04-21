@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative overflow-hidden vh-75 d-flex align-items-center" style="background: var(--dark-void);">
    <img src="{{ asset('images/about.jpg') }}" class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; opacity: 0.5; z-index: 1;" alt="Header">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, transparent, var(--dark-void)); z-index: 2;"></div>
    
    <div class="container text-center position-relative" style="z-index: 3;" 
         x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <h5 class="text-accent-pink tracking-widest text-uppercase mb-3 fw-bold animate__animated" 
            x-show="show" x-transition:enter="animate__fadeInDown">
            About Our Journey
        </h5>
        <h1 class="text-white display-3 mb-4 fw-black">
            Building Stronger <span class="brand-text">Families</span>
        </h1>
        <p class="lead text-white opacity-75 mx-auto" style="max-width: 750px;"
           x-show="show" x-transition:enter="animate__fadeInUp">
            Together, we are building a healthy, educated, and self-reliant Rwanda through compassion and collective action.
        </p>
    </div>
</div>

<div class="container py-100" x-data="{ visible: false }" x-intersect="visible = true">
    <div class="row g-5 align-items-center">
        <div class="col-lg-6" :class="visible ? 'animate__animated animate__fadeInLeft' : 'opacity-0'">
            <div class="position-relative">
                <img src="{{ asset('images/about.jpg') }}" class="img-fluid rounded-bento shadow-premium" alt="About Us">
                <div class="volunteer-overlay d-none d-md-block text-center border-accent">
                    <span class="h3 d-block mb-0 fw-black text-purple">HFRO</span>
                    <small class="text-uppercase fw-bold text-accent-pink" style="font-size: 0.7rem; letter-spacing: 2px;">Community First</small>
                </div>
            </div>
        </div>
        <div class="col-lg-6" :class="visible ? 'animate__animated animate__fadeInRight' : 'opacity-0'">
            <h5 class="text-accent-pink fw-bold mb-2">Who We Are</h5>
            <h2 class="display-5 fw-black text-purple mb-4">Founded on Love and Resilience</h2>
            <div class="text-muted fs-5 leading-relaxed">
                {!! $organization->about !!}
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-100 bg-white" style="border-top: 1px solid rgba(0,0,0,0.05);">
    <div class="container" x-data="{ visible: false }" x-intersect="visible = true">
        <div class="row g-5 align-items-center flex-column-reverse flex-lg-row">
            <div class="col-lg-6" :class="visible ? 'animate__animated animate__fadeInLeft' : 'opacity-0'">
                <h5 class="text-accent-pink fw-bold mb-2">Our Mission</h5>
                <h2 class="display-5 fw-black text-purple mb-4">A Purpose-Driven Mission</h2>
                <div class="text-muted fs-5 mb-4">
                    {!! $organization->mission !!}
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 rounded-pill bg-light border-start border-4 border-accent">
                            <i class="fas fa-heartbeat text-accent-pink me-3 fs-4"></i>
                            <span class="fw-bold text-dark">Health & Wellness</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 rounded-pill bg-light border-start border-4 border-success">
                            <i class="fas fa-graduation-cap text-success-green me-3 fs-4"></i>
                            <span class="fw-bold text-dark">Empowerment</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" :class="visible ? 'animate__animated animate__fadeInRight' : 'opacity-0'">
                <div class="position-relative p-3">
                    <div class="position-absolute top-0 end-0 w-75 h-75 bg-purple opacity-10 rounded-bento" style="z-index: 0; transform: translate(20px, -20px);"></div>
                    <img src="{{ asset('images/about.jpg') }}" class="img-fluid rounded-bento shadow-premium position-relative" style="z-index: 1;" alt="Mission">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-100" x-data="{ visible: false }" x-intersect="visible = true">
    <div class="row g-5 align-items-center">
        <div class="col-lg-6" :class="visible ? 'animate__animated animate__zoomIn' : 'opacity-0'">
            <div class="position-relative">
                <img src="{{ asset('images/about.jpg') }}" class="img-fluid rounded-bento shadow-premium" alt="Vision">
            </div>
        </div>
        <div class="col-lg-6" :class="visible ? 'animate__animated animate__fadeInRight' : 'opacity-0'">
            <h5 class="text-accent-pink fw-bold mb-2">Our Vision</h5>
            <h2 class="display-5 fw-black text-purple mb-4">The Future We Envision</h2>
            <div class="text-muted fs-5 mb-5">
                {!! $organization->vision !!}
            </div>
            <a href="/donate" class="btn-premium">
                Support Our Vision <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>

<div class="container-fluid py-5" style="background: var(--grad-premium);">
    <div class="container text-center py-5">
        <h2 class="text-white mb-4 fw-black display-6">Together, we can make Rwanda a nation of healthy families.</h2>
        <div class="mx-auto mb-5" style="height: 4px; width: 80px; background: rgba(255,255,255,0.4); border-radius: 2px;"></div>
        <a href="/contact" class="btn btn-lg bg-white text-purple fw-black rounded-pill px-5 py-3 shadow-lg hover-up">
            JOIN OUR MISSION <i class="fas fa-heart ms-2 text-accent-pink"></i>
        </a>
    </div>
</div>

@push('styles')
   <style>
    .py-100 { padding: 100px 0; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .border-accent { border: 1px solid var(--accent-color) !important; }
    .text-purple { color: var(--primary-color); }
    .hover-up { transition: 0.3s ease; }
    .hover-up:hover { transform: translateY(-5px); }
</style> 
@endpush
@endsection