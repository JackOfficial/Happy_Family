@extends('admin.layouts.app')
@section('title', 'Edit Cause | ' . $cause->name)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 border-bottom pb-3">
            <div class="col-sm-6">
                <h1 class="font-weight-bold text-dark">Edit Impact Area</h1>
                <p class="text-muted small mb-0">Modifying: <span class="text-primary">{{ $cause->name }}</span></p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.causes.index') }}">Causes</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content" x-data="{ logoPreview: null }">
    <form action="{{ route('admin.causes.update', $cause->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-8">
                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">General Information</h3>
                    </div>
                    
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <ul class="mb-0 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="cause" class="font-weight-bold">Cause Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="cause" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $cause->name) }}" 
                                   placeholder="e.g., Clean Water Initiative" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="myeditorinstance" class="font-weight-bold">Detailed Description</label>
                            <textarea id="myeditorinstance" name="description" class="form-control" rows="12">{{ old('description', $cause->description) }}</textarea>
                            @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">Publishing Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status">Current Status</label>
                            <select name="status" id="status" class="form-control custom-select">
                                <option value="1" {{ old('status', $cause->status) == 1 ? 'selected' : '' }}>🟢 Active (Public)</option>
                                <option value="0" {{ old('status', $cause->status) == 0 ? 'selected' : '' }}>🔴 Inactive (Hidden)</option>
                            </select>
                            <small class="text-muted d-block mt-2">Inactive causes will not be visible on the homepage "Impact" section.</small>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">Featured Image</h3>
                    </div>
                    <div class="card-body">
                        <div class="current-photo-wrapper mb-3 text-center border rounded p-2 bg-light">
                            <label class="d-block text-muted small mb-2">Currently Active Photo</label>
                            @if($cause->mainPhoto)
                                <img src="{{ asset('storage/'.$cause->mainPhoto->file_path) }}" 
                                     alt="Current" class="img-fluid rounded shadow-sm" style="max-height: 180px;">
                            @else
                                <div class="py-4 text-muted"><i class="fas fa-image fa-3x"></i><br>No Photo Uploaded</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="photo">Upload New Photo</label>
                            <div class="custom-file">
                                <input type="file" name="photo" id="photo" class="custom-file-input" 
                                       accept="image/*" @change="logoPreview = URL.createObjectURL($event.target.files[0])">
                                <label class="custom-file-label" for="photo">Choose file...</label>
                            </div>
                            <small class="text-muted mt-1 d-block font-italic text-xs">Replaces the current image. Max 5MB.</small>
                        </div>

                        <template x-if="logoPreview">
                            <div class="mt-3 text-center border border-success rounded p-2">
                                <label class="d-block text-success small mb-1 font-weight-bold">New Image Preview:</label>
                                <img :src="logoPreview" class="img-fluid rounded" style="max-height: 180px;">
                            </div>
                        </template>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('admin.causes.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                        <button type="submit" class="btn btn-success font-weight-bold">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

@push('scripts')
<script>
    // Show selected filename in Bootstrap's custom-file-input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush

<style>
    .card-outline.card-primary { border-top: 3px solid var(--primary-purple, #631084); }
    .btn-success { background-color: #28a745; border-color: #28a745; }
    .btn-success:hover { background-color: #218838; }
    .text-xs { font-size: 0.75rem; }
    .custom-file-label::after { content: "Browse"; }
</style>
@endsection