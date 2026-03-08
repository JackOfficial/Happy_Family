@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative overflow-hidden" style="background: #000; padding: 120px 0 80px 0;">
    <img src="{{ asset('storage/headers/team.jpg') }}" class="banner-img position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; z-index: 1; opacity: 0.5;" alt="Projects Header">
    <div class="overlay" style="z-index: 2;"></div>
    
    <div class="container text-center position-relative" style="z-index: 3;">
        <h5 class="text-white tracking-widest text-uppercase mb-3 opacity-90">Our Initiatives</h5>
        <h1 class="text-white display-3 mb-4 fw-bold">Projects of Hope</h1>
        <p class="lead text-white opacity-90 mx-auto mb-4" style="max-width: 700px;">
            Every effort we undertake is a step toward equality, opportunity, and dignity. Explore the programs transforming communities across Rwanda.
        </p>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-white opacity-75 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-pink fw-bold" aria-current="page">Projects</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-fluid py-5 {{ $projects->count() > 0 ? '' : 'd-none' }}" style="background: #f8f9fa;">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="brand-subtitle-centered mb-2">Impact in Action</h5>
            <h2 class="brand-title-dark display-5 mb-3">Our Transformative Efforts</h2>
            <div class="title-line-center mx-auto"></div>
        </div>

        <div class="row g-4">
            @foreach($projects as $project)
            <div class="col-lg-6 col-md-6 col-xl-4 mb-4" x-data="{ hovered: false }">
                <div class="impact-card h-100 border-0 shadow-sm" 
                     @mouseenter="hovered = true" 
                     @mouseleave="hovered = false">
                    
                    <div class="impact-img-container position-relative overflow-hidden">
                        <img src="{{ $project->project_photo?->file_path ? asset('storage/' . $project->project_photo->file_path) : asset('images/default.png') }}" 
                             class="img-fluid w-100" 
                             :class="hovered ? 'scale-110' : ''"
                             style="transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); height: 250px; object-fit: cover;"
                             alt="{{ $project->title }}">
                        
                        <div class="position-absolute top-0 start-0 m-3" style="z-index: 4;">
                            <span class="badge py-2 px-3 rounded-pill {{ $project->progress == 100 ? 'bg-success' : 'bg-pink' }}">
                                {{ $project->progress == 100 ? 'Completed' : ucfirst($project->status) }}
                            </span>
                        </div>

                        <div class="impact-overlay d-flex flex-column justify-content-end p-3" 
                             :class="hovered ? 'opacity-100' : 'opacity-0'" 
                             style="transition: 0.4s ease;">
                            <div class="glass-morphism p-3 rounded-custom text-white mb-2">
                                <div class="d-flex justify-content-between mb-1 small">
                                    <span><i class="fas fa-bullseye me-2 text-pink"></i>Goal:</span>
                                    <span class="fw-bold">RWF {{ number_format($project->budget, 0) }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span><i class="fas fa-chart-line me-2 text-pink"></i>Progress:</span>
                                    <span class="fw-bold">{{ $project->progress }}%</span>
                                </div>
                            </div>
                            <a href="/donate" class="btn-modern-accent w-100 py-2">Support Project</a>
                        </div>
                    </div>

                    <div class="progress w-100" style="height: 8px; border-radius: 0; background: #eee;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             role="progressbar" 
                             style="width: {{ $project->progress }}%; background: linear-gradient(45deg, var(--primary-purple), var(--accent-pink)); border:none;" 
                             aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1 bg-white">
                        <h4 class="brand-title-dark h5 mb-3">{{ $project->title }}</h4>
                        <p class="text-muted small mb-4">
                            {{ Str::limit(strip_tags($project->summary), 130) }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ url('project/'.$project->id) }}" class="link-learn-more text-uppercase fw-bold" style="font-size: 0.8rem;">
                                Project Details <i class="fas fa-arrow-right ms-1"></i>
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