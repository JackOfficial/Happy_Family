<footer class="bg-dark text-light pt-5 pb-4">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-5">
                <div class="footer-item">
                    <h4 class="text-white mb-4 position-relative pb-2 footer-title">Stay Connected</h4>
                    <p class="text-white-50 mb-4 lh-lg">
                        Join the Happy Family community to receive the latest updates and inspiring stories. 
                        Be the first to know about upcoming events and various opportunities in Rwanda.
                    </p>
                    
                    <div x-data="{ showMsg: true }" class="newsletter-form position-relative">
                        <div class="input-group mb-2">
                            <input type="email" 
                                   wire:model="email" 
                                   class="form-control border-0 bg-secondary-dark text-white py-3 px-4" 
                                   placeholder="Your email address" 
                                   style="border-radius: 50px 0 0 50px;">
                            <div class="input-group-append">
                                <button wire:click.prevent="subscribe" 
                                        class="btn btn-primary px-4 shadow-none" 
                                        type="button" 
                                        style="border-radius: 0 50px 50px 0;">
                                    <span wire:loading.remove wire:target="subscribe">Sign Up</span>
                                    <span wire:loading wire:target="subscribe" class="spinner-border spinner-border-sm"></span>
                                </button>
                            </div>
                        </div>

                        <div x-show="showMsg" x-init="setTimeout(() => showMsg = false, 5000)">
                            @error('email') <small class="text-danger ml-3">{{ $message }}</small> @enderror
                            @if(session('subscribeSuccess'))
                                <div class="alert alert-success py-2 mt-2 small border-0 shadow-sm">{{ session('subscribeSuccess') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <div class="footer-item">
                    <h4 class="text-white mb-4 footer-title pb-2">Explore</h4>
                    <ul class="list-unstyled footer-links">
                        <li><a href="/about" class="text-white-50 text-decoration-none d-block mb-2">About Us</a></li>
                        <li><a href="/causes" class="text-white-50 text-decoration-none d-block mb-2">Our Causes</a></li>
                        <li><a href="/blogs" class="text-white-50 text-decoration-none d-block mb-2">Latest News</a></li>
                        <li><a href="/contact" class="text-white-50 text-decoration-none d-block mb-2">Contact</a></li>
                        <li><a href="/volunteer" class="text-white-50 text-decoration-none d-block">Join Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 col-xl-4 ml-auto">
                <div class="footer-item">
                    <h4 class="text-white mb-4 footer-title pb-2">Impact Gallery</h4>
                    <div class="row no-gutters">
                        @foreach(range(1, 6) as $i)
                        <div class="col-4 p-1">
                            <div class="gallery-thumb overflow-hidden rounded">
                                <a href="{{ asset('frontend/img/gallery-footer-'.$i.'.jpg') }}" data-lightbox="footer-gallery">
                                    <img src="{{ asset('frontend/img/gallery-footer-'.$i.'.jpg') }}" 
                                         class="img-fluid transition-all" 
                                         alt="Gallery Image {{ $i }}"
                                         style="aspect-ratio: 1/1; object-fit: cover;">
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container border-top border-secondary pt-4 mt-2">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">
                <p class="mb-0 text-white-50 small">
                    &copy; {{ date('Y') }} <span class="text-white font-weight-bold">{{ $organization->name }}</span>. All rights reserved.
                </p>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-center justify-content-md-end">
                    <a href="#" class="social-circle mx-1"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-circle mx-1"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-circle mx-1"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-circle mx-1"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>