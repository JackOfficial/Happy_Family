@extends('layouts.app')

@section('title', 'Project: Vocational Toolkits | HFRO')

@section('content')
<div class="container-fluid bg-light py-5">
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('donations.index') }}" class="text-purple">Donations</a></li>
                <li class="breadcrumb-item active">Vocational Toolkits</li>
            </ol>
        </nav>
        
        <div class="row g-5 align-items-center">
            <div class="col-lg-7">
                <div class="badge bg-soft-purple text-purple px-3 py-2 rounded-pill mb-3">Education & Empowerment</div>
                <h1 class="display-4 fw-black text-purple mb-4">Empowering the Next Generation of Tech Leaders</h1>
                
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ asset('storage/team/jacques.jpg') }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <h6 class="mb-0 fw-bold">Jacques Musengimana</h6>
                        <p class="small text-muted mb-0">Project Lead • Kigali, Rwanda</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="bg-white p-4 rounded-bento shadow-lg border-0">
                    <div class="d-flex justify-content-between align-items-end mb-2">
                        <h3 class="fw-black text-purple mb-0">$3,400</h3>
                        <span class="text-muted small">Goal: $4,500</span>
                    </div>
                    <div class="progress rounded-pill mb-4" style="height: 12px;">
                        <div class="progress-bar bg-accent-pink" style="width: 75%"></div>
                    </div>
                    
                    <div class="row g-2 mb-4">
                        <div class="col-6"><button class="btn btn-outline-light-gray w-100 py-3 fw-bold active-price">$50</button></div>
                        <div class="col-6"><button class="btn btn-outline-light-gray w-100 py-3 fw-bold">$100</button></div>
                        <div class="col-12"><button class="btn btn-purple-gradient w-100 py-3 rounded-pill fw-black shadow">DONATE NOW</button></div>
                    </div>
                    
                    <p class="x-small text-center text-muted mb-0">
                        <i class="fas fa-lock me-1"></i> Secure payment processed via Paystack
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-100">
    <div class="row g-5">
        <div class="col-lg-8">
            <h3 class="fw-black text-purple mb-4">The Challenge</h3>
            <p class="text-muted leading-relaxed mb-5">
                Every year, brilliant students at World Mission High School reach Level 5 in Software Development. However, many lack the physical tools—laptops, networking kits, and testing devices—to turn their knowledge into a career. Without these kits, they cannot complete the practical certification required by the Rwandan government.
            </p>

            <h3 class="fw-black text-purple mb-4">How your donation helps</h3>
            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-soft-primary border-0 h-100">
                        <div class="fs-2 mb-2">🔌</div>
                        <h6 class="fw-bold">$15</h6>
                        <p class="x-small text-muted mb-0">Covers one student's networking cable and testing kit.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-soft-success border-0 h-100">
                        <div class="fs-2 mb-2">💻</div>
                        <h6 class="fw-bold">$150</h6>
                        <p class="x-small text-muted mb-0">Contributes to a refurbished laptop for a top-performing trainee.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-soft-warning border-0 h-100">
                        <div class="fs-2 mb-2">🎓</div>
                        <h6 class="fw-bold">$500</h6>
                        <p class="x-small text-muted mb-0">Full sponsorship for one student's final year tools and exam fees.</p>
                    </div>
                </div>
            </div>

            <img src="{{ asset('storage/projects/students-working.jpg') }}" class="w-100 rounded-bento shadow mb-5" style="max-height: 400px; object-fit: cover;">

            <h3 class="fw-black text-purple mb-4">The Long-Term Impact</h3>
            <p class="text-muted leading-relaxed">
                By providing these tools, we aren't just giving a gift—we are launching careers. Graduates from this program go on to support their families, pay for their siblings' education, and contribute to Rwanda's growing tech ecosystem.
            </p>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 100px;">
                <div class="card border-0 shadow-premium rounded-bento p-4 mb-4">
                    <h5 class="fw-black text-purple mb-3">Project Timeline</h5>
                    <div class="timeline-small">
                        <div class="t-item active">
                            <span class="t-dot"></span>
                            <p class="small mb-0 fw-bold">Fundraising Phase</p>
                            <p class="x-small text-muted">Ending June 2026</p>
                        </div>
                        <div class="t-item">
                            <span class="t-dot"></span>
                            <p class="small mb-0">Procurement of Kits</p>
                            <p class="x-small text-muted">July 2026</p>
                        </div>
                        <div class="t-item">
                            <span class="t-dot"></span>
                            <p class="small mb-0">Distribution to Students</p>
                            <p class="x-small text-muted">August 2026</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 bg-purple text-white rounded-bento p-4">
                    <h5 class="fw-bold mb-3">Verified Project</h5>
                    <p class="x-small mb-0 opacity-75">
                        This project has been personally vetted by the HFRO Board of Directors. 100% of funds are ring-fenced specifically for vocational equipment.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-soft-purple { background: rgba(111, 66, 193, 0.1); }
    .bg-soft-primary { background: #eef2ff; }
    .bg-soft-success { background: #ecfdf5; }
    .bg-soft-warning { background: #fffbeb; }
    .py-100 { padding: 100px 0; }
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .x-small { font-size: 0.8rem; }
    .active-price { border-color: var(--primary-color) !important; color: var(--primary-color) !important; background: var(--bg-soft-purple); }

    /* Timeline */
    .timeline-small { border-left: 2px solid #eee; margin-left: 10px; padding-left: 20px; }
    .t-item { position: relative; padding-bottom: 25px; }
    .t-dot { position: absolute; left: -27px; top: 5px; width: 12px; height: 12px; border-radius: 50%; background: #ddd; border: 2px solid #fff; }
    .t-item.active .t-dot { background: var(--accent-pink); box-shadow: 0 0 0 4px rgba(214, 51, 132, 0.2); }
</style>
@endpush
@endsection