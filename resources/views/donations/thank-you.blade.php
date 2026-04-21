@extends('layouts.app')

@section('title', 'Thank You for Your Support | HFRO')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                
                <div class="success-checkmark mb-5">
                    <div class="check-icon">
                        <span class="icon-line line-tip"></span>
                        <span class="icon-line line-long"></span>
                        <div class="icon-circle"></div>
                        <div class="icon-fix"></div>
                    </div>
                </div>

                <h5 class="text-accent-pink fw-bold text-uppercase tracking-widest mb-3 animate__animated animate__fadeIn">Donation Confirmed</h5>
                <h1 class="display-3 fw-black text-purple mb-4 animate__animated animate__zoomIn">You're a <span class="brand-text">Hero!</span></h1>
                
                <p class="lead text-muted mx-auto mb-5 fs-5" style="max-width: 600px;">
                    Thank you for your generous contribution of <span class="fw-bold text-dark">${{ session('amount') ?? '50.00' }}</span>. 
                    Your support is already on its way to making a real impact in our community.
                </p>

                <div class="bg-white p-5 rounded-bento shadow-premium border-0 mb-5 text-start animate__animated animate__fadeInUp">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h4 class="fw-black text-purple mb-3">What happens next?</h4>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="fas fa-envelope-open-text text-accent-pink mt-1 me-3"></i>
                                    <span>Check your inbox for your <strong>official tax receipt</strong> and a personal thank you note.</span>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="fas fa-project-diagram text-accent-pink mt-1 me-3"></i>
                                    <span>We'll send you an <strong>Impact Report</strong> in 3 months showing exactly how your funds were used.</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="fas fa-users text-accent-pink mt-1 me-3"></i>
                                    <span>Follow our journey on social media to meet the beneficiaries you supported today.</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-5 mt-4 mt-md-0">
                            <div class="p-4 rounded-4 bg-soft-purple text-center">
                                <p class="x-small text-uppercase fw-bold text-purple mb-2">Share the Mission</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="#" class="btn btn-purple-gradient rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="btn btn-purple-gradient rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="btn btn-purple-gradient rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                    <a href="{{ route('donations.index') }}" class="btn btn-outline-purple rounded-pill px-5 py-3 fw-bold">Back to Projects</a>
                    <a href="/" class="btn btn-purple-gradient rounded-pill px-5 py-3 fw-black shadow">Return Home</a>
                </div>

            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .bg-soft-purple { background: rgba(111, 66, 193, 0.05); }
    .x-small { font-size: 0.7rem; letter-spacing: 1px; }

    /* Success Animation Styling */
    .success-checkmark {
        width: 80px;
        height: 115px;
        margin: 0 auto;
    }
    .check-icon {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid #4CAF50;
    }
    .check-icon::before, .check-icon::after {
        content: '';
        height: 100px;
        position: absolute;
        background: #f8f9fa; /* Matches bg-light */
        transform: rotate(-45deg);
    }
    .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
    }
    .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
    }
    .icon-line {
        height: 5px;
        background-color: #4CAF50;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }
    .line-tip {
        top: 46px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
    }
    .line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
    }
    .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 4px solid rgba(76, 175, 80, 0.5);
        position: absolute;
        box-sizing: content-box;
    }
</style>
@endpush
@endsection