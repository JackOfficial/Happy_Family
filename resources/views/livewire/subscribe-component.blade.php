<div class="newsletter-wrapper">
    <form wire:submit.prevent="subscribe" class="newsletter-form position-relative">
        <div class="input-group">
            <input type="email" 
                   wire:model="email" 
                   class="form-control footer-glass-input shadow-none" 
                   placeholder="Your email address"
                   aria-label="Email for newsletter">
            
            <button class="btn btn-premium-sm" type="submit" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="subscribe">
                    Join <i class="fas fa-paper-plane ms-2"></i>
                </span>
                <span wire:loading wire:target="subscribe">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </button>
        </div>
    </form>

    @error('email') 
        <div class="newsletter-feedback text-accent-pink mt-2 small animate__animated animate__fadeIn">
            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
        </div> 
    @enderror

    @if(session('subscribeSuccess'))
        <div class="alert-success-footer mt-3 animate__animated animate__fadeInUp">
            <i class="fas fa-check-circle me-2 text-success-green"></i> 
            {{ session('subscribeSuccess') }}
        </div>
    @endif
</div>