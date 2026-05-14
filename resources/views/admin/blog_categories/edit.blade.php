@extends('admin.layouts.app')

@section('title', 'Edit Category | HFRO')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-jost fw-bold">Edit Category: <span class="text-primary">{{ $blogCategory->name }}</span></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right font-inter small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.blog-categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title font-inter fw-bold text-muted text-uppercase small">Update Category Info</h3>
                    </div>
                    
                    <form action="{{ route('admin.blog-categories.update', $blogCategory->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body font-inter">
                            <!-- Category Name -->
                            <div class="form-group mb-4">
                                <label for="name" class="font-weight-bold small text-uppercase">Category Name</label>
                                <input type="text" name="name" id="name" 
                                       class="form-control form-control-lg border-light shadow-none @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $blogCategory->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Current Image Display -->
                            <div class="form-group mb-4">
                                <label class="font-weight-bold small text-uppercase d-block">Current Thumbnail</label>
                                @if($blogCategory->categoryPhoto)
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset('storage/' . $blogCategory->categoryPhoto->file_path) }}" 
                                             alt="current" 
                                             class="rounded shadow-sm border" 
                                             style="max-height: 120px; width: auto;">
                                        <span class="badge badge-info position-absolute" style="top: -10px; right: -10px;">Active</span>
                                    </div>
                                @else
                                    <div class="p-3 bg-light rounded border text-muted small">
                                        <i class="fas fa-info-circle mr-1"></i> No image currently assigned.
                                    </div>
                                @endif
                            </div>

                            <!-- New Photo Upload -->
                            <div class="form-group mb-0">
                                <label for="photo" class="font-weight-bold small text-uppercase">Replace Image (Optional)</label>
                                <div class="custom-file mb-2">
                                    <input type="file" name="photo" id="photoInput" 
                                           class="custom-file-input @error('photo') is-invalid @enderror" 
                                           accept="image/png, image/jpeg, image/webp">
                                    <label class="custom-file-label" for="photoInput">Choose new file...</label>
                                    @error('photo')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <!-- New Preview (Hidden until file selected) -->
                                <div id="imagePreviewContainer" class="mt-3 d-none text-center p-3 border-dashed rounded">
                                    <p class="small text-success font-weight-bold mb-2"><i class="fas fa-sync-alt"></i> New Preview:</p>
                                    <img id="imagePreview" src="#" alt="New Preview" class="img-thumbnail shadow-sm" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light-50 py-3 d-flex justify-content-between">
                            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-link text-muted font-weight-bold">
                                Back to List
                            </a>
                            <button type="submit" class="btn btn-info px-5 shadow-sm text-white">
                                <i class="fas fa-sync-alt mr-2"></i> Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    .bg-light-50 { background-color: rgba(0,0,0,0.02); }
    .border-dashed { border: 2px dashed #e2e8f0; }
    .form-control-lg { font-size: 1rem; border-radius: 8px; border: 1px solid #e2e8f0; }
    .custom-file-label { border-radius: 8px; border-color: #e2e8f0; }
</style>
@endpush

@push('scripts')
<script>
    $('#photoInput').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);

        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#imagePreview').attr('src', event.target.result);
                $('#imagePreviewContainer').removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush