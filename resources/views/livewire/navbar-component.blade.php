<div 
    x-data="{ mobileMenuOpen: false, scrolled: false }" 
    @scroll.window="scrolled = (window.pageYOffset > 50)"
    :class="scrolled ? 'shadow-sm py-0' : 'py-2'"
    class="container-fluid fixed-top px-0 transition-all duration-300 bg-white"
>
    <div x-show="!scrolled" x-collapse.duration.500ms class="bg-dark py-2 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex small text-white-50">
                        <a href="mailto:{{ $organization->email }}" class="text-white-50 mr-4 text-decoration-none">
                            <i class="fas fa-envelope text-primary mr-2"></i>{{ $organization->email }}
                        </a>
                        <a href="tel:{{ $organization->phone }}" class="text-white-50 text-decoration-none">
                            <i class="fas fa-phone-alt text-primary mr-2"></i>{{ $organization->phone }}
                        </a>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <div class="social-links">
                        <a href="https://twitter.com/HFRwOrg" class="text-white-50 ml-3 small"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/hf.r.o" class="text-white-50 ml-3 small"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/channel/..." class="text-white-50 ml-3 small"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.linkedin.com/company/happy-family-rwanda" class="text-white-50 ml-3 small"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-0">
        <nav class="navbar navbar-expand-xl navbar-light bg-transparent px-lg-0">
            <a href="/" class="navbar-brand">
                <img src="{{ asset('storage/' . $organization->logo) }}" 
                     alt="logo" 
                     class="transition-all"
                     :style="scrolled ? 'height: 50px;' : 'height: 70px;'" />
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" @click="mobileMenuOpen = !mobileMenuOpen">
                <span :class="mobileMenuOpen ? 'fa fa-times' : 'fa fa-bars'" class="text-primary h4 mb-0"></span>
            </button>

            <div class="collapse navbar-collapse" :class="{ 'show': mobileMenuOpen }" id="navbarCollapse">
                <div class="navbar-nav ml-auto align-items-center">
                    <a href="/" class="nav-item nav-link mx-2 {{ Request::is('/') ? 'active text-primary' : '' }}">Home</a>
                    <a href="/about" class="nav-item nav-link mx-2">About</a>
                    <a href="/causes" class="nav-item nav-link mx-2">Causes</a>
                    <a href="/projects" class="nav-item nav-link mx-2">Projects</a>
                    
                    <div class="nav-item dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <a href="#" class="nav-link dropdown-toggle mx-2" :class="{ 'text-primary': open }">Resources</a>
                        <div class="dropdown-menu border-0 shadow-sm m-0" :class="{ 'show': open }">
                            <a href="#" class="dropdown-item py-2 px-4">Volunteers</a>
                            <a href="#" class="dropdown-item py-2 px-4">Career</a>
                            <a href="#" class="dropdown-item py-2 px-4">Gallery</a>
                        </div>
                    </div>

                    <a href="/contact" class="nav-item nav-link mx-2">Contact</a>

                    <div class="ml-xl-4 mt-3 mt-xl-0">
                        <a href="#" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm font-weight-bold">
                            Donate <i class="fas fa-heart ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>

