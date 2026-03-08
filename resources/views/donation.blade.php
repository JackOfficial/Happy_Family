@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative overflow-hidden" style="background: #000; padding: 120px 0 80px 0;">
    <img src="{{ asset('frontend/img/breadcrumb-bg.jpg') }}" class="banner-img position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; z-index: 1; opacity: 0.5;" alt="Donation Header">
    <div class="overlay" style="z-index: 2;"></div>
    
    <div class="container text-center position-relative" style="z-index: 3;">
        <h5 class="text-white tracking-widest text-uppercase mb-3 opacity-90">Make a Difference</h5>
        <h1 class="text-white display-3 mb-4 fw-bold">Every Franc Counts</h1>
        <p class="lead text-white opacity-90 mx-auto mb-4" style="max-width: 700px;">
            Your generosity fuels our mission to build a healthy, educated, and self-reliant Rwanda. Help today for a better tomorrow.
        </p>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-white opacity-75 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-pink fw-bold" aria-current="page">Donation</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="brand-subtitle-centered mb-2">Support Our Cause</h5>
            <h2 class="brand-title-dark display-5 mb-3">Your Kindness Saves Lives</h2>
            <div class="title-line-center mx-auto mb-4"></div>
            <p class="text-muted">Choose a cause to support. 100% of your donation goes directly to community programs in Rwanda.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="donation-card shadow-premium h-100">
                    <div class="donation-img-wrapper position-relative overflow-hidden">
                        <img src="{{ asset('frontend/img/donation-1.jpg') }}" class="img-fluid w-100" alt="Education">
                        <div class="donation-category-badge">Education</div>
                    </div>
                    <div class="p-4 bg-white text-center">
                        <h4 class="brand-title-dark mb-3">School Supplies</h4>
                        <p class="text-muted mb-4 small">Empower a student in Kigali with the essential tools they need to succeed in their studies this year.</p>
                        
                        <div class="donation-goal-mini mb-4">
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>Impact: 50 Students</span>
                                <span class="text-pink">80% Funded</span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-pink-gradient" style="width: 80%"></div>
                            </div>
                        </div>

                        <a href="#" class="btn-modern-accent w-100 py-2">Donate Now</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="donation-card shadow-premium h-100 border-brand-accent">
                    <div class="donation-img-wrapper position-relative overflow-hidden">
                        <img src="{{ asset('frontend/img/service-2.jpg') }}" class="img-fluid w-100" alt="Health">
                        <div class="donation-category-badge">Health</div>
                    </div>
                    <div class="p-4 bg-white text-center">
                        <h4 class="brand-title-dark mb-3">Medical Assistance</h4>
                        <p class="text-muted mb-4 small">Providing essential healthcare services and checkups for families in underserved rural areas.</p>
                        
                        <div class="donation-goal-mini mb-4">
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>Impact: 100 Families</span>
                                <span class="text-pink">45% Funded</span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-pink-gradient" style="width: 45%"></div>
                            </div>
                        </div>

                        <a href="#" class="btn-modern-accent w-100 py-2">Donate Now</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mx-auto">
                <div class="donation-card shadow-premium h-100">
                    <div class="donation-img-wrapper position-relative overflow-hidden">
                        <img src="{{ asset('frontend/img/donation-3.jpg') }}" class="img-fluid w-100" alt="Economic">
                        <div class="donation-category-badge">Self-Reliance</div>
                    </div>
                    <div class="p-4 bg-white text-center">
                        <h4 class="brand-title-dark mb-3">Job Training</h4>
                        <p class="text-muted mb-4 small">Supporting vocational training centers that teach youth valuable skills for future employment.</p>
                        
                        <div class="donation-goal-mini mb-4">
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>Impact: 20 Trainees</span>
                                <span class="text-pink">60% Funded</span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-pink-gradient" style="width: 60%"></div>
                            </div>
                        </div>

                        <a href="#" class="btn-modern-accent w-100 py-2">Donate Now</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 p-5 glass-morphism rounded-custom text-center shadow-lg" style="background: white;">
            <h3 class="brand-title-dark mb-4">General Fund Contribution</h3>
            <p class="mb-4 text-muted">Don't have a specific project in mind? Your contribution to our general fund allows us to respond where the need is greatest.</p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <button class="btn-outline-brand rounded-pill px-4 py-2">RWF 5,000</button>
                <button class="btn-outline-brand rounded-pill px-4 py-2">RWF 15,000</button>
                <button class="btn-outline-brand rounded-pill px-4 py-2">RWF 50,000</button>
                <button class="btn-outline-brand rounded-pill px-4 py-2">Other Amount</button>
            </div>
            <div class="mt-4">
                <a href="#" class="btn-modern-accent px-5">Proceed to Secure Payment</a>
            </div>
        </div>
    </div>
</div>
@endsection