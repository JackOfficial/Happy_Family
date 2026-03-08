@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative overflow-hidden section-hero">
    <img src="{{ asset('images/impact.jpg') }}" class="hero-bg-img" alt="Impact Header">
    <div class="hero-overlay"></div>
    
    <div class="container text-center position-relative hero-content">
        <h5 class="brand-subtitle text-white mb-3">Our Impacts</h5>
        <h1 class="text-white display-3 mb-4 fw-bold">Transforming Lives</h1>
        <p class="lead text-white opacity-90 mx-auto mb-4" style="max-width: 700px;">
            Together, we’re building a future where every individual thrives through sustainable initiatives.
        </p>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-pink fw-bold" aria-current="page">{{ $cause->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid py-5 bg-white">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h5 class="brand-subtitle-centered mb-2">Detailed Focus</h5>
                    <h2 class="brand-title-dark display-5 mb-3">{{ $cause->name }}</h2>
                    <div class="title-line-center mx-auto"></div>
                </div>
                
                <div class="brand-description-area fs-5 text-muted">
                    {!! $cause->description !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-5 bg-light {{ $projects->count() > 0 ? '' : 'd-none' }}">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="text-uppercase text-pink fw-bold mb-2">Our Work in Action</h5>
            <h2 class="brand-title-dark mb-4">Recent Projects in {{ $cause->name }}</h2>
            <p class="text-muted">Tangible results from our community-driven efforts.</p>
        </div>

        <div class="row g-4">
            @foreach($projects as $project)
            <div class="col-lg-4 col-md-6" x-data="{ hovered: false }">
                <div class="impact-card h-100 border-0 shadow-sm overflow-hidden bg-white" 
                     @mouseenter="hovered = true" 
                     @mouseleave="hovered = false"
                     style="border-radius: 15px;">
                    
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $project->project_photo?->file_path ? asset('storage/' . $project->project_photo->file_path) : asset('images/default.png') }}" 
                             class="w-100" 
                             :class="hovered ? 'scale-110' : ''"
                             style="height: 220px; object-fit: cover; transition: 0.6s ease;" 
                             alt="{{ $project->title }}">
                        
                        <div class="position-absolute bottom-0 start-0 w-100 p-3" 
                             style="background: linear-gradient(transparent, rgba(0,0,0,0.7)); z-index: 2;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-white small fw-bold">Goal: RWF {{ number_format($project->budget, 0) }}</span>
                                <a href="/donate" class="btn btn-sm btn-pink rounded-pill px-3">Donate</a>
                            </div>
                        </div>
                    </div>

                    <div class="progress w-100" style="height: 5px; border-radius: 0;">
                        <div class="progress-bar {{ $project->progress == 100 ? 'bg-success' : 'bg-pink-gradient' }}" 
                             style="width: {{ $project->progress }}%;"></div>
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge {{ $project->progress == 100 ? 'bg-success' : 'bg-warning-soft' }} rounded-pill text-uppercase" style="font-size: 0.65rem;">
                                {{ $project->progress == 100 ? 'Completed' : 'Ongoing' }}
                            </span>
                            <small class="text-muted fw-bold">{{ $project->progress }}%</small>
                        </div>
                        <h5 class="brand-title-dark fw-bold mb-3 h6">{{ $project->title }}</h5>
                        <p class="text-muted small line-clamp-3 mb-4">
                            {{ Str::limit(strip_tags($project->summary), 110) }}
                        </p>
                        <div class="mt-auto">
                            <a href="{{ url('project/'.$project->id) }}" class="link-impact-sm">
                                View Report <i class="fas fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection