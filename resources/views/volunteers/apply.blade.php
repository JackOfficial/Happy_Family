@extends('layouts.app')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-5">
                            <h2 class="fw-bold text-dark">Volunteer With Us</h2>
                            <p class="text-muted">Join our mission to empower vulnerable communities in Rwanda.</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('volunteer.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <!-- Full Name -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter your full name" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@example.com" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phone Number</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+250..." required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}" required>
                                    @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Country -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Country</label>
                                    <select name="country_id" class="form-select @error('country_id') is-invalid @enderror" required>
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Occupation -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Occupation</label>
                                    <input type="text" name="occupation" class="form-control @error('occupation') is-invalid @enderror" value="{{ old('occupation') }}" placeholder="e.g. Teacher, Student">
                                    @error('occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- City -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">City</label>
                                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="e.g. Kigali" required>
                                    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Province/State -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Province/State</label>
                                    <input type="text" name="province" class="form-control @error('province') is-invalid @enderror" value="{{ old('province') }}" placeholder="e.g. Northern Province">
                                    @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Reason -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Why do you want to volunteer with us?</label>
                                    <textarea name="reason" rows="4" class="form-control @error('reason') is-invalid @enderror" placeholder="Tell us a bit about your motivation and skills..." required>{{ old('reason') }}</textarea>
                                    @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-dark w-100 py-3 rounded-pill fw-bold">
                                        Submit Application
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection