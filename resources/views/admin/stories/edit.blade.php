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

                        {{-- Added Cause Selector --}}
                        <div class="form-group">
                            <label for="cause_id" class="font-weight-bold text-muted small">Impact</label>
                            <select name="cause_id" id="cause_id" class="form-control select2 @error('cause_id') is-invalid @enderror">
                                <option value="">-- No Specific Cause --</option>
                                @foreach($causes as $cause)
                                    <option value="{{ $cause->id }}" {{ (old('cause_id', $story->cause_id) == $cause->id) ? 'selected' : '' }}>
                                        {{ $cause->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cause_id')
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

                {{-- PHOTO GALLERY SECTION --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Current Photo Gallery</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($story->photos as $photo)
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="position-relative rounded border p-1 shadow-sm">
                                        <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                             class="img-fluid rounded" 
                                             style="height: 100px; width: 100%; object-fit: cover;">
                                        @if($photo->is_featured)
                                            <span class="badge badge-success position-absolute" style="top: 10px; left: 10px;">Featured</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-3 text-muted">
                                    No photos uploaded yet for this story.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Status & Media --}}
            <div class="col-md-4">
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

                {{-- UPLOAD NEW IMAGES --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Add More Photos</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label class="small text-muted">Select Images (Optional):</label>
                            <div class="custom-file">
                                {{-- Changed name to photos[] to match controller expectations --}}
                                <input type="file" name="photos[]" id="photos" class="custom-file-input" accept="image/*" multiple>
                                <label class="custom-file-label" for="photos">Choose files...</label>
                            </div>
                            <p class="x-small text-muted mt-2 mb-0">You can select multiple images to add to the gallery.</p>
                            @error('photos.*')
                                <span class="text-danger small mt-2 d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- DOCUMENTS SECTION --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Documents</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($story->documents as $doc)
                                <li class="list-group-item d-flex justify-content-between align-items-center small">
                                    <span class="text-truncate" style="max-width: 150px;">{{ $doc->title }}</span>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-info">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="p-3 border-top">
                            <input type="file" name="documents[]" class="form-control-file small" multiple>
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