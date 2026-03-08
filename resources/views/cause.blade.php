@extends('layouts.app')

@section('content')
<div class="position-relative vh-100 d-flex align-items-center overflow-hidden" style="background: #000;">
    <img src="{{ asset('images/impact.jpg') }}" class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; opacity: 0.4; filter: grayscale(30%);" alt="Impact">
    
    <div class="container position-relative" style="z-index: 5;">
        <div class="row">
            <div class="col-lg-7 text-start">
                <div class="badge-pill-aura mb-3">Our Footprint in Rwanda</div>
                <h1 class="display-1 text-white fw-bold mb-4 reveal-text">{{ $cause->name }}</h1>
                <div class="glass-lead p-4 rounded-4 mb-4 border-start border-pink border-4">
                    <p class="lead text-white mb-0 opacity-90">
                        We don't just start projects; we spark local revolutions. Explore how we're rewriting the narrative of {{ $cause->name }} together.
                    </p>
                </div>
                <div class="d-flex gap-3">
                    <a href="#projects" class="btn-aura-pink">View Projects</a>
                    <a href="/donate" class="btn-glass-white">Join the Mission</a>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll-down"></div>
</div>

<div class="container py-5 mt-n5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="impact-story-card shadow-lg p-5 bg-white border-0 rounded-5 position-relative" style="margin-top: -100px; z-index: 10;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="text-purple fw-bold mb-4">The Vision</h2>
                        <div class="brand-rich-text">
                            {!! $cause->description !!}
                        </div>
                    </div>
                    <div class="col-md-4 text-center border-start d-none d-md-block">
                        <div class="stat-circle mb-3 mx-auto">
                            <span class="counter text-pink h1 fw-bold">{{ $projects->count() }}</span>
                        </div>
                        <p class="text-uppercase tracking-widest small fw-bold text-muted">Active Initiatives</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="projects" class="container py-5">
    <div class="row g-5">
        @foreach($projects as $index => $project)
        <div class="col-lg-6 {{ $index % 2 != 0 ? 'mt-lg-5' : '' }}">
            <div class="project-art-card" x-data="{ open: false }">
                <div class="card-inner shadow-premium rounded-5 overflow-hidden">
                    <div class="image-box position-relative">
                        <img src="{{ $project->project_photo?->file_path ? asset('storage/' . $project->project_photo->file_path) : asset('images/default.png') }}" 
                             class="w-100 project-main-img" alt="{{ $project->title }}">
                        
                        <div class="project-meta-overlay p-4">
                            <span class="badge bg-pink shadow-sm mb-2">{{ $project->progress }}% Complete</span>
                            <h3 class="text-white fw-bold">{{ $project->title }}</h3>
                        </div>
                    </div>
                    
                    <div class="content-box p-4 bg-white">
                        <p class="text-muted line-clamp-2 mb-4">{{ strip_tags($project->summary) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ url('project/'.$project->id) }}" class="btn-link-move">
                                Explore Results <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection