@extends('layouts.app')

@section('content')
{{-- Logic: Featured Photo -> First Photo -> Default BG --}}
@php 
    $displayPhoto = $event->featuredPhoto ?? $event->photos->first(); 
@endphp

<div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url({{ $displayPhoto ? asset('storage/'.$displayPhoto->file_path) : asset('frontend/img/breadcrumb-bg.jpg') }});
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 120px 0 60px 0;">
    <div class="container text-center py-5" style="max-width: 900px;">
        <div class="mb-3">
            @if($event->status === 'ongoing')
                <span class="badge bg-danger p-2 px-3 shadow-sm text-white"><i class="fas fa-circle me-1 pulse"></i> ONGOING NOW</span>
            @elseif($event->status === 'completed')
                <span class="badge bg-secondary p-2 px-3 shadow-sm text-white">PAST EVENT</span>
            @else
                <span class="badge bg-primary p-2 px-3 shadow-sm text-white">UPCOMING EVENT</span>
            @endif
        </div>
        <h1 class="text-white display-4 mb-4">{{ $event->title }}</h1>
        <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
            <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('events.index') }}" class="text-white text-decoration-none">Events</a></li>
            <li class="breadcrumb-item active text-white-50">Event Details</li>
        </ol>    
    </div>
</div>

<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="row">
            {{-- Main Content --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center mb-4">
                            <h2 class="font-weight-bold text-dark mb-0">About the Event</h2>
                            @if($event->cause)
                                <span class="badge bg-info-soft text-info ms-3 px-3 py-2 rounded-pill small">
                                    <i class="fas fa-tag me-1"></i> {{ $event->cause->title }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="event-description text-secondary mb-5" style="line-height: 1.8; font-size: 1.1rem;">
                            {!! $event->description !!}
                        </div>

                        {{-- Gallery Section using 'photos' --}}
                        @if($event->photos->count() > 0)
                            <hr class="my-5">
                            <h4 class="mb-4 text-dark font-weight-bold">Event Gallery</h4>
                            <div class="row g-3">
                                @foreach($event->photos as $photo)
                                    <div class="col-md-4 col-6 mb-3">
                                        <a href="{{ asset('storage/' . $photo->file_path) }}" data-lightbox="event-gallery" data-title="{{ $photo->caption }}">
                                            <div class="gallery-item overflow-hidden rounded shadow-sm">
                                                <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                                     class="img-fluid gallery-img" 
                                                     alt="{{ $event->title }}"
                                                     style="height: 160px; width: 100%; object-fit: cover;">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar Details --}}
            <div class="col-lg-4">
                {{-- Info Card --}}
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 100px; z-index: 10;">
                    <div class="card-body p-4">
                        <h4 class="mb-4 border-bottom pb-2 font-weight-bold">Event Details</h4>
                        
                        <div class="info-row d-flex mb-3">
                            <div class="icon-box bg-primary-soft text-primary me-3">
                                <i class="fas fa-calendar-alt fa-lg"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted d-block">Date</small>
                                <span class="font-weight-bold text-dark">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</span>
                            </div>
                        </div>

                        <div class="info-row d-flex mb-3">
                            <div class="icon-box bg-primary-soft text-primary me-3">
                                <i class="fas fa-clock fa-lg"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted d-block">Time</small>
                                <span class="font-weight-bold text-dark">{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</span>
                            </div>
                        </div>

                        <div class="info-row d-flex mb-4">
                            <div class="icon-box bg-primary-soft text-primary me-3">
                                <i class="fas fa-map-marker-alt fa-lg"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted d-block">Location</small>
                                <span class="font-weight-bold text-dark">{{ $event->location }}</span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        @if($event->link)
                            <a href="{{ $event->link }}" target="_blank" class="btn btn-primary w-100 py-3 shadow-sm font-weight-bold mb-3 rounded-pill text-white">
                                <i class="fas fa-external-link-alt me-2"></i> Register / Join Event
                            </a>
                        @endif

                        {{-- Documents Section --}}
                        @if($event->documents && $event->documents->count() > 0)
                            <hr class="my-4">
                            <h5 class="mb-3 font-weight-bold">Resources & Downloads</h5>
                            <div class="list-group list-group-flush">
                                @foreach($event->documents as $doc)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" 
                                       class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center" 
                                       download>
                                        <i class="fas fa-file-pdf text-danger fa-lg me-3"></i>
                                        <div class="overflow-hidden">
                                            <p class="mb-0 small font-weight-bold text-truncate text-dark">{{ $doc->title ?? 'Download Resource' }}</p>
                                            <small class="text-muted">{{ strtoupper($doc->file_type) }} • {{ number_format($doc->file_size / 1024 / 1024, 2) }} MB</small>
                                        </div>
                                        <i class="fas fa-download ms-auto text-muted small"></i>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(var(--bs-primary-rgb), 0.1); }
    .bg-info-soft { background-color: rgba(var(--bs-info-rgb), 0.1); }
    .icon-box { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
    .pulse { animation: pulse-opacity 2s infinite; }
    @keyframes pulse-opacity { 0% { opacity: 1; } 50% { opacity: 0.4; } 100% { opacity: 1; } }
    
    .gallery-img { transition: transform 0.5s ease; cursor: pointer; }
    .gallery-item:hover .gallery-img { transform: scale(1.1); }
    
    .event-description img { max-width: 100%; height: auto; border-radius: 12px; margin: 20px 0; shadow: 0 4px 6px rgba(0,0,0,0.1); }
    
    .list-group-item-action:hover { background-color: transparent; color: var(--bs-primary) !important; }
</style>
@endsection