@extends('layouts.app')

@section('content')
@php $mainPhoto = $event->event_photos->first(); @endphp
<div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url({{ $mainPhoto ? asset('storage/'.$mainPhoto->file_path) : asset('frontend/img/breadcrumb-bg.jpg') }});
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 120px 0 60px 0;">
    <div class="container text-center py-5" style="max-width: 900px;">
        <div class="mb-3">
            @if($event->status === 'ongoing')
                <span class="badge badge-danger p-2 px-3 shadow-sm"><i class="fas fa-circle mr-1 pulse"></i> ONGOING NOW</span>
            @elseif($event->status === 'completed')
                <span class="badge badge-secondary p-2 px-3 shadow-sm">PAST EVENT</span>
            @else
                <span class="badge badge-primary p-2 px-3 shadow-sm">UPCOMING EVENT</span>
            @endif
        </div>
        <h1 class="text-white display-4 mb-4">{{ $event->event }}</h1>
        <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
            <li class="breadcrumb-item"><a href="/" class="text-white">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('events.index') }}" class="text-white">Events</a></li>
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
                        <h2 class="mb-4 font-weight-bold text-dark">About the Event</h2>
                        <div class="event-description text-secondary mb-5" style="line-height: 1.8; font-size: 1.1rem;">
                            {!! $event->description !!}
                        </div>

                        {{-- Gallery Section --}}
                        @if($event->event_photos->count() > 1)
                            <hr class="my-5">
                            <h4 class="mb-4">Event Gallery</h4>
                            <div class="row g-3">
                                @foreach($event->event_photos as $photo)
                                    <div class="col-md-4 col-6 mb-3">
                                        <a href="{{ asset('storage/' . $photo->file_path) }}" data-lightbox="event-gallery">
                                            <img src="{{ asset('storage/' . $photo->file_path) }}" class="img-fluid rounded shadow-sm" style="height: 150px; width: 100%; object-fit: cover;">
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
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h4 class="mb-4 border-bottom pb-2">Event Information</h4>
                        
                        <div class="d-flex mb-3">
                            <div class="bg-primary-soft p-3 rounded mr-3">
                                <i class="fas fa-calendar-alt text-primary fa-lg"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted d-block">Date</small>
                                <span class="font-weight-bold text-dark">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</span>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="bg-primary-soft p-3 rounded mr-3">
                                <i class="fas fa-clock text-primary fa-lg"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted d-block">Time</small>
                                <span class="font-weight-bold text-dark">{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</span>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="bg-primary-soft p-3 rounded mr-3">
                                <i class="fas fa-map-marker-alt text-primary fa-lg"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted d-block">Location</small>
                                <span class="font-weight-bold text-dark">{{ $event->location }}</span>
                            </div>
                        </div>

                        {{-- Registration/External Link --}}
                        @if($event->link)
                            <a href="{{ $event->link }}" target="_blank" class="btn btn-primary btn-block btn-lg shadow-sm font-weight-bold mb-3">
                                <i class="fas fa-external-link-alt mr-2"></i> Register / Join Event
                            </a>
                        @endif

                        {{-- Documents Section --}}
                        @if($event->documents && $event->documents->count() > 0)
                            <hr>
                            <h5 class="mb-3">Resources & Downloads</h5>
                            <ul class="list-unstyled">
                                @foreach($event->documents as $doc)
                                    <li class="mb-2">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" class="text-decoration-none d-flex align-items-center p-2 bg-light rounded text-dark" download>
                                            <i class="fas fa-file-pdf text-danger mr-2"></i>
                                            <span class="small font-weight-bold text-truncate">{{ $doc->file_name ?? 'Download Document' }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(0, 123, 255, 0.1); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; }
    .pulse { animation: pulse-red 2s infinite; }
    @keyframes pulse-red { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }
    .event-description img { max-width: 100%; height: auto; border-radius: 8px; }
</style>
@endsection