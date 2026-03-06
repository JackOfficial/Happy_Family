@extends('admin.layouts.app')
@section('title', 'HFRO | Post Story')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="font-weight-bold">Create Story</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
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
            {{-- LEFT COLUMN: Primary Content --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Story Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                placeholder="Enter a catchy title..." required autofocus>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="summary" class="font-weight-bold">Short Summary</label>
                            <textarea name="summary" id="summary" rows="3" 
                                class="form-control @error('summary') is-invalid @enderror" 
                                placeholder="Briefly explain what this story is about...">{{ old('summary') }}</textarea>
                            <small class="form-text text-muted">This will appear on the blog listing page.</small>
                            @error('summary')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="myeditorinstance" class="font-weight-bold">Detailed Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="myeditorinstance" 
                                class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                            @error('content')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Settings & Metadata --}}
            <div class="col-md-4">
                {{-- STATUS & PUBLISHING --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Publishing</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status">Post Status</label>
                            <select name="status" id="status" class="form-control custom-select">
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block shadow-sm">
                            <i class="fa fa-paper-plane mr-1"></i> Post Story
                        </button>
                        <a href="{{ route('admin.stories.index') }}" class="btn btn-light btn-block mt-2">Cancel</a>
                    </div>
                </div>

                {{-- FEATURED IMAGE --}}
                <div class="card shadow-sm border-0" x-data="{ photoPreview: null }">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Featured Image</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <div class="custom-file">
                                <input type="file" name="photo" id="photo" class="custom-file-input" accept="image/*"
                                    @change="photoPreview = URL.createObjectURL($event.target.files[0])">
                                <label class="custom-file-label" for="photo">Choose file</label>
                            </div>
                            
                            <div class="mt-3 text-center bg-light rounded border p-2" style="min-height: 150px; display: flex; align-items: center; justify-content: center;">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="img-fluid rounded shadow-sm">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="text-muted small">
                                        <i class="far fa-image fa-3x d-block mb-2"></i>
                                        Preview will appear here
                                    </div>
                                </template>
                            </div>
                            @error('photo')
                                <span class="text-danger small mt-2 d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<style>
    .card-title { font-size: 0.85rem; letter-spacing: 0.5px; }
    .form-control-lg { font-size: 1.5rem; border-color: transparent; border-bottom: 2px solid #eee; border-radius: 0; }
    .form-control-lg:focus { border-color: transparent; border-bottom-color: #007bff; box-shadow: none; }
    .custom-file-label::after { content: "Browse"; }
</style>
@endsection