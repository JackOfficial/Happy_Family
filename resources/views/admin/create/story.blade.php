@extends('admin.layouts.app')
@section('title', 'HFRO | Post Story')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-end">
            <div class="col-sm-6">
                <h1 class="font-weight-bold text-dark mb-0">Create New Story</h1>
                <p class="text-muted mb-0 small">Draft an inspiring narrative for the HFRO community.</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.stories.index') }}">Stories</a></li>
                    <li class="breadcrumb-item active">New Post</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form method="POST" action="{{ route('admin.stories.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            {{-- LEFT COLUMN: Editor --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label for="title" class="small text-uppercase font-weight-bold text-muted">Story Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                class="form-control form-control-title @error('title') is-invalid @enderror" 
                                placeholder="Enter a catchy title..." required autofocus>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="summary" class="small text-uppercase font-weight-bold text-muted">Short Excerpt</label>
                            <textarea name="summary" id="summary" rows="2" 
                                class="form-control border-0 bg-light rounded shadow-none @error('summary') is-invalid @enderror" 
                                placeholder="Write a brief, engaging summary for the listing page...">{{ old('summary') }}</textarea>
                            @error('summary')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="myeditorinstance" class="small text-uppercase font-weight-bold text-muted mb-3 d-block">Story Body <span class="text-danger">*</span></label>
                            <div class="editor-container">
                                <textarea name="content" id="myeditorinstance" 
                                    class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                            </div>
                            @error('content')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Publishing & Media --}}
            <div class="col-md-4 sticky-top-admin">
                {{-- PUBLISHING PANEL --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase mb-0">Publishing Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label for="status" class="small font-weight-bold text-muted">Post Visibility</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-eye"></i></span>
                                </div>
                                <select name="status" id="status" class="form-control custom-select border-0 bg-light shadow-none">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Save as Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish Immediately</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold shadow-sm rounded-pill">
                                <i class="fa fa-paper-plane mr-2"></i> Save Story
                            </button>
                            <a href="{{ route('admin.stories.index') }}" class="btn btn-link btn-block btn-sm text-muted mt-2">Discard Changes</a>
                        </div>
                    </div>
                </div>

                {{-- FEATURED IMAGE PANEL --}}
                <div class="card shadow-sm border-0" x-data="{ photoPreview: null }">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase mb-0">Visuals</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-0 text-center">
                            <div class="image-preview-container rounded mb-3" 
                                 :class="photoPreview ? 'border-primary' : 'border-dashed'">
                                
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="img-fluid rounded shadow-sm main-preview">
                                </template>
                                
                                <template x-if="!photoPreview">
                                    <div class="text-muted p-4">
                                        <i class="far fa-image fa-3x d-block mb-3 opacity-50"></i>
                                        <p class="small mb-0">Recommended size: 1200x630px</p>
                                    </div>
                                </template>
                            </div>

                            <div class="upload-btn-wrapper">
                                <label for="photo" class="btn btn-outline-secondary btn-sm btn-block rounded-pill">
                                    <i class="fas fa-camera mr-1"></i> Choose Featured Image
                                </label>
                                <input type="file" name="photo" id="photo" class="d-none" accept="image/*"
                                    @change="photoPreview = URL.createObjectURL($event.target.files[0])">
                            </div>

                            @error('photo')
                                <span class="text-danger small mt-2 d-block text-left">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<style>
    /* Clean Title Input */
    .form-control-title {
        font-size: 2.25rem !important;
        font-weight: 800;
        border: none;
        border-bottom: 2px solid #f1f1f1;
        border-radius: 0;
        padding-left: 0;
        padding-right: 0;
        transition: 0.3s;
        color: #1a1a1a;
    }
    .form-control-title:focus {
        box-shadow: none;
        border-bottom-color: var(--primary-purple, #007bff);
        background: transparent;
    }
    .form-control-title::placeholder { color: #d1d1d1; }

    /* Sidebar Positioning */
    .sticky-top-admin {
        position: sticky;
        top: 20px;
        z-index: 1020;
    }

    /* Image Upload UI */
    .image-preview-container {
        border: 2px dashed #ddd;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fafafa;
        transition: 0.3s;
    }
    .border-primary { border-color: #007bff !important; background: #f0f7ff; }
    .main-preview { max-height: 250px; width: 100%; object-fit: cover; }

    /* TinyMCE / Editor Spacing */
    .tox-tinymce { border: none !important; border-radius: 10px !important; }
</style>
@endsection