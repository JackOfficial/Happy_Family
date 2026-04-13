@extends('layouts.app')

@section('content')
{{-- Hero Section --}}
<div class="container-fluid position-relative overflow-hidden section-hero">
    {{-- Optimization: Standardized path for headers --}}
    <img src="{{ asset('storage/headers/team.jpg') }}" class="hero-bg-img" alt="Projects Header">
    <div class="hero-overlay"></div>
    
    <div class="container text-center position-relative hero-content">
        <h5 class="brand-subtitle text-white mb-3">Our Initiatives</h5>
        <h1 class="text-white display-3 mb-4 fw-bold">Projects of Hope</h1>
        <p class="lead text-white opacity-90 mx-auto mb-4" style="max-width: 700px;">
            Every effort we undertake is a step toward equality, opportunity, and dignity. Explore the programs transforming communities across Rwanda.
        </p>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-pink fw-bold" aria-current="page">Projects</li>
            </ol>
        </nav>
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