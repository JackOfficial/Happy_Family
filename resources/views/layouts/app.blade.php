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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --primary-color: #2E7D32; /* Example: Earthy Green for "Family/Growth" */
            --accent-color: #FF9800;
        }
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }
        h1, h2, h3, .nav-link { font-family: 'Jost', sans-serif; font-weight: 700; }

        /* Custom UI Enhancements */
        .glass-nav {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        .scrolled-nav {
            padding: 10px 0 !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .btn-modern {
            border-radius: 50px;
            padding: 12px 30px;
            transition: transform 0.2s;
        }
        .btn-modern:hover { transform: translateY(-2px); }
        
        /* Smooth Spinner */
        [x-cloak] { display: none !important; }
    /* Clean Transitions */
    .transition-all { transition: all 0.3s ease-in-out; }
    
    .nav-link {
        font-weight: 500;
        color: #333 !important;
        position: relative;
    }
    
    .nav-link:after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 5px;
        left: 50%;
        background: var(--primary);
        transition: all 0.3s ease;
    }

    .nav-link:hover:after, .nav-link.active:after {
        width: 70%;
        left: 15%;
    }

    .dropdown-menu {
        border-radius: 12px;
        top: 90%;
    }
    
    /* Mobile styles */
    @media (max-width: 1199px) {
        .navbar-collapse {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-top: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    }

        .footer-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 2px;
        background: var(--primary);
    }

    .bg-secondary-dark {
        background: rgba(255, 255, 255, 0.1);
    }

    .footer-links a {
        transition: all 0.3s ease;
    }

    .footer-links a:hover {
        color: var(--primary) !important;
        padding-left: 8px;
    }

    .gallery-thumb img:hover {
        transform: scale(1.15);
        filter: brightness(0.7);
    }

    .social-circle {
        width: 35px;
        height: 35px;
        background: rgba(255,255,255,0.05);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 14px;
        transition: 0.3s;
    }

    .social-circle:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-3px);
    }

    .lh-lg { line-height: 1.8; }
    .transition-all { transition: all 0.4s ease; }
    </style>
@yield('styles')
    @livewireStyles
</head>

<body class="bg-light">

  <div 
    x-data="{ loading: true }" 
    x-init="window.onload = () => { loading = false }; setTimeout(() => loading = false, 3000)" 
    x-show="loading" 
    x-transition:leave="transition ease-in duration-500"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed-top w-100 vh-100 bg-white d-flex align-items-center justify-content-center" 
    style="z-index: 99999;"
>
    <div class="text-center">
        <div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
        <p class="mt-3 text-uppercase tracking-widest small text-muted font-weight-bold">Happy Family Rwanda</p>
    </div>
</div>

    <header :class="{ 'scrolled-nav': scrolled }" class="glass-nav sticky-top">
        <livewire:navbar-component />
    </header>

    <main>
        @yield('content')
    </main>

    <livewire:footer-component />

    <button 
        x-show="scrolled" 
        x-transition 
        @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="btn btn-primary position-fixed shadow-lg" 
        style="bottom: 30px; right: 30px; width: 50px; height: 50px; border-radius: 50%; z-index: 1000;">
        <i class="fa fa-arrow-up"></i>
    </button>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/lightbox/js/lightbox.min.js') }}"></script>
    
    @livewireScripts
</body>
</html>