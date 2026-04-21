<div>
    {{-- --- NOTIFICATION SYSTEM --- --}}
    @if(session('contactSuccess'))
        <div class="alert alert-premium-success d-flex align-items-center animate__animated animate__fadeInDown mb-4">
            <div class="alert-icon-wrap me-3">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <strong class="d-block">Message Sent!</strong>
                <span class="small">{{ session('contactSuccess') }}</span>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('contactFail'))
        <div class="alert alert-premium-danger d-flex align-items-center animate__animated animate__shakeX mb-4">
            <div class="alert-icon-wrap me-3">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <strong class="d-block">Error</strong>
                <span class="small">{{ session('contactFail') }}</span>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- --- CONTACT FORM --- --}}
    <form wire:submit.prevent="contact" class="position-relative">
        {{-- Loading Overlay for a premium feel during submission --}}
        <div wire:loading.flex wire:target="contact" class="form-loading-overlay">
            <div class="spinner-premium"></div>
        </div>

        <div class="row g-4">
            {{-- Name --}}
            <div class="col-xl-6">
                <div class="form-group-premium">
                    <label class="form-label-small">Full Name</label>
                    <input type="text" wire:model="name" 
                           class="form-control-premium @error('name') is-invalid @enderror" 
                           placeholder="John Doe" />
                    @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="col-xl-6">
                <div class="form-group-premium">
                    <label class="form-label-small">Email Address</label>
                    <input type="email" wire:model="email" 
                           class="form-control-premium @error('email') is-invalid @enderror" 
                           placeholder="name@example.com" />
                    @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Subject --}}
            <div class="col-xl-12">
                <div class="form-group-premium">
                    <label class="form-label-small">Subject</label>
                    <input type="text" wire:model="subject" 
                           class="form-control-premium @error('subject') is-invalid @enderror" 
                           placeholder="How can we help you?" />
                    @error('subject') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Message --}}
            <div class="col-12">
                <div class="form-group-premium">
                    <label class="form-label-small">Your Message</label>
                    <textarea wire:model="message" 
                              class="form-control-premium @error('message') is-invalid @enderror" 
                              rows="5" placeholder="Tell us more about your inquiry..."></textarea>
                    @error('message') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="col-12 mt-4">
                <button class="btn btn-purple-gradient w-100 py-3 rounded-pill fw-black shadow-lg d-flex align-items-center justify-content-center" 
                        type="submit" 
                        wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="contact">
                        Send Message <i class="fas fa-paper-plane ms-2 small"></i>
                    </span>
                    <span wire:loading wire:target="contact">
                        Processing...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>