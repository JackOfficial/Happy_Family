@extends('layouts.app')

@section('title', 'Events | Happy Family Rwanda Organization')

@section('content')
<div class="container-fluid position-relative overflow-hidden vh-60 d-flex align-items-center" style="background: var(--dark-void);">
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(135deg, rgba(45, 13, 82, 0.8) 0%, rgba(214, 51, 132, 0.4) 100%); z-index: 2;"></div>
        <img src="{{ asset('frontend/img/breadcrumb-bg.jpg') }}" 
             class="w-100 h-100 animate-slow-zoom" 
             style="object-fit: cover; opacity: 0.6;" 
             alt="HFRO Events">
    </div>
    
    <div class="container position-relative text-center py-5" style="z-index: 10;">
        <div class="d-inline-flex align-items-center mb-4 px-3 py-1 rounded-pill animate__animated animate__fadeInDown" 
             style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
            <small class="text-white fw-bold text-uppercase tracking-wider" style="font-size: 0.7rem; letter-spacing: 2px;">Community Engagement</small>
        </div>

        <h1 class="text-white display-2 fw-black mb-4 animate__animated animate__fadeInUp">
            Our <span class="brand-text">Events</span>
        </h1>
        
        <p class="lead text-white opacity-75 mx-auto mb-5 fs-4" style="max-width: 700px;">
            Be the helping hand today. Join our upcoming community activations and workshops.
        </p>
        
        <nav aria-label="breadcrumb" class="d-inline-block p-2 px-4 rounded-pill shadow-lg animate__animated animate__fadeInUp" 
             style="background: rgba(0, 0, 0, 0.3); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1);">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                     <span class="text-accent-pink">●</span> Events
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid py-100 bg-light">
    {{-- UPCOMING & ONGOING SECTION --}}
    <div class="container mb-5">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-5">
            <div style="max-width: 600px;">
                <h5 class="text-accent-pink fw-bold text-uppercase mb-2">Active Schedule</h5>
                <h2 class="display-5 fw-black text-purple">Join Our Journey</h2>
            </div>
            <div class="d-none d-md-block">
                <div class="custom-owl-nav">
                    <button class="nav-prev me-2"><i class="fas fa-arrow-left"></i></button>
                    <button class="nav-next"><i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </div>

        @php
            $upcoming = $events->whereIn('status', ['upcoming', 'ongoing']);
            $passed = $events->where('status', 'completed');
        @endphp

        @if($upcoming->count() > 0)
            <div class="event-carousel owl-carousel">
                @foreach($upcoming as $event)
                <div class="event-card-premium shadow-premium bg-white rounded-bento overflow-hidden h-100 d-flex flex-column border-0">
                    @php $displayPhoto = $event->featuredPhoto ?? $event->photos->first(); @endphp
                    
                    <div class="position-relative overflow-hidden" style="height: 240px;">
                        <img src="{{ $displayPhoto ? asset('storage/'.$displayPhoto->file_path) : asset('frontend/img/placeholder.jpg') }}" 
                             class="img-fluid w-100 h-100 transition-zoom" style="object-fit: cover;" alt="{{ $event->title }}">
                        
                        @if($event->status === 'ongoing')
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge-live-pulse">
                                    <span class="pulse-dot"></span> LIVE NOW
                                </span>
                            </div>
                        @else
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge-impact bg-purple-gradient">Upcoming</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <div class="d-flex justify-content-between mb-3 text-muted small fw-bold">
                            <span><i class="fas fa-map-marker-alt text-accent-pink me-2"></i>{{ Str::limit($event->location, 20) }}</span>
                            <span><i class="fas fa-calendar-day text-accent-pink me-2"></i>{{ \Carbon\Carbon::parse($event->date)->format('d M') }}</span>
                        </div>
                        
                        <h4 class="text-purple fw-black mb-3 h5">{{ Str::limit($event->title, 50) }}</h4>
                        <p class="text-muted small mb-4 flex-grow-1">{{ Str::limit(strip_tags($event->description), 110) }}</p>
                        
                        <a class="btn-premium-outline text-center w-100" href="{{ route('events.show', $event->slug ?? $event->id) }}">
                            Secure Your Spot
                        </a>
                    </div>
                </div>  
                @endforeach
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-bento shadow-sm border-dashed">
                <i class="far fa-calendar-times text-muted display-1 mb-3 opacity-25"></i>
                <h4 class="fw-black text-purple">No Active Events</h4>
                <p class="text-muted">Stay tuned for our upcoming schedule!</p>
            </div>
        @endif
    </div>

    {{-- PASSED / COMPLETED SECTION --}}
    <div class="container py-100 border-top">
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <h5 class="text-accent-pink fw-bold text-uppercase mb-2">History of Impact</h5>
            <h2 class="display-5 fw-black text-purple mb-4">Memories of Change</h2>
            <div class="mx-auto mt-3" style="width: 50px; height: 4px; background: var(--grad-premium); border-radius: 10px;"></div>
        </div>

        @if($passed->count() > 0)
            <div class="row g-4">
                @foreach($passed as $event)
                <div class="col-lg-4 col-md-6">
                    <div class="event-card-premium grayscale shadow-sm bg-white rounded-bento overflow-hidden h-100 d-flex flex-column border-0">
                        @php $displayPhoto = $event->featuredPhoto ?? $event->photos->first(); @endphp
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            <img src="{{ $displayPhoto ? asset('storage/'.$displayPhoto->file_path) : asset('frontend/img/placeholder.jpg') }}" 
                                 class="img-fluid w-100 h-100 transition-zoom" style="object-fit: cover;" alt="{{ $event->title }}">
                        </div>
                        
                        <div class="p-4">
                            <div class="d-flex justify-content-between mb-3 small fw-bold">
                                <span class="text-success"><i class="fas fa-check-circle me-2"></i>Completed</span>
                                <span class="text-muted">{{ \Carbon\Carbon::parse($event->date)->format('M Y') }}</span>
                            </div>
                            <h5 class="text-purple fw-black mb-3">{{ Str::limit($event->title, 45) }}</h5>
                            <a class="btn btn-outline-secondary rounded-pill btn-sm w-100 fw-bold" href="{{ route('events.show', $event->slug ?? $event->id) }}">
                                Read Impact Report
                            </a>
                        </div>
                    </div>  
                </div>
                @endforeach
            </div>
        @endif
        
        <div class="d-flex justify-content-center mt-100 pagination-premium">
            {{ $events->links() }}
        </div>
    </div>
</div>

@push('styles')
<style>
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .text-purple { color: var(--primary-color); }
    .py-100 { padding: 80px 0; }
    .mt-100 { margin-top: 80px; }

    /* Premium Live Badge */
    .badge-live-pulse {
        background: rgba(220, 53, 69, 0.9);
        color: white;
        padding: 6px 15px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }
    .pulse-dot {
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
        animation: pulse-white 1.5s infinite;
    }
    @keyframes pulse-white {
        0% { transform: scale(0.9); opacity: 1; }
        70% { transform: scale(1.8); opacity: 0; }
        100% { transform: scale(0.9); opacity: 0; }
    }

    /* Grayscale Hover */
    .grayscale img { filter: grayscale(100%); opacity: 0.7; transition: 0.5s ease; }
    .event-card-premium:hover img { filter: grayscale(0%); opacity: 1; }
    
    .event-card-premium { transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .event-card-premium:hover { transform: translateY(-12px); }
    .transition-zoom { transition: transform 0.8s ease; }
    .event-card-premium:hover .transition-zoom { transform: scale(1.1); }

    /* Custom Navigation Buttons */
    .custom-owl-nav button {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid var(--primary-color);
        background: transparent;
        color: var(--primary-color);
        transition: 0.3s;
    }
    .custom-owl-nav button:hover {
        background: var(--primary-color);
        color: white;
    }

    .btn-premium-outline {
        display: inline-block;
        padding: 12px 25px;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        border-radius: 50px;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        text-decoration: none;
        transition: 0.3s;
    }
    .btn-premium-outline:hover {
        background: var(--primary-color);
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function(){
        var owl = $('.event-carousel');
        owl.owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            dots: true,
            autoplay: true,
            responsive:{
                0:{ items:1 },
                768:{ items:2 },
                1200:{ items:3 }
            }
        });

        // Custom Navigation linking
        $('.nav-next').click(function() { owl.trigger('next.owl.carousel'); })
        $('.nav-prev').click(function() { owl.trigger('prev.owl.carousel'); })
    });
</script>
@endpush
@endsection