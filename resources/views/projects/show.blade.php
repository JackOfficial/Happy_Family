@extends('layouts.app')

@section('content')
{{-- --- DYNAMIC HERO SECTION --- --}}
<div class="container-fluid position-relative overflow-hidden vh-60 d-flex align-items-center" style="background: var(--dark-void);">
    {{-- Optimization: Using the Accessor to ensure photos show up on Namecheap --}}
    <img src="{{ $project->featured_image_url }}" 
         class="position-absolute top-0 start-0 w-100 h-100 animate-slow-zoom" 
         style="object-fit: cover; opacity: 0.4; filter: brightness(0.7);" 
         alt="{{ $project->title }}">
         
    <div class="container position-relative text-center animate__animated animate__fadeIn" style="z-index: 5;">
        <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill" 
             style="background: rgba(232, 62, 140, 0.2); border: 1px solid var(--accent-pink);">
            <small class="text-accent-pink fw-black text-uppercase tracking-wider" style="font-size: 0.75rem;">Impact Showcase</small>
        </div>
        
        <h1 class="text-white display-3 fw-black mb-4 text-shadow-sm">{{ $project->title }}</h1>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-white-50 text-decoration-none">Projects</a></li>
                <li class="breadcrumb-item active text-accent-pink fw-bold" aria-current="page">Case Study</li>
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
                {{-- QUICK STATS GRID --}}
                <div class="row g-3 mb-5">
                    <div class="col-md-4">
                        <div class="stat-glass-card h-100 p-4 shadow-premium bg-white rounded-bento text-center border-bottom border-accent border-4">
                            <i class="fas fa-wallet text-accent-pink mb-2 fs-4"></i>
                            <span class="d-block small text-uppercase text-muted fw-bold">Project Budget</span>
                            <span class="h5 fw-black text-purple d-block mt-1">RWF {{ number_format($project->budget, 0) }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-glass-card h-100 p-4 shadow-premium bg-white rounded-bento text-center border-bottom border-purple border-4">
                            <i class="fas fa-calendar-alt text-purple mb-2 fs-4"></i>
                            <span class="d-block small text-uppercase text-muted fw-bold">Timeline</span>
                            <span class="h6 fw-bold text-dark d-block mt-1 leading-tight">
                                {{ $project->start_date?->format('M Y') ?? 'Ongoing' }} - {{ $project->duration ?? 'Present' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-glass-card h-100 p-4 shadow-premium bg-white rounded-bento text-center border-bottom border-success border-4">
                            <i class="fas fa-tasks text-success mb-2 fs-4"></i>
                            <span class="d-block small text-uppercase text-muted fw-bold">Execution</span>
                            <div class="impact-progress mt-2 mb-1" style="height: 8px;">
                                <div class="impact-progress-bar bg-success" style="width: {{ $project->progress }}%"></div>
                            </div>
                            <span class="small fw-black text-success">{{ $project->progress }}% COMPLETE</span>
                        </div>
                    </div>
                </div>

                {{-- PROJECT NARRATIVE --}}
                <div class="bg-white p-4 p-md-5 rounded-bento shadow-premium border-0 overflow-hidden">
                    <h3 class="text-purple fw-black mb-4 display-6">Project Overview</h3>
                    <article class="brand-rich-text fs-5 text-muted mb-5 leading-relaxed">
                        {!! $project->description !!}
                    </article>
                    
                    <div class="p-4 rounded-bento bg-light d-flex flex-wrap justify-content-between align-items-center gap-4">
                        <div>
                            <h5 class="fw-black text-purple mb-1">Make this possible</h5>
                            <p class="text-muted small mb-0">Your donation goes directly to the field operations for this project.</p>
                        </div>
                        <a href="{{ url('/donate') }}" class="btn-premium">Donate Now</a>
                    </div>
                </div>

                {{-- SOCIAL SHARE --}}
                <div class="mt-4 d-flex align-items-center justify-content-end">
                    <span class="small fw-bold text-muted me-3">SPREAD THE WORD:</span>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank" class="btn btn-purple btn-sm rounded-circle shadow-sm"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($project->title . ' ' . Request::fullUrl()) }}" target="_blank" class="btn btn-success btn-sm rounded-circle shadow-sm"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>

            {{-- --- SIDEBAR COLUMN --- --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px; z-index: 5;">
                    {{-- CAUSE FILTER BOX --}}
                    <div class="p-4 rounded-bento shadow-lg mb-4 text-white" style="background: var(--grad-premium);">
                        <h5 class="fw-black mb-3"><i class="fas fa-search me-2"></i>Explore Causes</h5>
                        <p class="small opacity-75 mb-4">Select a category to view other transformative initiatives across Rwanda.</p>
                        <form action="{{ route('projects.index') }}" method="GET">
                            <div class="mb-3">
                                <select class="form-select border-0 py-3 rounded-pill shadow-sm" name="cause" style="font-size: 0.9rem;">
                                    <option selected disabled>Choose a Category</option>
                                    @foreach($causes as $cause)
                                        <option value="{{ $cause->id }}">{{ $cause->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-light w-100 rounded-pill py-3 fw-black text-purple shadow-sm">FILTER PROJECTS</button>
                        </form>
                    </div>

                    {{-- IMPACT CREDENTIALS --}}
                    <div class="bg-white p-4 rounded-bento shadow-premium border-start border-accent border-5">
                        <h6 class="text-accent-pink fw-black text-uppercase small mb-3">Project Transparency</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-center mb-3">
                                <div class="bg-light p-2 rounded-circle me-3"><i class="fas fa-user-shield text-purple"></i></div>
                                <div class="small">
                                    <span class="text-muted d-block">Managed By</span>
                                    <strong class="text-dark">{{ $project->creator->name ?? 'HFRO Operations' }}</strong>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="bg-light p-2 rounded-circle me-3"><i class="fas fa-map-marker-alt text-purple"></i></div>
                                <div class="small">
                                    <span class="text-muted d-block">Impact Area</span>
                                    <strong class="text-dark">{{ $project->causes->first()->name ?? 'National / Rwanda' }}</strong>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- --- RELATED INITIATIVES --- --}}
@if($otherProjects->count() > 0)
<div class="container-fluid py-100 bg-white border-top">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h5 class="text-accent-pink fw-bold text-uppercase mb-1">Discover More</h5>
                <h2 class="text-purple fw-black display-5">Related Initiatives</h2>
            </div>
            <a href="{{ route('projects.index') }}" class="btn btn-outline-purple rounded-pill px-4 fw-bold">View All</a>
        </div>

        <div class="row g-4">
            @foreach($otherProjects as $other)
                <div class="col-lg-4">
                    <div class="impact-card h-100 border-0 shadow-premium bg-white rounded-bento overflow-hidden transition-up">
                        <img src="{{ $other->featured_image_url }}" 
                             alt="{{ $other->title }}" 
                             style="width: 100%; height: 220px; object-fit: cover;">
                        <div class="p-4">
                            <h5 class="fw-black text-purple mb-3">{{ Str::limit($other->title, 45) }}</h5>
                            <a href="{{ route('projects.show', $other->slug) }}" class="text-accent-pink fw-bold text-decoration-none small text-uppercase">
                                VIEW DETAILS <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<style>
    .vh-60 { height: 60vh; }
    .leading-relaxed { line-height: 1.8; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .text-purple { color: var(--primary-color); }
    .bg-purple { background: var(--primary-color); }
</style>
@endsection