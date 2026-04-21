@extends('layouts.app')
@section('title')
 <title>{{ $cause->name }} | Happy Family Rwanda Organization</title>
@endsection

@push('styles')
    <style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .card:hover { transform: translateY(-5px); transition: 0.3s ease; }
    .gallery-img:hover { filter: brightness(80%); transition: 0.3s ease; cursor: pointer; }
    .btn-primary { background-color: #e83e8c; border-color: #e83e8c; }
    .btn-primary:hover { background-color: #d82a7b; border-color: #d82a7b; }
    .text-primary { color: #e83e8c !important; }
    .bg-primary { background-color: #e83e8c !important; }
    .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.5); }
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="position-relative vh-100 d-flex align-items-center overflow-hidden" style="background: #000;">
    @php $heroPhoto = $cause->mainPhoto ?? $cause->photos->first(); @endphp
    <img src="{{ $heroPhoto ? $heroPhoto->url : asset('images/impact.jpg') }}" 
         class="position-absolute top-0 start-0 w-100 h-100" 
         style="object-fit: cover; opacity: 0.4; filter: grayscale(20%);" alt="{{ $cause->name }}">
    
    <div class="container position-relative" style="z-index: 5;">
        <div class="row">
            <div class="col-lg-8 text-start">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('causes.index') }}" class="text-white-50 text-decoration-none">Our Impacts</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $cause->name }}</li>
                    </ol>
                </nav>
                <h1 class="display-1 text-white fw-bold mb-4">{{ $cause->name }}</h1>
                <div class="p-4 rounded-4 mb-4 border-start border-primary border-4" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                    <p class="lead text-white mb-0 opacity-90">
                        We don't just start projects; we spark local revolutions. Explore how we're rewriting the narrative of {{ $cause->name }} together.
                    </p>
                </div>
                <div class="d-flex gap-3">
                    <a href="#impact-details" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg">Explore Impact</a>
                    <a href="/donate" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3">Join the Mission</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="impact-details" class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Vision Card --}}
            <div class="card shadow-lg p-5 bg-white border-0 rounded-5 position-relative" style="margin-top: -100px; z-index: 10;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="text-dark fw-bold mb-4">The Vision</h2>
                        <div class="text-secondary" style="line-height: 1.8; font-size: 1.1rem;">
                            {!! $cause->description !!}
                        </div>
                    </div>
                    <div class="col-md-4 text-center border-start d-none d-md-block">
                        <div class="mb-4">
                            <h1 class="text-primary fw-bold mb-0">{{ $cause->events_count + $cause->stories_count + $cause->projects_count }}</h1>
                            <p class="text-uppercase tracking-widest small fw-bold text-muted">Successful Milestones</p>
                        </div>
                        <div class="bg-light p-3 rounded-4">
                            <i class="fas fa-quote-left text-primary mb-2"></i>
                            <p class="small fst-italic text-muted">Building a more self-reliant Rwanda, one initiative at a time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- Projects Section --}}
    @if($cause->projects->count() > 0)
    <div class="mt-5 pt-5">
        <div class="mb-5">
            <h5 class="text-primary text-uppercase fw-bold">Long-term Impact</h5>
            <h2 class="display-5 fw-bold">Key Projects</h2>
        </div>
        <div class="row g-4">
            @foreach($cause->projects as $project)
            <div class="col-md-6">
                {{-- Wrapped in a link with a 'project-card' class for styling --}}
                <a href="{{ route('projects.show', $project->slug) }}" class="text-decoration-none project-card d-block h-100">
                    <div class="d-flex align-items-center p-4 bg-white shadow-sm rounded-4 border-start border-primary border-4 h-100">
                        <div class="flex-grow-1">
                            <h4 class="fw-bold mb-1 text-dark">{{ $project->name }}</h4>
                            <p class="text-muted small mb-0">{{ Str::limit(strip_tags($project->description), 120) }}</p>
                        </div>
                        <div class="ms-3 text-primary opacity-50">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Events Section --}}
    @if($cause->events->count() > 0)
    <div class="mt-5 pt-5">
        <div class="mb-5">
            <h5 class="text-primary text-uppercase fw-bold">Community Engagement</h5>
            <h2 class="display-5 fw-bold">Ongoing Events</h2>
        </div>
        <div class="row g-4">
            @foreach($cause->events as $event)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="position-relative" style="height: 200px;">
                        @php $eventPhoto = $event->photos->first(); @endphp
                        <img src="{{ $eventPhoto ? $eventPhoto->url : asset('images/impact.jpg') }}" 
                             class="w-100 h-100" style="object-fit: cover;" alt="{{ $event->title }}">
                        <span class="position-absolute top-0 end-0 m-3 badge bg-{{ $event->status == 'ongoing' ? 'danger' : 'primary' }}">
                            {{ strtoupper($event->status) }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold">{{ $event->title }}</h5>
                        <p class="text-muted small mb-3"><i class="fas fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                        <p class="text-muted line-clamp-2 small">{{ strip_tags($event->description) }}</p>
                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-link text-primary p-0 text-decoration-none fw-bold">
                            See Details <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Impact Stories --}}
    @if($cause->stories->count() > 0)
    <div class="mt-5 pt-5">
        <div class="text-center mb-5">
            <h5 class="text-primary text-uppercase fw-bold">Human Impact</h5>
            <h2 class="display-5 fw-bold">Success Stories</h2>
            <div class="mx-auto" style="width: 60px; height: 3px; background: #e83e8c;"></div>
        </div>
        <div class="row g-4">
            @foreach($cause->stories as $story)
            <div class="col-lg-6">
                <div class="card border-0 bg-dark text-white rounded-5 overflow-hidden position-relative">
                    @php $storyPhoto = $story->mainPhoto ?? $story->photos->first(); @endphp
                    <img src="{{ $storyPhoto ? $storyPhoto->url : asset('images/impact.jpg') }}" 
                         class="card-img opacity-50" style="height: 400px; object-fit: cover;" alt="{{ $story->title }}">
                    <div class="card-img-overlay d-flex flex-column justify-content-end p-5">
                        <h3 class="fw-bold mb-3">{{ $story->title }}</h3>
                        <p class="opacity-90 mb-4">{{ Str::limit(strip_tags($story->content), 150) }}</p>
                        <div>
                            <a href="{{ route('stories.show', $story->slug) }}" class="btn btn-primary rounded-pill px-4 shadow">Read Full Story</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Gallery --}}
    @if($cause->photos->count() > 1)
    <div class="mt-5 pt-5">
        <h4 class="fw-bold mb-4">In the Field</h4>
        <div class="row g-3">
            @foreach($cause->photos as $photo)
            <div class="col-6 col-md-3">
                <a href="{{ $photo->url }}" data-lightbox="cause-gallery">
                    <img src="{{ $photo->url }}" class="img-fluid rounded-4 shadow-sm gallery-img" style="height: 180px; width: 100%; object-fit: cover;">
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- CTA --}}
<div class="container-fluid py-5 mt-5" style="background: linear-gradient(45deg, #6f42c1, #e83e8c);">
    <div class="container text-center text-white py-5">
        <h2 class="display-4 fw-bold mb-4">Make an Impact in {{ $cause->name }}</h2>
        <p class="lead mb-5 opacity-90">Your contribution directly fuels these initiatives and transforms lives in Rwanda.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="/donate" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold text-primary shadow">Donate Now</a>
            <a href="/contact" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3">Inquire More</a>
        </div>
    </div>
</div>
@endsection