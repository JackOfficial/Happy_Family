@extends('layouts.app')
@section('content')
<div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url({{ asset('frontend/img/breadcrumb-bg.jpg') }});
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 100px 0 0 0;">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Success Stories</h1>
        <p class="fs-5 text-white mb-4">DISCOVER OUR IMPACTFUL STORIES</p>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active text-white">Stories</li>
        </ol>    
    </div>
</div>
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <h5 class="text-uppercase text-primary">Our Impact</h5>
            <p class="mb-0">Find out how Happy Family is fostering resilience and making impact in the local communities. Join us in building a brighter future together.</p>
        </div>

        <div class="row g-4">
            @forelse($stories as $story)
            <div class="col-lg-4 col-md-6">
                <div class="story-item bg-white shadow-sm rounded overflow-hidden h-100 d-flex flex-column">
                    <div class="story-img position-relative">
                        {{-- Using the featuredPhoto relationship from your controller --}}
                        <img src="{{ $story->featuredPhoto ? asset('storage/'.$story->featuredPhoto->file_path) : asset('frontend/img/placeholder.jpg') }}" 
                             class="img-fluid w-100" style="height: 250px; object-fit: cover;" alt="{{ $story->title }}">
                        
                        @if($story->cause)
                            <div class="position-absolute bg-primary text-white px-3 py-1 rounded-right" style="top: 20px; left: 0; font-size: 0.8rem;">
                                {{ $story->cause->name }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <div class="d-flex justify-content-between mb-3 text-muted small">
                            <span><i class="fas fa-calendar-alt text-primary me-2"></i>{{ $story->created_at->format('M d, Y') }}</span>
                            <span><i class="fas fa-user text-primary me-2"></i>HFRO Team</span>
                        </div>
                        
                        <h4 class="mb-3">{{ Str::limit($story->title, 60) }}</h4>
                        
                        <p class="text-muted mb-4">
                            {{ $story->summary ?? Str::limit(strip_tags($story->content), 120) }}
                        </p>
                        
                        <div class="mt-auto">
                            <a class="btn btn-outline-primary rounded-pill py-2 px-4 w-100" href="{{ route('stories.show', $story->slug ?? $story->id) }}">
                                Read Full Story
                            </a>
                        </div>
                    </div>
                </div>
            </div>  
            @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    No stories available at the moment. Please check back later.
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $stories->links() }}
        </div>
    </div>
</div>
<div class="container-fluid bg-secondary py-5">
    <div class="container py-4 text-center text-white">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="display-5 mb-3">Together, we can make a difference.</h2>
                <p class="lead mb-4">We rely on the support and generosity of individuals like you to continue our life-changing work. Whether through donations or volunteering, your help transforms communities.</p>
                <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow">Get Involved</a>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
    .story-item { transition: 0.3s; border: 1px solid #eee; }
    .story-item:hover { transform: translateY(-10px); border-color: var(--bs-primary); }
    .story-img img { transition: 0.5s; }
    .story-item:hover .story-img img { scale: 1.1; }
    .rounded-right { border-top-right-radius: 20px; border-bottom-right-radius: 20px; }
    </style>
@endpush
@endsection