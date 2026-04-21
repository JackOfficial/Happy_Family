@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative overflow-hidden vh-60 d-flex align-items-center" style="background: var(--dark-void);">
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(135deg, rgba(45, 13, 82, 0.9) 0%, rgba(214, 51, 132, 0.4) 100%); z-index: 2;"></div>
        <img src="{{ asset('frontend/img/breadcrumb-bg.jpg') }}" 
             class="w-100 h-100 animate-slow-zoom" 
             style="object-fit: cover; opacity: 0.5;" 
             alt="Success Stories">
    </div>
    
    <div class="container position-relative text-center py-5" style="z-index: 10;">
        <div class="d-inline-flex align-items-center mb-4 px-3 py-1 rounded-pill animate__animated animate__fadeInDown" 
             style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
            <small class="text-white fw-bold text-uppercase tracking-wider" style="font-size: 0.7rem; letter-spacing: 2px;">Voices of Change</small>
        </div>

        <h1 class="text-white display-2 fw-black mb-4 animate__animated animate__fadeInUp">
            Success <span class="brand-text">Stories</span>
        </h1>
        
        <p class="lead text-white opacity-75 mx-auto mb-5 fs-4" style="max-width: 700px;">
            Real people. Real impact. Explore how your support is reshaping lives across Rwanda.
        </p>
        
        <nav aria-label="breadcrumb" class="d-inline-block p-2 px-4 rounded-pill shadow-lg animate__animated animate__fadeInUp" 
             style="background: rgba(0, 0, 0, 0.3); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1);">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white opacity-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                     <span class="text-accent-pink">●</span> Stories
                </li>
            </ol>
        </nav>
    </div>

    <div class="position-absolute bottom-0 start-0 w-100" style="line-height: 0; transform: rotate(180deg);">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width: 100%; height: 50px; fill: #f8f9fa;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
</div>

<div class="container-fluid py-100 bg-light">
    <div class="container">
        <div class="text-center mx-auto mb-100" style="max-width: 800px;">
            <h5 class="text-accent-pink fw-bold text-uppercase mb-2">Our Impact</h5>
            <h2 class="display-5 fw-black text-purple mb-4">Stories of Resilience</h2>
            <p class="text-muted fs-5">Fostering hope and making a tangible impact in local communities. Join us in celebrating these milestones of human dignity.</p>
            <div class="mx-auto mt-4" style="width: 60px; height: 5px; background: var(--grad-premium); border-radius: 10px;"></div>
        </div>

        <div class="row g-4">
            @forelse($stories as $story)
            <div class="col-lg-4 col-md-6">
                <article class="story-card h-100 shadow-premium bg-white rounded-bento overflow-hidden d-flex flex-column border-0">
                    <div class="position-relative overflow-hidden" style="height: 260px;">
                        <img src="{{ $story->featuredPhoto ? asset('storage/'.$story->featuredPhoto->file_path) : asset('frontend/img/placeholder.jpg') }}" 
                             class="img-fluid w-100 h-100 transition-zoom" 
                             style="object-fit: cover;" 
                             alt="{{ $story->title }}">
                        
                        @if($story->cause)
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge-impact bg-purple-gradient shadow-sm">
                                    {{ $story->cause->name }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3 text-muted small fw-bold">
                            <span class="me-3"><i class="far fa-calendar-alt text-accent-pink me-2"></i>{{ $story->created_at->format('M d, Y') }}</span>
                            <span><i class="far fa-user text-accent-pink me-2"></i>HFRO Editorial</span>
                        </div>
                        
                        <h4 class="text-purple fw-black mb-3 h5" style="line-height: 1.4;">
                            {{ Str::limit($story->title, 65) }}
                        </h4>
                        
                        <p class="text-muted small mb-4 flex-grow-1">
                            {{ $story->summary ?? Str::limit(strip_tags($story->content), 120) }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top">
                            <a class="btn-premium-outline w-100 text-center" href="{{ route('stories.show', $story->slug ?? $story->id) }}">
                                Read Full Narrative
                            </a>
                        </div>
                    </div>
                </article>
            </div>  
            @empty
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-bento shadow-sm border-dashed">
                    <i class="fas fa-feather-alt text-purple opacity-25 display-1 mb-3"></i>
                    <h3 class="fw-black text-purple">New Stories Coming Soon</h3>
                    <p class="text-muted">We are currently documenting our latest field work. Stay tuned!</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5 pagination-premium">
            {{ $stories->links() }}
        </div>
    </div>
</div>

<div class="container-fluid py-5 overflow-hidden" style="background: var(--primary-color);">
    <div class="container py-5 text-center position-relative" style="z-index: 5;">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h2 class="display-5 fw-black text-white mb-4">Together, we can scale this impact.</h2>
                <p class="lead text-white opacity-75 mb-5">Every story you read here was made possible by someone like you. Whether through time or resources, you can be part of the next chapter.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-black text-purple shadow-lg">Become a Volunteer</a>
                    <a href="{{ url('/donate') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-black shadow-lg">Make a Donation</a>
                </div>
            </div>
        </div>
    </div>
    <div class="position-absolute top-50 start-0 translate-middle-y opacity-10" style="font-size: 20rem; color: white; transform: rotate(-15deg);">
        <i class="fas fa-heart"></i>
    </div>
</div>

@push('styles')
    <style>
    .py-100 { padding: 100px 0; }
    .mb-100 { margin-bottom: 80px; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .text-purple { color: var(--primary-color); }
    
    .story-card { transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .story-card:hover { transform: translateY(-10px); }
    
    .transition-zoom { transition: transform 0.8s ease; }
    .story-card:hover .transition-zoom { transform: scale(1.1); }
    
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
        transition: all 0.3s ease;
    }
    .btn-premium-outline:hover {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 10px 20px rgba(99, 16, 132, 0.2);
    }
    
    .bg-purple-gradient { background: var(--grad-premium); color: white; border: none; padding: 6px 16px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
</style>
@endpush
@endsection