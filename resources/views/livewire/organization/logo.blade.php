<a href="/" class="navbar-brand d-flex align-items-center py-0">
    <img src="{{ asset('storage/' . $organization->logo) }}" 
         alt="{{ $organization->name }} Logo" 
         class="logo-img transition-all duration-500"
         style="object-fit: contain; width: auto;"
         :style="scrolled ? 'height: 40px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));' : 'height: 60px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.15));'" />
</a>