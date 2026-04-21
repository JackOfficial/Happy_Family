@extends('admin.layouts.app')

@section('title', 'HFRO - Edit Project')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-edit mr-2 text-primary"></i>Edit Project: {{ $project->title }}
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <ol class="breadcrumb float-sm-right bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content pb-5">
    <div class="container-fluid">
        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" 
              x-data="projectUploadHandler()">
            @csrf
            @method('PUT')

            {{-- Hidden inputs to track IDs marked for deletion --}}
            <template x-for="id in deletedPhotoIds">
                <input type="hidden" name="delete_photos[]" :value="id">
            </template>
            <template x-for="id in deletedDocIds">
                <input type="hidden" name="delete_documents[]" :value="id">
            </template>
            {{-- Tracks which photo ID is featured (either existing or new index) --}}
            <input type="hidden" name="featured_photo_id" :value="featuredPhotoId">
            <input type="hidden" name="featured_index" :value="featuredIndex">

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary text-uppercase small">Project Essentials</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label for="title" class="font-weight-bold">Project Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control form-control-lg border-2 @error('title') is-invalid @enderror" value="{{ old('title', $project->title) }}" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row">
                                <div class="col-md-12 form-group mb-4">
                                    <label class="font-weight-bold small text-muted text-uppercase d-block">Mission Categories <span class="text-danger">*</span></label>
                                    <div class="p-3 border rounded bg-light">
                                        <div class="row">
                                            @php 
                                                $selectedCauses = old('cause_ids', $project->causes->pluck('id')->toArray()); 
                                            @endphp
                                            @foreach($causes as $cause)
                                                <div class="col-md-4 mb-2">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" 
                                                               name="cause_ids[]" 
                                                               class="custom-control-input" 
                                                               id="cause_{{ $cause->id }}" 
                                                               value="{{ $cause->id }}"
                                                               {{ in_array($cause->id, $selectedCauses) ? 'checked' : '' }}>
                                                        <label class="custom-control-label font-weight-normal" for="cause_{{ $cause->id }}">
                                                            {{ $cause->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('cause_ids')
                                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold small text-muted text-uppercase">Full Description</label>
                                <textarea name="description" id="myeditorinstance" rows="8" class="form-control">{{ old('description', $project->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary text-uppercase small">Project Gallery</h5>
                            <button type="button" class="btn btn-primary btn-sm" @click="$refs.photoInput.click()">
                                <i class="fas fa-images mr-1"></i> Add More Photos
                            </button>
                            <input type="file" name="photos[]" x-ref="photoInput" class="d-none" multiple accept="image/*" @change="addPhotos">
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-3"><i class="fas fa-info-circle mr-1"></i> Click the star to set a photo as featured.</p>
                            
                            <div class="row">
                                {{-- Existing Photos from DB --}}
                                @foreach($project->project_photos as $photo)
                                    <div class="col-md-4 mb-3" x-show="!deletedPhotoIds.includes({{ $photo->id }})">
                                        <div class="position-relative border rounded p-1" 
                                             :class="featuredPhotoId == {{ $photo->id }} ? 'border-primary shadow-sm' : ''">
                                            <img src="{{ asset('storage/' . $photo->file_path) }}" class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                                            
                                            <button type="button" @click="setExistingFeatured({{ $photo->id }})"
                                                    class="btn btn-sm position-absolute" style="top: 10px; left: 10px;"
                                                    :class="featuredPhotoId == {{ $photo->id }} ? 'btn-warning' : 'btn-light opacity-75'">
                                                <i class="fas fa-star"></i>
                                            </button>

                                            <button type="button" @click="removeExistingPhoto({{ $photo->id }})" 
                                                    class="btn btn-danger btn-sm position-absolute" style="top: 10px; right: 10px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- New Upload Previews --}}
                                <template x-for="(photo, index) in photos" :key="index">
                                    <div class="col-md-4 mb-3">
                                        <div class="position-relative border rounded p-1" :class="photo.is_featured ? 'border-primary shadow-sm' : ''">
                                            <img :src="photo.preview" class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                                            
                                            <button type="button" @click="setNewFeatured(index)"
                                                    class="btn btn-sm position-absolute" style="top: 10px; left: 10px;"
                                                    :class="photo.is_featured ? 'btn-warning' : 'btn-light opacity-75'">
                                                <i class="fas fa-star"></i>
                                            </button>

                                            <button type="button" @click="removePhoto(index)" class="btn btn-danger btn-sm position-absolute" style="top: 10px; right: 10px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary text-uppercase small">Reports & Documents</h5>
                        </div>
                        <div class="card-body">
                            @if($project->documents->count() > 0)
                                <label class="small font-weight-bold text-muted">Current Documents</label>
                                <ul class="list-group mb-4">
                                    @foreach($project->documents as $doc)
                                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light" 
                                            x-show="!deletedDocIds.includes({{ $doc->id }})">
                                            <span><i class="far fa-file-pdf mr-2 text-danger"></i> {{ $doc->title }}</span>
                                            <div>
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-link"><i class="fas fa-download"></i></a>
                                                <button type="button" @click="removeExistingDoc({{ $doc->id }})" class="btn btn-sm btn-link text-danger"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <div class="upload-zone p-4 mb-3" @click="$refs.docInput.click()" style="cursor: pointer;">
                                <i class="fas fa-file-upload fa-2x text-muted mb-2"></i>
                                <p class="mb-0">Click to upload additional documents</p>
                                <input type="file" name="documents[]" x-ref="docInput" class="d-none" multiple @change="addDocuments">
                            </div>

                            <ul class="list-group">
                                <template x-for="(doc, index) in documents" :key="index">
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-primary">
                                        <span><i class="far fa-file-alt mr-2 text-primary"></i> <span x-text="doc.name"></span></span>
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
                        <div class="card-body" x-data="{ progress: {{ old('progress', $project->progress ?? 0) }} }">
                            <div class="form-group mb-3">
                                <label class="small font-weight-bold">Status</label>
                                <select name="status" class="form-control">
                                    @foreach(['Upcoming', 'Ongoing', 'Completed'] as $status)
                                        <option value="{{ $status }}" {{ old('status', $project->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="small font-weight-bold mb-0">Project Progress</label>
                                    <span class="badge badge-primary rounded-pill px-2" x-text="progress + '%'"></span>
                                </div>
                                <input type="range" name="progress" class="custom-range" 
                                       min="0" max="100" step="5" 
                                       x-model="progress">
                            </div>

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold">Target Budget (RWF)</label>
                                <input type="number" name="budget" class="form-control" value="{{ old('budget', $project->budget) }}" placeholder="0.00">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small font-weight-bold">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $project->start_date ? $project->start_date->format('Y-m-d') : '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small font-weight-bold">Est. Duration</label>
                                        <input type="text" name="duration" class="form-control" value="{{ old('duration', $project->duration) }}" placeholder="e.g. 6 Months">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm font-weight-bold mb-3">
                        <i class="fas fa-check-circle mr-2"></i> UPDATE PROJECT
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
        deletedPhotoIds: [],
        deletedDocIds: [],
        featuredIndex: -1,
        // Set the initial featured ID from the existing database record
        featuredPhotoId: {{ $project->project_photos()->where('is_featured', true)->first()->id ?? 'null' }},

        addPhotos(e) {
            const files = Array.from(e.target.files);
            files.forEach(file => {
                this.photos.push({
                    file: file,
                    preview: URL.createObjectURL(file),
                    is_featured: false
                });
            });
        },

        removePhoto(index) {
            this.photos.splice(index, 1);
            if (this.featuredIndex === index) {
                this.featuredIndex = -1;
            }
            this.syncFeatured();
        },

        removeExistingPhoto(id) {
            if(confirm('Are you sure you want to delete this photo from the gallery?')) {
                this.deletedPhotoIds.push(id);
                if (this.featuredPhotoId === id) this.featuredPhotoId = null;
            }
        },

        setExistingFeatured(id) {
            this.featuredPhotoId = id;
            this.featuredIndex = -1; // Reset new uploads featured status
            this.syncFeatured();
        },

        setNewFeatured(index) {
            this.featuredIndex = index;
            this.featuredPhotoId = null; // Reset existing featured ID
            this.syncFeatured();
        },

        syncFeatured() {
            this.photos.forEach((p, i) => p.is_featured = (i === this.featuredIndex));
        },

        addDocuments(e) {
            const files = Array.from(e.target.files);
            files.forEach(file => {
                this.documents.push({
                    name: file.name,
                    file: file
                });
            });
        },

        removeDoc(index) {
            this.documents.splice(index, 1);
        },

        removeExistingDoc(id) {
            if(confirm('Delete this document?')) {
                this.deletedDocIds.push(id);
            }
        }
    }
}
</script>

<style>
    .border-dashed { border: 2px dashed #ced4da !important; }
    .upload-zone { border: 2px dashed #28a745; background: #fafffa; border-radius: 8px; text-align: center; transition: 0.3s; }
    .upload-zone:hover { background: #f0fff0; border-color: #1e7e34; }
    .opacity-75 { opacity: 0.75; }
</style>
@endsection