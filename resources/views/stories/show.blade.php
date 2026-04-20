@extends('layouts.app')

@section('content')
@php
    // Use featured photo for background, fallback to default breadcrumb
    $bgImage = $story->featuredPhoto 
        ? asset('storage/' . $story->featuredPhoto->file_path) 
        : asset('frontend/img/breadcrumb-bg.jpg');
@endphp

<div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url({{ $bgImage }});
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 120px 0 60px 0;">
    <div class="container text-center py-5" style="max-width: 900px;">
        <span class="badge bg-primary text-uppercase px-3 py-2 mb-3 shadow-sm">{{ $story->cause->name ?? 'Impact Story' }}</span>
        <h1 class="text-white display-4 mb-4 font-weight-bold">{{ $story->title }}</h1>
        <div class="d-flex justify-content-center align-items-center text-white mb-4">
            <div class="me-3 px-3 border-end border-white-50"><i class="fas fa-user me-2 text-primary"></i>By {{ $story->user->name ?? 'HFRO Team' }}</div>
            <div class="ms-3"><i class="fas fa-calendar-alt me-2 text-primary"></i>{{ $story->created_at->format('M d, Y') }}</div>
        </div>
        <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
            <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('stories.index') }}" class="text-white-50 text-decoration-none">Stories</a></li>
            <li class="breadcrumb-item active text-white">View Details</li>
        </ol>    
    </div>
</div>
<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="row g-5">
            {{-- Main Content --}}
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 rounded shadow-sm overflow-hidden">
                    @if($story->summary)
                        <div class="lead text-primary font-italic mb-5 border-start border-4 border-primary ps-4 py-2" style="background: rgba(var(--bs-primary-rgb), 0.03);">
                            "{{ $story->summary }}"
                        </div>
                    @endif

                    <div class="story-body text-dark lh-lg mb-5" style="font-size: 1.1rem;">
                        {!! $story->content !!}
                    </div>

                    {{-- Gallery Section --}}
                    @if($story->photos->count() > 1)
                        <div class="mt-5 pt-4 border-top">
                            <h4 class="mb-4 font-weight-bold"><i class="fas fa-images text-primary me-2"></i>Photo Gallery</h4>
                            <div class="row g-3">
                                @foreach($story->photos as $photo)
                                    <div class="col-md-4 col-6">
                                        <a href="{{ asset('storage/' . $photo->file_path) }}" data-lightbox="story-gallery" data-title="{{ $photo->caption }}">
                                            <div class="gallery-hover rounded overflow-hidden shadow-sm">
                                                <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                                     class="img-fluid" 
                                                     style="height: 180px; width: 100%; object-fit: cover;" 
                                                     alt="{{ $photo->caption }}">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Related Stories Section --}}
                @if(isset($relatedStories) && $relatedStories->count() > 0)
                <div class="mt-5">
                    <h3 class="mb-4 font-weight-bold">Other Stories You Might Like</h3>
                    <div class="row g-4">
                        @foreach($relatedStories as $related)
                        <div class="col-md-6">
                            <a href="{{ route('stories.show', $related->slug ?? $related->id) }}" class="text-decoration-none text-dark">
                                <div class="card border-0 shadow-sm h-100 story-mini-card">
                                    <img src="{{ $related->featuredPhoto ? asset('storage/' . $related->featuredPhoto->file_path) : asset('frontend/img/placeholder.jpg') }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold mb-0 text-truncate">{{ $related->title }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Social Share --}}
                <div class="bg-white p-4 rounded shadow-sm mb-4 border-top border-primary border-4">
                    <h5 class="mb-3 font-weight-bold">Share this Impact</h5>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-facebook btn-sm flex-fill"><i class="fab fa-facebook-f me-2"></i>FB</a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-twitter btn-sm flex-fill"><i class="fab fa-twitter me-2"></i>X</a>
                        <a href="whatsapp://send?text={{ urlencode(url()->current()) }}" class="btn btn-whatsapp btn-sm flex-fill"><i class="fab fa-whatsapp me-2"></i>WA</a>
                    </div>
                </div>

                {{-- Documents Section --}}
                @if($story->documents->count() > 0)
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="mb-3 font-weight-bold border-bottom pb-2">Resources</h5>
                    <div class="list-group list-group-flush">
                        @foreach($story->documents as $doc)
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center px-0 bg-transparent">
                                <div class="bg-light p-2 rounded me-3 text-danger">
                                    <i class="fas fa-file-pdf fa-lg"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="small fw-bold text-dark text-truncate">{{ $doc->title }}</div>
                                    <div class="text-muted" style="font-size: 11px;">{{ strtoupper($doc->file_type) }} • {{ number_format($doc->file_size / 1024, 1) }} KB</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- CTA Box --}}
                <div class="bg-primary p-4 rounded shadow text-white text-center position-relative overflow-hidden">
                    <div class="position-absolute" style="top:-10px; right:-10px; opacity:0.1">
                        <i class="fas fa-heart fa-6x"></i>
                    </div>
                    <h5 class="font-weight-bold position-relative">Support Our Mission</h5>
                    <p class="small position-relative">Your contribution helps us create more stories like this one.</p>
                    <a href="{{ url('/donate') }}" class="btn btn-light text-primary fw-bold w-100 rounded-pill mt-2">DONATE NOW</a>
                </div>
            </div>
        </div> 
    </div> 
</div>

<style>
    .gallery-hover { position: relative; transition: all 0.3s ease; }
    .gallery-hover:hover { transform: scale(1.05); cursor: pointer; }
    .story-mini-card:hover { transform: translateY(-5px); transition: 0.3s; }
    .btn-facebook { background: #3b5998; color: white; }
    .btn-twitter { background: #1da1f2; color: white; }
    .btn-whatsapp { background: #25d366; color: white; }
    .story-body img { border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin: 20px 0; }
</style>
@endsection