<div>
    @if (session()->has('message'))
        <div class="alert alert-success border-0 shadow-sm mb-4 animate__animated animate__fadeIn">
            <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
        </div>
    @endif

    @error('application_error')
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            {{ $message }}
        </div>
    @enderror

    <form wire:submit.prevent="save" class="row">
        <!-- First Name -->
        <div class="col-md-6 form-group">
            <label class="form-label font-inter small fw-bold">First Name *</label>
            <input type="text" wire:model="first_name" class="form-control rounded-pill px-4 border-0 bg-light shadow-none">
            @error('first_name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Last Name -->
        <div class="col-md-6 form-group">
            <label class="form-label font-inter small fw-bold">Last Name *</label>
            <input type="text" wire:model="last_name" class="form-control rounded-pill px-4 border-0 bg-light shadow-none">
            @error('last_name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Email Address -->
        <div class="col-md-6 form-group">
            <label class="form-label font-inter small fw-bold">Email Address *</label>
            <input type="email" wire:model="email" class="form-control rounded-pill px-4 border-0 bg-light shadow-none">
            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Phone Number -->
        <div class="col-md-6 form-group">
            <label class="form-label font-inter small fw-bold">Phone Number *</label>
            <input type="text" wire:model="phone" class="form-control rounded-pill px-4 border-0 bg-light shadow-none" placeholder="+250...">
            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Country Selection -->
        <div class="col-md-6 form-group">
            <label class="form-label font-inter small fw-bold">Country of Residence *</label>
            <select wire:model="country_id" class="form-control rounded-pill px-4 border-0 bg-light shadow-none" style="height: 45px; -webkit-appearance: none;">
                <option value="">Select Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            @error('country_id') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Gender Selection -->
        <div class="col-md-6 form-group">
            <label class="form-label font-inter small fw-bold">Gender (Optional)</label>
            <select wire:model="gender" class="form-control rounded-pill px-4 border-0 bg-light shadow-none" style="height: 45px; -webkit-appearance: none;">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            @error('gender') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- LinkedIn URL -->
        <div class="col-12 form-group">
            <label class="form-label font-inter small fw-bold">LinkedIn Profile URL</label>
            <input type="url" wire:model="linkedin_url" class="form-control rounded-pill px-4 border-0 bg-light shadow-none" placeholder="https://linkedin.com/in/username">
            @error('linkedin_url') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- CV Upload -->
        <div class="col-12 form-group">
            <label class="form-label font-inter small fw-bold">Upload CV/Resume (PDF/DOCX) *</label>
            <div class="custom-file overflow-hidden rounded-pill">
                <input type="file" wire:model="cv" class="custom-file-input" id="cvInput">
                <label class="custom-file-label border-0 bg-light px-4" for="cvInput" style="padding-top: 10px;">
                    {{ $cv ? $cv->getClientOriginalName() : 'Choose file...' }}
                </label>
            </div>
            <div wire:loading wire:target="cv" class="text-primary small mt-2 ml-3">
                <i class="fas fa-spinner fa-spin mr-1"></i> Uploading to server...
            </div>
            @error('cv') <span class="text-danger small ml-3">{{ $message }}</span> @enderror
        </div>

        <!-- Cover Letter / Additional Notes -->
        <div class="col-12 form-group">
            <label class="form-label font-inter small fw-bold">Additional Notes / Cover Letter</label>
            <textarea wire:model="additional_notes" class="form-control border-0 bg-light shadow-none px-4 py-3" style="border-radius: 20px;" rows="4" placeholder="Tell us why you are interested in this position..."></textarea>
            @error('additional_notes') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="col-12 mt-4 text-center">
            <button type="submit" class="btn btn-dark px-5 py-3 rounded-pill shadow-sm font-weight-bold" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">Submit Application</span>
                <span wire:loading wire:target="save">
                    <i class="fas fa-circle-notch fa-spin mr-2"></i> Processing...
                </span>
            </button>
        </div>
    </form>
</div>