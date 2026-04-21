<!DOCTYPE html>
<html lang="en" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Family Rwanda Organization</title>
    
    <meta name="description" content="Empowering vulnerable communities in Rwanda through sustainable education, health support, and social development.">
    <meta name="author" content="MUSENGIMANA Jacques">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="Happy Family Rwanda | Empowering Communities">
    <meta property="og:description" content="Join our mission to support families and children across Rwanda.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Jost:wght@700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    @stack('styles')
    @livewireStyles
</head>

<body>

    <header :class="{ 'scrolled-nav': scrolled }" class="navbar sticky-top">
        <div class="container">
            <x-partials.navbar />
        </div>
    </header>

    <main id="main-content">
        @yield('content')
    </main>

    <x-partials.footer />

    <button 
        x-cloak
        x-show="scrolled" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="btn-premium position-fixed d-flex align-items-center justify-content-center" 
        style="bottom: 30px; right: 30px; width: 55px; height: 55px; z-index: 1050; padding: 0;">
        <i class="fa fa-arrow-up"></i>
    </button>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/lightbox/js/lightbox.min.js') }}"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = { threshold: 0.1 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
        });
    </script>

    @stack('scripts')
    @livewireScripts
</body>
</html>