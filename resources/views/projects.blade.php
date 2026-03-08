@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative overflow-hidden section-hero">
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
                <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Home</a></li>
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
            
            <div class="d-flex justify-content-center gap-2 mt-4">
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
                
                <div class="impact-card h-100 border-0 shadow-premium" 
                     @mouseenter="hovered = true" 
                     @mouseleave="hovered = false">
                    
                    <div class="impact-img-container position-relative overflow-hidden">
                        <img src="{{ $project->project_photo?->file_path ? asset('storage/' . $project->project_photo->file_path) : asset('images/default.png') }}" 
                             class="img-fluid w-100 project-img" 
                             :class="hovered ? 'scale-110' : ''"
                             alt="{{ $project->title }}">
                        
                        <div class="position-absolute top-0 start-0 m-3" style="z-index: 4;">
                            <span class="badge-custom {{ $project->progress == 100 ? 'bg-success' : 'bg-pink-gradient' }}">
                                {{ $project->progress == 100 ? 'Completed' : 'Active' }}
                            </span>
                        </div>

                        <div class="impact-overlay-glass d-flex flex-column justify-content-end p-3" 
                             :class="hovered ? 'opacity-100' : 'opacity-0'">
                            <div class="glass-stats p-3 mb-2">
                                <div class="d-flex justify-content-between mb-1 small text-white">
                                    <span>Goal:</span>
                                    <span class="fw-bold">RWF {{ number_format($project->budget, 0) }}</span>
                                </div>
                                <div class="progress bg-white-20" style="height: 4px;">
                                    <div class="progress-bar bg-white" style="width: {{ $project->progress }}%"></div>
                                </div>
                            </div>
                            <a href="/donate" class="btn-modern-pink-sm w-100">Support This Project</a>
                        </div>
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1 bg-white rounded-bottom-custom">
                        <h4 class="text-purple h5 mb-3 fw-bold">{{ $project->title }}</h4>
                        <p class="text-muted small mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($project->summary), 130) }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ url('project/'.$project->id) }}" class="link-impact">
                                View Details <i class="fas fa-arrow-right ms-2 transition-icon"></i>
                            </a>
                            <div class="text-pink small fw-bold">{{ $project->progress }}%</div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No projects found in this category.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection