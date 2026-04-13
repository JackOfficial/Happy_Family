@extends('layouts.app')

@section('content')
{{-- Hero Section --}}
<div class="container-fluid position-relative overflow-hidden" style="min-height: 450px; background: #000;">
    {{-- Optimization: Using the Accessor to ensure photos show up on Namecheap --}}
    <img src="{{ $project->featured_image_url }}" 
         class="position-absolute top-0 start-0 w-100 h-100" 
         style="object-fit: cover; opacity: 0.5;" 
         alt="{{ $project->title }}">
         
    <div class="container position-relative d-flex flex-column justify-content-center text-center" style="min-height: 450px; z-index: 5;">
        <span class="badge-pill-aura mb-3 mx-auto">Project Showcase</span>
        <h1 class="text-white display-4 fw-bold mb-4">{{ $project->title }}</h1>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white opacity-75">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-white opacity-75">Projects</a></li>
                <li class="breadcrumb-item active text-pink fw-bold" aria-current="page">Details</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="row g-5">
            {{-- Main Content --}}
            <div class="col-lg-8">
                <div class="row g-3 mb-5">
                    <div class="col-md-4">
                        <div class="stat-glass-card h-100 p-4 shadow-sm bg-white rounded-4 text-center">
                            <i class="fas fa-wallet text-pink mb-2 fs-4"></i>
                            <span class="d-block small text-uppercase text-muted fw-bold">Budget</span>
                            <span class="h5 fw-bold text-purple d-block mt-1">RWF {{ number_format($project->budget, 0) }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-glass-card h-100 p-4 shadow-sm bg-white rounded-4 text-center">
                            <i class="fas fa-calendar-alt text-pink mb-2 fs-4"></i>
                            <span class="d-block small text-uppercase text-muted fw-bold">Timeline</span>
                            <span class="h6 fw-bold text-purple d-block mt-1">
                                {{ $project->start_date?->format('M Y') ?? 'TBA' }} - {{ $project->duration ?? 'Ongoing' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-glass-card h-100 p-4 shadow-sm bg-white rounded-4 text-center">
                            <i class="fas fa-tasks text-pink mb-2 fs-4"></i>
                            <span class="d-block small text-uppercase text-muted fw-bold">Progress</span>
                            <div class="progress mt-2 mb-1" style="height: 8px; border-radius: 50px;">
                                <div class="progress-bar bg-pink-gradient" style="width: {{ $project->progress }}%"></div>
                            </div>
                            <span class="small fw-bold">{{ $project->progress }}% Completed</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 p-md-5 rounded-5 shadow-premium">
                    <h3 class="brand-title-dark mb-4">Project Overview</h3>
                    <article class="brand-rich-text fs-5 text-muted mb-5">
                        {!! $project->description !!}
                    </article>
                    
                    <hr class="my-5 opacity-5">
                    
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <a href="{{ url('/donate') }}" class="btn-aura-pink px-5">Donate to this cause</a>
                        <div class="share-links">
                            <span class="small text-muted me-2">Share:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank" class="btn btn-sm btn-light rounded-circle"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($project->title . ' ' . Request::fullUrl()) }}" target="_blank" class="btn btn-sm btn-light rounded-circle"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <div class="bg-purple text-white p-4 rounded-5 shadow-lg mb-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-search me-2"></i>Explore Causes</h5>
                        <form action="{{ route('projects.index') }}" method="GET">
                            <div class="mb-3">
                                <select class="form-select border-0 py-3 rounded-4 shadow-sm" name="cause">
                                    <option selected disabled>Choose a Category</option>
                                    @foreach($causes as $cause)
                                        <option value="{{ $cause->id }}">{{ $cause->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-pink w-100 rounded-pill py-2 fw-bold text-white" style="background: var(--accent-pink);">Filter Projects</button>
                        </form>
                    </div>

                    <div class="bg-white p-4 rounded-5 shadow-premium border-start border-pink border-4">
                        <h6 class="text-pink fw-bold text-uppercase small">Our Impact</h6>
                        <p class="text-muted small mb-0">
                            Managed by: <strong>{{ $project->creator->name ?? 'HFRO Admin' }}</strong><br>
                            Impact Area: <strong>{{ $project->causes->first()->name ?? 'Community' }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Related Projects --}}
@if($otherProjects->count() > 0)
<div class="container-fluid py-5 bg-white">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h5 class="text-pink fw-bold mb-0">Discover More</h5>
                <h2 class="brand-title-dark">Related Initiatives</h2>
            </div>
            <a href="{{ route('projects.index') }}" class="btn btn-outline-dark rounded-pill px-4">See All</a>
        </div>

        <div class="row g-4">
            @foreach($otherProjects as $other)
                <div class="col-lg-4">
                    <div class="project-mini-card shadow-sm rounded-4 overflow-hidden border">
                        <img src="{{ $other->featured_image_url }}" 
                             alt="{{ $other->title }}" 
                             style="width: 100%; height: 200px; object-fit: cover;">
                        <div class="p-4 bg-white">
                            <h6 class="fw-bold mb-2 text-dark">{{ Str::limit($other->title, 40) }}</h6>
                            <a href="{{ route('projects.show', $other->slug) }}" class="text-pink small fw-bold text-decoration-none">
                                View Details <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection