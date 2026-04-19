@extends('admin.layouts.app')
@section('title', 'HFRO | Edit Story')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="font-weight-bold text-dark">
                    <i class="fas fa-edit mr-2 text-muted"></i>Edit Story
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent border-0 m-0 p-0">
                    <li class="breadcrumb-item"><a href="/admin" class="text-primary">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.stories.index') }}" class="text-primary">Stories</a></li>
                    <li class="breadcrumb-item active text-muted">Edit Post</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content" x-data="storyManager()">
    <form method="POST" action="{{ route('admin.stories.update', $story->slug) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Hidden Inputs for Laravel Controller --}}
        <template x-for="id in removedPhotos" :key="'photo-'+id">
            <input type="hidden" name="remove_photos[]" :value="id">
        </template>
        <template x-for="id in removedDocs" :key="'doc-'+id">
            <input type="hidden" name="remove_documents[]" :value="id">
        </template>
        <input type="hidden" name="featured_photo_id" :value="featuredPhotoId">

        <div class="row">
            {{-- LEFT COLUMN --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Story Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $story->title) }}" 
                                class="form-control form-control-lg border-0 border-bottom rounded-0 px-0 shadow-none" style="font-size: 1.75rem;">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small font-weight-bold text-muted">IMPACT CAUSE</label>
                                    <select name="cause_id" class="form-control select2">
                                        <option value="">General / None</option>
                                        @foreach($causes as $cause)
                                            <option value="{{ $cause->id }}" {{ $story->cause_id == $cause->id ? 'selected' : '' }}>
                                                {{ $cause->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small font-weight-bold text-muted">STATUS</label>
                                    <select name="status" class="form-control custom-select">
                                        <option value="published" {{ $story->status == 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="draft" {{ $story->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-muted small">STORY CONTENT</label>
                            <textarea name="content" id="myeditorinstance" class="form-control">{{ old('content', $story->content) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- GALLERY MANAGEMENT --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Photo Gallery</h3>
                        <label class="btn btn-sm btn-outline-primary mb-0 cursor-pointer">
                            <i class="fas fa-images mr-1"></i> Add Photos
                            <input type="file" name="photos[]" multiple class="d-none" @change="previewNewPhotos">
                        </label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($story->photos as $photo)
                            <div class="col-md-3 col-6 mb-4" x-show="!removedPhotos.includes({{ $photo->id }})" x-transition>
                                <div class="position-relative gallery-item rounded border shadow-sm overflow-hidden">
                                    <img src="{{ asset('storage/' . $photo->file_path) }}" class="img-fluid w-100" style="height: 120px; object-fit: cover;">
                                    <div class="gallery-overlay d-flex flex-column justify-content-between p-2">
                                        <div class="text-right">
                                            <button type="button" @click="removePhoto({{ $photo->id }})" class="btn btn-danger btn-xs rounded-circle shadow">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <button type="button" @click="setFeatured({{ $photo->id }})" 
                                            :class="featuredPhotoId == {{ $photo->id }} ? 'btn-warning' : 'btn-light'"
                                            class="btn btn-xs btn-block font-weight-bold shadow-sm">
                                            <i class="fas fa-star mr-1"></i> <span x-text="featuredPhotoId == {{ $photo->id }} ? 'Featured' : 'Set Featured'"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            {{-- New Previews --}}
                            <template x-for="(img, index) in newPhotoPreviews" :key="index">
                                <div class="col-md-3 col-6 mb-4">
                                    <div class="position-relative rounded border border-primary shadow-sm overflow-hidden" style="height: 120px;">
                                        <img :src="img" class="img-fluid w-100 h-100" style="object-fit: cover; opacity: 0.8;">
                                        <span class="badge badge-primary position-absolute" style="top: 5px; right: 5px;">New</span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4 sticky-top" style="top: 20px; z-index: 1020;">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow">
                            <i class="fas fa-save mr-2"></i> Update Story
                        </button>
                        <a href="{{ route('admin.stories.index') }}" class="btn btn-link btn-block text-muted small">Cancel Changes</a>
                        <hr>
                        <div class="bg-light p-2 rounded small">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Total Photos:</span> 
                                <b x-text="{{ $story->photos->count() }} - removedPhotos.length + newPhotoPreviews.length"></b>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total Docs:</span> 
                                <b x-text="{{ $story->documents->count() }} - removedDocs.length"></b>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DOCUMENT MANAGEMENT --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Managed Documents</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($story->documents as $doc)
                            <li class="list-group-item d-flex justify-content-between align-items-center" 
                                x-show="!removedDocs.includes({{ $doc->id }})" x-transition>
                                <div class="text-truncate mr-2" style="max-width: 180px;">
                                    <i class="far fa-file-pdf text-danger mr-2"></i>
                                    <span class="small font-weight-bold">{{ $doc->title }}</span>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-xs btn-light border"><i class="fas fa-download"></i></a>
                                    <button type="button" @click="removeDoc({{ $doc->id }})" class="btn btn-xs btn-outline-danger border">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item text-center text-muted small py-3">No documents attached.</li>
                            @endforelse
                        </ul>
                        <div class="p-3 bg-light border-top">
                            <label class="small font-weight-bold text-muted">UPLOAD NEW DOCS</label>
                            <input type="file" name="documents[]" multiple class="form-control-file border p-1 rounded bg-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

{{-- SCRIPTS SECTION --}}
@push('scripts')
<script>
function storyManager() {
    return {
        removedPhotos: [],
        removedDocs: [],
        newPhotoPreviews: [],
        featuredPhotoId: {{ $story->photos->where('is_featured', true)->first()->id ?? 'null' }},

        removePhoto(id) {
            if(confirm('Are you sure you want to remove this photo?')) {
                this.removedPhotos.push(id);
                if(this.featuredPhotoId == id) this.featuredPhotoId = null;
            }
        },

        removeDoc(id) {
            if(confirm('Are you sure you want to remove this document?')) {
                this.removedDocs.push(id);
            }
        },

        setFeatured(id) {
            this.featuredPhotoId = id;
        },

        previewNewPhotos(event) {
            this.newPhotoPreviews = [];
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                this.newPhotoPreviews.push(URL.createObjectURL(files[i]));
            }
        }
    }
}
</script>
@endpush

@push('styles')
    <style>
    .gallery-item .gallery-overlay {
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5); opacity: 0; transition: 0.3s;
    }
    .gallery-item:hover .gallery-overlay { opacity: 1; }
    .btn-xs { padding: 2px 6px; font-size: 11px; }
    .cursor-pointer { cursor: pointer; }
</style>
@endpush
@endsection