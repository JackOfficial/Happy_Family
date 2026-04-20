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

            @if($upcomingEvents->count() > 0)
                <div class="event-carousel owl-carousel">
                    @foreach($upcomingEvents as $event)
                    <div class="event-item shadow-sm">
                        {{-- Image logic matching your specific relationship --}}
                        @php $photo = $event->event_photos->first(); @endphp
                        <img src="{{ $photo ? asset('storage/'.$photo->file_path) : asset('images/placeholder.jpg') }}" 
                             class="img-fluid w-100" style="height: 250px; object-fit: cover;" alt="{{ $event->event }}">
                        
                        <div class="event-content p-4">
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-body small"><i class="fas fa-map-marker-alt text-primary me-2"></i>{{ Str::limit($event->location, 20) }}</span>
                                <span class="text-body small">
                                    <i class="fas fa-calendar-alt text-primary me-2"></i>{{ \Carbon\Carbon::parse($event->date)->format('d M, Y') }}
                                    @if($event->status === 'ongoing')
                                        <span class="badge badge-danger ms-2">LIVE</span>
                                    @endif
                                </span>
                            </div>
                            <h4 class="mb-4">{{ Str::limit($event->event, 50) }}</h4>
                            <p class="mb-4 text-muted small">{!! Str::limit(strip_tags($event->description), 150) !!}</p>
                            
                            {{-- Using the new named route and slug --}}
                            <a class="btn-hover-bg btn btn-primary text-white py-2 px-4 w-100" 
                               href="{{ route('events.show', $event->slug ?? $event->id) }}">View Details</a>
                        </div>
                    </div>  
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 border rounded bg-light">
                    <i class="fas fa-calendar-day fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No upcoming events scheduled at the moment.</h4>
                    <p>Check back soon or follow our social media for updates!</p>
                </div>
            @endif
        </div>

        {{-- PASSED / COMPLETED SECTION --}}
        <div class="container py-5">
            <div class="text-center mx-auto mb-5" style="max-width: 800px;">
                <h5 class="text-uppercase text-secondary">Past Highlights</h5>
                <h2 class="mb-0">Memories of Change</h1>
            </div>

            @if($passedEvents->count() > 0)
                <div class="event-carousel owl-carousel">
                    @foreach($passedEvents as $event)
                    <div class="event-item grayscale shadow-sm" style="opacity: 0.85;">
                        @php $photo = $event->event_photos->first(); @endphp
                        <img src="{{ $photo ? asset('storage/'.$photo->file_path) : asset('images/placeholder.jpg') }}" 
                             class="img-fluid w-100" style="height: 200px; object-fit: cover;" alt="Image">
                        
                        <div class="event-content p-4">
                            <div class="d-flex justify-content-between mb-3 small">
                                <span class="text-body"><i class="fas fa-check-circle text-success me-2"></i>Completed</span>
                                <span class="text-body">{{ \Carbon\Carbon::parse($event->date)->format('M Y') }}</span>
                            </div>
                            <h5 class="mb-3">{{ Str::limit($event->event, 40) }}</h5>
                            <a class="btn btn-outline-secondary btn-sm py-2 px-4 w-100" 
                               href="{{ route('events.show', $event->slug ?? $event->id) }}">View Report</a>
                        </div>
                    </div>  
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted small">History of our past events will appear here.</p>
                </div>
            @endif
        </div>
    </div>
    {{-- Owl Carousel Init --}}
    @push('scripts')
    <script>
        $(document).ready(function(){
            $('.event-carousel').owlCarousel({
                loop: false,
                margin: 25,
                nav: true,
                dots: true,
                autoplay: true,
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
        .grayscale img { filter: grayscale(40%); transition: 0.3s; }
        .grayscale:hover img { filter: grayscale(0%); }
        .event-item { border-radius: 15px; overflow: hidden; background: #fff; transition: transform 0.3s; }
        .event-item:hover { transform: translateY(-5px); }
        .badge-danger { background-color: #dc3545; animation: blink 1.5s infinite; }
        @keyframes blink { 0% { opacity: 1; } 50% { opacity: 0.4; } 100% { opacity: 1; } }
    </style>
@endsection