<footer class="main-footer pt-5 pb-4">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-5">
                <div class="footer-item">
                    <h4 class="footer-title mb-4">Stay Connected</h4>
                    <p class="footer-text mb-4">
                        Join the Happy Family community to receive the latest updates and inspiring stories from our work in Rwanda.
                    </p>
                    
                    <livewire:subscribe-component/>
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
                <livewire:organization.copyright/>
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

    </style>
</footer>