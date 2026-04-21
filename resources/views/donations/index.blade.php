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
            @forelse($projects as $project)
                @php 
                    // Dynamic Progress Calculation
                    $percent = $project->goal_amount > 0 
                        ? min(round(($project->raised_amount / $project->goal_amount) * 100), 100) 
                        : 0;
                    
                    // Image Logic
                    $photo = $project->project_photos->first();
                    $imagePath = $photo ? asset('storage/' . $photo->path) : asset('images/default-project.jpg');
                @endphp

                <div class="col-lg-4 col-md-6">
                    <div class="project-card shadow-premium rounded-bento overflow-hidden h-100 border-0 bg-white">
                        <div class="position-relative overflow-hidden" style="height: 240px;">
                            <img src="{{ $imagePath }}" class="w-100 h-100 img-zoom" style="object-fit: cover;" alt="{{ $project->title }}">
                            
                            {{-- Dynamic Tags from Causes relationship --}}
                            @if($project->causes->isNotEmpty())
                                <div class="project-tag">
                                    {{ $project->causes->first()->name }}
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="fw-black text-purple mb-3 text-truncate-2">{{ $project->title }}</h4>
                            <p class="text-muted small mb-4">
                                {{ $project->summary ?? Str::limit(strip_tags($project->description), 110) }}
                            </p>
                            
                            <div class="progress-wrapper mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small fw-bold text-dark">
                                        ${{ number_format($project->raised_amount) }} 
                                        <small class="text-muted">of ${{ number_format($project->goal_amount) }}</small>
                                    </span>
                                    <span class="small fw-bold text-accent-pink">{{ $percent }}%</span>
                                </div>
                                <div class="progress rounded-pill" style="height: 8px;">
                                    <div class="progress-bar bg-accent-pink" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                            
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-outline-purple w-100 rounded-pill fw-bold">Read Story & Donate</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open text-muted display-4 mb-3"></i>
                    <p class="text-muted">No projects currently seeking funding. Check back soon!</p>
                </div>
            @endforelse
        </div>
        
        {{-- Pagination --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $projects->links() }}
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
                    <p class="small text-muted mb-0">Your payment is encrypted and processed via Paystack (Mobile Money & Cards).</p>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('donations.checkout') }}?amount=25" class="text-decoration-none">
                            <div class="bg-white p-4 rounded-bento text-center shadow-sm hover-up border-0 h-100 d-flex flex-column justify-content-center">
                                <h3 class="fw-black text-purple mb-1">$25</h3>
                                <p class="text-muted x-small mb-3">Impact Partner</p>
                                <span class="btn btn-sm btn-purple-gradient rounded-pill">Select</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('donations.checkout') }}?amount=100" class="text-decoration-none">
                            <div class="bg-white p-4 rounded-bento text-center shadow-premium hover-up border-0 h-100 d-flex flex-column justify-content-center border-accent">
                                <h3 class="fw-black text-purple mb-1">$100</h3>
                                <p class="text-muted x-small mb-3">Change Maker</p>
                                <span class="btn btn-sm btn-purple-gradient rounded-pill shadow">Select</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('donations.checkout') }}" class="text-decoration-none">
                            <div class="bg-white p-4 rounded-bento text-center shadow-sm hover-up border-0 h-100 d-flex flex-column justify-content-center">
                                <h3 class="fw-black text-purple mb-1">$Custom</h3>
                                <p class="text-muted x-small mb-3">Own Amount</p>
                                <span class="btn btn-sm btn-outline-purple rounded-pill">Type</span>
                            </div>
                        </a>
                    </div>
                </div>

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
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }

    .project-card { transition: all 0.4s ease; }
    .project-card:hover { transform: translateY(-10px); }
    .project-tag {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background: linear-gradient(135deg, #631084 0%, #ec409e 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        z-index: 5;
    }
    .img-zoom { transition: transform 0.6s ease; }
    .project-card:hover .img-zoom { transform: scale(1.1); }
    .progress-bar {
        border-radius: 50px;
        background: linear-gradient(135deg, #631084 0%, #ec409e 100%) !important;
    }
    .border-accent { border: 2px solid #ec409e !important; }
    .hover-up { transition: 0.3s; }
    .hover-up:hover { transform: translateY(-5px); }
</style>
@endpush
@endsection