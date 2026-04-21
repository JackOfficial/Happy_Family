@extends('layouts.app')

@section('content')
@php
    $bgImage = $story->featuredPhoto 
        ? asset('storage/' . $story->featuredPhoto->file_path) 
        : asset('frontend/img/breadcrumb-bg.jpg');
@endphp

<div class="container-fluid position-relative overflow-hidden vh-75 d-flex align-items-center" style="background: var(--dark-void);">
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(13, 13, 13, 0.9) 100%); z-index: 2;"></div>
        <img src="{{ $bgImage }}" 
             class="w-100 h-100 animate-slow-zoom" 
             style="object-fit: cover;" 
             alt="{{ $story->title }}">
    </div>

    <div class="container position-relative text-center py-5" style="z-index: 10;">
        <div class="animate__animated animate__fadeInDown mb-4">
            <span class="badge-impact bg-accent-pink shadow-sm text-uppercase tracking-wider">
                {{ $story->cause->name ?? 'Impact Narrative' }}
            </span>
        </div>

        <h1 class="text-white display-3 fw-black mb-4 mx-auto animate__animated animate__fadeInUp" style="max-width: 900px; text-shadow: 0 10px 30px rgba(0,0,0,0.5);">
            {{ $story->title }}
        </h1>

        <div class="d-flex justify-content-center align-items-center text-white-50 mb-5 animate__animated animate__fadeInUp">
            <div class="px-4 border-end border-white-25"><i class="far fa-user text-accent-pink me-2"></i>By HFRO Editorial</div>
            <div class="px-4"><i class="far fa-calendar-alt text-accent-pink me-2"></i>{{ $story->created_at->format('M d, Y') }}</div>
        </div>

        <nav aria-label="breadcrumb" class="animate__animated animate__fadeInUp">
            <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
                <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('stories.index') }}" class="text-white-50 text-decoration-none">Stories</a></li>
                <li class="breadcrumb-item active text-accent-pink fw-bold" aria-current="page text-uppercase">Full Story</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="row g-5">
            {{-- --- MAIN NARRATIVE COLUMN --- --}}
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 rounded-bento shadow-premium border-0 overflow-hidden">
                    @if($story->summary)
                        <div class="quote-card mb-5">
                            <i class="fas fa-quote-left text-accent-pink opacity-25 display-4 d-block mb-3"></i>
                            <p class="fs-4 fw-bold text-purple lh-base">
                                {{ $story->summary }}
                            </p>
                        </div>
                    @endif

                    <div class="story-content brand-rich-text fs-5 text-muted mb-5 leading-relaxed">
                        {!! $story->content !!}
                    </div>

                    {{-- PHOTO JOURNEY --}}
                    @if($story->photos->count() > 1)
                        <div class="mt-5 pt-5 border-top">
                            <h4 class="fw-black text-purple mb-4">Captured Moments</h4>
                            <div class="row g-3">
                                @foreach($story->photos as $photo)
                                    <div class="col-md-4 col-6">
                                        <a href="{{ asset('storage/' . $photo->file_path) }}" 
                                           data-lightbox="story-gallery" 
                                           data-title="{{ $photo->caption }}" 
                                           class="gallery-link">
                                            <div class="rounded-bento overflow-hidden shadow-sm hover-up">
                                                <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                                     class="img-fluid w-100 h-100" 
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

                {{-- RELATED NARRATIVES --}}
                @if(isset($relatedStories) && $relatedStories->count() > 0)
                <div class="mt-5 pt-4">
                    <h4 class="fw-black text-purple mb-4">More from this Cause</h4>
                    <div class="row g-4">
                        @foreach($relatedStories as $related)
                        <div class="col-md-6">
                            <a href="{{ route('stories.show', $related->slug ?? $related->id) }}" class="text-decoration-none">
                                <div class="card border-0 rounded-bento shadow-premium overflow-hidden h-100 transition-up">
                                    <img src="{{ $related->featuredPhoto ? asset('storage/' . $related->featuredPhoto->file_path) : asset('frontend/img/placeholder.jpg') }}" 
                                         class="card-img-top" style="height: 160px; object-fit: cover;">
                                    <div class="card-body p-3">
                                        <h6 class="fw-black text-purple mb-0 text-truncate">{{ $related->title }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- --- INTERACTIVE SIDEBAR --- --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    {{-- SHARE CARD --}}
                    <div class="bg-white p-4 rounded-bento shadow-premium mb-4 border-start border-accent-pink border-5">
                        <h6 class="text-uppercase fw-black text-muted small mb-3">Share the Impact</h6>
                        <div class="d-flex flex-column gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-facebook-premium"><i class="fab fa-facebook-f me-2"></i>Facebook</a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-x-premium"><i class="fab fa-x-twitter me-2"></i>Share on X</a>
                            <a href="whatsapp://send?text={{ urlencode(url()->current()) }}" class="btn btn-whatsapp-premium"><i class="fab fa-whatsapp me-2"></i>WhatsApp</a>
                        </div>
                    </div>

                    {{-- ATTACHMENTS --}}
                    @if($story->documents->count() > 0)
                    <div class="bg-white p-4 rounded-bento shadow-premium mb-4">
                        <h6 class="text-uppercase fw-black text-purple small mb-3 border-bottom pb-2">Technical Reports</h6>
                        <div class="list-group list-group-flush">
                            @foreach($story->documents as $doc)
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center px-0 bg-transparent border-0 mb-2">
                                    <div class="bg-light p-2 rounded-circle me-3 text-accent-pink">
                                        <i class="fas fa-file-download fa-lg"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="small fw-black text-dark text-truncate">{{ $doc->title }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ strtoupper($doc->file_type) }} • PDF Document</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- IMPACT CTA --}}
                    <div class="p-4 rounded-bento shadow-lg text-white text-center position-relative overflow-hidden" style="background: var(--grad-premium);">
                        <div class="position-absolute top-0 end-0 p-3 opacity-10">
                            <i class="fas fa-heart fa-6x"></i>
                        </div>
                        <h5 class="fw-black position-relative mb-2">Change Lives Today</h5>
                        <p class="small opacity-75 mb-4">Your support helps us scale our operations and reach more families in need.</p>
                        <a href="{{ url('/donate') }}" class="btn btn-light btn-lg text-purple fw-black w-100 rounded-pill shadow-sm">DONATE NOW</a>
                    </div>
                </div>
            </div>
        </div> 
    </div> 
</div>

@push('styles')
    <style>
    .vh-75 { height: 75vh; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .text-purple { color: var(--primary-color); }
    .leading-relaxed { line-height: 1.9; }

    .quote-card {
        padding: 2rem;
        background: rgba(var(--bs-primary-rgb), 0.04);
        border-radius: 20px;
        border-left: 8px solid var(--accent-pink);
    }

    .btn-facebook-premium { background: #1877F2; color: white; border-radius: 50px; font-weight: 800; padding: 10px; transition: 0.3s; }
    .btn-x-premium { background: #000000; color: white; border-radius: 50px; font-weight: 800; padding: 10px; transition: 0.3s; }
    .btn-whatsapp-premium { background: #25D366; color: white; border-radius: 50px; font-weight: 800; padding: 10px; transition: 0.3s; }
    
    .btn-facebook-premium:hover, .btn-x-premium:hover, .btn-whatsapp-premium:hover { opacity: 0.9; transform: scale(1.02); color: white; }

    .story-content p { margin-bottom: 1.5rem; }
    .story-content img { border-radius: 24px; margin: 30px 0; box-shadow: 0 20px 40px rgba(0,0,0,0.1); width: 100%; height: auto; }
</style>
@endpush
@endsection