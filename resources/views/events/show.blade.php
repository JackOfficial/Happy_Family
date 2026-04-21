@extends('layouts.app')

@section('title')
    <title>{{ $event->title }} | Happy Family Rwanda Organization</title>
@endsection

@section('content')
@php 
    $displayPhoto = $event->featuredPhoto ?? $event->photos->first(); 
@endphp

<div class="container-fluid position-relative vh-60 d-flex align-items-center overflow-hidden" style="background: var(--dark-void);">
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(13, 13, 13, 0.9) 100%); z-index: 2;"></div>
        <img src="{{ $displayPhoto ? asset('storage/'.$displayPhoto->file_path) : asset('frontend/img/breadcrumb-bg.jpg') }}" 
             class="w-100 h-100 animate-slow-zoom" 
             style="object-fit: cover;" 
             alt="{{ $event->title }}">
    </div>

    <div class="container position-relative text-center py-5" style="z-index: 10;">
        <div class="animate__animated animate__fadeInDown mb-3">
            @if($event->status === 'ongoing')
                <span class="badge-live-pulse px-4 py-2 shadow-lg mx-auto">
                    <span class="pulse-dot"></span> LIVE NOW
                </span>
            @elseif($event->status === 'completed')
                <span class="badge-impact bg-secondary px-4 py-2">Past Achievement</span>
            @else
                <span class="badge-impact bg-purple-gradient px-4 py-2">Upcoming Opportunity</span>
            @endif
        </div>

        <h1 class="text-white display-3 fw-black mb-4 mx-auto animate__animated animate__fadeInUp" style="max-width: 900px;">
            {{ $event->title }}
        </h1>

        <nav aria-label="breadcrumb" class="animate__animated animate__fadeInUp">
            <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
                <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('events.index') }}" class="text-white-50 text-decoration-none">Events</a></li>
                <li class="breadcrumb-item active text-accent-pink fw-bold">Full Details</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="row g-5">
            {{-- --- MAIN CONTENT AREA --- --}}
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 rounded-bento shadow-premium border-0">
                    <div class="d-flex align-items-center mb-5 border-bottom pb-4">
                        <h2 class="fw-black text-purple mb-0">Event Overview</h2>
                        @if($event->cause)
                            <span class="ms-auto badge bg-light text-primary px-3 py-2 rounded-pill small fw-bold">
                                <i class="fas fa-bullseye me-1"></i> {{ $event->cause->title }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="event-description brand-rich-text text-muted fs-5 leading-relaxed mb-5">
                        {!! $event->description !!}
                    </div>

                    {{-- GALLERY GRID --}}
                    @if($event->photos->count() > 0)
                        <div class="mt-5 pt-5 border-top">
                            <h4 class="fw-black text-purple mb-4">Event Gallery</h4>
                            <div class="row g-3">
                                @foreach($event->photos as $photo)
                                    <div class="col-md-4 col-6">
                                        <a href="{{ asset('storage/' . $photo->file_path) }}" 
                                           data-lightbox="event-gallery" 
                                           data-title="{{ $photo->caption }}" 
                                           class="gallery-link">
                                            <div class="rounded-bento overflow-hidden shadow-sm hover-up">
                                                <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                                     class="img-fluid w-100" 
                                                     style="height: 180px; object-fit: cover;" 
                                                     alt="{{ $photo->caption }}">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- --- SIDEBAR DETAILS --- --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <div class="bg-white p-4 rounded-bento shadow-premium mb-4">
                        <h5 class="fw-black text-purple mb-4 border-bottom pb-2 text-uppercase small tracking-wider">Quick Info</h5>
                        
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-premium bg-light text-accent-pink me-3">
                                <i class="far fa-calendar-alt"></i>
                            </div>
                            <div>
                                <small class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.65rem;">Schedule</small>
                                <span class="fw-black text-dark">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-premium bg-light text-accent-pink me-3">
                                <i class="far fa-clock"></i>
                            </div>
                            <div>
                                <small class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.65rem;">Starting At</small>
                                <span class="fw-black text-dark">{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-5">
                            <div class="icon-box-premium bg-light text-accent-pink me-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <small class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.65rem;">Location</small>
                                <span class="fw-black text-dark">{{ $event->location }}</span>
                            </div>
                        </div>

                        {{-- REGISTRATION CTA --}}
                        @if($event->link)
                            <a href="{{ $event->link }}" target="_blank" class="btn btn-purple-gradient w-100 py-3 rounded-pill fw-black shadow-lg mb-3">
                                <i class="fas fa-paper-plane me-2"></i> Register Now
                            </a>
                        @endif

                        {{-- RESOURCE DOWNLOADS --}}
                        @if($event->documents && $event->documents->count() > 0)
                            <div class="mt-4 pt-4 border-top">
                                <h6 class="fw-black text-purple small text-uppercase mb-3">Event Briefings</h6>
                                <div class="list-group list-group-flush">
                                    @foreach($event->documents as $doc)
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" 
                                           class="list-group-item list-group-item-action px-0 bg-transparent border-0 d-flex align-items-center mb-2" 
                                           download>
                                            <div class="bg-light p-2 rounded text-danger me-3">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div class="overflow-hidden">
                                                <p class="mb-0 small fw-black text-dark text-truncate">{{ $doc->title ?? 'Download' }}</p>
                                                <small class="text-muted opacity-75" style="font-size: 10px;">{{ strtoupper($doc->file_type) }} • PDF</small>
                                            </div>
                                            <i class="fas fa-download ms-auto text-muted small"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- DONATION CTA --}}
                    <div class="p-4 rounded-bento shadow-lg text-white text-center position-relative overflow-hidden" style="background: var(--grad-premium);">
                        <h6 class="fw-black position-relative mb-2">Fuel This Project</h6>
                        <p class="small opacity-75 mb-3">Support the funding of this specific event to make it a reality.</p>
                        <a href="{{ url('/donate') }}" class="btn btn-light btn-sm text-purple fw-black rounded-pill w-100">Contribute Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .vh-60 { height: 60vh; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .text-purple { color: var(--primary-color); }
    .leading-relaxed { line-height: 1.8; }
    
    .icon-box-premium {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 1.2rem;
    }

    .btn-purple-gradient {
        background: var(--grad-premium);
        border: none;
        color: white;
        transition: 0.3s;
    }
    .btn-purple-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(45, 13, 82, 0.2);
        color: white;
    }

    .event-description img { 
        border-radius: 20px; 
        box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
        margin: 25px 0;
    }

    /* Live Badge Styles */
    .badge-live-pulse {
        background: #dc3545;
        color: white;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .pulse-dot {
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
        animation: pulse-dot 1.5s infinite;
    }
    @keyframes pulse-dot {
        0% { transform: scale(0.9); opacity: 1; }
        70% { transform: scale(1.8); opacity: 0; }
        100% { transform: scale(0.9); opacity: 0; }
    }
</style>
@endpush
@endsection