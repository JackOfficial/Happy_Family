<div class="d-flex align-items-center small fw-semibold">
    <a href="mailto:{{ $organization->email }}" 
       class="text-white text-opacity-75 text-decoration-none me-4 transition-all hover-opacity-100 d-flex align-items-center">
        <i class="fas fa-envelope me-2 text-accent-pink"></i>
        <span class="d-none d-sm-inline">{{ $organization->email }}</span>
    </a>

    <a href="tel:{{ $organization->phone }}" 
       class="text-white text-opacity-75 text-decoration-none transition-all hover-opacity-100 d-flex align-items-center">
        <i class="fas fa-phone-alt me-2 text-accent-pink"></i>
        <span>{{ $organization->phone }}</span>
    </a>
</div>