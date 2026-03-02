<div>
    <!-- Footer Start -->
        <div class="container-fluid footer bg-dark text-body py-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-5">
                        <div class="footer-item">
                            <h4 class="mb-4 text-white">Stay Connected</h4>
                            <p class="mb-4">
                                Join the Happy Family community to receive the latest updates, and inspiring stories straight to your inbox. Be the first to know about upcoming events and various opportunities. 
                            </p>
                            <div class="position-relative mx-auto">
    <input class="form-control border-0 bg-secondary w-100 py-3 ps-4 pe-5" type="email" wire:model="email" placeholder="Enter your email" required />
    <button type="button" wire:click.prevent="subscribe" class="btn-hover-bg btn btn-primary position-absolute top-0 end-0 py-2 mt-2 me-2">SignUp 
        <div wire:loading wire:target="subscribe" class="spinner-border spinner-border-sm" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
    </button>
    <div class="text-danger">@error('email') {{ $message }} @enderror</div>
    @if(session('subscribeSuccess'))
    <div class="alert alert-sm alert-success mt-1">{{ session('subscribeSuccess') }}</div>
    @elseif(session('subscribeFail'))
    <div class="alert alert-sm alert-danger mt-1">{{ session('subscribeFail') }}</div>
    @endif
</div>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-2">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="mb-4 text-white">Quick Links</h4>
                            <a href="/about"><i class="fas fa-angle-right me-2"></i> About</a>
                            <a href="/causes"><i class="fas fa-angle-right me-2"></i> Causes</a>
                            <a href="/blogs"><i class="fas fa-angle-right me-2"></i> News</a>
                            <a href="/stories"><i class="fas fa-angle-right me-2"></i> Stories</a>
                            <a href="/contact"><i class="fas fa-angle-right me-2"></i> Contact</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-2">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="mb-4 text-white">Other Links</h4>
                            <a href="/gallery"><i class="fas fa-angle-right me-2"></i> Gallery</a>
                            <a href="/events"><i class="fas fa-angle-right me-2"></i> Events</a>
                            <a href="/projects"><i class="fas fa-angle-right me-2"></i> Projects</a>
                            <a href="/volunteer"><i class="fas fa-angle-right me-2"></i> Volunteers</a>
                            <a href="/donate"><i class="fas fa-angle-right me-2"></i> Donate</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item">
                            <h4 class="mb-4 text-white">Our Gallery</h4>
                            <div class="row g-2">
                                <div class="col-4">
                                    <div class="footer-gallery">
                                        <img src="{{ asset('frontend/img/gallery-footer-1.jpg') }}" class="img-fluid w-100" alt="">
                                        <div class="footer-search-icon">
                                            <a href="{{ asset('frontend/img/gallery-footer-1.jpg') }}" data-lightbox="footerGallery-1" class="my-auto"><i class="fas fa-search-plus text-white"></i></a>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-4">
                                    <div class="footer-gallery">
                                        <img src="{{ asset('frontend/img/gallery-footer-2.jpg') }}" class="img-fluid w-100" alt="">
                                        <div class="footer-search-icon">
                                            <a href="{{ asset('frontend/img/gallery-footer-2.jpg') }}" data-lightbox="footerGallery-2" class="my-auto"><i class="fas fa-search-plus text-white"></i></a>
                                        </div>
                                    </div>
                               </div>
                                <div class="col-4">
                                    <div class="footer-gallery">
                                        <img src="{{ asset('frontend/img/gallery-footer-3.jpg') }}" class="img-fluid w-100" alt="">
                                        <div class="footer-search-icon">
                                            <a href="{{ asset('frontend/img/gallery-footer-3.jpg') }}" data-lightbox="footerGallery-3" class="my-auto"><i class="fas fa-search-plus text-white"></i></a>
                                        </div>
                                    </div>
                               </div>
                                <div class="col-4">
                                    <div class="footer-gallery">
                                        <img src="{{ asset('frontend/img/gallery-footer-4.jpg') }}" class="img-fluid w-100" alt="">
                                        <div class="footer-search-icon">
                                            <a href="{{ asset('frontend/img/gallery-footer-4.jpg') }}" data-lightbox="footerGallery-4" class="my-auto"><i class="fas fa-search-plus text-white"></i></a>
                                        </div>
                                    </div>
                               </div>
                                <div class="col-4">
                                    <div class="footer-gallery">
                                        <img src="{{ asset('frontend/img/gallery-footer-5.jpg') }}" class="img-fluid w-100" alt="">
                                        <div class="footer-search-icon">
                                            <a href="{{ asset('frontend/img/gallery-footer-5.jpg') }}" data-lightbox="footerGallery-5" class="my-auto"><i class="fas fa-search-plus text-white"></i></a>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-4">
									<div class="footer-gallery">
										<img src="{{ asset('frontend/img/gallery-footer-6.jpg') }}" class="img-fluid w-100" alt="">
                                        <div class="footer-search-icon">
                                            <a href="{{ asset('frontend/img/gallery-footer-6.jpg') }}" data-lightbox="footerGallery-6" class="my-auto"><i class="fas fa-search-plus text-white"></i></a>
                                        </div>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Copyright Start -->
        <div class="container-fluid copyright py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-4 text-center text-md-start mb-md-0">
                        <span class="text-body"><a href="#"><i class="fas fa-copyright text-light me-2"></i>{{ $organization->name }}</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="#" target="__blank" class="btn-hover-color btn-square text-white me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/HFRwOrg" target="__blank" class="btn-hover-color btn-square text-white me-2"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.instagram.com/hf.r.o?igsh=OXVjbnlmOXVzNjQy" target="__blank" class="btn-hover-color btn-square text-white me-2"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.youtube.com/channel/UCbWRXU7KOSRxNodro3H8mug" target="__blank" class="btn-hover-color btn-square text-white me-2"><i class="fab fa-youtube"></i></a>
                            <a href="https://www.linkedin.com/company/happy-family-rwanda" target="__blank" class="btn-hover-color btn-square text-white me-0"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 text-center text-md-end text-body">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">Tonny Jack</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->
</div>
