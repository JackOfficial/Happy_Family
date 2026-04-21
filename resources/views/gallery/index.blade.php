@extends('layouts.app')

@section('title', 'Visual Impact Gallery | Happy Family Rwanda Organization')

@section('content')
{{-- --- MODERN DARK HERO --- --}}
<div class="container-fluid position-relative overflow-hidden vh-50 d-flex align-items-center" style="background: var(--dark-void);">
    <div class="container position-relative text-center py-5" style="z-index: 10;">
        <div class="badge bg-accent-pink px-3 py-2 rounded-pill mb-4 animate__animated animate__fadeInDown">
            <i class="fas fa-camera-retro me-2"></i> CAPTURING CHANGE
        </div>
        <h1 class="text-white display-3 fw-black mb-0 animate__animated animate__fadeInUp">
            Our <span class="brand-text">Gallery</span>
        </h1>
        <p class="lead text-white-50 mx-auto mt-3" style="max-width: 600px;">
            A visual journey through our missions, the families we serve, and the progress we're making together in Rwanda.
        </p>
    </div>
</div>

{{-- --- GALLERY SECTION --- --}}
<div class="container-fluid bg-white py-5">
    <div class="container py-5">
        
        {{-- DYNAMIC FILTERS --}}
        <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
            <a href="{{ route('gallery.index') }}" 
               class="btn {{ is_null($activeCategory) ? 'btn-purple-gradient shadow' : 'btn-outline-purple' }} rounded-pill px-4">
               All Moments
            </a>
            
            @foreach($categories as $category)
                <a href="{{ route('gallery.filter', $category->slug) }}" 
                   class="btn {{ ($activeCategory && $activeCategory->id == $category->id) ? 'btn-purple-gradient shadow' : 'btn-outline-purple' }} rounded-pill px-4">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- MASONRY-STYLE GRID --}}
        <div class="row g-4">
            @forelse($photos as $photo)
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item rounded-bento overflow-hidden shadow-premium position-relative border-0 h-100 bg-light">
                        {{-- Model Accessor: Using $photo->url --}}
                        <img src="{{ $photo->url }}" 
                             class="w-100 h-100 img-fluid transition-all" 
                             style="object-fit: cover; min-height: 300px;"
                             alt="{{ $photo->caption }}">
                        
                        <div class="gallery-overlay d-flex flex-column justify-content-end p-4">
                            {{-- Polymorphic Label: Handles Cause or Project --}}
                            @if($photo->imageable)
                                <span class="badge bg-accent-pink align-self-start mb-2 px-3 py-2 rounded-pill x-small">
                                    {{ $photo->imageable->title ?? $photo->imageable->name }}
                                </span>
                            @endif
                            
                            <h6 class="text-white fw-bold mb-1">{{ $photo->caption ?? 'Mission Moment' }}</h6>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="x-small text-white-50 mb-0">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $photo->created_at->format('M Y') }}
                                </p>
                                {{-- Accessor: Using $photo->readable_size --}}
                                <span class="x-small text-white-50 opacity-50">{{ $photo->readable_size }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-light rounded-bento p-5 d-inline-block">
                        <i class="fas fa-images text-muted display-4 mb-3"></i>
                        <p class="text-muted fs-5 mb-0">No photos found for this category yet.</p>
                        <a href="{{ route('gallery.index') }}" class="btn btn-link text-purple mt-2">View All Photos</a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $photos->links() }}
        </div>
    </div>
</div>

@push('styles')
<style>
    .vh-50 { height: 50vh; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .x-small { font-size: 0.7rem; }
    .transition-all { transition: all 0.5s ease; }

    /* Gallery Card Interaction */
    .gallery-item {
        cursor: pointer;
        transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .gallery-item:hover {
        transform: translateY(-8px);
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(45, 13, 82, 0.95) 0%, rgba(45, 13, 82, 0.4) 40%, transparent 80%);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
        filter: brightness(0.7);
    }

    /* Badge and Text Shadowing for readability */
    .gallery-overlay h6 { text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
</style>
@endpush
@endsection