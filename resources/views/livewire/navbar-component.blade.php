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
                    <div class="d-flex small">
                        <a href="mailto:{{ $organization->email }}" class="contact-link mr-4">
                            <i class="fas fa-envelope mr-2"></i>{{ $organization->email }}
                        </a>
                        <a href="tel:{{ $organization->phone }}" class="contact-link">
                            <i class="fas fa-phone-alt mr-2"></i>{{ $organization->phone }}
                        </a>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <div class="social-links-header">
                        <a href="https://twitter.com/HFRwOrg" class="ml-3"><i class="fab fa-x-twitter"></i></a>
                        <a href="https://www.instagram.com/hf.r.o" class="ml-3"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/channel/..." class="ml-3"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.linkedin.com/company/happy-family-rwanda" class="ml-3"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-3 px-lg-0">
        <nav class="navbar navbar-expand-xl navbar-light bg-transparent px-0">
            <a href="/" class="navbar-brand">
                <img src="{{ asset('storage/' . $organization->logo) }}" 
                     alt="logo" 
                     class="transition-all logo-img"
                     :style="scrolled ? 'height: 45px;' : 'height: 65px;'" />
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" @click="mobileMenuOpen = !mobileMenuOpen">
                <div class="hamburger-icon" :class="mobileMenuOpen ? 'open' : ''">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <div class="collapse navbar-collapse" :class="{ 'show': mobileMenuOpen }" id="navbarCollapse">
                <div class="navbar-nav ml-auto align-items-center">
                    <a href="/" class="nav-item nav-link mx-2 {{ Request::is('/') ? 'active' : '' }}">Home</a>
                    <a href="/about" class="nav-item nav-link mx-2 {{ Request::is('about*') ? 'active' : '' }}">About</a>
                    <a href="/causes" class="nav-item nav-link mx-2 {{ Request::is('causes*') ? 'active' : '' }}">Causes</a>
                    <a href="/projects" class="nav-item nav-link mx-2 {{ Request::is('projects*') ? 'active' : '' }}">Projects</a>
                    
                    <div class="nav-item dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <a href="#" class="nav-link dropdown-toggle mx-2" :class="{ 'active': open }">Resources</a>
                        <div class="dropdown-menu border-0 shadow-lg m-0 animated-dropdown" :class="{ 'show': open }">
                            <a href="/volunteers" class="dropdown-item py-2 px-4">Volunteers</a>
                            <a href="/careers" class="dropdown-item py-2 px-4">Careers</a>
                            <a href="/gallery" class="dropdown-item py-2 px-4">Gallery</a>
                        </div>
                    </div>

                    <a href="/contact" class="nav-item nav-link mx-2 {{ Request::is('contact*') ? 'active' : '' }}">Contact</a>

                    <div class="ml-xl-4 mt-4 mt-xl-0">
                        <a href="/donate" class="btn-donate-nav shadow-sm">
                            <span>Donate Now</span>
                            <i class="fas fa-heart ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <style>
        /* Top Bar Styling */
        .top-info-bar {
            background-color: var(--primary-color);
            color: rgba(255,255,255,0.8);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .contact-link {
            color: rgba(255,255,255,0.8) !important;
            transition: 0.3s;
            text-decoration: none !important;
        }
        .contact-link:hover { color: var(--accent-color) !important; }
        .social-links-header a { color: white; transition: 0.3s; }
        .social-links-header a:hover { color: var(--accent-color); }

        /* Navigation Links */
        .nav-link {
            color: var(--primary-color) !important;
            font-size: 15px;
            letter-spacing: 0.5px;
        }
        .nav-link.active {
            color: var(--accent-color) !important;
        }

        /* Animated Dropdown */
        .animated-dropdown {
            border-radius: 12px !important;
            transform: translateY(10px);
            transition: 0.3s;
            display: block;
            opacity: 0;
            visibility: hidden;
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(10px);
        }
        .animated-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .dropdown-item:hover {
            background-color: var(--light-bg);
            color: var(--accent-color);
        }

        /* Professional Donate Button */
        .btn-donate-nav {
            background: var(--accent-color);
            color: white !important;
            padding: 10px 25px;
            border-radius: 8px; /* Matching the 2026 Square-Round trend */
            text-decoration: none !important;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-donate-nav:hover {
            background: var(--primary-color);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 20px rgba(99, 16, 132, 0.2);
        }

        /* Hamburger Icon Animation */
        .hamburger-icon {
            width: 30px;
            height: 20px;
            position: relative;
            cursor: pointer;
        }
        .hamburger-icon span {
            display: block;
            position: absolute;
            height: 3px;
            width: 100%;
            background: var(--primary-color);
            border-radius: 9px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }
        .hamburger-icon span:nth-child(1) { top: 0px; }
        .hamburger-icon span:nth-child(2) { top: 10px; }
        .hamburger-icon span:nth-child(3) { top: 20px; }
        .hamburger-icon.open span:nth-child(1) { top: 10px; transform: rotate(135deg); }
        .hamburger-icon.open span:nth-child(2) { opacity: 0; left: -60px; }
        .hamburger-icon.open span:nth-child(3) { top: 10px; transform: rotate(-135deg); }

        @media (max-width: 1199.98px) {
            .navbar-collapse {
                background: white;
                margin-top: 15px;
                padding: 20px;
                border-radius: 15px;
                box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            }
        }
    </style>
</div>