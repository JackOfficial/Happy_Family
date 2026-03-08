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
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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