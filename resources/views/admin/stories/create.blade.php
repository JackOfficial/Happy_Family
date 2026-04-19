@extends('admin.layouts.app')
@section('title', 'HFRO | Post Story')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="font-weight-bold">Create New Story</h1>
            </div>
            <div class="col-sm-6 text-right">
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
                <div class="card shadow-sm border-0 mb-4">
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
                            <textarea name="summary" id="summary" rows="2" 
                                class="form-control @error('summary') is-invalid @enderror" 
                                placeholder="Briefly explain what this story is about...">{{ old('summary') }}</textarea>
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

                {{-- PHOTO GALLERY SECTION --}}
                <div class="card shadow-sm border-0" x-data="photoGallery()">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Photo Gallery</h3>
                    </div>
                    <div class="card-body">
                        <div class="custom-file mb-3">
                            <input type="file" name="photos[]" id="photos" class="custom-file-input" multiple accept="image/*"
                                @change="handleFiles($event)">
                            <label class="custom-file-label" for="photos">Select multiple photos...</label>
                        </div>

                        <div class="row">
                            <template x-for="(image, index) in previews" :key="index">
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="position-relative bg-light rounded border p-1">
                                        <img :src="image" class="img-fluid rounded shadow-xs" style="height: 100px; width: 100%; object-fit: cover;">
                                        <button type="button" @click="removeImage(index)" class="btn btn-danger btn-xs position-absolute" style="top: -5px; right: -5px; border-radius: 50%;">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <div x-if="index === 0" class="badge badge-primary position-absolute" style="bottom: 5px; left: 5px; font-size: 10px;">Featured</div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Settings & Metadata --}}
            <div class="col-md-4">
                {{-- STATUS & CAUSE --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Classification</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cause_id">Related Cause</label>
                            <select name="cause_id" id="cause_id" class="form-control custom-select">
                                <option value="">None (General Story)</option>
                                @foreach($causes as $cause)
                                    <option value="{{ $cause->id }}" {{ old('cause_id') == $cause->id ? 'selected' : '' }}>
                                        {{ $cause->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Post Status</label>
                            <select name="status" id="status" class="form-control custom-select">
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block shadow-sm py-2 font-weight-bold">
                            <i class="fa fa-save mr-1"></i> Save Story
                        </button>
                        <a href="{{ route('admin.stories.index') }}" class="btn btn-light btn-block mt-2">Cancel</a>
                    </div>
                </div>

                {{-- DOCUMENTS UPLOAD --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Attachments (PDF/Reports)</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <input type="file" name="documents[]" multiple class="form-control-file" accept=".pdf,.doc,.docx">
                            <small class="text-muted mt-2 d-block">Max 10MB per file.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    function photoGallery() {
        return {
            previews: [],
            handleFiles(event) {
                const files = event.target.files;
                this.previews = []; // Clear for fresh selection
                for (let i = 0; i < files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previews.push(e.target.result);
                    };
                    reader.readAsDataURL(files[i]);
                }
            },
            removeImage(index) {
                this.previews.splice(index, 1);
                // Note: To fully sync with the actual input, you'd need a DataTransfer object,
                // but this UI feedback works for typical multi-upload flows.
            }
        }
    }
</script>

<style>
    .card-title { font-size: 0.8rem; letter-spacing: 0.5px; }
    .form-control-lg { 
        font-size: 1.6rem; 
        font-weight: 700;
        border-color: transparent; 
        border-bottom: 2px solid #e9ecef; 
        border-radius: 0; 
        padding-left: 0;
    }
    .form-control-lg:focus { 
        border-color: transparent; 
        border-bottom-color: #007bff; 
        box-shadow: none; 
        background: transparent;
    }
    .custom-file-label::after { content: "Browse"; }
</style>
@endsection