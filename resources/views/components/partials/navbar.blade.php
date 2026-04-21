<div 
    x-data="{ mobileMenuOpen: false, scrolled: false }" 
    @scroll.window="scrolled = (window.pageYOffset > 50)"
    :class="scrolled ? 'navbar-scrolled py-1' : 'navbar-top py-3'"
    class="container-fluid fixed-top px-0 transition-all-500"
>
    {{-- Topbar - Hides on Scroll for a cleaner look --}}
    <div x-show="!scrolled" 
         x-collapse.duration.500ms 
         class="topbar-modern py-2 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <livewire:organization.contact-address/>
                </div>
                <div class="col-md-4 text-end">
                    <div class="header-social-group">
                        <a href="https://twitter.com/HFRwOrg" class="social-link-top"><i class="fab fa-x-twitter"></i></a>
                        <a href="https://www.instagram.com/hf.r.o" class="social-link-top"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/..." class="social-link-top"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.linkedin.com/..." class="social-link-top"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-lg-2">
        <nav class="navbar navbar-expand-xl px-0">
            <a class="navbar-brand" href="/">
                <livewire:organization.logo/>
            </a>

            <button class="navbar-toggler border-0" type="button" @click="mobileMenuOpen = !mobileMenuOpen">
                <div class="modern-hamburger" :class="mobileMenuOpen ? 'open' : ''">
                    <span></span><span></span><span></span>
                </div>
            </button>

            <div class="collapse navbar-collapse justify-content-end" :class="{ 'show': mobileMenuOpen }">
                <div class="navbar-nav align-items-center bg-mobile-menu">
                    <a href="/" class="nav-link-impact {{ Request::is('/') ? 'active' : '' }}">Home</a>
                    <a href="/about" class="nav-link-impact {{ Request::is('about*') ? 'active' : '' }}">About</a>
                    <a href="/causes" class="nav-link-impact {{ Request::is('causes*') ? 'active' : '' }}">Causes</a>
                    <a href="{{ route('projects.index') }}" class="nav-link-impact {{ Request::is('projects*') ? 'active' : '' }}">Projects</a>
                    
                    <div class="nav-item dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <a href="#" class="nav-link-impact dropdown-toggle" :class="{ 'active': open }">Resources</a>
                        <div class="dropdown-menu-impact border-0 shadow-premium" :class="{ 'show': open }">
                            <a href="/volunteers" class="dropdown-item">Volunteers</a>
                            <a href="/careers" class="dropdown-item">Careers</a>
                            <a href="/gallery" class="dropdown-item">Gallery</a>
                        </div>
                    </div>

                    <a href="/contact" class="nav-link-impact {{ Request::is('contact*') ? 'active' : '' }}">Contact</a>

                    <div class="ms-xl-4 mt-4 mt-xl-0">
                        <a href="/donate" class="btn-nav-donate">
                            <span>Donate Now</span>
                            <i class="fas fa-heart ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>