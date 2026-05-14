@extends('layouts.app') <!-- Replace with your public layout -->

@section('title', 'Insights & Updates | Happy Family Rwanda')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <!-- Header -->
        <div class="row mb-5">
            <div class="col-md-8">
                <h6 class="text-primary text-uppercase fw-bold tracking-widest">Our Stories</h6>
                <h1 class="display-5 fw-bold font-jost">Latest News & Impact Stories</h1>
                <p class="lead text-muted">Stay updated with our latest activities and the lives being transformed through our shared mission in Rwanda.</p>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar: Cause Filter -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3 font-jost">Filter by Impact</h5>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('blogs.index') }}" 
                               class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center {{ !isset($currentCategory) ? 'text-primary fw-bold' : '' }}">
                                All Categories
                            </a>
                            @foreach($causes as $cause)
                                <a href="{{ route('blogs.category', $cause->slug) }}" 
                                   class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center">
                                    {{ $cause->name }}
                                    <span class="badge rounded-pill bg-light text-dark border">{{ $cause->blogs_count ?? '' }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blog Grid -->
            <div class="col-lg-9">
                <div class="row g-4">
                    @forelse($blogs as $blog)
                        <div class="col-md-6 col-xl-4">
                            <article class="card h-100 border-0 shadow-sm hover-lift transition">
                                <!-- Image with Badge -->
                                <div class="position-relative overflow-hidden rounded-top">
                                    <a href="{{ route('blogs.show', $blog->slug) }}">
                                        @if($blog->blogPhoto)
                                            <img src="{{ asset('storage/' . $blog->blogPhoto->file_path) }}" 
                                                 class="card-img-top img-fluid" alt="{{ $blog->title }}"
                                                 style="height: 220px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary d-flex align-items-center justify-content-center text-white" style="height: 220px;">
                                                <i class="fas fa-image fa-3x"></i>
                                            </div>
                                        @endif
                                    </a>
                                    @if($blog->cause)
                                        <span class="position-absolute top-0 start-0 m-3 badge bg-primary shadow-sm py-2 px-3">
                                            {{ $blog->cause->name }}
                                        </span>
                                    @endif
                                </div>

                                <div class="card-body p-4">
                                    <div class="small text-muted mb-2">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $blog->created_at->format('M d, Y') }}
                                    </div>
                                    <h5 class="card-title fw-bold mb-3 font-jost">
                                        <a href="{{ route('blogs.show', $blog->slug) }}" class="text-dark text-decoration-none stretched-link">
                                            {{ Str::limit($blog->title, 60) }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit(strip_tags($blog->content), 100) }}
                                    </p>
                                </div>

                                <div class="card-footer bg-white border-0 p-4 pt-0 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-user text-muted small"></i>
                                        </div>
                                        <span class="small text-muted fw-bold">{{ $blog->user->name ?? 'HFRO Team' }}</span>
                                    </div>
                                    <i class="fas fa-arrow-right text-primary small"></i>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5 bg-white rounded shadow-sm">
                                <i class="fas fa-newspaper fa-3x text-light mb-3"></i>
                                <h4>No stories found</h4>
                                <p class="text-muted">Check back soon for updates from the field.</p>
                                <a href="{{ route('blogs.index') }}" class="btn btn-primary mt-2">View All Posts</a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $blogs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .tracking-widest { letter-spacing: 0.1em; }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
    .transition { transition: all 0.3s ease-in-out; }
    .avatar-sm { border: 1px solid #eee; }
    .card-title a:hover { color: #0d6efd !important; }
    .list-group-item-action:hover { background-color: #f8f9fa; color: #0d6efd; }
</style>
@endpush
@endsection