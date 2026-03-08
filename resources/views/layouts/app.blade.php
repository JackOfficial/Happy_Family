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