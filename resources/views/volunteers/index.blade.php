@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="py-5 bg-dark text-white text-center position-relative" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=2070') center/cover;">
    <div class="container py-5">
        <h1 class="display-3 fw-bold mb-3">Be the Change in Rwanda</h1>
        <p class="lead mb-4 mx-auto" style="max-width: 700px;">
            Join our dedicated team at Happy Family Rwanda. Your time, skills, and heart can transform lives and build a stronger community in Kigali and beyond.
        </p>
        <a href="{{ route('volunteer.apply') }}" class="btn btn-warning btn-lg px-5 rounded-pill fw-bold shadow-sm">
            Apply to Volunteer
        </a>
    </div>
</section>

<!-- Mission & Impact -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&q=80&w=2070" class="img-fluid rounded-4 shadow" alt="Impact">
            </div>
            <div class="col-lg-6 ps-lg-5">
                <h2 class="fw-bold mb-4">Why Volunteer with HFRO?</h2>
                <p class="text-muted mb-4">
                    At Happy Family Rwanda, we believe every individual has something unique to offer. Whether you are a teacher, a healthcare professional, an IT expert, or simply someone who cares, there is a place for you here.
                </p>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-patch-check-fill text-success fs-3 me-3"></i>
                            <span class="fw-bold">Community Growth</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-heart-pulse-fill text-danger fs-3 me-3"></i>
                            <span class="fw-bold">Personal Fulfillment</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-people-fill text-primary fs-3 me-3"></i>
                            <span class="fw-bold">New Connections</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-briefcase-fill text-warning fs-3 me-3"></i>
                            <span class="fw-bold">Skill Building</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Roles & Opportunities -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Current Opportunities</h2>
            <p class="text-muted">We are looking for passionate individuals for the following areas:</p>
        </div>
        <div class="row g-4">
            <!-- Teaching -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center">
                    <div class="card-body">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="bi bi-book fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Education</h5>
                        <p class="small text-muted">Empower children and youth through teaching and mentorship programs.</p>
                    </div>
                </div>
            </div>
            <!-- Healthcare -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center">
                    <div class="card-body">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="bi bi-hospital fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Health Support</h5>
                        <p class="small text-muted">Assist in our community outreach and family health initiatives.</p>
                    </div>
                </div>
            </div>
            <!-- IT/Admin -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center">
                    <div class="card-body">
                        <div class="bg-dark bg-opacity-10 text-dark rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="bi bi-laptop fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Technical Help</h5>
                        <p class="small text-muted">Help us digitize operations and manage our software platforms.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="py-5 text-center">
    <div class="container py-4">
        <h3 class="fw-bold mb-4">Ready to start your journey?</h3>
        <p class="mb-4 text-muted">The application takes less than 5 minutes to complete.</p>
        <a href="{{ route('volunteer.apply') }}" class="btn btn-dark btn-lg px-5 rounded-pill shadow">Apply Now</a>
    </div>
</section>
@endsection