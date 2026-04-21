@extends('layouts.app')

@section('title', 'Contribute: ' . $project->title . ' | HFRO')

@section('content')
{{-- --- DYNAMIC HERO SECTION --- --}}
<div class="container-fluid position-relative overflow-hidden vh-60 d-flex align-items-center" style="background: var(--dark-void);">
    {{-- Optimization: Using your accessor for Namecheap compatibility --}}
    <img src="{{ $project->featured_image_url }}" 
         class="position-absolute top-0 start-0 w-100 h-100 animate-slow-zoom" 
         style="object-fit: cover; opacity: 0.4; filter: brightness(0.7);" 
         alt="{{ $project->title }}">
         
    <div class="container position-relative text-center animate__animated animate__fadeIn" style="z-index: 5;">
        <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill" 
             style="background: rgba(232, 62, 140, 0.2); border: 1px solid var(--accent-pink);">
            <small class="text-accent-pink fw-black text-uppercase tracking-wider" style="font-size: 0.75rem;">Support a Mission</small>
        </div>
        
        <h1 class="text-white display-3 fw-black mb-4 text-shadow-sm">{{ $project->title }}</h1>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('donations.index') }}" class="text-white-50 text-decoration-none">Donations</a></li>
                <li class="breadcrumb-item active text-accent-pink fw-bold" aria-current="page">Contribute</li>
            </ol>
        </nav>
    </div>

    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; transform: rotate(180deg);">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width: 150%; height: 50px; fill: #f8f9fa;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
</div>

<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="row g-5">
            {{-- --- MAIN CONTENT COLUMN --- --}}
            <div class="col-lg-8">
                {{-- PROJECT NARRATIVE --}}
                <div class="bg-white p-4 p-md-5 rounded-bento shadow-premium border-0 overflow-hidden">
                    <h3 class="text-purple fw-black mb-4 display-6">The Impact of your Gift</h3>
                    <article class="brand-rich-text fs-5 text-muted mb-5 leading-relaxed content-area">
                        {!! $project->description !!}
                    </article>
                    
                    {{-- IMPACT TILES --}}
                    <div class="row g-3 mb-5">
                        <div class="col-md-4">
                            <div class="p-4 rounded-4 bg-soft-primary border-0 h-100 text-center">
                                <div class="fs-2 mb-2">🌱</div>
                                <h6 class="fw-bold">$15</h6>
                                <p class="x-small text-muted mb-0">Basic materials for one local beneficiary.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 rounded-4 bg-soft-success border-0 h-100 text-center">
                                <div class="fs-2 mb-2">⚙️</div>
                                <h6 class="fw-bold">$150</h6>
                                <p class="x-small text-muted mb-0">Infrastructure and technical setup costs.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 rounded-4 bg-soft-warning border-0 h-100 text-center">
                                <div class="fs-2 mb-2">🏆</div>
                                <h6 class="fw-bold">$500</h6>
                                <p class="x-small text-muted mb-0">Full sponsorship for a major milestone.</p>
                            </div>
                        </div>
                    </div>

                    @php $photo = $project->project_photos->first(); @endphp
                    @if($photo)
                        <img src="{{ asset('storage/' . $photo->path) }}" class="w-100 rounded-bento shadow mb-5" style="max-height: 450px; object-fit: cover;">
                    @endif

                    <h3 class="fw-black text-purple mb-4">Sustainability</h3>
                    <p class="text-muted leading-relaxed">
                        {{ $project->summary ?? 'Your support ensures that we can maintain this initiative long-term, creating a cycle of self-reliance for families in Rwanda.' }}
                    </p>
                </div>
            </div>

            {{-- --- SIDEBAR COLUMN --- --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px; z-index: 5;">
                    
                    {{-- DONATION CARD --}}
                    <div class="bg-white p-4 rounded-bento shadow-lg border-0 mb-4">
                        @php 
                            $percent = $project->goal_amount > 0 ? min(round(($project->raised_amount / $project->goal_amount) * 100), 100) : 0;
                        @endphp
                        
                        <div class="d-flex justify-content-between align-items-end mb-2">
                            <h3 class="fw-black text-purple mb-0">${{ number_format($project->raised_amount) }}</h3>
                            <span class="text-muted small">Target: ${{ number_format($project->goal_amount) }}</span>
                        </div>
                        <div class="progress rounded-pill mb-4" style="height: 12px;">
                            <div class="progress-bar bg-accent-pink" style="width: {{ $percent }}%"></div>
                        </div>
                        
                        <form action="{{ route('donations.checkout') }}" method="GET">
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <div class="row g-2 mb-4">
                                <div class="col-6"><button type="submit" name="amount" value="50" class="btn btn-outline-purple w-100 py-3 fw-bold">$50</button></div>
                                <div class="col-6"><button type="submit" name="amount" value="100" class="btn btn-outline-purple w-100 py-3 fw-bold">$100</button></div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-purple-gradient w-100 py-3 rounded-pill fw-black shadow">
                                        DONATE TO THIS PROJECT
                                    </button>
                                </div>
                            </div>
                        </form>
                        <p class="x-small text-center text-muted mb-0">
                            <i class="fas fa-lock me-1"></i> Secure payment via Paystack
                        </p>
                    </div>

                    {{-- IMPACT TRANSPARENCY --}}
                    <div class="bg-white p-4 rounded-bento shadow-premium border-start border-accent border-5 mb-4">
                        <h6 class="text-accent-pink fw-black text-uppercase small mb-3">Project Verification</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-center mb-3">
                                <div class="bg-light p-2 rounded-circle me-3"><i class="fas fa-user-shield text-purple"></i></div>
                                <div class="small">
                                    <span class="text-muted d-block">Project Lead</span>
                                    <strong class="text-dark">{{ $project->creator->name ?? 'Jacques Musengimana' }}</strong>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="bg-light p-2 rounded-circle me-3"><i class="fas fa-map-marker-alt text-purple"></i></div>
                                <div class="small">
                                    <span class="text-muted d-block">Location</span>
                                    <strong class="text-dark">{{ $project->causes->first()->name ?? 'National' }} • Rwanda</strong>
                                </div>
                            </li>
                        </ul>
                    </div>

                    {{-- STATUS CARD --}}
                    <div class="card border-0 bg-purple text-white rounded-bento p-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-check-circle me-2"></i>Mission Control</h5>
                        <div class="timeline-small">
                            <div class="t-item active">
                                <span class="t-dot" style="background: var(--accent-pink)"></span>
                                <p class="small mb-0 fw-bold">Currently Fundraising</p>
                                <p class="x-small opacity-75">100% of funds go to direct costs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .vh-60 { height: 60vh; }
    .bg-soft-purple { background: rgba(99, 16, 132, 0.1); }
    .bg-soft-primary { background: #eef2ff; }
    .bg-soft-success { background: #ecfdf5; }
    .bg-soft-warning { background: #fffbeb; }
    .py-100 { padding: 100px 0; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .x-small { font-size: 0.8rem; }
    .leading-relaxed { line-height: 1.8; }
    .content-area p { margin-bottom: 1.5rem; }

    /* Timeline */
    .timeline-small { border-left: 2px solid rgba(255,255,255,0.2); margin-left: 10px; padding-left: 20px; }
    .t-item { position: relative; padding-bottom: 5px; }
    .t-dot { position: absolute; left: -27px; top: 5px; width: 12px; height: 12px; border-radius: 50%; border: 2px solid #fff; }
</style>
@endsection