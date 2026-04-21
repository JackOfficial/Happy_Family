@extends('layouts.app')

@section('title')
 <title>{{ $cause->name }} | Happy Family Rwanda Organization</title>
@endsection

@section('content')
{{-- --- CINEMATIC HERO SECTION --- --}}
<div class="position-relative vh-100 d-flex align-items-center overflow-hidden" style="background: var(--dark-void);">
    @php $heroPhoto = $cause->mainPhoto ?? $cause->photos->first(); @endphp
    <img src="{{ $heroPhoto ? $heroPhoto->url : asset('images/impact.jpg') }}" 
         class="position-absolute top-0 start-0 w-100 h-100 animate__animated animate__fadeIn" 
         style="object-fit: cover; opacity: 0.5; transform: scale(1.1); transition: 10s linear;" alt="{{ $cause->name }}">
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to right, var(--dark-void), transparent);"></div>

    <div class="container position-relative" style="z-index: 5;">
        <div class="row">
            <div class="col-lg-9 text-start">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('causes.index') }}" class="text-white-50 text-decoration-none">Our Impacts</a></li>
                        <li class="breadcrumb-item active text-accent-pink fw-bold" aria-current="page">{{ $cause->name }}</li>
                    </ol>
                </nav>
                <h1 class="display-1 text-white fw-black mb-4 animate__animated animate__fadeInLeft">
                    {{ $cause->name }}
                </h1>
                <div class="p-4 rounded-bento mb-4 border-start border-accent border-5 shadow-lg" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(15px);">
                    <p class="lead text-white mb-0 opacity-90 fw-medium">
                        We don't just start projects; we spark local revolutions. Explore how we're rewriting the narrative of <span class="text-accent-pink fw-bold">{{ $cause->name }}</span> together.
                    </p>
                </div>
                <div class="d-flex gap-3 animate__animated animate__fadeInUp animate__delay-1s">
                    <a href="#impact-details" class="btn-premium">Explore Impact</a>
                    <a href="/donate" class="btn btn-outline-light rounded-pill px-5 py-3 fw-bold border-2">Join the Mission</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="impact-details" class="container py-5">
    {{-- --- THE VISION (GLASS CARD) --- --}}
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-premium p-4 p-md-5 bg-white border-0 rounded-bento position-relative" style="margin-top: -120px; z-index: 10;">
                <div class="row g-5 align-items-center">
                    <div class="col-md-8">
                        <h5 class="text-accent-pink fw-bold text-uppercase mb-2">The Vision</h5>
                        <h2 class="text-purple fw-black display-5 mb-4">Why it Matters</h2>
                        <div class="text-muted fs-5 leading-relaxed">
                            {!! $cause->description !!}
                        </div>
                    </div>
                    <div class="col-md-4 text-center border-start d-none d-md-block">
                        <div class="mb-4">
                            <h1 class="brand-text display-3 fw-black mb-0">{{ $cause->events_count + $cause->stories_count + $cause->projects_count }}</h1>
                            <p class="text-uppercase tracking-widest small fw-black text-muted">Total Milestones</p>
                        </div>
                        <div class="bg-light p-4 rounded-bento border-start border-accent border-4">
                            <i class="fas fa-quote-left text-accent-pink mb-3 fs-3"></i>
                            <p class="small fst-italic text-dark fw-medium">"Building a more self-reliant Rwanda, one initiative at a time."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- --- PROJECTS SECTION (BENTO GRID) --- --}}
    @if($cause->projects->count() > 0)
    <div class="mt-100">
        <div class="mb-5 text-center">
            <h5 class="text-accent-pink fw-bold text-uppercase">Long-term Impact</h5>
            <h2 class="display-5 fw-black text-purple">Key Projects</h2>
            <div class="mx-auto mt-3" style="width: 60px; height: 4px; background: var(--grad-premium); border-radius: 2px;"></div>
        </div>
        <div class="row g-4">
            @foreach($cause->projects as $project)
            <div class="col-md-6">
                <a href="{{ route('projects.show', $project->slug) }}" class="text-decoration-none d-block h-100">
                    <div class="p-4 bg-white shadow-sm rounded-bento border-start border-accent border-5 h-100 transition-up">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="fw-black mb-2 text-purple">{{ $project->name }}</h4>
                                <p class="text-muted small mb-0">{{ Str::limit(strip_tags($project->description), 140) }}</p>
                            </div>
                            <div class="ms-3 text-accent-pink">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- --- ONGOING EVENTS --- --}}
    @if($cause->events->count() > 0)
    <div class="mt-100">
        <div class="mb-5">
            <h5 class="text-accent-pink fw-bold text-uppercase">Community Engagement</h5>
            <h2 class="display-5 fw-black text-purple">Ongoing Events</h2>
        </div>
        <div class="row g-4">
            @foreach($cause->events as $event)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-premium rounded-bento overflow-hidden transition-up">
                    <div class="position-relative" style="height: 220px;">
                        @php $eventPhoto = $event->photos->first(); @endphp
                        <img src="{{ $eventPhoto ? $eventPhoto->url : asset('images/impact.jpg') }}" 
                             class="w-100 h-100" style="object-fit: cover;" alt="{{ $event->title }}">
                        <span class="position-absolute top-0 end-0 m-3 badge-impact">
                            {{ strtoupper($event->status) }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-black text-purple">{{ $event->title }}</h5>
                        <p class="text-accent-pink small mb-3 fw-bold"><i class="fas fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                        <p class="text-muted small mb-4">{{ Str::limit(strip_tags($event->description), 100) }}</p>
                        <a href="{{ route('events.show', $event->id) }}" class="text-purple fw-black text-decoration-none small">
                            SEE DETAILS <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- --- SUCCESS STORIES (FULL-WIDTH CARDS) --- --}}
    @if($cause->stories->count() > 0)
    <div class="mt-100 pt-5">
        <div class="text-center mb-5">
            <h5 class="text-accent-pink fw-bold text-uppercase">Human Impact</h5>
            <h2 class="display-5 fw-black text-purple">Success Stories</h2>
        </div>
        <div class="row g-4">
            @foreach($cause->stories as $story)
            <div class="col-lg-6">
                <div class="card border-0 bg-dark text-white rounded-bento overflow-hidden shadow-premium position-relative" style="height: 450px;">
                    @php $storyPhoto = $story->mainPhoto ?? $story->photos->first(); @endphp
                    <img src="{{ $storyPhoto ? $storyPhoto->url : asset('images/impact.jpg') }}" 
                         class="card-img h-100 opacity-50" style="object-fit: cover;" alt="{{ $story->title }}">
                    <div class="card-img-overlay d-flex flex-column justify-content-end p-5" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                        <h3 class="fw-black mb-3">{{ $story->title }}</h3>
                        <p class="opacity-90 mb-4 fs-6">{{ Str::limit(strip_tags($story->content), 130) }}</p>
                        <div>
                            <a href="{{ route('stories.show', $story->slug) }}" class="btn btn-light rounded-pill px-4 fw-black text-purple shadow">Read Story</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- --- GALLERY GRID --- --}}
    @if($cause->photos->count() > 1)
    <div class="mt-100">
        <h4 class="fw-black text-purple mb-4">In the Field</h4>
        <div class="row g-3">
            @foreach($cause->photos as $photo)
            <div class="col-6 col-md-3">
                <a href="{{ $photo->url }}" data-lightbox="cause-gallery">
                    <div class="overflow-hidden rounded-bento shadow-sm" style="height: 200px;">
                        <img src="{{ $photo->url }}" class="img-fluid w-100 h-100 gallery-img" style="object-fit: cover;">
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- --- PREMIUM CTA --- --}}
<div class="container-fluid py-5 mt-100" style="background: var(--grad-premium);">
    <div class="container text-center text-white py-5">
        <h2 class="display-4 fw-black mb-4">Make an Impact in {{ $cause->name }}</h2>
        <p class="lead mb-5 opacity-90 mx-auto" style="max-width: 700px;">Your contribution directly fuels these initiatives and transforms lives across the communities of Rwanda.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="/donate" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-black text-purple shadow-lg">Donate Now</a>
            <a href="/contact" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 border-2">Inquire More</a>
        </div>
    </div>
</div>

@push('styles')
    <style>
    .mt-100 { margin-top: 100px; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .text-purple { color: var(--primary-color); }
    .text-accent-pink { color: var(--accent-color); }
    .transition-up { transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .transition-up:hover { transform: translateY(-10px); }
    .gallery-img { transition: 0.5s ease; cursor: zoom-in; }
    .gallery-img:hover { transform: scale(1.1); filter: brightness(1.1); }
</style>
@endpush
@endsection