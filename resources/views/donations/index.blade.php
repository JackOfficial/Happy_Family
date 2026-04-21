@extends('layouts.app')

@section('title', 'Support Our Missions | Happy Family Rwanda')

@section('content')
{{-- --- HERO SECTION: DRIVING ACTION --- --}}
<div class="container-fluid position-relative overflow-hidden vh-70 d-flex align-items-center" style="background: var(--dark-void);">
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(to bottom, rgba(45, 13, 82, 0.85) 0%, rgba(0, 0, 0, 0.7) 100%); z-index: 2;"></div>
        <img src="{{ asset('storage/headers/donation-hero.jpg') }}" 
             class="w-100 h-100 animate-slow-zoom" 
             style="object-fit: cover;" 
             alt="Impact in Rwanda">
    </div>
    
    <div class="container position-relative text-center py-5" style="z-index: 10;">
        <div class="badge bg-accent-pink px-3 py-2 rounded-pill mb-4 animate__animated animate__fadeInDown">
            <i class="fas fa-heart me-2"></i> BE THE CHANGE
        </div>
        <h1 class="text-white display-2 fw-black mb-4 animate__animated animate__fadeInUp">
            Invest in <span class="brand-text">Hope</span>
        </h1>
        <p class="lead text-white opacity-75 mx-auto mb-5 fs-4" style="max-width: 800px;">
            100% of your donation goes directly to the field. Choose a specific initiative below or give to our general fund to support our most urgent needs.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="#urgent-missions" class="btn btn-purple-gradient btn-lg rounded-pill px-5 shadow-lg">Support a Mission</a>
            <a href="#general-giving" class="btn btn-outline-light btn-lg rounded-pill px-5">General Giving</a>
        </div>
    </div>
</div>

{{-- --- ACTIVE MISSIONS GRID --- --}}
<div id="urgent-missions" class="container-fluid bg-white py-100">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-lg-7">
                <h5 class="text-accent-pink fw-bold text-uppercase tracking-widest mb-2">Fundraising Now</h5>
                <h2 class="fw-black text-purple mb-0">Active Missions in Rwanda</h2>
            </div>
            <div class="col-lg-5 text-lg-end">
                <p class="text-muted mb-0">Every RWF/USD brings these communities closer to self-reliance.</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($projects as $project)
                @php 
                    $percent = $project->goal_amount > 0 
                        ? min(round(($project->raised_amount / $project->goal_amount) * 100), 100) 
                        : 0;
                    
                    // Accessor optimization for hosting
                    $imagePath = $project->featured_image_url ?? asset('images/default-project.jpg');
                @endphp

                <div class="col-lg-4 col-md-6">
                    <div class="project-card shadow-premium rounded-bento overflow-hidden h-100 border-0 bg-white d-flex flex-column">
                        <div class="position-relative overflow-hidden" style="height: 240px;">
                            <img src="{{ $imagePath }}" class="w-100 h-100 img-zoom" style="object-fit: cover;" alt="{{ $project->title }}">
                            
                            @if($project->causes->isNotEmpty())
                                <div class="project-tag">
                                    {{ $project->causes->first()->name }}
                                </div>
                            @endif
                        </div>

                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-black text-purple mb-3 text-truncate-2">{{ $project->title }}</h4>
                            <p class="text-muted small mb-4 flex-grow-1">
                                {{ $project->summary ?? Str::limit(strip_tags($project->description), 110) }}
                            </p>
                            
                            <div class="progress-wrapper mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small fw-bold text-dark">
                                        ${{ number_format($project->raised_amount) }} 
                                        <small class="text-muted">raised</small>
                                    </span>
                                    <span class="small fw-black text-accent-pink">{{ $percent }}%</span>
                                </div>
                                <div class="progress rounded-pill" style="height: 10px; background: #f0f0f0;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="text-center mt-2">
                                    <small class="text-muted x-small uppercase fw-bold">Goal: ${{ number_format($project->goal_amount) }}</small>
                                </div>
                            </div>
                            
                            <a href="{{ route('donations.show', $project->slug) }}" class="btn btn-purple-gradient w-100 rounded-pill fw-black shadow-sm py-3">
                                SUPPORT THIS MISSION
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-light rounded-bento p-5 d-inline-block">
                        <i class="fas fa-heart-broken text-muted display-4 mb-3"></i>
                        <p class="text-muted fw-bold">All current missions are fully funded! Check back soon.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if($projects->hasPages())
            <div class="mt-5 d-flex justify-content-center">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>

{{-- --- GENERAL SUPPORT SECTION --- --}}
<div id="general-giving" class="container-fluid bg-light py-100 border-top">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <h5 class="text-accent-pink fw-bold text-uppercase mb-2">Flexible Impact</h5>
                <h2 class="fw-black text-purple mb-4">HFRO General Fund</h2>
                <p class="text-muted leading-relaxed mb-5 fs-5">
                    Don't want to choose just one? General donations allow our team to react instantly to emergencies and operational needs across all our Rwandan initiatives.
                </p>
                <div class="bg-white p-4 rounded-bento shadow-sm border-start border-4 border-accent-pink">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <h6 class="fw-bold mb-0">100% Transparency</h6>
                    </div>
                    <p class="small text-muted mb-0">Every contribution is tracked and reported in our annual impact report.</p>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="row g-3">
                    @foreach([25 => 'Partner', 100 => 'Change Maker', 500 => 'Visionary'] as $amount => $label)
                    <div class="col-md-4">
                        <a href="{{ route('donations.checkout') }}?amount={{ $amount }}" class="text-decoration-none">
                            <div class="bg-white p-4 rounded-bento text-center shadow-sm hover-up border-0 h-100 d-flex flex-column justify-content-center transition-all {{ $amount == 100 ? 'border-accent shadow-premium' : '' }}">
                                <h3 class="fw-black text-purple mb-1">${{ $amount }}</h3>
                                <p class="text-muted x-small mb-3 fw-bold text-uppercase">{{ $label }}</p>
                                <span class="btn btn-sm {{ $amount == 100 ? 'btn-purple-gradient' : 'btn-outline-purple' }} rounded-pill">Select</span>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="mt-5 text-center">
                    <p class="text-muted small mb-4">WE ACCEPT:</p>
                    <div class="d-flex flex-wrap gap-4 justify-content-center opacity-50 grayscale">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" height="25" alt="PayPal">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" height="15" alt="Visa">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" height="25" alt="Mastercard">
                        <span class="fw-bold text-dark"><i class="fas fa-mobile-alt me-1"></i> MTN & Airtel MoMo</span>
                    </div>
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
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }

    /* Grayscale icons for general giving */
    .grayscale { filter: grayscale(1); }

    .project-card { transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .project-card:hover { transform: translateY(-12px); }
    
    .project-tag {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background: var(--grad-premium);
        color: white;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        z-index: 5;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .img-zoom { transition: transform 0.8s ease; }
    .project-card:hover .img-zoom { transform: scale(1.1); }
    
    .progress-bar {
        border-radius: 50px;
        background: var(--grad-premium) !important;
    }

    .border-accent { border: 2px solid var(--accent-pink) !important; }
    .hover-up:hover { transform: translateY(-8px); }
    .transition-all { transition: all 0.3s ease; }
</style>
@endpush
@endsection