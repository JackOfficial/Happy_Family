@extends('admin.layouts.app')
@section('title', 'HFRO | Add Partner')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-end">
            <div class="col-sm-6">
                <h1 class="font-weight-bold text-dark mb-0">Add New Partner</h1>
                <p class="text-muted mb-0 small">Register a new organization or affiliate to the HFRO network.</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.partners.index') }}">Partners</a></li>
                    <li class="breadcrumb-item active">Add Partner</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            {{-- LEFT COLUMN: Basic Info & Description --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="row">
                            {{-- NAME --}}
                            <div class="form-group col-md-6 mb-4">
                                <label for="name" class="small text-uppercase font-weight-bold text-muted">Partner Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                    class="form-control bg-light border-0 shadow-none @error('name') is-invalid @enderror" 
                                    placeholder="e.g. UNICEF Rwanda" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- WEBSITE --}}
                            <div class="form-group col-md-6 mb-4">
                                <label for="website" class="small text-uppercase font-weight-bold text-muted">Website URL</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-link text-muted"></i></span>
                                    </div>
                                    <input type="url" name="website" id="website" value="{{ old('website') }}" 
                                        class="form-control bg-light border-0 shadow-none @error('website') is-invalid @enderror" 
                                        placeholder="https://example.com">
                                </div>
                                @error('website')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="form-group mb-0">
                            <label for="myeditorinstance" class="small text-uppercase font-weight-bold text-muted mb-3 d-block">About the Partnership</label>
                            <textarea name="description" id="myeditorinstance" 
                                class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Logo & Action --}}
            <div class="col-md-4">
                {{-- LOGO PANEL --}}
                <div class="card shadow-sm border-0 mb-4" x-data="{ logoPreview: null }">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase mb-0">Partner Logo</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="logo-upload-zone rounded mb-3" 
                             :class="logoPreview ? 'border-primary bg-white' : 'border-dashed bg-light'">
                            
                            <template x-if="logoPreview">
                                <img :src="logoPreview" class="img-fluid rounded p-2" style="max-height: 180px; object-fit: contain;">
                            </template>
                            
                            <template x-if="!logoPreview">
                                <div class="py-4 text-muted">
                                    <i class="fas fa-cloud-upload-alt fa-3x mb-2 opacity-50"></i>
                                    <p class="small mb-0 font-weight-bold">PNG or JPG (Max 2MB)</p>
                                    <p class="extra-small text-muted">Transparent backgrounds look best</p>
                                </div>
                            </template>
                        </div>

                        <label for="logo" class="btn btn-outline-primary btn-sm btn-block rounded-pill mb-0">
                            <i class="fas fa-image mr-1"></i> Select Logo
                        </label>
                        <input type="file" name="logo" id="logo" class="d-none" accept="image/*"
                            @change="logoPreview = URL.createObjectURL($event.target.files[0])">
                        
                        @error('logo')
                            <span class="text-danger small mt-2 d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- ACTION PANEL --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold shadow-sm rounded-pill mb-2">
                            <i class="fa fa-check-circle mr-2"></i> Save Partner
                        </button>
                        <a href="{{ route('admin.partners.index') }}" class="btn btn-light btn-block btn-sm text-muted">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<style>
    /* Global Clean Ups */
    .bg-light { background-color: #f8f9fa !important; }
    .extra-small { font-size: 0.75rem; }
    
    /* Logo Zone */
    .logo-upload-zone {
        border: 2px dashed #ccd1d6;
        min-height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        position: relative;
    }
    .border-primary { border-color: var(--primary) !important; border-style: solid !important; }
    
    /* Input Styling */
    .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #007bff !important;
    }
    .input-group-text {
        border-right: 0;
    }
</style>
@endsection