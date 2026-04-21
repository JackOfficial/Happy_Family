@props(['photo', 'tab' => 'all'])

<div {{ $attributes->merge(['class' => 'gallery-card-modern shadow-premium border-0 overflow-hidden position-relative']) }}>
    <div class="gallery-img-wrapper" style="height: 250px;">
        <img src="{{ asset('storage/' . ($photo->file_path ?? $photo->photo)) }}" 
             class="w-100 h-100 object-fit-cover transition-scale" 
             alt="HFRO Gallery">
        
        <div class="gallery-modern-overlay d-flex flex-column align-items-center justify-content-center">
            <a href="{{ asset('storage/' . ($photo->file_path ?? $photo->photo)) }}" 
               data-lightbox="gallery-{{ $tab }}" 
               data-title="{{ $photo->caption ?? $photo->description }}"
               class="btn-glass-circle mb-3">
                <i class="fas fa-expand-alt"></i>
            </a>
            <span class="text-white extra-small fw-bold text-uppercase tracking-widest">{{ $photo->category }}</span>
        </div>
    </div>
    
    @if($photo->caption)
    <div class="gallery-meta-simple p-2 bg-white">
        <p class="text-muted extra-small mb-0 text-truncate px-1">{{ $photo->caption }}</p>
    </div>
    @endif
</div>