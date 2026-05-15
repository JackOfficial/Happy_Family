@extends('layouts.app')

@section('content')
<section class="py-5 d-flex align-items-center" style="min-height: 80vh;">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Success Icon -->
                <div class="mb-4">
                    <div class="display-1 text-success">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                </div>

                <h1 class="fw-bold mb-3">Murakoze, {{ session('volunteer_name') ?? 'Future Volunteer' }}!</h1>
                <p class="lead text-muted mb-5">
                    Your application to join the Happy Family Rwanda team has been received. 
                    We truly appreciate your willingness to share your time and skills with us.
                </p>

                <!-- Process Timeline -->
                <div class="card border-0 bg-light rounded-4 mb-5">
                    <div class="card-body p-4 text-start">
                        <h5 class="fw-bold mb-4">What happens next?</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span><strong>Review:</strong> Our management team will review your application and skills.</span>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-envelope-fill text-primary me-3 mt-1"></i>
                                <span><strong>Contact:</strong> You will receive an email from us at your registered address within 3-5 business days.</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-people-fill text-info me-3 mt-1"></i>
                                <span><strong>Interview:</strong> If there's a match, we'll schedule a brief introductory call or meeting.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid d-md-flex justify-content-md-center gap-3">
                    <a href="{{ url('/') }}" class="btn btn-dark btn-lg px-5 rounded-pill shadow-sm">
                        Back to Home
                    </a>
                    <a href="{{ url('/about') }}" class="btn btn-outline-dark btn-lg px-5 rounded-pill">
                        Learn More About Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection