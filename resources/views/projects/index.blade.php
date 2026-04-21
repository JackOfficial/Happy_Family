@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative overflow-hidden vh-75 d-flex align-items-center" style="background: var(--dark-void);">
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <img src="{{ asset('images/banner1.png') }}" 
             class="w-100 h-100 animate-slow-zoom" 
             style="object-fit: cover; opacity: 0.35; filter: saturate(1.2) contrast(1.1);" 
             alt="Projects Header">
        
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(135deg, rgba(99, 16, 132, 0.85) 0%, rgba(236, 64, 158, 0.2) 100%);"></div>
    </div>
    
    <div class="container position-relative py-5" style="z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="d-inline-flex align-items-center mb-4 px-3 py-1 rounded-pill animate__animated animate__fadeInDown" 
                     style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                    <span class="dot-pulse me-2"></span>
                    <small class="text-white fw-bold text-uppercase tracking-wider" style="font-size: 0.7rem; letter-spacing: 2px;">Impact Report 2026</small>
                </div>

                <h1 class="text-white display-2 fw-black mb-4 animate__animated animate__fadeInUp">
                    Projects <span class="brand-text">of Hope</span>
                </h1>
                
                <p class="lead text-white opacity-75 mx-auto mb-5 fs-4" style="max-width: 800px; line-height: 1.6;">
                    Every effort we undertake is a step toward equality, opportunity, and dignity. Explore the programs transforming communities across Rwanda.
                </p>
                
                <nav aria-label="breadcrumb" class="d-inline-block p-2 px-4 rounded-pill shadow-lg animate__animated animate__fadeInUp animate__delay-1s" 
                     style="background: rgba(0, 0, 0, 0.3); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1);">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white opacity-50 text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                             <span class="text-accent-pink">●</span> Our Projects
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; transform: rotate(180deg);">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width: 150%; height: 60px; fill: #f8f9fa;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
</div>

<div class="container-fluid py-100 bg-light" x-data="{ filter: 'all' }">
    <div class="container">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h5 class="text-accent-pink fw-bold text-uppercase mb-2">Impact in Action</h5>
            <h2 class="display-5 fw-black text-purple mb-3">Our Transformative Efforts</h2>
            <div class="mx-auto mb-4" style="width: 80px; height: 4px; background: var(--grad-premium); border-radius: 2px;"></div>
            
            <div class="d-flex justify-content-center flex-wrap gap-3 mt-4">
                <button @click="filter = 'all'" :class="filter === 'all' ? 'btn-filter-active' : 'btn-filter'">
                    All Initiatives
                </button>
                <button @click="filter = 'ongoing'" :class="filter === 'ongoing' ? 'btn-filter-active' : 'btn-filter'">
                    Ongoing Projects
                </button>
                <button @click="filter = 'completed'" :class="filter === 'completed' ? 'btn-filter-active' : 'btn-filter'">
                    Success Stories
                </button>
            </div>
        </div>

        <div class="row g-4">
            @forelse($projects as $project)
            <div class="col-lg-6 col-md-6 col-xl-4" 
                 x-show="filter === 'all' || (filter === 'ongoing' && {{ $project->progress }} < 100) || (filter === 'completed' && {{ $project->progress }} === 100)"
                 x-transition:enter="transition ease-out duration-400"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                
                <div class="impact-card h-100 bg-white shadow-premium overflow-hidden border-0">
                    <div class="position-relative overflow-hidden" style="height: 260px;">
                        <img src="{{ $project->featured_image_url }}" 
                             class="img-fluid w-100 h-100 transition-zoom" 
                             style="object-fit: cover;"
                             alt="{{ $project->title }}">
                        
                        <div class="position-absolute top-0 start-0 m-3" style="z-index: 4;">
                            <span class="badge-impact {{ $project->progress == 100 ? 'bg-success' : '' }}">
                                {{ $project->progress == 100 ? 'Completed' : 'Active' }}
                            </span>
                        </div>

                        <div class="gallery-overlay d-flex flex-column justify-content-end p-4">
                            <div class="p-3 mb-3 rounded-bento shadow-sm" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.2);">
                                <div class="d-flex justify-content-between mb-2 small text-white fw-bold">
                                    <span>Milestone Progress</span>
                                    <span>{{ $project->progress }}%</span>
                                </div>
                                <div class="impact-progress mb-0" style="height: 6px; background: rgba(255,255,255,0.2);">
                                    <div class="impact-progress-bar bg-white" style="width: {{ $project->progress }}%"></div>
                                </div>
                            </div>
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-light rounded-pill fw-black text-purple btn-sm py-2 shadow">
                                VIEW PROJECT DETAILS
                            </a>
                        </div>
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h4 class="text-purple h5 mb-3 fw-black">{{ $project->title }}</h4>
                        <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                            {{ $project->summary ?? Str::limit(strip_tags($project->description), 125) }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('projects.show', $project->slug) }}" class="text-accent-pink text-decoration-none fw-bold text-uppercase small" style="letter-spacing: 1px;">
                                Learn More <i class="fas fa-arrow-right ms-2 transition-icon"></i>
                            </a>
                            <div class="text-purple fw-black small">{{ number_format($project->progress) }}%</div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-bento shadow-sm border-dashed">
                    <i class="fas fa-folder-open text-purple opacity-25 display-1 mb-3"></i>
                    <h3 class="fw-black text-purple">No Projects Found</h3>
                    <p class="text-muted">We are currently updating our impact reports. Please check back soon.</p>
                    <a href="{{ route('projects.index') }}" class="btn-premium">Reset Filter</a>
                </div>
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5 pagination-premium">
            {{ $projects->links() }}
        </div>
    </div>
</div>

<style>
    .py-100 { padding: 100px 0; }
    .fw-black { font-weight: 900; }
    .text-purple { color: var(--primary-color); }
    
    /* Filter Button Styles */
    .btn-filter, .btn-filter-active {
        padding: 12px 28px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        border: 2px solid rgba(99, 16, 132, 0.1);
    }
    .btn-filter { background: white; color: var(--primary-color); }
    .btn-filter:hover { background: #fdf2f8; transform: translateY(-2px); }
    .btn-filter-active { 
        background: var(--grad-premium); 
        color: white; 
        border: none;
        box-shadow: 0 10px 20px rgba(99, 16, 132, 0.2);
    }

    .transition-zoom { transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .impact-card:hover .transition-zoom { transform: scale(1.1); }
    
    .border-dashed { border: 2px dashed rgba(99, 16, 132, 0.1); }
</style>
@endsection