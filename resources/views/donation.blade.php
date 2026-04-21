@extends('layouts.app')

@section('title', 'Support Our Mission | Happy Family Rwanda Organization')

@section('content')
<div class="container-fluid position-relative overflow-hidden vh-60 d-flex align-items-center" style="background: var(--dark-void);">
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(to right, rgba(45, 13, 82, 0.9) 0%, rgba(214, 51, 132, 0.4) 100%); z-index: 2;"></div>
        <img src="{{ asset('storage/headers/donation-hero.jpg') }}" 
             class="w-100 h-100 animate-slow-zoom" 
             style="object-fit: cover; opacity: 0.5;" 
             alt="Support HFRO">
    </div>
    
    <div class="container position-relative text-center py-5" style="z-index: 10;">
        <h5 class="text-accent-pink fw-bold text-uppercase tracking-widest mb-3 animate__animated animate__fadeInDown">Make a Change</h5>
        <h1 class="text-white display-3 fw-black mb-4 animate__animated animate__fadeInUp">Your Kindness, <span class="brand-text">Their Future</span></h1>
        <p class="lead text-white-50 mx-auto mb-5 fs-5" style="max-width: 800px;">
            100% of your donation goes directly to our community programs in Rwanda. From education to healthcare, your support builds a lasting legacy.
        </p>
    </div>
</div>

<div class="container-fluid bg-light py-100">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-black text-purple">Choose Your Impact</h2>
            <p class="text-muted">Select an amount that resonates with your heart.</p>
        </div>

        <div class="row g-4 mb-5">
            {{-- Option 1 --}}
            <div class="col-md-4">
                <div class="bg-white p-5 rounded-bento shadow-premium text-center h-100 border-0 hover-up">
                    <div class="icon-box-premium bg-light text-primary mx-auto mb-4">
                        <i class="fas fa-apple-alt"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-2">$25</h3>
                    <p class="text-muted small mb-4">Provide nutrition and school meals for one child for an entire month.</p>
                    <a href="#" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Select</a>
                </div>
            </div>

            {{-- Option 2 (Featured) --}}
            <div class="col-md-4">
                <div class="p-5 rounded-bento shadow-lg text-center h-100 border-0 position-relative text-white overflow-hidden" style="background: var(--grad-premium);">
                    <span class="position-absolute top-0 end-0 bg-accent-pink px-3 py-1 fw-bold small" style="border-radius: 0 0 0 15px;">MOST POPULAR</span>
                    <div class="icon-box-premium bg-white text-purple mx-auto mb-4">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <h3 class="fw-black mb-2 text-white">$100</h3>
                    <p class="text-white-50 small mb-4">Sponsor a student's full vocational training module and equipment.</p>
                    <a href="#" class="btn btn-light text-purple rounded-pill px-5 fw-black">Select</a>
                </div>
            </div>

            {{-- Option 3 --}}
            <div class="col-md-4">
                <div class="bg-white p-5 rounded-bento shadow-premium text-center h-100 border-0 hover-up">
                    <div class="icon-box-premium bg-light text-primary mx-auto mb-4">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-2">$500+</h3>
                    <p class="text-muted small mb-4">Major contribution to community infrastructure and clean water projects.</p>
                    <a href="#" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Select</a>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-5 align-items-center g-5">
            <div class="col-lg-6">
                <div class="bg-white p-5 rounded-bento shadow-premium border-0">
                    <h4 class="fw-black text-purple mb-4">How to Give</h4>
                    
                    <div class="d-flex align-items-center mb-4 p-3 rounded-4 bg-light border-0">
                        <div class="bg-white p-3 rounded-3 shadow-sm me-3">
                            <i class="fas fa-university text-primary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Bank Transfer</h6>
                            <p class="text-muted small mb-0">I&M Bank Rwanda | Acc: 000123456789</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4 p-3 rounded-4 bg-light border-0">
                        <div class="bg-white p-3 rounded-3 shadow-sm me-3">
                            <i class="fas fa-mobile-alt text-success fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Mobile Money (Momo)</h6>
                            <p class="text-muted small mb-0">Dial *182*8*1*123456# (HFRO)</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center p-3 rounded-4 bg-light border-0">
                        <div class="bg-white p-3 rounded-3 shadow-sm me-3">
                            <i class="fab fa-paypal text-info fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Online Payment</h6>
                            <p class="text-muted small mb-0">Donate securely via PayPal or Credit Card</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="ps-lg-5">
                    <h2 class="fw-black text-purple mb-4">Where does your money go?</h2>
                    <p class="text-muted leading-relaxed mb-4">
                        Transparency is our core value. Every contribution is tracked and reported back to our donors. We ensure that 100% of public donations reach the final beneficiaries.
                    </p>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-check-circle text-accent-pink me-3"></i>
                            <span class="fw-bold text-dark">Verified Project Allocation</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-check-circle text-accent-pink me-3"></i>
                            <span class="fw-bold text-dark">Quarterly Impact Reports</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-check-circle text-accent-pink me-3"></i>
                            <span class="fw-bold text-dark">Direct Beneficiary Connection</span>
                        </li>
                    </ul>
                    <div class="mt-5 p-4 rounded-bento bg-white shadow-sm border-start border-primary border-5">
                        <p class="fst-italic text-muted mb-0">
                            "Supporting HFRO isn't just giving money; it's investing in the dignity of a family."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .vh-60 { height: 60vh; }
    .py-100 { padding: 100px 0; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .text-purple { color: var(--primary-color); }
    .leading-relaxed { line-height: 1.8; }
    
    .icon-box-premium {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        font-size: 1.8rem;
        transition: 0.3s;
    }

    .hover-up {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .hover-up:hover {
        transform: translateY(-15px);
        box-shadow: 0 25px 50px rgba(45, 13, 82, 0.1) !important;
    }
</style>
@endpush
@endsection