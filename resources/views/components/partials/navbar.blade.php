<div 
    x-data="{ mobileMenuOpen: false, scrolled: false }" 
    @scroll.window="scrolled = (window.pageYOffset > 50)"
    :class="scrolled ? 'shadow-lg py-1 scrolled-nav' : 'py-3'"
    class="container-fluid fixed-top px-0 transition-all duration-500 glass-nav"
>
    <div x-show="!scrolled" x-collapse.duration.500ms class="top-info-bar py-2 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <livewire:organization.contact-address/>
                </div>
                <div class="col-md-4 text-end">
                    <div class="social-links-header">
                        <a href="https://twitter.com/HFRwOrg" class="ms-3"><i class="fab fa-x-twitter"></i></a>
                        <a href="https://www.instagram.com/hf.r.o" class="ms-3"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/channel/..." class="ms-3"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.linkedin.com/company/happy-family-rwanda" class="ms-3"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-3 px-lg-0">
        <nav class="navbar navbar-expand-xl navbar-light bg-transparent px-0">
            <livewire:organization.logo/>

            <button class="navbar-toggler border-0 shadow-none" type="button" @click="mobileMenuOpen = !mobileMenuOpen">
                <div class="hamburger-icon" :class="mobileMenuOpen ? 'open' : ''">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <div class="collapse navbar-collapse" :class="{ 'show': mobileMenuOpen }" id="navbarCollapse">
                <div class="navbar-nav ms-auto align-items-center">
                    <a href="/" class="nav-item nav-link mx-2 {{ Request::is('/') ? 'active' : '' }}">Home</a>
                    <a href="/about" class="nav-item nav-link mx-2 {{ Request::is('about*') ? 'active' : '' }}">About</a>
                    <a href="/causes" class="nav-item nav-link mx-2 {{ Request::is('causes*') ? 'active' : '' }}">Causes</a>
                    <a href="{{ route('projects.index') }}" class="nav-item nav-link mx-2 {{ Request::is('projects*') ? 'active' : '' }}">Projects</a>
                    
                    <div class="nav-item dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <a href="#" class="nav-link dropdown-toggle mx-2" :class="{ 'active': open }">Resources</a>
                        <div class="dropdown-menu border-0 shadow-lg m-0 animated-dropdown" :class="{ 'show': open }">
                            <a href="/volunteers" class="dropdown-item py-2 px-4">Volunteers</a>
                            <a href="/careers" class="dropdown-item py-2 px-4">Careers</a>
                            <a href="/gallery" class="dropdown-item py-2 px-4">Gallery</a>
                        </div>
                    </div>

                    <a href="/contact" class="nav-item nav-link mx-2 {{ Request::is('contact*') ? 'active' : '' }}">Contact</a>

                    <div class="ms-xl-4 mt-4 mt-xl-0">
                        <a href="/donate" class="btn-donate-nav shadow-sm">
                            <span>Donate Now</span>
                            <i class="fas fa-heart ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>