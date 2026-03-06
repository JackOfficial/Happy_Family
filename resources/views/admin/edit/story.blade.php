@extends('admin.layouts.app')
@section('title', 'HFRO | Edit Story')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="font-weight-bold text-dark">Edit Story</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.stories.index') }}">Stories</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    {{-- Notice: Using $story->slug for the route to match your model's RouteKey --}}
    <form method="POST" action="{{ route('admin.stories.update', $story->slug) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            {{-- LEFT COLUMN: Content --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Story Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $story->title) }}" 
                                class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                placeholder="Enter title..." required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="summary" class="font-weight-bold">Short Summary</label>
                            <textarea name="summary" id="summary" rows="3" 
                                class="form-control @error('summary') is-invalid @enderror">{{ old('summary', $story->summary) }}</textarea>
                            @error('summary')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="myeditorinstance" class="font-weight-bold">Detailed Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="myeditorinstance" 
                                class="form-control @error('content') is-invalid @enderror">{{ old('content', $story->content) }}</textarea>
                            @error('content')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Status & Media --}}
            <div class="col-md-4">
                {{-- ACTIONS --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Publishing</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status">Post Status</label>
                            <select name="status" id="status" class="form-control custom-select">
                                <option value="published" {{ old('status', $story->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ old('status', $story->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="archived" {{ old('status', $story->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <div class="small text-muted mb-3">
                            <i class="fas fa-history mr-1"></i> Last updated: {{ $story->updated_at->diffForHumans() }}
                        </div>
                        <button type="submit" class="btn btn-primary btn-block shadow-sm">
                            <i class="fa fa-save mr-1"></i> Save Changes
                        </button>
                        <a href="{{ route('admin.stories.index') }}" class="btn btn-light btn-block mt-2">Back to List</a>
                    </div>
                </div>

                {{-- FEATURED IMAGE --}}
                <div class="card shadow-sm border-0" x-data="{ photoPreview: null }">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Featured Image</h3>
                    </div>
                    <div class="card-body">
                        {{-- Show Current Image --}}
                        <div class="mb-3 text-center">
                            <label class="d-block text-left small text-muted">Current Photo:</label>
                            @if($story->photo)
                                <img src="{{ asset('storage/' . $story->photo->file_path) }}" 
                                     class="img-fluid rounded border shadow-sm mb-2" 
                                     style="max-height: 150px; width: 100%; object-fit: cover;">
                            @else
                                <div class="bg-light py-4 rounded border text-muted small">No photo uploaded</div>
                            @endif
                        </div>

                        {{-- Upload New Image --}}
                        <div class="form-group mb-0">
                            <label class="small text-muted">Upload New (Optional):</label>
                            <div class="custom-file">
                                <input type="file" name="photo" id="photo" class="custom-file-input" accept="image/*"
                                    @change="photoPreview = URL.createObjectURL($event.target.files[0])">
                                <label class="custom-file-label" for="photo">Browse...</label>
                            </div>

                            {{-- Alpine Preview for New Upload --}}
                            <template x-if="photoPreview">
                                <div class="mt-3 text-center">
                                    <label class="d-block text-left small text-success">New Photo Preview:</label>
                                    <img :src="photoPreview" class="img-fluid rounded shadow-sm border-success border">
                                </div>
                            </template>
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
    .form-control-lg { font-size: 1.5rem; border-color: transparent; border-bottom: 2px solid #eee; border-radius: 0; padding-left: 0; }
    .form-control-lg:focus { border-color: transparent; border-bottom-color: #007bff; box-shadow: none; }
    .custom-file-label::after { content: "Browse"; }
</style>
@endsection