<a href="/" class="navbar-brand">
                <img src="{{ asset('storage/' . $organization->logo) }}" 
                     alt="logo" 
                     class="transition-all logo-img"
                     :style="scrolled ? 'height: 45px;' : 'height: 65px;'" />
            </a>