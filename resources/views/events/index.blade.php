@extends('layouts.app')
@section('content')
    <div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url({{ asset('frontend/img/breadcrumb-bg.jpg') }});
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 100px 0 0 0;">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h3 class="text-white display-3 mb-4">Our Events</h1>
            <p class="fs-5 text-white mb-4">Help today because tomorrow you may be the one who needs more helping!</p>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active text-white">Events</li>
            </ol>    
        </div>
    </div>
    <div class="container-fluid event py-5">
        
        {{-- UPCOMING & ONGOING SECTION --}}
        <div class="container py-5">
            <div class="text-center mx-auto mb-5" style="max-width: 800px;">
                <h5 class="text-uppercase text-primary">Current & Upcoming</h5>
                <h1 class="mb-0">Join our journey of impact</h1>
            </div>

            @php
                $upcoming = $events->whereIn('status', ['upcoming', 'ongoing']);
                $passed = $events->where('status', 'completed');
            @endphp

            @if($upcoming->count() > 0)
                <div class="event-carousel owl-carousel">
                    @foreach($upcoming as $event)
                    <div class="event-item shadow-sm">
                        {{-- Use featuredPhoto logic matching your Controller --}}
                        @php $displayPhoto = $event->featuredPhoto ?? $event->photos->first(); @endphp
                        
                        <div class="position-relative">
                            <img src="{{ $displayPhoto ? asset('storage/'.$displayPhoto->file_path) : asset('frontend/img/placeholder.jpg') }}" 
                                 class="img-fluid w-100" style="height: 280px; object-fit: cover;" alt="{{ $event->title }}">
                            
                            @if($event->status === 'ongoing')
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-danger px-3 py-2 shadow-sm animate-pulse">
                                        <i class="fas fa-broadcast-tower me-1"></i> LIVE NOW
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="event-content p-4">
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-muted small"><i class="fas fa-map-marker-alt text-primary me-2"></i>{{ Str::limit($event->location, 25) }}</span>
                                <span class="text-muted small">
                                    <i class="fas fa-calendar-alt text-primary me-2"></i>{{ \Carbon\Carbon::parse($event->date)->format('d M, Y') }}
                                </span>
                            </div>
                            <h4 class="mb-3 text-dark">{{ Str::limit($event->title, 55) }}</h4>
                            <p class="mb-4 text-muted small">{{ Str::limit(strip_tags($event->description), 120) }}</p>
                            
                            <a class="btn btn-primary rounded-pill text-white py-2 px-4 w-100" 
                               href="{{ route('events.show', $event->slug ?? $event->id) }}">View Details</a>
                        </div>
                    </div>  
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 border rounded bg-light">
                    <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No active events at the moment.</h4>
                    <p>Check out our past impact highlights below!</p>
                </div>
            @endif
        </div>

        {{-- PASSED / COMPLETED SECTION --}}
        <div class="container py-5 border-top">
            <div class="text-center mx-auto mb-5" style="max-width: 800px;">
                <h5 class="text-uppercase text-secondary">Past Highlights</h5>
                <h2 class="mb-0 text-dark">Memories of Change</h2>
            </div>

            @if($passed->count() > 0)
                <div class="row g-4">
                    @foreach($passed as $event)
                    <div class="col-lg-4 col-md-6">
                        <div class="event-item grayscale shadow-sm border h-100">
                            @php $displayPhoto = $event->featuredPhoto ?? $event->photos->first(); @endphp
                            <img src="{{ $displayPhoto ? asset('storage/'.$displayPhoto->file_path) : asset('frontend/img/placeholder.jpg') }}" 
                                 class="img-fluid w-100" style="height: 200px; object-fit: cover;" alt="{{ $event->title }}">
                            
                            <div class="event-content p-4">
                                <div class="d-flex justify-content-between mb-3 small text-muted">
                                    <span><i class="fas fa-check-circle text-success me-2"></i>Finished</span>
                                    <span>{{ \Carbon\Carbon::parse($event->date)->format('M Y') }}</span>
                                </div>
                                <h5 class="mb-3 text-dark">{{ Str::limit($event->title, 45) }}</h5>
                                <a class="btn btn-outline-secondary rounded-pill btn-sm py-2 px-4 w-100" 
                                   href="{{ route('events.show', $event->slug ?? $event->id) }}">Read Impact Report</a>
                            </div>
                        </div>  
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted italic">Detailed reports of our past work will appear here.</p>
                </div>
            @endif
            
            {{-- Pagination for all events --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $events->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function(){
            $('.event-carousel').owlCarousel({
                loop: false,
                margin: 25,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 6000,
                navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
                responsive:{
                    0:{ items:1 },
                    768:{ items:2 },
                    1200:{ items:3 }
                }
            });
        });
    </script>
    @endpush

    <style>
        .grayscale img { filter: grayscale(100%); transition: 0.4s; opacity: 0.8; }
        .event-item:hover img { filter: grayscale(0%); opacity: 1; }
        .event-item { border-radius: 12px; overflow: hidden; background: #fff; transition: all 0.3s ease; }
        .event-item:hover { transform: translateY(-8px); border-color: var(--bs-primary); }
        .animate-pulse { animation: pulse-red 2s infinite; }
        @keyframes pulse-red {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
        }
        .owl-nav button { background: var(--bs-primary) !important; color: #fff !important; width: 40px; height: 40px; border-radius: 50% !important; }
    </style>
@endsection