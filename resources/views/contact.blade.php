@extends('layouts.app')

@section('title', 'Contact Us | Happy Family Rwanda Organization')

@section('content')
<div class="container-fluid position-relative overflow-hidden vh-60 d-flex align-items-center" style="background: var(--dark-void);">
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(135deg, rgba(45, 13, 82, 0.85) 0%, rgba(214, 51, 132, 0.5) 100%); z-index: 2;"></div>
        <img src="{{ asset('storage/headers/team.jpg') }}" 
             class="w-100 h-100 animate-slow-zoom" 
             style="object-fit: cover; opacity: 0.6;" 
             alt="HFRO Team">
    </div>
    
    <div class="container position-relative text-center py-5" style="z-index: 10;">
        <div class="d-inline-flex align-items-center mb-4 px-3 py-1 rounded-pill animate__animated animate__fadeInDown" 
             style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
            <small class="text-white fw-bold text-uppercase tracking-wider" style="font-size: 0.7rem; letter-spacing: 2px;">Reach Out</small>
        </div>

        <h1 class="text-white display-2 fw-black mb-4 animate__animated animate__fadeInUp">
            Get In <span class="brand-text">Touch</span>
        </h1>
        
        <p class="lead text-white opacity-75 mx-auto mb-5 fs-4" style="max-width: 700px;">
            We are here to listen, collaborate, and grow. Every message brings us closer to a stronger community.
        </p>
        
        <nav aria-label="breadcrumb" class="d-inline-block p-2 px-4 rounded-pill shadow-lg animate__animated animate__fadeInUp" 
             style="background: rgba(0, 0, 0, 0.3); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1);">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                     <span class="text-accent-pink">●</span> Contact
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid bg-light py-100">
    <div class="container">
        <div class="row g-5">
            {{-- --- LEFT COLUMN: CONTACT FORM --- --}}
            <div class="col-xl-5">
                <div class="bg-white p-4 p-md-5 rounded-bento shadow-premium h-100 border-0 animate__animated animate__fadeInLeft">
                    <div class="mb-5">
                        <h5 class="text-accent-pink fw-bold text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">Message Us</h5>
                        <h2 class="fw-black text-purple">Send an Inquiry</h2>
                        <div class="mt-3" style="width: 40px; height: 4px; background: var(--grad-premium); border-radius: 10px;"></div>
                    </div>
                    
                    <p class="text-muted mb-5 leading-relaxed">
                        Whether you want to volunteer, partner with us, or simply learn more about our impact, our team will get back to you within 24 hours.
                    </p>
                    
                    {{-- Livewire component --}}
                    <div class="contact-form-wrapper">
                        <livewire:contact-component />
                    </div>
                </div>
            </div>

            {{-- --- RIGHT COLUMN: INFO & MAP --- --}}
            <div class="col-xl-7">
                <div class="row g-4 mb-4 animate__animated animate__fadeInRight">
                    <div class="col-md-4">
                        <div class="contact-card-premium text-center p-4 bg-white rounded-bento shadow-sm h-100 border-0">
                            <div class="icon-box-premium bg-light text-accent-pink mx-auto mb-3">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <h6 class="fw-black text-purple mb-2">Location</h6>
                            <p class="small text-muted mb-0">Kicukiro,<br>Kigali, Rwanda</p>

                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="contact-card-premium text-center p-4 bg-white rounded-bento shadow-sm h-100 border-0">
                            <div class="icon-box-premium bg-light text-accent-pink mx-auto mb-3">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <h6 class="fw-black text-purple mb-2">Email</h6>
                            <p class="small text-muted mb-0">info@happyfamilyrwanda.org</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-card-premium text-center p-4 bg-white rounded-bento shadow-sm h-100 border-0">
                            <div class="icon-box-premium bg-light text-accent-pink mx-auto mb-3">
                                <i class="fas fa-phone-volume"></i>
                            </div>
                            <h6 class="fw-black text-purple mb-2">Call Us</h6>
                            <p class="small text-muted mb-0">+250 788 708 314<br>Mon-Fri, 8am-5pm</p>
                        </div>
                    </div>
                </div>

                {{-- --- MAP SECTION --- --}}
                <div class="map-wrapper rounded-bento shadow-premium overflow-hidden border-0 position-relative animate__animated animate__fadeInUp">
                    <div class="map-overlay-label">
                        <i class="fas fa-location-arrow me-2 text-accent-pink"></i> Find us in Kigali
                    </div>

                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.4308441253006!2d30.106314674487564!3d-1.9822218367817352!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca7f61695a5ad%3A0x8991a02cf324e51a!2sHappy%20Family%20Rwanda%20Organization!5e0!3m2!1sen!2srw!4v1778814254528!5m2!1sen!2srw" 
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        font-size: 1.4rem;
        transition: 0.3s;
    }

    .contact-card-premium {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .contact-card-premium:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(45, 13, 82, 0.1) !important;
    }

    .contact-card-premium:hover .icon-box-premium {
        background: var(--grad-premium) !important;
        color: white !important;
    }

    .map-overlay-label {
        position: absolute;
        top: 20px;
        left: 20px;
        background: white;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        z-index: 5;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        color: var(--primary-color);
    }

    /* Target Livewire Input Styling */
    .contact-form-wrapper input, 
    .contact-form-wrapper textarea {
        border-radius: 12px !important;
        border: 1px solid #eee !important;
        padding: 12px 20px !important;
        background: #fcfcfc !important;
        transition: 0.3s !important;
    }

    .contact-form-wrapper input:focus, 
    .contact-form-wrapper textarea:focus {
        border-color: var(--primary-color) !important;
        background: white !important;
        box-shadow: 0 0 0 4px rgba(45, 13, 82, 0.05) !important;
    }
       /* --- Premium Form Styling --- */
    .form-group-premium { position: relative; margin-bottom: 5px; }
    
    .form-label-small {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--primary-color);
        letter-spacing: 1px;
        margin-left: 5px;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-premium {
        background: #f8f9fa;
        border: 2px solid transparent;
        border-radius: 15px;
        padding: 14px 20px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control-premium:focus {
        background: #fff;
        border-color: var(--primary-color);
        box-shadow: 0 10px 20px rgba(45, 13, 82, 0.05);
        outline: none;
    }

    .form-control-premium.is-invalid {
        border-color: #dc3545;
        background-color: rgba(220, 53, 69, 0.02);
    }

    .error-msg {
        color: #dc3545;
        font-size: 11px;
        font-weight: 700;
        margin-top: 5px;
        margin-left: 5px;
        display: block;
    }

    /* --- Premium Alerts --- */
    .alert-premium-success {
        background: #e7f6f2;
        border: none;
        border-left: 5px solid #28a745;
        border-radius: 15px;
        color: #1b5e20;
    }

    .alert-premium-danger {
        background: #fdf2f2;
        border: none;
        border-left: 5px solid #dc3545;
        border-radius: 15px;
        color: #721c24;
    }

    .alert-icon-wrap { font-size: 1.5rem; }

    /* --- Loading Overlay --- */
    .form-loading-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(2px);
        z-index: 10;
        border-radius: 24px;
        justify-content: center;
        align-items: center;
        display: none;
    }

    .spinner-premium {
        width: 40px;
        height: 40px;
        border: 4px solid rgba(45, 13, 82, 0.1);
        border-left-color: var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush
@endsection