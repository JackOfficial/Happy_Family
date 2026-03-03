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
                        <form wire:submit.prevent="subscribe" class="input-group">
                            <input type="email" 
                                   wire:model="email" 
                                   class="form-control footer-input" 
                                   placeholder="Your email address">
                            <div class="input-group-append">
                                <button class="btn btn-subscribe" type="submit">
                                    <span wire:loading.remove wire:target="subscribe">Join Us</span>
                                    <span wire:loading wire:target="subscribe" class="spinner-border spinner-border-sm"></span>
                                </button>
                            </div>
                        </form>

                        @error('email') <small class="text-accent mt-2 d-block">{{ $message }}</small> @enderror
                        @if(session('subscribeSuccess'))
                            <div class="alert-success-footer mt-3">{{ session('subscribeSuccess') }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <div class="footer-item">
                    <h4 class="footer-title mb-4">Explore</h4>
                    <ul class="list-unstyled footer-links">
                        <li><a href="/about"><i class="fas fa-chevron-right mr-2 small"></i>About Us</a></li>
                        <li><a href="/causes"><i class="fas fa-chevron-right mr-2 small"></i>Our Causes</a></li>
                        <li><a href="/blogs"><i class="fas fa-chevron-right mr-2 small"></i>Latest News</a></li>
                        <li><a href="/contact"><i class="fas fa-chevron-right mr-2 small"></i>Contact</a></li>
                        <li><a href="/volunteer"><i class="fas fa-chevron-right mr-2 small"></i>Join Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 col-xl-4 ml-auto">
                <div class="footer-item">
                    <h4 class="footer-title mb-4">Impact Gallery</h4>
                    <div class="row no-gutters gallery-grid">
                        @foreach(range(1, 6) as $i)
                        <div class="col-4 p-1">
                            <div class="footer-gallery-thumb">
                                <a href="{{ asset('frontend/img/gallery-footer-'.$i.'.jpg') }}" data-lightbox="footer-gallery">
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
            <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">
                <p class="mb-0 copyright-text">
                    &copy; {{ date('Y') }} <span class="brand-text">{{ $organization->name }}</span>. Empowering Families.
                </p>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-center justify-content-md-end social-links-footer">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .main-footer {
            background-color: #1a0422; /* Very dark shade of your purple */
            color: #fff;
            position: relative;
        }

        .footer-title {
            color: #fff;
            font-family: 'Jost', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            position: relative;
            padding-bottom: 12px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: var(--accent-pink); /* Your brand pink */
            border-radius: 2px;
        }

        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.8;
        }

        /* Newsletter Professional Look */
        .footer-input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-radius: 8px 0 0 8px !important;
            padding: 12px 20px !important;
        }

        .btn-subscribe {
            background: var(--primary-purple); /* Brand Purple */
            color: white;
            border: none;
            padding: 0 25px;
            font-weight: 600;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease;
        }

        .btn-subscribe:hover {
            background: var(--accent-pink); /* Hover turns Pink */
            color: white;
        }

        /* Link Interactions */
        .footer-links li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
            margin-bottom: 10px;
        }

        .footer-links li a:hover {
            color: var(--accent-pink);
            padding-left: 8px;
        }

        /* Gallery Effects */
        .footer-gallery-thumb {
            overflow: hidden;
            border-radius: 6px;
            aspect-ratio: 1/1;
        }

        .footer-gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            filter: grayscale(30%);
        }

        .footer-gallery-thumb:hover img {
            transform: scale(1.1);
            filter: grayscale(0%);
        }

        /* Social Icons */
        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
            margin-left: 10px;
            transition: all 0.3s ease;
            text-decoration: none !important;
        }

        .social-icon:hover {
            background: var(--accent-pink);
            color: white;
            transform: translateY(-3px);
        }

        .footer-bottom-border {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .copyright-text {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }

        .brand-text {
            color: var(--accent-pink);
        }

        .alert-success-footer {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.85rem;
            border: 1px solid rgba(40, 167, 69, 0.2);
        }
    </style>
</footer>