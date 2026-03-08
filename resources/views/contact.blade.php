@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative overflow-hidden" style="background: #000; padding: 120px 0 80px 0;">
    <img src="{{ asset('storage/headers/team.jpg') }}" class="banner-img position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; z-index: 1; opacity: 0.5;" alt="Contact Header">
    <div class="overlay" style="z-index: 2;"></div>
    
    <div class="container text-center position-relative" style="z-index: 3;">
        <h5 class="text-white tracking-widest text-uppercase mb-3 opacity-90">Get In Touch</h5>
        <h1 class="text-white display-3 mb-4 fw-bold">Contact Us</h1>
        <p class="lead text-white opacity-90 mx-auto mb-4" style="max-width: 700px;">
            Help today because tomorrow you may be the one who needs more helping! We are here to listen and collaborate.
        </p>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-white opacity-75 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-pink fw-bold" aria-current="page">Contact</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-fluid bg-light py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-xl-5">
                <div class="bg-white p-5 rounded-custom shadow-premium h-100">
                    <h5 class="brand-subtitle mb-2">Message Us</h5>
                    <h2 class="brand-title-dark mb-4">Send an Inquiry</h2>
                    <p class="text-muted mb-5">
                        Whether you want to volunteer, donate, or just say hello, our team will get back to you within 24 hours.
                    </p>
                    
                    <livewire:contact-component />
                </div>
            </div>

            <div class="col-xl-7">
                <div class="row g-4 mb-4">
                    <div class="col-lg-4">
                        <div class="contact-info-card text-center p-4 h-100">
                            <div class="contact-icon-wrapper mb-3 mx-auto">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Address</h5>
                            <p class="small text-muted mb-0">Norrsken House, Kigali</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-info-card text-center p-4 h-100">
                            <div class="contact-icon-wrapper mb-3 mx-auto">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Mail Us</h5>
                            <p class="small text-muted mb-0">info@hfro.org</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-info-card text-center p-4 h-100">
                            <div class="contact-icon-wrapper mb-3 mx-auto">
                                <i class="fa fa-phone-alt"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Call Us</h5>
                            <p class="small text-muted mb-0">+250 788 708 314</p>
                        </div>
                    </div>
                </div>

                <div class="map-wrapper rounded-custom shadow-premium overflow-hidden border-brand">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.502859187383!2d30.05739837589574!3d-1.9521360367123955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca425da6c761b%3A0xc3f8376f9d020a56!2sNorrsken%20House%20Kigali!5e0!3m2!1sen!2srw!4v1709900000000!5m2!1sen!2srw" 
                        class="w-100" style="height: 400px; border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection