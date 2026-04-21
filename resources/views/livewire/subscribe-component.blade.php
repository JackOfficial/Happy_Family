<div class="newsletter-wrapper">
                        <form wire:submit.prevent="subscribe" class="input-group newsletter-form">
                            <input type="email" 
                                   wire:model="email" 
                                   class="form-control footer-input shadow-none" 
                                   placeholder="Your email address">
                            <button class="btn btn-subscribe" type="submit">
                                <span wire:loading.remove wire:target="subscribe">
                                    Join Us <i class="fas fa-paper-plane ms-2 small"></i>
                                </span>
                                <span wire:loading wire:target="subscribe" class="spinner-border spinner-border-sm"></span>
                            </button>
                        </form>

                        @error('email') <small class="text-accent-pink mt-2 d-block">{{ $message }}</small> @enderror
                        @if(session('subscribeSuccess'))
                            <div class="alert-success-footer mt-3">
                                <i class="fas fa-check-circle me-2"></i> {{ session('subscribeSuccess') }}
                            </div>
                        @endif
                    </div>