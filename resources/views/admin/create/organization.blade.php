@extends('admin.layouts.app')

@section('title', 'HFRO - Add Organization')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-6">
                <h1 class="font-weight-bold text-dark"><i class="fas fa-plus-circle mr-2 text-success"></i>Register New Organization</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.organization.index') }}">Organizations</a></li>
                    <li class="breadcrumb-item active">Add New</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-11 mx-auto">
                <form method="POST" action="{{ route('admin.organization.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card shadow-sm border-0 card-success card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="orgAddTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active px-4 py-3" id="basic-tab" data-toggle="pill" href="#basic" role="tab">
                                        <i class="fas fa-id-card mr-1"></i> Basic Identity
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-4 py-3" id="contact-tab" data-toggle="pill" href="#contact" role="tab">
                                        <i class="fas fa-address-book mr-1"></i> Contact Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-4 py-3" id="details-tab" data-toggle="pill" href="#details" role="tab">
                                        <i class="fas fa-file-alt mr-1"></i> Mission & Vision
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="orgAddTabContent">
                                
                                {{-- Tab 1: Basic Identity --}}
                                <div class="tab-pane fade show active py-3" id="basic" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Organization Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                                       placeholder="Enter full legal name" value="{{ old('name') }}" required>
                                                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Website URL</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-link"></i></span></div>
                                                    <input type="url" name="website" class="form-control" placeholder="https://www.example.org" value="{{ old('website') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-center border-left" x-data="{ logoPreview: null }">
                                            <label class="font-weight-bold d-block">Upload Logo</label>
                                            <div class="mb-3 d-flex align-items-center justify-content-center border rounded bg-light mx-auto" style="height: 120px; width: 120px;">
                                                <template x-if="logoPreview">
                                                    <img :src="logoPreview" class="img-fluid rounded shadow-sm" style="max-height: 110px;">
                                                </template>
                                                <template x-if="!logoPreview">
                                                    <i class="fas fa-image text-muted fa-3x"></i>
                                                </template>
                                            </div>
                                            <div class="custom-file w-75 mx-auto">
                                                <input type="file" name="logo" class="custom-file-input" id="logoInput" accept="image/*" 
                                                       @change="logoPreview = URL.createObjectURL($event.target.files[0])">
                                                <label class="custom-file-label text-left" for="logoInput">Choose Logo</label>
                                            </div>
                                            <small class="text-muted d-block mt-2">Max file size: 2MB</small>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tab 2: Contact Info --}}
                                <div class="tab-pane fade py-3" id="contact" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Contact Email</label>
                                                <div class="input-group shadow-none">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                                    <input type="email" name="email" class="form-control" placeholder="info@org.rw" value="{{ old('email') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Phone Number</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone-alt"></i></span></div>
                                                    <input type="text" name="phone" class="form-control" placeholder="+250..." value="{{ old('phone') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Office Address</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marked"></i></span></div>
                                                    <input type="text" name="address" class="form-control" placeholder="Street, City, Sector" value="{{ old('address') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tab 3: Detailed Info --}}
                                <div class="tab-pane fade py-3" id="details" role="tabpanel">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-success">Our Mission</label>
                                        <textarea name="mission" id="mission_editor" class="form-control" rows="3" placeholder="What is the organization's purpose?">{{ old('mission') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-success">Our Vision</label>
                                        <textarea name="vision" id="vision_editor" class="form-control" rows="3" placeholder="Where do you see the organization in 5 years?">{{ old('vision') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-success">About Us</label>
                                        <textarea name="about" id="about_editor" class="form-control" rows="6" placeholder="General history and background...">{{ old('about') }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer bg-light p-4 border-top">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.organization.index') }}" class="btn btn-link text-muted mt-2">
                                    <i class="fas fa-chevron-left mr-1"></i> Back to List
                                </a>
                                <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                    <i class="fas fa-save mr-2"></i> Register Organization
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    .nav-tabs .nav-link { border: none; color: #6c757d; font-weight: 500; transition: 0.3s; }
    .nav-tabs .nav-link.active { border-bottom: 3px solid #28a745; color: #28a745; background: transparent; }
    .input-group-text { background-color: #f8f9fa; border-right: none; color: #adb5bd; }
    .input-group .form-control { border-left: none; }
    .form-control:focus { box-shadow: none; border-color: #28a745; }
    .custom-file-label::after { content: "Browse"; background-color: #28a745; color: white; }
</style>

@endsection

@push('scripts')
<script>
    // Update filename on choose
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName || 'Choose Logo');
    });
</script>
@endpush