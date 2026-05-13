@extends('layouts.app')

@section('title', 'Careers | Happy Family Rwanda')

@section('content')
<!-- Hero Section -->
<section class="bg-dark text-white py-5 mb-5" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('images/career-hero.jpg') }}') center/cover;">
    <div class="container py-4 text-center">
        <h1 class="font-jost display-4 fw-black mb-3">Join Our Mission</h1>
        <p class="font-inter lead mx-auto" style="max-width: 700px;">
            Help us empower vulnerable communities in Rwanda. We are looking for passionate individuals to join the Happy Family Rwanda team.
        </p>
    </div>
</section>

<div class="container pb-5">
    <div class="row g-4">
        <!-- Sidebar Filters -->
        <aside class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="font-jost fw-bold mb-4">Departments</h5>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('careers.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0">
                            <span>All Positions</span>
                            <span class="badge bg-primary rounded-pill">{{ $jobs->total() }}</span>
                        </a>
                        @foreach($categories as $category)
                        <a href="{{ route('careers.index', ['category' => $category->slug]) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0">
                            <span>{{ $category->name }}</span>
                            <span class="badge bg-secondary rounded-pill">{{ $category->jobs_count }}</span>
                        </a>
                        @endforeach
                    </div>

                    <hr class="my-4">

                    <div class="bg-light p-3 rounded text-center">
                        <h6 class="font-jost fw-bold">Can't find a role?</h6>
                        <p class="small text-muted mb-0">We are always looking for volunteers.</p>
                        <a href="#" class="btn btn-link btn-sm fw-bold p-0 mt-2">Contact HR</a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Job Listings -->
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="font-jost fw-bold mb-0">Open Vacancies</h4>
                <span class="text-muted font-inter small">Showing {{ $jobs->count() }} of {{ $jobs->total() }} jobs</span>
            </div>

            @forelse($jobs as $job)
                <div class="card border-0 shadow-sm mb-3 reveal-on-scroll">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-soft-primary text-primary mb-2 px-3 py-2 rounded-pill">
                                    {{ $job->type }}
                                </span>
                                <h3 class="font-jost h4 fw-bold mb-1">
                                    <a href="{{ route('careers.show', $job->slug) }}" class="text-decoration-none text-dark stretched-link">
                                        {{ $job->title }}
                                    </a>
                                </h3>
                                <div class="d-flex gap-3 text-muted small mt-2">
                                    <span><i class="bi bi-geo-alt me-1"></i> {{ $job->location }}</span>
                                    <span><i class="bi bi-folder me-1"></i> {{ $job->category->name }}</span>
                                    <span><i class="bi bi-calendar-event me-1"></i> Deadline: {{ $job->deadline->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="text-end d-none d-md-block">
                                <i class="fa fa-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-light rounded">
                    <i class="bi bi-search display-1 text-muted"></i>
                    <p class="mt-3 text-muted">No vacancies found in this category. Check back soon!</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .fw-black { font-weight: 900; }
    .card { transition: transform 0.2s ease-in-out; }
    .card:hover { transform: translateY(-5px); }
</style>
@endpush