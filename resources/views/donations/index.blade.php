@extends('layouts.app')

@section('title', 'Our Projects & Impact | Happy Family Rwanda Organization')

@section('content')
<div class="container-fluid position-relative overflow-hidden vh-70 d-flex align-items-center" style="background: var(--dark-void);">
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(to bottom, rgba(45, 13, 82, 0.8) 0%, rgba(0, 0, 0, 0.6) 100%); z-index: 2;"></div>
        <img src="{{ asset('storage/headers/donation-hero.jpg') }}" 
             class="w-100 h-100 animate-slow-zoom" 
             style="object-fit: cover;" 
             alt="Impact in Rwanda">
    </div>
    
    <div class="container position-relative text-center py-5" style="z-index: 10;">
        <div class="badge bg-accent-pink px-3 py-2 rounded-pill mb-4 animate__animated animate__fadeInDown">
            <i class="fas fa-heart me-2"></i> ACTIVE MISSIONS 2026
        </div>
        <h1 class="text-white display-2 fw-black mb-4 animate__animated animate__fadeInUp">
            Change a <span class="brand-text">Life</span> Today
        </h1>
        <p class="lead text-white opacity-75 mx-auto mb-5 fs-4" style="max-width: 800px;">
            At Happy Family, we don't just give charity; we build self-reliance. Choose a specific project below to see exactly how your contribution creates a future.
        </p>
        <a href="#projects" class="btn btn-purple-gradient btn-lg rounded-pill px-5 shadow-lg">View Our Projects</a>
    </div>
</div>

<div id="projects" class="container-fluid bg-white py-100">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-lg-7">
                <h5 class="text-accent-pink fw-bold text-uppercase tracking-widest mb-2">Urgent Needs</h5>
                <h2 class="fw-black text-purple mb-0">Help Us Complete These Missions</h2>
            </div>
            <div class="col-lg-5 text-lg-end">
                <p class="text-muted mb-0">Your donation directly funds these vetted community projects.</p>
            </div>
        </div>

        <div class="row g-4">
            {{-- Project 1: Education --}}
            <div class="col-lg-4 col-md-6">
                <div class="project-card shadow-premium rounded-bento overflow-hidden h-100 border-0 bg-white">
                    <div class="position-relative overflow-hidden" style="height: 240px;">
                        <img src="{{ asset('storage/projects/school.jpg') }}" class="w-100 h-100 img-zoom" style="object-fit: cover;">
                        <div class="project-tag">Education</div>
                    </div>
                    <div class="p-4">
                        <h4 class="fw-black text-purple mb-3">Vocational Toolkits for Youth</h4>
                        <p class="text-muted small mb-4">Help 50 Level 5 students acquire the networking tools and laptops needed for their final certification exams.</p>
                        
                        <div class="progress-wrapper mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold text-dark">$3,400 <small class="text-muted">Raised</small></span>
                                <span class="small fw-bold text-accent-pink">75%</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 8px;">
                                <div class="progress-bar bg-accent-pink" style="width: 75%"></div>
                            </div>
                        </div>
                        
                        <a href="/projects/vocational-kits" class="btn btn-outline-purple w-100 rounded-pill fw-bold">Read Story & Donate</a>
                    </div>
                </div>
            </div>

            {{-- Project 2: Health/Nutrition --}}
            <div class="col-lg-4 col-md-6">
                <div class="project-card shadow-premium rounded-bento overflow-hidden h-100 border-0 bg-white">
                    <div class="position-relative overflow-hidden" style="height: 240px;">
                        <img src="{{ asset('storage/projects/nutrition.jpg') }}" class="w-100 h-100 img-zoom" style="object-fit: cover;">
                        <div class="project-tag bg-success">Nutrition</div>
                    </div>
                    <div class="p-4">
                        <h4 class="fw-black text-purple mb-3">Community Feeding Program</h4>
                        <p class="text-muted small mb-4">Ensuring consistent school meals for 200 children in rural Kigali to improve concentration and attendance.</p>
                        
                        <div class="progress-wrapper mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold text-dark">$1,200 <small class="text-muted">Raised</small></span>
                                <span class="small fw-bold text-accent-pink">40%</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 8px;">
                                <div class="progress-bar bg-accent-pink" style="width: 40%"></div>
                            </div>
                        </div>
                        
                        <a href="/projects/nutrition" class="btn btn-outline-purple w-100 rounded-pill fw-bold">Read Story & Donate</a>
                    </div>
                </div>
            </div>

            {{-- Project 3: Water --}}
            <div class="col-lg-4 col-md-12">
                <div class="project-card shadow-premium rounded-bento overflow-hidden h-100 border-0 bg-white">
                    <div class="position-relative overflow-hidden" style="height: 240px;">
                        <img src="{{ asset('storage/projects/water.jpg') }}" class="w-100 h-100 img-zoom" style="object-fit: cover;">
                        <div class="project-tag bg-info">Clean Water</div>
                    </div>
                    <div class="p-4">
                        <h4 class="fw-black text-purple mb-3">Clean Water Borehole</h4>
                        <p class="text-muted small mb-4">Constructing a solar-powered water point for a community of 1,200 people currently walking 5km for water.</p>
                        
                        <div class="progress-wrapper mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold text-dark">$8,900 <small class="text-muted">Raised</small></span>
                                <span class="small fw-bold text-accent-pink">89%</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 8px;">
                                <div class="progress-bar bg-accent-pink" style="width: 89%"></div>
                            </div>
                        </div>
                        
                        <a href="/projects/water-mission" class="btn btn-outline-purple w-100 rounded-pill fw-bold">Read Story & Donate</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid bg-light py-100 border-top border-bottom">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <h5 class="text-accent-pink fw-bold text-uppercase mb-2">Support Everything</h5>
                <h2 class="fw-black text-purple mb-4">General Support</h2>
                <p class="text-muted leading-relaxed mb-5">
                    Not sure which project to choose? A general donation allows our directors to allocate funds wherever the need is most urgent today.
                </p>
                <div class="bg-white p-4 rounded-bento shadow-sm mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light p-2 rounded-3 me-3 text-primary"><i class="fas fa-shield-alt"></i></div>
                        <h6 class="fw-bold mb-0 text-dark">Secure Transaction</h6>
                    </div>
                    <p class="small text-muted mb-0">Your payment is encrypted and processed via world-class gateways (PayPal/Paystack).</p>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="bg-white p-4 rounded-bento text-center shadow-sm hover-up border-0 h-100 d-flex flex-column justify-content-center">
                            <h3 class="fw-black text-purple mb-1">$25</h3>
                            <p class="text-muted x-small mb-3">Impact Partner</p>
                            <button class="btn btn-sm btn-purple-gradient rounded-pill">Select</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white p-4 rounded-bento text-center shadow-premium hover-up border-0 h-100 d-flex flex-column justify-content-center border-accent">
                            <h3 class="fw-black text-purple mb-1">$100</h3>
                            <p class="text-muted x-small mb-3">Change Maker</p>
                            <button class="btn btn-sm btn-purple-gradient rounded-pill shadow">Select</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white p-4 rounded-bento text-center shadow-sm hover-up border-0 h-100 d-flex flex-column justify-content-center">
                            <h3 class="fw-black text-purple mb-1">$Custom</h3>
                            <p class="text-muted x-small mb-3">Own Amount</p>
                            <button class="btn btn-sm btn-outline-purple rounded-pill">Type</button>
                        </div>
                    </div>
                </div>

                {{-- Payment Methods Summary --}}
                <div class="mt-5 d-flex flex-wrap gap-4 justify-content-center opacity-75">
                    <div class="d-flex align-items-center"><i class="fas fa-university me-2"></i> Bank</div>
                    <div class="d-flex align-items-center"><i class="fas fa-mobile-alt me-2"></i> Momo</div>
                    <div class="d-flex align-items-center"><i class="fab fa-cc-visa me-2"></i> Visa</div>
                    <div class="d-flex align-items-center"><i class="fab fa-paypal me-2"></i> PayPal</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .vh-70 { height: 70vh; }
    .py-100 { padding: 100px 0; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .leading-relaxed { line-height: 1.8; }
    .x-small { font-size: 0.75rem; }

    /* Project Cards */
    .project-card {
        transition: all 0.4s ease;
    }
    .project-card:hover {
        transform: translateY(-10px);
    }
    .project-tag {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background: var(--grad-premium);
        color: white;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        z-index: 5;
    }
    .img-zoom {
        transition: transform 0.6s ease;
    }
    .project-card:hover .img-zoom {
        transform: scale(1.1);
    }
    .progress-bar {
        border-radius: 50px;
        background: var(--grad-premium) !important;
    }
    .border-accent { border: 2px solid var(--accent-pink) !important; }

    .btn-outline-purple {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
    }
    .btn-outline-purple:hover {
        background: var(--primary-color);
        color: white;
    }
</style>
@endpush
@endsection