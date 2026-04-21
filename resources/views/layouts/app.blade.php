<!DOCTYPE html>
<html lang="en" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Family Rwanda | Empowering Communities</title>
    
    <meta name="title" content="Happy Family Rwanda | Empowering Communities">
    <meta name="description" content="Empowering vulnerable communities in Rwanda through sustainable education, health support, and social development.">
    <meta name="author" content="MUSENGIMANA Jacques">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="Happy Family Rwanda | Empowering Communities">
    <meta property="og:description" content="Join us in our mission to support families and children across Rwanda.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    <style>
        /* Essential Inline Utilities */
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; }
        
        /* Modern Font Rendering */
        body { 
            -webkit-font-smoothing: antialiased; 
            -moz-osx-font-smoothing: grayscale; 
        }
        
    /* --- Base Project Cards --- */
    .project-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 12px;
    }
    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .project-card .overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        opacity: 0;
        transition: opacity 0.3s;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    .project-card:hover .overlay {
        opacity: 1;
    }

    /* --- General UI Elements --- */
    .btn-hover-bg:hover {
        background-color: #0056b3 !important;
        color: #fff !important;
    }
    .progress {
        border-radius: 0;
        margin-bottom: 0;
    }
    .rounded-custom {
        border-radius: 12px;
    }
    .about-section {
        background-color: #ffffff;
    }
    .opacity-90 { opacity: 0.9; }
    .opacity-70 { opacity: 0.7; }

    /* --- Hero & Carousel Design --- */
    .carousel-item {
        background: #000; /* Prevent white flash */
        position: relative;
    }
    .banner-img {
        object-fit: cover;
        filter: brightness(0.6); /* Modern dark overlay for text readability */
        width: 100%;
        height: 100%;
    }
    .carousel-item::after {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
    }
    .overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to bottom, rgba(99, 16, 132, 0.4), rgba(0,0,0,0.7));
        z-index: 1;
    }
    .carousel-caption {
        z-index: 10;
        bottom: 0; left: 0; right: 0; top: 0;
    }
    .hero-glass-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        max-width: 900px;
    }
    .hero-subtitle {
        max-width: 700px;
    }

    /* --- Typography --- */
    .tracking-widest { letter-spacing: 0.2rem; }
    .display-3 { font-size: calc(1.5rem + 3.5vw); line-height: 1.1; }
    .brand-title { color: var(--primary-purple); font-weight: 800; }
    .brand-title-dark { color: var(--primary-purple); font-weight: 800; }
    .brand-subtitle { color: var(--accent-pink); text-transform: uppercase; letter-spacing: 2px; font-weight: 700; font-size: 0.9rem; }
    .brand-subtitle-centered { color: var(--accent-pink); text-transform: uppercase; letter-spacing: 3px; font-weight: 700; font-size: 0.85rem; }
    .text-purple { color: var(--primary-purple); font-weight: 700; }
    .text-pink { color: var(--accent-pink) !important; }

    /* --- Buttons --- */
    .btn-modern {
        border-radius: 50px;
        padding: 15px 40px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .btn-hero {
        padding: 15px 35px;
        border-radius: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }
    .btn-primary.btn-hero { background: var(--primary-color); border: none; }
    .btn-hero:hover { transform: translateY(-5px); }
    
    .btn-modern-accent {
        display: inline-block;
        background: var(--accent-pink);
        color: white;
        padding: 10px 25px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-modern-accent:hover {
        background: var(--primary-purple);
        box-shadow: 0 5px 15px rgba(99, 16, 132, 0.3);
        transform: translateY(-3px);
    }
    .btn-modern-purple {
        background: var(--primary-purple);
        color: #ffffff !important;
        border-radius: 8px;
        padding: 12px 25px;
        font-weight: 700;
        border: 2px solid var(--primary-purple);
        box-shadow: 0 4px 15px rgba(99, 16, 132, 0.2);
        transition: 0.3s;
    }
    .btn-modern-purple:hover { background: var(--accent-pink); border-color: var(--accent-pink); color: white; }

    /* --- Carousel Controls --- */
    .custom-indicators li, .custom-indicators [data-bs-target] {
        width: 12px; height: 12px; border-radius: 50%; margin: 0 8px;
        background-color: rgba(255,255,255,0.5); border: none;
    }
    .custom-indicators li.active, .custom-indicators .active {
        background-color: var(--accent-pink); width: 30px; border-radius: 10px;
    }
    .control-icon {
        width: 50px; height: 50px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        backdrop-filter: blur(5px);
        transition: 0.3s;
    }
    .control-icon:hover { background: var(--primary-purple); color: white; }

    /* --- About & Image Decor --- */
    .image-wrapper::before {
        content: ''; position: absolute; width: 100%; height: 100%;
        border: 2px solid var(--accent-pink);
        top: 20px; left: -20px; z-index: -1; border-radius: 12px;
    }
    .experience-badge {
        position: absolute; bottom: -20px; right: -10px;
        background: var(--primary-purple); color: white;
        padding: 20px; border-radius: 12px; text-align: center;
        box-shadow: 0 10px 30px rgba(99, 16, 132, 0.3);
    }
    .volunteer-img-wrapper::before {
        content: ""; position: absolute; top: -15px; left: -15px;
        width: 100px; height: 100px;
        border-top: 5px solid var(--primary-purple);
        border-left: 5px solid var(--primary-purple);
        border-radius: 20px 0 0 0;
    }

    /* --- Tabs --- */
    .modern-pills .nav-link {
        border: 1px solid #eee; background: white; color: #666;
        margin-right: 10px; font-weight: 600; padding: 10px 25px;
        transition: all 0.3s ease; border-radius: 8px;
    }
    .modern-pills .nav-link.active {
        background: var(--primary-purple) !important;
        color: white !important; border-color: var(--primary-purple);
    }
    .impact-tab-content {
        background: #fcfaff; border-left: 5px solid var(--accent-pink);
    }
    .tab-description { color: #555; font-size: 1rem; line-height: 1.7; }

    /* --- Impact Section & Cards --- */
    .impact-section { background-color: #fcfaff; }
    .title-line-center { width: 60px; height: 4px; background: var(--accent-pink); border-radius: 10px; }
    .impact-card {
        background: #fff; border-radius: 15px; overflow: hidden; height: 100%;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0,0,0,0.05); display: flex; flex-direction: column;
    }
    .impact-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(99, 16, 132, 0.12); }
    .impact-img-container { position: relative; overflow: hidden; height: 220px; }
    .impact-img-container img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .impact-card:hover .impact-img-container img { transform: scale(1.1); }
    .impact-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(99, 16, 132, 0.7); display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: 0.4s; z-index: 2;
    }
    .impact-card:hover .impact-overlay { opacity: 1; }
    .impact-tag {
        position: absolute; top: 15px; right: 15px;
        background: var(--accent-pink); color: white;
        font-size: 0.7rem; padding: 4px 12px; border-radius: 50px;
        font-weight: 700; text-transform: uppercase;
    }
    .impact-card-title { color: var(--primary-purple); font-weight: 700; transition: 0.3s; text-decoration: none !important; }
    .impact-card-title:hover { color: var(--accent-pink); }
    .impact-text { color: #6c757d; font-size: 0.95rem; line-height: 1.6; }
    .impact-progress-bar { height: 6px; border-radius: 10px; background-color: #eee; }
    .impact-progress-bar .progress-bar { background-color: var(--accent-pink); border-radius: 10px; }
    
    .btn-impact-view {
        color: white; border: 2px solid white; padding: 8px 20px;
        border-radius: 50px; text-decoration: none !important; font-weight: 600; transition: 0.3s;
    }
    .btn-impact-view:hover { background: white; color: var(--primary-purple); }

    /* --- Counter Cards --- */
    .counter-card {
        background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; transition: all 0.3s ease;
    }
    .counter-card:hover { background: rgba(255, 255, 255, 0.15); transform: translateY(-5px); border-color: var(--accent-pink); }
    .counter-icon-wrap {
        width: 70px; height: 70px; line-height: 70px;
        background: rgba(234, 62, 160, 0.2); border-radius: 50%;
        margin: 0 auto; display: flex; align-items: center; justify-content: center;
    }

    /* --- Events --- */
    .event-date-badge {
        position: absolute; top: 0; left: 20px;
        background: var(--accent-pink); color: white;
        padding: 10px 15px; text-align: center;
        border-radius: 0 0 10px 10px; z-index: 3;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .event-date-badge .day { display: block; font-size: 1.4rem; font-weight: 800; line-height: 1; }
    .event-date-badge .month { display: block; font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; }
    .event-carousel .owl-nav button {
        background: var(--primary-purple) !important; color: white !important;
        width: 40px; height: 40px; border-radius: 50% !important; transition: 0.3s;
    }
    .event-carousel .owl-nav button:hover { background: var(--accent-pink) !important; }

    /* --- Gallery --- */
    .gallery-card { border: none; background: transparent; transition: 0.3s; }
    .gallery-card .impact-img-container { border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
    .gallery-caption-simple { font-weight: 600; font-size: 0.8rem; }
    .lb-outerContainer { border-radius: 10px; }
    .lb-data .lb-caption { color: var(--primary-purple); font-weight: 700; }
    .lb-number { background: var(--accent-pink); padding: 2px 8px; border-radius: 20px; color: white; }

    /* --- Partners & Links --- */
    .partners-section { border-top: 1px solid rgba(99, 16, 132, 0.05); }
    .partner-item a { text-decoration: none !important; color: inherit; }
    .partner-logo-wrap {
        background: #fff; height: 120px; display: flex; align-items: center; justify-content: center;
        padding: 20px; border-radius: 15px; transition: all 0.4s ease; border: 1px solid #eee;
    }
    .partner-logo { max-height: 80px; min-width: 50px; filter: grayscale(100%); opacity: 0.7; transition: 0.4s; }
    .partner-item:hover .partner-logo-wrap { border-color: var(--accent-pink); transform: translateY(-5px); box-shadow: 0 10px 20px rgba(99, 16, 132, 0.1) !important; }
    .partner-item:hover .partner-logo { filter: grayscale(0%); opacity: 1; }
    .partner-carousel .owl-dots .owl-dot.active span { background: var(--accent-pink) !important; }
    .partner-info p { color: #6c757d; text-decoration: none; }
    .partner-item:hover .text-purple { color: var(--accent-pink) !important; transition: color 0.4s ease; }
    .link-learn-more { color: var(--primary-purple); font-weight: 700; font-size: 0.9rem; text-decoration: none !important; transition: 0.3s; }
    .link-learn-more:hover { color: var(--accent-pink); padding-left: 5px; }

    /* --- Misc & Animations --- */
    .benefit-icon {
        width: 25px; height: 25px; background: rgba(234, 62, 160, 0.1);
        color: var(--accent-pink); border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-size: 0.7rem;
    }
    .owl-carousel .owl-item { opacity: 1 !important; display: block !important; }

    /* Fix: Remove Bootstrap's negative margins when Owl is active on mobile */
@media (max-width: 991px) {
    .impact-carousel.owl-carousel {
        margin-left: 0;
        margin-right: 0;
        display: block;
    }
    /* Ensure cards take full height in carousel */
    .impact-carousel .owl-stage {
        display: flex;
    }
    .impact-carousel .owl-item {
        display: flex;
        flex: 1 0 auto;
    }
}
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce { animation: bounce 3s infinite ease-in-out; }

    @media (max-width: 768px) {
        .display-3 { font-size: 2.5rem; }
    }

           /* CSS Variables for local context */
        :root {
            --primary-color: #631084;
            --accent-color: #ec409e;
            --light-bg: #fcfaff;
        }

        /* Glassmorphism Base */
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.5s ease;
        }

        .scrolled-nav {
            background: rgba(255, 255, 255, 0.95) !important;
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }

        /* Spacing Fixes */
        .top-info-bar {
            background-color: var(--primary-color);
            color: rgba(255,255,255,0.9);
        }

        .btn-donate-nav {
            background: var(--accent-color);
            color: white !important;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            transition: 0.3s;
        }

        .btn-donate-nav:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 16, 132, 0.3);
        }

        /* Mobile Adjustments */
        @media (max-width: 1199.98px) {
            .navbar-collapse {
                background: white;
                margin-top: 1rem;
                padding: 2rem;
                border-radius: 20px;
                border: 1px solid rgba(0,0,0,0.05);
            }
        }

                :root {
            --primary-purple: #631084;
            --accent-pink: #ec409e;
            --footer-dark: #14031a;
        }

        .main-footer {
            background-color: var(--footer-dark);
            color: #ffffff;
            font-family: 'Inter', sans-serif;
        }

        .footer-title {
            font-family: 'Jost', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            padding-bottom: 12px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 35px;
            height: 3px;
            background: var(--accent-pink);
            border-radius: 2px;
        }

        /* Newsletter Interaction */
        .newsletter-form {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 5px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: border-color 0.3s ease;
        }

        .newsletter-form:focus-within {
            border-color: var(--accent-pink);
        }

        .footer-input {
            background: transparent !important;
            border: none !important;
            color: white !important;
            padding: 12px 15px !important;
        }

        .btn-subscribe {
            background: var(--primary-purple);
            color: white;
            border-radius: 8px !important;
            padding: 10px 20px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-subscribe:hover {
            background: var(--accent-pink);
            color: white;
            transform: scale(1.02);
        }

        /* Gallery Hover Effects */
        .footer-gallery-thumb {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            aspect-ratio: 1/1;
        }

        .gallery-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(99, 16, 132, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.3s;
            z-index: 2;
        }

        .footer-gallery-thumb:hover .gallery-overlay {
            opacity: 1;
        }

        .footer-gallery-thumb img {
            transition: 0.5s ease;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .footer-gallery-thumb:hover img {
            transform: scale(1.15);
        }

        /* Footer Links */
        .footer-links li a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
            margin-bottom: 12px;
        }

        .footer-links li a:hover {
            color: var(--accent-pink);
            transform: translateX(5px);
        }

        .social-icon {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-left: 12px;
            transition: 0.3s;
        }

        .social-icon:hover {
            background: var(--accent-pink);
            transform: translateY(-5px);
            color: white;
        }

        .footer-bottom-border {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .text-accent-pink { color: var(--accent-pink); }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('styles')
    @livewireStyles
</head>

<body class="bg-light">

    <header :class="{ 'scrolled-nav': scrolled }" class="glass-nav sticky-top">
        <div class="container">
    <x-partials.navbar />
        </div>
    </header>

    <main>
        @yield('content')
    </main>
   <x-partials.footer />

    <button 
        x-cloak
        x-show="scrolled" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-4"
        @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="btn position-fixed shadow-lg text-white d-flex align-items-center justify-content-center" 
        style="bottom: 30px; right: 30px; width: 50px; height: 50px; border-radius: 12px; z-index: 1000; background-color: var(--accent-color); border: none;">
        <i class="fa fa-arrow-up"></i>
    </button>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/lightbox/js/lightbox.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            // Initialize Owl Carousel (Example for your events)
            $(".event-carousel").owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                center: false,
                dots: true,
                loop: true,
                margin: 25,
                nav : true,
                navText : [
                    '<i class="bi bi-arrow-left"></i>',
                    '<i class="bi bi-arrow-right"></i>'
                ],
                responsive: {
                    0:{ items:1 },
                    768:{ items:2 },
                    992:{ items:3 }
                }
            });
        });
    </script>
    @stack('scripts')
    @livewireScripts
</body>
</html>