@extends('layouts.app')

@section('title', $job->title . ' | Happy Family Rwanda')

@section('content')
<!-- Job Header Section -->
<section class="bg-light border-bottom py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb font-inter small">
                <li class="breadcrumb-item"><a href="{{ route('careers.index') }}" class="text-decoration-none text-primary">Careers</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $job->category->name }}</li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">{{ $job->type }}</span>
                <h1 class="font-jost display-5 fw-bold text-dark">{{ $job->title }}</h1>
                <div class="d-flex flex-wrap gap-4 mt-3 text-muted font-inter">
                    <span><i class="bi bi-geo-alt-fill text-primary me-1"></i> {{ $job->location }}</span>
                    <span><i class="bi bi-briefcase-fill text-primary me-1"></i> {{ $job->category->name }}</span>
                    <span><i class="bi bi-clock-fill text-primary me-1"></i> Posted {{ $job->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-4 mt-md-0">
                <a href="#apply-form" class="btn btn-premium px-5 py-3 shadow-sm rounded-pill font-jost fw-bold text-white">
                    Apply for this Position
                </a>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row g-5">
        <!-- Job Description Content -->
        <div class="col-lg-8">
            <div class="job-content font-inter text-secondary leading-relaxed">
                <h4 class="font-jost fw-bold text-dark mb-4">About the Role</h4>
                {!! $job->description !!}

                @if($job->requirements)
                    <h4 class="font-jost fw-bold text-dark mt-5 mb-4">Requirements</h4>
                    {!! $job->requirements !!}
                @endif

                @if($job->benefits)
                    <h4 class="font-jost fw-bold text-dark mt-5 mb-4">Benefits & Compensation</h4>
                    {!! $job->benefits !!}
                @endif
            </div>

            <hr class="my-5">

            <!-- Livewire Application Form -->
            <div id="apply-form" class="reveal-on-scroll">
                <h3 class="font-jost fw-bold text-dark mb-2">Submit Your Application</h3>
                <p class="text-muted mb-4 font-inter">Please complete the form below. All fields marked with * are required.</p>
                
                @livewire('career-application-form', ['job' => $job, 'countries' => $countries])
            </div>
        </div>

        <!-- Sidebar Info Card -->
        <aside class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="font-jost fw-bold border-bottom pb-3 mb-3">Job Summary</h5>
                    
                    <ul class="list-unstyled font-inter">
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="text-muted">Category:</span>
                            <span class="fw-semibold">{{ $job->category->name }}</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="text-muted">Job Type:</span>
                            <span class="fw-semibold">{{ $job->type }}</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="text-muted">Location:</span>
                            <span class="fw-semibold">{{ $job->location }}</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-between text-danger fw-bold">
                            <span>Deadline:</span>
                            <span>{{ $job->deadline->format('M d, Y') }}</span>
                        </li>
                    </ul>

                    <div class="bg-light p-3 rounded mt-4">
                        <h6 class="font-jost fw-bold small text-uppercase text-muted mb-3 text-center">Share this opening</h6>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection

@push('styles')
<style>
    .job-content h4 {
        color: #1a1a1a;
    }
    .job-content ul {
        padding-left: 1.2rem;
        margin-bottom: 1.5rem;
    }
    .job-content li {
        margin-bottom: 0.5rem;
    }
    .btn-premium {
        background: #000; /* Matching your bg-dark layout theme */
        transition: all 0.3s ease;
    }
    .btn-premium:hover {
        background: #333;
        transform: translateY(-2px);
    }
    .leading-relaxed {
        line-height: 1.8;
    }
</style>
@endpush