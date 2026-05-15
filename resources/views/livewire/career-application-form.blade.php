<div>
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center animate__animated animate__fadeIn" role="alert">
            <i class="fas fa-check-circle me-2"></i> 
            <div>{{ session('message') }}</div>
        </div>
    @endif

    <!-- General Error Message -->
    @error('application_error')
        <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <div>{{ $message }}</div>
        </div>
    @enderror

    <form wire:submit.prevent="save" class="row g-3">
        <!-- First Name -->
        <div class="col-md-6">
            <label class="form-label fw-bold small">First Name *</label>
            <input type="text" wire:model="first_name" class="form-control rounded-pill px-4 border-0 bg-light shadow-none" placeholder="John">
            @error('first_name') <div class="text-danger small mt-1 ms-2">{{ $message }}</div> @enderror
        </div>

        <!-- Last Name -->
        <div class="col-md-6">
            <label class="form-label fw-bold small">Last Name *</label>
            <input type="text" wire:model="last_name" class="form-control rounded-pill px-4 border-0 bg-light shadow-none" placeholder="Doe">
            @error('last_name') <div class="text-danger small mt-1 ms-2">{{ $message }}</div> @enderror
        </div>

        <!-- Email Address -->
        <div class="col-md-6">
            <label class="form-label fw-bold small">Email Address *</label>
            <input type="email" wire:model="email" class="form-control rounded-pill px-4 border-0 bg-light shadow-none" placeholder="john@example.com">
            @error('email') <div class="text-danger small mt-1 ms-2">{{ $message }}</div> @enderror
        </div>

        <!-- Phone Number -->
        <div class="col-md-6">
            <label class="form-label fw-bold small">Phone Number *</label>
            <input type="text" wire:model="phone" class="form-control rounded-pill px-4 border-0 bg-light shadow-none" placeholder="+250...">
            @error('phone') <div class="text-danger small mt-1 ms-2">{{ $message }}</div> @enderror
        </div>

        <!-- Country Selection -->
        <div class="col-md-6">
            <label class="form-label fw-bold small">Country of Residence *</label>
            <select wire:model="country_id" class="form-select rounded-pill px-4 border-0 bg-light shadow-none">
                <option value="">Select Country</option>
                @forelse($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @empty
                    <option value="" disabled>No countries available</option>
                @endforelse
            </select>
            @error('country_id') <div class="text-danger small mt-1 ms-2">{{ $message }}</div> @enderror
        </div>

        <!-- Gender Selection -->
        <div class="col-md-6">
            <label class="form-label fw-bold small">Gender (Optional)</label>
            <select wire:model="gender" class="form-select rounded-pill px-4 border-0 bg-light shadow-none">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            @error('gender') <div class="text-danger small mt-1 ms-2">{{ $message }}</div> @enderror
        </div>

        <!-- LinkedIn URL -->
        <div class="col-12">
            <label class="form-label fw-bold small">LinkedIn Profile URL</label>
            <input type="url" wire:model="linkedin_url" class="form-control rounded-pill px-4 border-0 bg-light shadow-none" placeholder="https://linkedin.com/in/username">
            @error('linkedin_url') <div class="text-danger small mt-1 ms-2">{{ $message }}</div> @enderror
        </div>

        <!-- CV Upload (Bootstrap 5 Style) -->
        <div class="col-12">
            <label for="cvInput" class="form-label fw-bold small">Upload CV/Resume (PDF/DOCX) *</label>
            <input class="form-control rounded-pill border-0 bg-light shadow-none" type="file" id="cvInput" wire:model="cv" style="padding: 0.6rem 1.5rem;">
            
            <div wire:loading wire:target="cv" class="text-primary small mt-2 ms-3">
                <i class="fas fa-spinner fa-spin me-1"></i> Uploading...
            </div>
            
            @if($cv && !$errors->has('cv'))
                <div class="text-success small mt-2 ms-3">
                    <i class="fas fa-file-alt me-1"></i> Ready: {{ $cv->getClientOriginalName() }}
                </div>
            @endif
            @error('cv') <div class="text-danger small mt-1 ms-2">{{ $message }}</div> @enderror
        </div>

        <!-- Additional Notes -->
        <div class="col-12">
            <label class="form-label fw-bold small">Additional Notes / Cover Letter</label>
            <textarea wire:model="additional_notes" class="form-control border-0 bg-light shadow-none px-4 py-3" style="border-radius: 20px;" rows="4" placeholder="Tell us about your experience..."></textarea>
            @error('additional_notes') <div class="text-danger small mt-1 ms-2">{{ $message }}</div> @enderror
        </div>

        <!-- Submit -->
        <div class="col-12 mt-4 text-center">
            <button type="submit" class="btn btn-dark px-5 py-3 rounded-pill shadow-sm fw-bold" 
                    wire:loading.attr="disabled"
                    wire:target="cv, save">
                <span wire:loading.remove wire:target="save">Submit Application</span>
                <span wire:loading wire:target="save">
                    <i class="fas fa-circle-notch fa-spin me-2"></i> Processing...
                </span>
            </button>
        </div>
    </form>
</div>