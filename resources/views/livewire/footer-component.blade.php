<footer class="main-footer pt-5 pb-4">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-5">
                <div class="footer-item">
                    <h4 class="footer-title mb-4">Stay Connected</h4>
                    <p class="footer-text mb-4">
                        Join the Happy Family community to receive the latest updates and inspiring stories from our work in Rwanda.
                    </p>
                    
                    <div class="newsletter-wrapper">
                        <form wire:submit.prevent="subscribe" class="input-group newsletter-form">
                            <input type="email" 
                                   wire:model="email" 
                                   class="form-control footer-input shadow-none" 
                                   placeholder="Your email address">
                            <button class="btn btn-subscribe" type="submit">
                                <span wire:loading.remove wire:target="subscribe">
                                    Join Us <i class="fas fa-paper-plane ms-2 small"></i>
                                </span>
                                <span wire:loading wire:target="subscribe" class="spinner-border spinner-border-sm"></span>
                            </button>
                        </form>

                        @error('email') <small class="text-accent-pink mt-2 d-block">{{ $message }}</small> @enderror
                        @if(session('subscribeSuccess'))
                            <div class="alert-success-footer mt-3">
                                <i class="fas fa-check-circle me-2"></i> {{ session('subscribeSuccess') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <div class="footer-item">
                    <h4 class="footer-title mb-4">Explore</h4>
                    <ul class="list-unstyled footer-links">
                        <li><a href="/about"><i class="fas fa-chevron-right me-2 small"></i>About Us</a></li>
                        <li><a href="/causes"><i class="fas fa-chevron-right me-2 small"></i>Our Causes</a></li>
                        <li><a href="/blogs"><i class="fas fa-chevron-right me-2 small"></i>Latest News</a></li>
                        <li><a href="/contact"><i class="fas fa-chevron-right me-2 small"></i>Contact</a></li>
                        <li><a href="/volunteer"><i class="fas fa-chevron-right me-2 small"></i>Join Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 col-xl-4 ms-auto">
                <div class="footer-item">
                    <h4 class="footer-title mb-4">Impact Gallery</h4>
                    <div class="row g-2 gallery-grid">
                        @foreach(range(1, 6) as $i)
                        <div class="col-4">
                            <div class="footer-gallery-thumb">
                                <a href="{{ asset('frontend/img/gallery-footer-'.$i.'.jpg') }}" data-lightbox="footer-gallery">
                                    <div class="gallery-overlay">
                                        <i class="fas fa-plus text-white"></i>
                                    </div>
                                    <img src="{{ asset('frontend/img/gallery-footer-'.$i.'.jpg') }}" 
                                         class="img-fluid" 
                                         alt="Impact {{ $i }}">
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container footer-bottom-border pt-4">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-0 copyright-text">
                    &copy; {{ date('Y') }} <span class="brand-text">{{ $organization->name }}</span>. 
                    <span class="d-none d-sm-inline">Empowering Families across Rwanda.</span>
                </p>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-center justify-content-md-end social-links-footer">
                    <a href="#" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-purple: #631084;
            --accent-pink: #ec409e;
            --footer-dark: #14031a;
        }

        .main-footer {
            background-color: var(--footer-dark);
            color: #ffffff;
            font-family: 'Inter', sans-serif;
        }

        .footer-title {
            font-family: 'Jost', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            padding-bottom: 12px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 35px;
            height: 3px;
            background: var(--accent-pink);
            border-radius: 2px;
        }

        /* Newsletter Interaction */
        .newsletter-form {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 5px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: border-color 0.3s ease;
        }

        .newsletter-form:focus-within {
            border-color: var(--accent-pink);
        }

        .footer-input {
            background: transparent !important;
            border: none !important;
            color: white !important;
            padding: 12px 15px !important;
        }

        .btn-subscribe {
            background: var(--primary-purple);
            color: white;
            border-radius: 8px !important;
            padding: 10px 20px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-subscribe:hover {
            background: var(--accent-pink);
            color: white;
            transform: scale(1.02);
        }

        /* Gallery Hover Effects */
        .footer-gallery-thumb {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            aspect-ratio: 1/1;
        }

        .gallery-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(99, 16, 132, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.3s;
            z-index: 2;
        }

        .footer-gallery-thumb:hover .gallery-overlay {
            opacity: 1;
        }

        .footer-gallery-thumb img {
            transition: 0.5s ease;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .footer-gallery-thumb:hover img {
            transform: scale(1.15);
        }

        /* Footer Links */
        .footer-links li a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
            margin-bottom: 12px;
        }

        .footer-links li a:hover {
            color: var(--accent-pink);
            transform: translateX(5px);
        }

        .social-icon {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-left: 12px;
            transition: 0.3s;
        }

        .social-icon:hover {
            background: var(--accent-pink);
            transform: translateY(-5px);
            color: white;
        }

        .footer-bottom-border {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .text-accent-pink { color: var(--accent-pink); }
    </style>
</footer>