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
        <span class="badge bg-primary text-uppercase px-3 py-2 mb-3">{{ $story->cause->name ?? 'Community' }}</span>
        <h1 class="text-white display-4 mb-4">{{ $story->title }}</h1>
        <div class="d-flex justify-content-center align-items-center text-white mb-4">
            <div class="me-3"><i class="fas fa-user me-2 text-primary"></i>By {{ $story->user->name }}</div>
            <div><i class="fas fa-calendar-alt me-2 text-primary"></i>{{ $story->created_at->format('M d, Y') }}</div>
        </div>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="/" class="text-white-50">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/stories') }}" class="text-white-50">Stories</a></li>
            <li class="breadcrumb-item active text-white">View</li>
        </ol>    
    </div>
</div>
<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 rounded shadow-sm">
                    @if($story->summary)
                        <p class="lead text-primary fw-bold mb-4 border-start border-4 border-primary ps-3">
                            {{ $story->summary }}
                        </p>
                    @endif

                    <div class="story-body text-dark lh-lg">
                        {!! $story->content !!}
                    </div>

                    @if($story->photos->count() > 1)
                        <div class="mt-5">
                            <h4 class="mb-4 border-bottom pb-2">Photo Gallery</h4>
                            <div class="row g-3">
                                @foreach($story->photos as $photo)
                                    <div class="col-md-4 col-6">
                                        <a href="{{ asset('storage/' . $photo->file_path) }}" data-lightbox="story-gallery" data-title="{{ $photo->caption }}">
                                            <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                                 class="img-fluid rounded shadow-sm border" 
                                                 style="height: 160px; width: 100%; object-fit: cover;" 
                                                 alt="{{ $photo->caption }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="mb-3">Share this Impact</h5>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-outline-primary btn-sm px-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-outline-info btn-sm px-3"><i class="fab fa-twitter"></i></a>
                        <a href="whatsapp://send?text={{ urlencode(url()->current()) }}" class="btn btn-outline-success btn-sm px-3"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                @if($story->documents->count() > 0)
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="mb-3"><i class="fas fa-file-pdf text-danger me-2"></i>Resources</h5>
                    <div class="list-group list-group-flush">
                        @foreach($story->documents as $doc)
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center px-0">
                                <i class="fas fa-download me-3 text-muted"></i>
                                <div>
                                    <div class="small fw-bold text-dark">{{ $doc->title }}</div>
                                    <div class="text-muted" style="font-size: 11px;">{{ strtoupper($doc->file_type) }} ({{ number_format($doc->file_size / 1024, 1) }} KB)</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="bg-primary p-4 rounded shadow text-white text-center">
                    <h5>Support Our Mission</h5>
                    <p class="small">Your contribution helps us create more stories like this one.</p>
                    <a href="{{ url('/donate') }}" class="btn btn-light text-primary fw-bold w-100">DONATE NOW</a>
                </div>
            </div>
        </div> 
    </div> 
</div>
@endsection