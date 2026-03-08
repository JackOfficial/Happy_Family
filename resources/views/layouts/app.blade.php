<!DOCTYPE html>
<html lang="en" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">

<head>
    <meta charset="utf-8">
    <title>Happy Family Rwanda | Empowering Communities</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Jost:wght@500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
     <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <style>
        :root {
            /* Your Official Brand Colors */
            --primary-color: #631084; /* Deep Purple (Trust & Authority) */
            --btn-modern-purple: #631084;
            --accent-color: #ec409e;  /* Vibrant Pink (Action & Heart) */
            --light-bg: #fcfaff;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body { 
            font-family: 'Inter', sans-serif; 
            overflow-x: hidden; 
            color: #333;
            background-color: var(--light-bg);
        }

        h1, h2, h3, .nav-link { 
            font-family: 'Jost', sans-serif; 
            font-weight: 700; 
            color: var(--primary-color);
        }

        /* --- Glassmorphism Navigation --- */
        .glass-nav {
            transition: var(--transition-smooth);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(99, 16, 132, 0.1);
        }

        .scrolled-nav {
            padding: 5px 0 !important;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 10px 30px rgba(99, 16, 132, 0.1);
        }

        /* --- Professional Button UI --- */
        .btn-modern {
            border-radius: 8px; /* 2026 trend: Move away from pills to soft squares */
            padding: 12px 30px;
            font-weight: 600;
            transition: var(--transition-smooth);
            background: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-modern:hover {
            background: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(236, 64, 158, 0.3);
            color: white;
        }

        /* --- Nav Link Interaction --- */
        .nav-link {
            font-weight: 600;
            color: var(--primary-color) !important;
            position: relative;
            padding: 10px 15px;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: 0;
            left: 50%;
            background: var(--accent-color);
            transition: var(--transition-smooth);
            border-radius: 10px;
        }

        .nav-link:hover:after, .nav-link.active:after {
            width: 60%;
            left: 20%;
        }

        /* --- Back to Top --- */
        .back-to-top {
            background: var(--accent-color) !important;
            border: none;
            transition: var(--transition-smooth);
        }
        
        .back-to-top:hover {
            background: var(--primary-color) !important;
            transform: scale(1.1);
        }

        /* --- Global Refinements --- */
        [x-cloak] { display: none !important; }
        .lh-lg { line-height: 1.8; }
        
        .section-title-border {
            width: 60px;
            height: 4px;
            background: var(--accent-color);
            margin: 10px 0;
            border-radius: 2px;
        }
    </style>
    
    @yield('styles')
    @livewireStyles
</head>

<body class="bg-light">

    {{-- <div 
        x-data="{ loading: true }" 
        x-init="window.onload = () => { loading = false }; setTimeout(() => loading = false, 2500)" 
        x-show="loading" 
        x-transition:leave="transition ease-in duration-500"
        class="fixed-top w-100 vh-100 bg-white d-flex align-items-center justify-content-center" 
        style="z-index: 99999;"
    >
        <div class="text-center">
            <div class="spinner-border" style="width: 3rem; height: 3rem; color: var(--primary-color);" role="status"></div>
            <p class="mt-3 text-uppercase tracking-widest small font-weight-bold" style="color: var(--primary-color); letter-spacing: 2px;">
                Happy Family Rwanda
            </p>
        </div>
    </div> --}}

    <header :class="{ 'scrolled-nav': scrolled }" class="glass-nav sticky-top">
        <div class="container">
            <livewire:navbar-component />
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <livewire:footer-component />

    <button 
        x-show="scrolled" 
        x-transition 
        @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="btn back-to-top position-fixed shadow-lg text-white" 
        style="bottom: 30px; right: 30px; width: 55px; height: 55px; border-radius: 12px; z-index: 1000;">
        <i class="fa fa-arrow-up"></i>
    </button>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/lightbox/js/lightbox.min.js') }}"></script>
    
    @livewireScripts
</body>
</html>