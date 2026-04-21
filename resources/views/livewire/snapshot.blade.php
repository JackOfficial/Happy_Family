<div class="footer-item">
    <h4 class="footer-title mb-4">Impact Gallery</h4>
    <div class="row g-2">
        @forelse($photos as $photo)
            <div class="col-4">
                <div class="footer-gallery-thumb">
                    <a href="{{ asset('storage/' . $photo->path) }}" data-lightbox="footer-gallery">
                        <div class="gallery-overlay">
                            <i class="fas fa-expand-alt text-white"></i>
                        </div>
                        <img src="{{ asset('storage/' . $photo->path) }}" 
                             class="img-fluid rounded-3" 
                             style="height: 70px; width: 100%; object-fit: cover;"
                             alt="{{ $photo->imageable->title ?? 'HFRO Impact' }}">
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="small text-muted">New photos coming soon.</p>
            </div>
        @endforelse
    </div>
</div>