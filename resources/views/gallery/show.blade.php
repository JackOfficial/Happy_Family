@extends('layouts.app')

@section('title', ($photo->caption ?? 'Gallery Detail') . ' | Happy Family Rwanda Organization')

@section('content')
{{-- --- MINIMALIST TOP NAVIGATION --- --}}
<div class="container-fluid bg-white border-bottom py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('gallery.index') }}" class="btn btn-outline-purple rounded-pill px-4 btn-sm">
            <i class="fas fa-arrow-left me-2"></i> Back to Gallery
        </a>
        <div class="text-muted x-small fw-bold text-uppercase tracking-widest">
            Photo ID: #{{ str_pad($photo->id, 5, '0', STR_PAD_LEFT) }}
        </div>
    </div>
</div>

<div class="container-fluid bg-light py-5 min-vh-100">
    <div class="container">
        <div class="row g-5">
            {{-- --- LEFT COLUMN: THE IMAGE --- --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-premium rounded-bento overflow-hidden">
                    <div class="position-relative">
                        <img src="{{ $photo->url }}" class="w-100 img-fluid" alt="{{ $photo->caption }}">
                        
                        {{-- Featured Ribbon --}}
                        @if($photo->is_featured)
                            <div class="position-absolute top-0 end-0 m-4">
                                <span class="badge bg-accent-pink px-3 py-2 rounded-pill shadow">
                                    <i class="fas fa-star me-1"></i> FEATURED MOMENT
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                
                {{-- Quick Metadata Bar --}}
                <div class="d-flex flex-wrap gap-4 mt-4 opacity-75">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-expand text-purple me-2"></i>
                        <span class="small fw-bold">{{ $photo->readable_size }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-day text-purple me-2"></i>
                        <span class="small fw-bold">{{ $photo->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-image text-purple me-2"></i>
                        <span class="small fw-bold text-uppercase">{{ $photo->file_type ?? 'Image' }}</span>
                    </div>
                </div>
            </div>

            {{-- --- RIGHT COLUMN: CONTEXT & ACTIONS --- --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <div class="mb-5">
                        <h5 class="text-accent-pink fw-bold text-uppercase tracking-widest mb-2">The Story</h5>
                        <h1 class="fw-black text-purple mb-4">{{ $photo->caption ?? 'Capturing the Mission' }}</h1>
                        
                        @if($photo->imageable)
                            <div class="bg-white p-4 rounded-bento shadow-sm mb-4 border-start border-4 border-purple">
                                <p class="text-muted small text-uppercase fw-bold mb-1">Associated With</p>
                                <h5 class="fw-bold text-dark mb-3">
                                    {{ $photo->imageable->title ?? $photo->imageable->name }}
                                </h5>
                                
                                {{-- Link to the Project if applicable --}}
                                @if($photo->imageable_type === 'App\Models\Project')
                                    <a href="{{ route('projects.show', $photo->imageable->slug) }}" class="btn btn-sm btn-purple-gradient rounded-pill px-3">
                                        View Project Details
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="card border-0 rounded-bento bg-purple text-white p-4 shadow-lg">
                        <h6 class="fw-bold mb-3">Share this Moment</h6>
                        <p class="small opacity-75 mb-4">Help us spread the word about our work in Rwanda by sharing this visual update.</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-light btn-sm rounded-circle" style="width: 40px; height: 40px;"><i class="fab fa-facebook-f"></i></button>
                            <button class="btn btn-light btn-sm rounded-circle" style="width: 40px; height: 40px;"><i class="fab fa-whatsapp"></i></button>
                            <button class="btn btn-light btn-sm rounded-circle" style="width: 40px; height: 40px;"><i class="fab fa-twitter"></i></button>
                            <button class="btn btn-light btn-sm rounded-circle" style="width: 40px; height: 40px;"><i class="fas fa-link"></i></button>
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <a href="{{ route('donations.index') }}" class="btn btn-link text-accent-pink fw-bold text-decoration-none">
                            <i class="fas fa-heart me-2"></i> Support this Cause
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .x-small { font-size: 0.75rem; }
    .bg-purple { background: var(--dark-void) !important; }
    
    .shadow-premium {
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    img {
        transition: transform 0.5s ease;
    }

    /* Subtle hover on the main image */
    .card:hover img {
        transform: scale(1.02);
    }
</style>
@endpush
@endsection