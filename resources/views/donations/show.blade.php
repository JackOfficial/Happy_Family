@extends('layouts.app')

@section('title', 'Project: ' . $project->title . ' | HFRO')

@section('content')
<div class="container-fluid bg-light py-5">
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('donations.index') }}" class="text-purple">Donations</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width: 200px;">{{ $project->title }}</li>
            </ol>
        </nav>
        
        <div class="row g-5 align-items-center">
            <div class="col-lg-7">
                {{-- Dynamic Cause Badge --}}
                @if($project->causes->isNotEmpty())
                    <div class="badge bg-soft-purple text-purple px-3 py-2 rounded-pill mb-3">
                        {{ $project->causes->first()->name }}
                    </div>
                @endif
                
                <h1 class="display-4 fw-black text-purple mb-4">{{ $project->title }}</h1>
                
                <div class="d-flex align-items-center mb-4">
                    {{-- Assuming Jacques is the lead if no specific staff is attached --}}
                    <img src="{{ asset('storage/team/jacques.jpg') }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <h6 class="mb-0 fw-bold">Jacques Musengimana</h6>
                        <p class="small text-muted mb-0">Project Lead • Kigali, Rwanda</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="bg-white p-4 rounded-bento shadow-lg border-0">
                    @php 
                        $percent = $project->goal_amount > 0 ? min(round(($project->raised_amount / $project->goal_amount) * 100), 100) : 0;
                    @endphp
                    
                    <div class="d-flex justify-content-between align-items-end mb-2">
                        <h3 class="fw-black text-purple mb-0">${{ number_format($project->raised_amount) }}</h3>
                        <span class="text-muted small">Goal: ${{ number_format($project->goal_amount) }}</span>
                    </div>
                    <div class="progress rounded-pill mb-4" style="height: 12px;">
                        <div class="progress-bar bg-accent-pink" style="width: {{ $percent }}%"></div>
                    </div>
                    
                    <form action="{{ route('donations.checkout') }}" method="GET">
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <div class="row g-2 mb-4">
                            <div class="col-6"><button type="submit" name="amount" value="50" class="btn btn-outline-light-gray w-100 py-3 fw-bold active-price">$50</button></div>
                            <div class="col-6"><button type="submit" name="amount" value="100" class="btn btn-outline-light-gray w-100 py-3 fw-bold">$100</button></div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-purple-gradient w-100 py-3 rounded-pill fw-black shadow">
                                    DONATE TO THIS PROJECT
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <p class="x-small text-center text-muted mb-0">
                        <i class="fas fa-lock me-1"></i> Secure payment via Paystack
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-100">
    <div class="row g-5">
        <div class="col-lg-8">
            <h3 class="fw-black text-purple mb-4">Project Overview</h3>
            <div class="text-muted leading-relaxed mb-5 content-area">
                {!! $project->description !!}
            </div>

            <h3 class="fw-black text-purple mb-4">How your donation helps</h3>
            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-soft-primary border-0 h-100">
                        <div class="fs-2 mb-2">🌱</div>
                        <h6 class="fw-bold">$15</h6>
                        <p class="x-small text-muted mb-0">Provides basic materials for one community beneficiary.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-soft-success border-0 h-100">
                        <div class="fs-2 mb-2">⚙️</div>
                        <h6 class="fw-bold">$150</h6>
                        <p class="x-small text-muted mb-0">Contributes to the core infrastructure of this mission.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-soft-warning border-0 h-100">
                        <div class="fs-2 mb-2">🏆</div>
                        <h6 class="fw-bold">$500</h6>
                        <p class="x-small text-muted mb-0">Significant sponsorship for a high-impact milestone.</p>
                    </div>
                </div>
            </div>

            {{-- Main Project Photo --}}
            @php $photo = $project->project_photos->first(); @endphp
            <img src="{{ $photo ? asset('storage/' . $photo->path) : asset('images/default-project.jpg') }}" 
                 class="w-100 rounded-bento shadow mb-5" 
                 style="max-height: 500px; object-fit: cover;"
                 alt="{{ $project->title }}">

            <h3 class="fw-black text-purple mb-4">The Impact</h3>
            <p class="text-muted leading-relaxed">
                {{ $project->summary ?? 'Your support directly contributes to long-term sustainability and self-reliance within the local community.' }}
            </p>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 100px;">
                <div class="card border-0 shadow-premium rounded-bento p-4 mb-4">
                    <h5 class="fw-black text-purple mb-3">Current Status</h5>
                    <div class="timeline-small">
                        <div class="t-item {{ $project->status == 'active' ? 'active' : '' }}">
                            <span class="t-dot"></span>
                            <p class="small mb-0 fw-bold">Active Mission</p>
                            <p class="x-small text-muted">Started {{ $project->created_at->format('M Y') }}</p>
                        </div>
                        <div class="t-item {{ $project->progress >= 100 ? 'active' : '' }}">
                            <span class="t-dot"></span>
                            <p class="small mb-0">Completion Goal</p>
                            <p class="x-small text-muted">Estimated: {{ $project->created_at->addMonths(6)->format('M Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 bg-purple text-white rounded-bento p-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-check-circle me-2"></i>Verified Project</h5>
                    <p class="x-small mb-0 opacity-75">
                        This mission has been personally vetted by the HFRO Board of Directors. 100% of your gift is allocated directly to this project.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-soft-purple { background: rgba(99, 16, 132, 0.1); }
    .bg-soft-primary { background: #eef2ff; }
    .bg-soft-success { background: #ecfdf5; }
    .bg-soft-warning { background: #fffbeb; }
    .py-100 { padding: 100px 0; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .x-small { font-size: 0.8rem; }
    .leading-relaxed { line-height: 1.8; }
    .active-price { border-color: #631084 !important; color: #631084 !important; background: rgba(99, 16, 132, 0.05); }

    .timeline-small { border-left: 2px solid #eee; margin-left: 10px; padding-left: 20px; }
    .t-item { position: relative; padding-bottom: 25px; }
    .t-dot { position: absolute; left: -27px; top: 5px; width: 12px; height: 12px; border-radius: 50%; background: #ddd; border: 2px solid #fff; }
    .t-item.active .t-dot { background: #ec409e; box-shadow: 0 0 0 4px rgba(236, 64, 158, 0.2); }
    
    .content-area p { margin-bottom: 1.5rem; }
</style>
@endpush
@endsection