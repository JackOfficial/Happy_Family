<div 
    x-data="{ mobileMenuOpen: false, scrolled: false }" 
    @scroll.window="scrolled = (window.pageYOffset > 50)"
    :class="scrolled ? 'scrolled-nav py-2' : 'py-3'"
    class="container-fluid fixed-top px-0 transition-all duration-500 glass-nav"
>
    <div x-show="!scrolled" 
         x-collapse.duration.500ms 
         class="topbar py-2 d-none d-lg-block border-bottom border-white border-opacity-10">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <livewire:organization.contact-address/>
                </div>
                <div class="col-md-4 text-end">
                    <div class="social-links-header">
                        <a href="https://twitter.com/HFRwOrg" class="social-icon-sm ms-3"><i class="fab fa-x-twitter"></i></a>
                        <a href="https://www.instagram.com/hf.r.o" class="social-icon-sm ms-3"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/channel/..." class="social-icon-sm ms-3"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.linkedin.com/company/happy-family-rwanda" class="social-icon-sm ms-3"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-3 px-lg-0">
      <nav class="navbar navbar-expand-xl navbar-dark bg-transparent px-0 w-100">
    <div class="navbar-brand">
        <livewire:organization.logo/>
    </div>

    {{-- Use layout's mobileMenuOpen logic if needed, or stick to data-bs-target for simplicity --}}
    <button class="navbar-toggler border-0 shadow-none" type="button" 
            data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <div class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto align-items-center">
            <a href="/" class="nav-link mx-2 {{ Request::is('/') ? 'active' : '' }}">Home</a>
            <a href="/about" class="nav-link mx-2 {{ Request::is('about*') ? 'active' : '' }}">About</a>
            <a href="/causes" class="nav-link mx-2 {{ Request::is('causes*') ? 'active' : '' }}">Causes</a>
            <a href="{{ route('projects.index') }}" class="nav-link mx-2 {{ Request::is('projects*') ? 'active' : '' }}">Projects</a>
            
            <div class="nav-item dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                <a href="#" class="nav-link dropdown-toggle mx-2" :class="{ 'active': open }">Resources</a>
                <div class="dropdown-menu border-0 shadow-premium m-0 animated-dropdown" :class="{ 'show': open }">
                    <a href="/volunteers" class="dropdown-item py-2 px-4">Volunteers</a>
                    <a href="/careers" class="dropdown-item py-2 px-4">Careers</a>
                    <a href="/gallery" class="dropdown-item py-2 px-4">Gallery</a>
                </div>
            </div>

            <a href="/contact" class="nav-link mx-2 {{ Request::is('contact*') ? 'active' : '' }}">Contact</a>

            <div class="ms-xl-4 mt-4 mt-xl-0">
                <a href="{{ route('donations.index') }}" class="nav-donate-btn shadow-sm d-flex align-items-center">
                    <span>Donate Now</span>
                    <i class="fas fa-heart ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</nav>
    </div>
</div>

