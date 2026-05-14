@extends('layouts.app')

@section('title', $blog->title . ' | Happy Family Rwanda')

@section('content')
<!-- Blog Hero Section -->
<header class="py-5 bg-light border-bottom mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3 font-inter small">
                        <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Blog</a></li>
                        @if($blog->cause)
                            <li class="breadcrumb-item">
                                <a href="{{ route('blogs.category', $blog->cause->slug) }}">{{ $blog->cause->name }}</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">Post</li>
                    </ol>
                </nav>
                <h1 class="fw-bold display-4 font-jost mb-4 text-dark">{{ $blog->title }}</h1>
                
                <div class="d-flex align-items-center">
                    <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold text-dark">{{ $blog->user->name ?? 'HFRO Team' }}</p>
                        <p class="mb-0 small text-muted">{{ $blog->created_at->format('F d, Y') }} • {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Featured Image -->
            @if($blog->blogPhoto)
                <figure class="mb-5">
                    <img class="img-fluid rounded shadow-sm w-100" 
                         src="{{ asset('storage/' . $blog->blogPhoto->file_path) }}" 
                         alt="{{ $blog->title }}" 
                         style="max-height: 500px; object-fit: cover;"/>
                </figure>
            @endif

            <!-- Post Content -->
            <section class="mb-5 blog-content font-inter text-dark lh-lg" style="font-size: 1.15rem;">
                {!! $blog->content !!}
            </section>

            <hr class="my-5">

            <!-- Related Posts Section -->
            @if($relatedBlogs->count() > 0)
                <div class="related-posts mb-5">
                    <h3 class="font-jost fw-bold mb-4">More from {{ $blog->cause->name ?? 'Our Stories' }}</h3>
                    <div class="row g-4">
                        @foreach($relatedBlogs as $related)
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-xs hover-lift transition">
                                    <div class="position-relative">
                                        <a href="{{ route('blogs.show', $related->slug) }}">
                                            @php $photo = $related->blogPhoto->file_path ?? null; @endphp
                                            <img src="{{ $photo ? asset('storage/'.$photo) : 'https://via.placeholder.com/300x200' }}" 
                                                 class="card-img-top rounded shadow-sm" 
                                                 style="height: 150px; object-fit: cover;" 
                                                 alt="{{ $related->title }}">
                                        </a>
                                    </div>
                                    <div class="card-body px-0">
                                        <h6 class="fw-bold font-jost">
                                            <a href="{{ route('blogs.show', $related->slug) }}" class="text-dark text-decoration-none">
                                                {{ Str::limit($related->title, 50) }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Comments Section placeholder -->
            <section class="bg-light p-4 rounded border-0 shadow-sm">
                <h4 class="font-jost fw-bold mb-4"><i class="far fa-comments me-2"></i> Conversation</h4>
                <p class="text-muted small">The comment section for this post is currently being moderated. Check back soon!</p>
            </section>
        </div>
    </div>
</div>

@push('styles')
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    .blog-content p { margin-bottom: 1.5rem; }
    .blog-content img { max-width: 100%; height: auto; border-radius: 8px; margin: 2rem 0; }
    .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .transition { transition: all 0.3s ease; }
    .hover-lift:hover { transform: translateY(-3px); }
</style>
@endpush
@endsection