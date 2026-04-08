@extends('admin.layouts.app')

@section('title', 'HFRO - Create Project')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-plus-circle mr-2 text-primary"></i>Create New Project
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <ol class="breadcrumb float-sm-right bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
                    <li class="breadcrumb-item active">New</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content pb-5">
    <div class="container-fluid">
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" 
              x-data="projectUploadHandler()">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary text-uppercase small">Project Essentials</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label for="title" class="font-weight-bold">Project Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control form-control-lg border-2 @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-4">
                                    <label class="font-weight-bold small text-muted text-uppercase">Mission Category</label>
                                    <select name="cause_id" class="custom-select">
                                        <option value="">Select a cause</option>
                                        @foreach($causes as $cause)
                                            <option value="{{ $cause->id }}">{{ $cause->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-4">
                                    <label class="font-weight-bold small text-muted text-uppercase">Short Summary</label>
                                    <input type="text" name="summary" class="form-control" placeholder="Brief tagline">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold small text-muted text-uppercase">Full Description</label>
                                <textarea name="description" id="myeditorinstance" rows="8" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary text-uppercase small">Project Gallery</h5>
                            <button type="button" class="btn btn-primary btn-sm" @click="$refs.photoInput.click()">
                                <i class="fas fa-images mr-1"></i> Add Photos
                            </button>
                            <input type="file" name="photos[]" x-ref="photoInput" class="d-none" multiple accept="image/*" @change="addPhotos">
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-3"><i class="fas fa-info-circle mr-1"></i> Click the <i class="fas fa-star text-warning"></i> to set the main featured image.</p>
                            
                            <div class="row" x-show="photos.length > 0">
                                <template x-for="(photo, index) in photos" :key="index">
                                    <div class="col-md-4 mb-3">
                                        <div class="position-relative border rounded p-1" :class="photo.is_featured ? 'border-primary shadow-sm' : ''">
                                            <img :src="photo.preview" class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                                            
                                            <button type="button" 
                                                    @click="setFeatured(index)"
                                                    class="btn btn-sm position-absolute" 
                                                    style="top: 10px; left: 10px;"
                                                    :class="photo.is_featured ? 'btn-warning' : 'btn-light opacity-75'">
                                                <i class="fas fa-star"></i>
                                            </button>

                                            <button type="button" @click="removePhoto(index)" class="btn btn-danger btn-sm position-absolute" style="top: 10px; right: 10px;">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <input type="hidden" name="featured_index" :value="featuredIndex">
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div x-show="photos.length === 0" class="py-5 text-center border-2 border-dashed rounded bg-light">
                                <i class="fas fa-camera fa-3x text-muted mb-2"></i>
                                <p class="text-muted">No photos selected yet.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary text-uppercase small">Reports & Documents</h5>
                        </div>
                        <div class="card-body">
                            <div class="upload-zone p-4 mb-3" @click="$refs.docInput.click()" style="cursor: pointer;">
                                <i class="fas fa-file-upload fa-2x text-muted mb-2"></i>
                                <p class="mb-0">Click to upload PDFs, Reports, or Spreadsheets</p>
                                <input type="file" name="documents[]" x-ref="docInput" class="d-none" multiple @change="addDocuments">
                            </div>

                            <ul class="list-group">
                                <template x-for="(doc, index) in documents" :key="index">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="far fa-file-pdf mr-2 text-danger"></i> <span x-text="doc.name"></span></span>
                                        <button type="button" @click="removeDoc(index)" class="btn btn-link text-danger p-0"><i class="fas fa-times"></i></button>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary text-uppercase small">Project Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="small font-weight-bold">Status</label>
                                <select name="status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="completed">Completed</option>
                                    <option value="planned">Planned</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="small font-weight-bold">Target Budget (RWF)</label>
                                <input type="number" name="budget" class="form-control" placeholder="0.00">
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold">Start Date</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm font-weight-bold mb-3">
                        <i class="fas fa-save mr-2"></i> SAVE PROJECT
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary btn-block">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
function projectUploadHandler() {
    return {
        photos: [],
        documents: [],
        featuredIndex: 0,

        addPhotos(e) {
            const files = Array.from(e.target.files);
            files.forEach(file => {
                this.photos.push({
                    file: file,
                    preview: URL.createObjectURL(file),
                    is_featured: this.photos.length === 0 // First photo is featured by default
                });
            });
            this.syncFeatured();
        },

        removePhoto(index) {
            this.photos.splice(index, 1);
            if (this.featuredIndex === index) this.featuredIndex = 0;
            this.syncFeatured();
        },

        setFeatured(index) {
            this.featuredIndex = index;
            this.syncFeatured();
        },

        syncFeatured() {
            this.photos.forEach((p, i) => p.is_featured = (i === this.featuredIndex));
        },

        addDocuments(e) {
            this.documents.push(...Array.from(e.target.files));
        },

        removeDoc(index) {
            this.documents.splice(index, 1);
        }
    }
}
</script>

<style>
    .border-dashed { border: 2px dashed #ced4da !important; }
    .upload-zone { border: 2px dashed #007bff; background: #f8fbff; border-radius: 8px; text-align: center; transition: 0.3s; }
    .upload-zone:hover { background: #eef5ff; border-color: #0056b3; }
    .opacity-75 { opacity: 0.75; }
</style>
@endsection