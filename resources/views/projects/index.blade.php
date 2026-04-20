@extends('layouts.app')

@section('content')
{{-- Hero Section --}}
<div class="container-fluid position-relative overflow-hidden vh-75 d-flex align-items-center" style="background: #0a0118;">
    {{-- Animated Background Layer --}}
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <img src="{{ asset('images/banner1.png') }}" 
             class="w-100 h-100 animate-slow-zoom" 
             style="object-fit: cover; opacity: 0.4; filter: saturate(1.2) contrast(1.1);" 
             alt="Projects Header">
        {{-- Gradient Mesh Overlay --}}
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(135deg, rgba(45, 13, 82, 0.8) 0%, rgba(214, 51, 132, 0.3) 100%);"></div>
    </div>
    
    <div class="container position-relative py-5" style="z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-9 text-center">
                {{-- Floating Badge --}}
                <div class="d-inline-flex align-items-center mb-4 px-3 py-1 rounded-pill" 
                     style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                    <span class="dot-pulse me-2"></span>
                    <small class="text-white fw-bold text-uppercase tracking-wider" style="font-size: 0.7rem;">Impact Report 2026</small>
                </div>

                <h1 class="text-white display-2 fw-black mb-4 text-shadow-sm">
                    Projects <span class="text-gradient-pink">of Hope</span>
                </h1>
                
                <p class="lead text-white-50 mx-auto mb-5 fs-4" style="max-width: 750px; line-height: 1.6;">
                    Every effort we undertake is a step toward equality, opportunity, and dignity. Explore the programs transforming communities across Rwanda.
                </p>
                
                {{-- Glass Breadcrumb Card --}}
                <nav aria-label="breadcrumb" class="d-inline-block p-2 px-4 rounded-4 shadow-lg" 
                     style="background: rgba(0, 0, 0, 0.3); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1);">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-white">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                             <span class="text-pink">●</span> Projects
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Bottom Curve Decor --}}
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; transform: rotate(180deg);">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width: 150%; height: 60px; fill: #f8f9fa;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
</div>

<div class="container-fluid py-5 bg-light-gray" x-data="{ filter: 'all' }">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="brand-subtitle-centered mb-2">Impact in Action</h5>
            <h2 class="brand-title-dark display-5 mb-3">Our Transformative Efforts</h2>
            <div class="title-line-center mx-auto mb-4"></div>
            
            {{-- Filter Buttons --}}
            <div class="d-flex justify-content-center flex-wrap gap-2 mt-4">
                <button @click="filter = 'all'" :class="filter === 'all' ? 'btn-filter-active' : 'btn-filter'">All Projects</button>
                <button @click="filter = 'ongoing'" :class="filter === 'ongoing' ? 'btn-filter-active' : 'btn-filter'">Ongoing</button>
                <button @click="filter = 'completed'" :class="filter === 'completed' ? 'btn-filter-active' : 'btn-filter'">Completed</button>
            </div>
        </div>

        <div class="row g-4">
            @forelse($projects as $project)
            <div class="col-lg-6 col-md-6 col-xl-4" 
                 x-show="filter === 'all' || (filter === 'ongoing' && {{ $project->progress }} < 100) || (filter === 'completed' && {{ $project->progress }} === 100)"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-90"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-data="{ hovered: false }">
                
                <div class="impact-card h-100 border-0 shadow-premium bg-white overflow-hidden" 
                     @mouseenter="hovered = true" 
                     @mouseleave="hovered = false">
                    
                    <div class="impact-img-container position-relative overflow-hidden" style="height: 240px;">
                        {{-- Optimization: Using our model accessor for reliable images --}}
                        <img src="{{ $project->featured_image_url }}" 
                             class="img-fluid w-100 h-100 project-img" 
                             style="object-fit: cover; transition: transform 0.5s ease;"
                             :class="hovered ? 'scale-110' : ''"
                             alt="{{ $project->title }}">
                        
                        {{-- Status Badge --}}
                        <div class="position-absolute top-0 start-0 m-3" style="z-index: 4;">
                            <span class="badge {{ $project->progress == 100 ? 'bg-success' : 'bg-pink-gradient' }} px-3 py-2 rounded-pill shadow-sm">
                                {{ $project->progress == 100 ? 'Completed' : 'Active' }}
                            </span>
                        </div>

                        {{-- Hover Glass Overlay --}}
                        <div class="impact-overlay-glass d-flex flex-column justify-content-end p-3 position-absolute top-0 start-0 w-100 h-100" 
                             style="background: rgba(0,0,0,0.4); transition: opacity 0.3s ease;"
                             :class="hovered ? 'opacity-100' : 'opacity-0'">
                            <div class="glass-stats p-3 mb-2 rounded-3" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(5px);">
                                <div class="d-flex justify-content-between mb-1 small text-white">
                                    <span>Goal:</span>
                                    <span class="fw-bold">RWF {{ number_format($project->budget, 0) }}</span>
                                </div>
                                <div class="progress bg-white-20" style="height: 4px;">
                                    <div class="progress-bar bg-white" style="width: {{ $project->progress }}%"></div>
                                </div>
                            </div>
                            <a href="{{ url('/donate') }}" class="btn btn-pink btn-sm w-100 fw-bold rounded-pill">Support This Project</a>
                        </div>
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h4 class="text-purple h5 mb-3 fw-bold">{{ $project->title }}</h4>
                        <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $project->summary ?? Str::limit(strip_tags($project->description), 130) }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            {{-- SEO Friendly Slug-based routing --}}
                            <a href="{{ route('projects.show', $project->slug) }}" class="link-impact text-decoration-none fw-bold text-purple small">
                                View Details <i class="fas fa-arrow-right ms-2 transition-icon"></i>
                            </a>
                            <div class="text-pink small fw-bold">{{ $project->progress }}%</div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm">
                    <i class="fas fa-folder-open text-muted fs-1 mb-3"></i>
                    <p class="text-muted">No projects found in this category.</p>
                    <a href="{{ route('projects.index') }}" class="btn btn-outline-purple rounded-pill">View All Projects</a>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $projects->links() }}
        </div>
    </div>
</div>
@endsection