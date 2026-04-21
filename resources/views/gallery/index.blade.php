@extends('layouts.app')

@section('title', 'Visual Impact Gallery | HFRO')

@section('content')
{{-- --- PREMIUM DARK HERO --- --}}
<div class="container-fluid position-relative overflow-hidden vh-50 d-flex align-items-center" style="background: var(--dark-void);">
    {{-- Decorative Background Elements --}}
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" style="background-image: url('{{ asset('images/pattern-dots.svg') }}'); background-size: 30px;"></div>
    
    <div class="container position-relative text-center py-5" style="z-index: 10;">
        <div class="badge bg-accent-pink px-4 py-2 rounded-pill mb-4 animate__animated animate__fadeInDown shadow-lg">
            <i class="fas fa-camera-retro me-2"></i> CAPTURING IMPACT
        </div>
        <h1 class="text-white display-3 fw-black mb-0 animate__animated animate__fadeInUp">
            Our <span class="brand-text">Gallery</span>
        </h1>
        <p class="lead text-white-50 mx-auto mt-3 fw-medium" style="max-width: 650px;">
            A curated visual story of hope, community, and transformation across Rwanda.
        </p>
    </div>
</div>

{{-- --- GALLERY SECTION --- --}}
<div class="container-fluid bg-white py-5">
    <div class="container py-4">
        
        {{-- ADVANCED FILTER BAR --}}
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-5">
            <a href="{{ route('gallery.index') }}" 
               class="btn {{ is_null($activeCategory) ? 'btn-purple-gradient' : 'btn-light' }} rounded-pill px-4 transition-all fw-bold border-0 shadow-sm">
               All Moments
            </a>
            
            @foreach($categories as $category)
                <a href="{{ route('gallery.filter', $category->slug) }}" 
                   class="btn {{ ($activeCategory && $activeCategory->id == $category->id) ? 'btn-purple-gradient' : 'btn-light text-muted' }} rounded-pill px-4 transition-all fw-bold border-0 shadow-sm">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- BENTO-STYLE GRID --}}
        <div class="row g-4">
            @forelse($photos as $photo)
                <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp">
                    <a href="{{ route('gallery.show', $photo->id) }}" class="text-decoration-none">
                        <div class="gallery-item rounded-bento overflow-hidden shadow-premium position-relative border-0 h-100">
                            
                            {{-- Image Container --}}
                            <div class="image-wrapper position-relative" style="height: 350px;">
                                <img src="{{ $photo->url }}" 
                                     class="w-100 h-100 transition-all object-cover" 
                                     alt="{{ $photo->caption }}">
                                
                                {{-- Top Badge: Dynamic Label --}}
                                @if($photo->imageable)
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge glass-badge px-3 py-2 rounded-pill x-small fw-bold text-white shadow-sm">
                                            @php
                                                $type = class_basename($photo->imageable_type);
                                                $icon = match($type) {
                                                    'Project' => 'fas fa-hands-helping',
                                                    'Event'   => 'fas fa-calendar-star',
                                                    'Story'   => 'fas fa-book-open',
                                                    'Team'    => 'fas fa-user-shield',
                                                    default   => 'fas fa-heart'
                                                };
                                            @endphp
                                            <i class="{{ $icon }} me-1"></i> {{ $type }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Content Overlay --}}
                            <div class="gallery-overlay d-flex flex-column justify-content-end p-4">
                                <h5 class="text-white fw-black mb-1 line-clamp-2">
                                    {{ $photo->caption ?? 'HFRO Mission Moment' }}
                                </h5>
                                
                                <div class="d-flex justify-content-between align-items-center mt-2 border-top border-white-50 pt-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-accent-pink rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 24px; height: 24px; font-size: 10px;">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <span class="x-small text-white-50 fw-bold">{{ $photo->imageable->title ?? $photo->imageable->name }}</span>
                                    </div>
                                    <span class="x-small text-white-50"><i class="far fa-clock me-1"></i> {{ $photo->created_at->diffForHumans() }}</span>
                                </div>

                                {{-- Interaction Trigger (Visible on Hover) --}}
                                <div class="view-btn-hover mt-3">
                                    <span class="btn btn-sm btn-white rounded-pill px-3 fw-bold x-small">
                                        View Moment <i class="fas fa-arrow-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-light rounded-bento p-5 d-inline-block shadow-sm">
                        <img src="{{ asset('images/empty-gallery.svg') }}" class="mb-4" style="width: 120px; opacity: 0.5;">
                        <h4 class="text-dark fw-bold">No Moments Found</h4>
                        <p class="text-muted">We haven't uploaded photos for this category yet.</p>
                        <a href="{{ route('gallery.index') }}" class="btn btn-purple-gradient rounded-pill px-4 mt-3">Explore All</a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $photos->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --dark-void: #1a0b2e;
        --accent-pink: #ff2d55;
    }

    .vh-50 { height: 50vh; }
    .rounded-bento { border-radius: 28px; }
    .fw-black { font-weight: 900; }
    .x-small { font-size: 0.72rem; letter-spacing: 0.5px; }
    .object-cover { object-fit: cover; }
    .transition-all { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }

    /* Glassmorphism Badge */
    .glass-badge {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Card Styling */
    .gallery-item {
        background: #f8f9fa;
        cursor: pointer;
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(26, 11, 46, 0.95) 5%, rgba(26, 11, 46, 0.6) 40%, transparent 90%);
        opacity: 0.9; /* Subtle visible gradient even without hover */
        transition: all 0.3s ease;
    }

    .view-btn-hover {
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.3s ease;
    }

    /* Interaction Effects */
    .gallery-item:hover {
        transform: translateY(-10px);
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
        background: linear-gradient(to top, rgba(255, 45, 85, 0.8) 0%, rgba(26, 11, 46, 0.85) 60%);
    }

    .gallery-item:hover .view-btn-hover {
        transform: translateY(0);
        opacity: 1;
    }

    .gallery-item:hover img {
        transform: scale(1.15);
    }

    /* Text Protection */
    .gallery-overlay h5 { text-shadow: 0 4px 10px rgba(0,0,0,0.5); }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-white {
        background: white;
        color: var(--dark-void);
    }
</style>
@endpush
@endsection