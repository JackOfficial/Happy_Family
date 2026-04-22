<footer class="main-footer">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-5">
                <div class="footer-item footer-newsletter">
                    <h4 class="footer-title mb-4">Stay Connected</h4>
                    <p class="mb-4 opacity-75">
                        Join the Happy Family community to receive the latest updates and inspiring stories from our work in Rwanda.
                    </p>
                    <livewire:subscribe-component/>
                </div>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <div class="footer-item">
                    <h4 class="footer-title mb-4">Explore</h4>
                    <ul class="list-unstyled">
                        <li><a href="/about" class="footer-link"><i class="fas fa-chevron-right me-2 small opacity-50"></i>About Us</a></li>
                        <li><a href="/causes" class="footer-link"><i class="fas fa-chevron-right me-2 small opacity-50"></i>Our Causes</a></li>
                        <li><a href="/blogs" class="footer-link"><i class="fas fa-chevron-right me-2 small opacity-50"></i>Latest News</a></li>
                        <li><a href="/contact" class="footer-link"><i class="fas fa-chevron-right me-2 small opacity-50"></i>Contact</a></li>
                        <li><a href="/volunteer" class="footer-link"><i class="fas fa-chevron-right me-2 small opacity-50"></i>Join Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 col-xl-4 ms-auto">
                <livewire:snapshot/>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="footer-bottom-border pt-4 mt-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <div class="opacity-75">
                        <livewire:organization.copyright/>
                    </div>
                </div>
                <div class="col-md-6">
    <div class="d-flex justify-content-center justify-content-md-end social-links-footer mt-3 mt-md-0">
        <a href="https://twitter.com/HFRwOrg" class="social-icon" title="Twitter"><i class="fab fa-x-twitter"></i></a>
        <a href="https://www.instagram.com/hf.r.o" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://www.linkedin.com/company/happy-family-rwanda" class="social-icon" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        <a href="" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-icon" title="YouTube"><i class="fab fa-youtube"></i></a>
    </div>
</div>
            </div>
        </div>
    </div>
</footer>