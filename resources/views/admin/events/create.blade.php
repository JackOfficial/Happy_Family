@extends('admin.layouts.app')
@section('title', 'HFRO | Create New Event')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="font-weight-bold">Create New Event</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                    <li class="breadcrumb-item active">Add Event</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            {{-- LEFT COLUMN: Event Details --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        {{-- Event Title (Modern Large Input) --}}
                        <div class="form-group">
                            <label for="title" class="font-weight-bold small text-uppercase text-muted">Event Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" 
                                   class="form-control form-control-lg border-0 border-bottom rounded-0 px-0 @error('title') is-invalid @enderror" 
                                   placeholder="e.g. Annual Charity Gala 2026" value="{{ old('title') }}" required autofocus>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Event Description --}}
                        <div class="form-group mt-4">
                            <label for="myeditorinstance" class="font-weight-bold small text-uppercase text-muted">Detailed Description</label>
                            <textarea name="description" id="myeditorinstance" 
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Document Upload Card --}}
                <div class="card shadow-sm border-0" x-data="documentHandler()">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase"><i class="fas fa-file-pdf mr-1 text-danger"></i> Event Documents</h3>
                    </div>
                    <div class="card-body">
                        <div class="custom-file">
                            <input type="file" name="documents[]" id="documents" class="custom-file-input" 
                                   accept=".pdf,.doc,.docx,.zip,.xlsx" multiple
                                   @change="handleDocs($event)">
                            <label class="custom-file-label" for="documents" x-text="docLabel">Choose documents...</label>
                        </div>
                        
                        <template x-if="docNames.length > 0">
                            <div class="mt-3">
                                <ul class="list-group list-group-flush border rounded">
                                    <template x-for="(name, index) in docNames" :key="index">
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-2 bg-light-alt">
                                            <span><i class="far fa-file-alt mr-2 text-primary"></i> <span x-text="name" class="small"></span></span>
                                            <button type="button" @click="removeDoc(index)" class="btn btn-link text-danger p-0"><i class="fas fa-times-circle"></i></button>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>
                        <small class="text-muted mt-2 d-block">Attach reports, programs, or registration forms (Max 10MB each).</small>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Metadata & Media --}}
            <div class="col-md-4">
                {{-- Schedule & Location --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Schedule & Location</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="small font-weight-bold"><i class="far fa-calendar-alt mr-1"></i> Date</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold"><i class="far fa-clock mr-1"></i> Time</label>
                            <input type="time" name="time" class="form-control @error('time') is-invalid @enderror" value="{{ old('time') }}">
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold"><i class="fas fa-map-marker-alt mr-1"></i> Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Address or Online" value="{{ old('location') }}">
                        </div>
                        <div class="form-group mb-0">
                            <label class="small font-weight-bold"><i class="fas fa-link mr-1"></i> Registration Link</label>
                            <input type="url" name="link" class="form-control" placeholder="https://..." value="{{ old('link') }}">
                        </div>
                    </div>
                </div>

                {{-- Status Card --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase">Visibility</h3>
                    </div>
                    <div class="card-body">
                        <select name="status" class="form-control custom-select">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Public (Active)</option>
                            <option value="inactive" {{ old('status', 'inactive') == 'inactive' ? 'selected' : '' }}>Draft (Inactive)</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm mt-3 font-weight-bold">
                            <i class="fas fa-paper-plane mr-1"></i> Publish Event
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-light btn-block mt-2 text-muted small">Discard Draft</a>
                    </div>
                </div>

                {{-- Photo Upload Card --}}
                <div class="card shadow-sm border-0" x-data="photoGallery()">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-muted small text-uppercase"><i class="far fa-images mr-1 text-info"></i> Event Gallery</h3>
                    </div>
                    <div class="card-body">
                        <div class="custom-file mb-2">
                            <input type="file" name="photos[]" id="photos" class="custom-file-input" 
                                   accept="image/*" multiple @change="handlePhotos($event)">
                            <label class="custom-file-label" for="photos">Add event photos</label>
                        </div>
                        
                        <div class="d-flex flex-wrap mt-3" style="gap: 8px;">
                            <template x-for="(src, index) in previews" :key="index">
                                <div class="position-relative">
                                    <img :src="src" class="img-thumbnail" style="width: 75px; height: 75px; object-fit: cover;">
                                    <button type="button" @click="removePhoto(index)" class="btn btn-danger btn-xs position-absolute" style="top: -5px; right: -5px; border-radius: 50%; padding: 0 4px;">
                                        <i class="fas fa-times" style="font-size: 10px;"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    function documentHandler() {
        return {
            docNames: [],
            docLabel: 'Choose documents...',
            handleDocs(event) {
                const files = Array.from(event.target.files);
                this.docNames = files.map(f => f.name);
                this.docLabel = files.length > 1 ? `${files.length} files selected` : files[0].name;
            },
            removeDoc(index) {
                this.docNames.splice(index, 1);
                // Updating the label if empty
                if(this.docNames.length === 0) this.docLabel = 'Choose documents...';
            }
        }
    }

    function photoGallery() {
        return {
            previews: [],
            handlePhotos(event) {
                const files = Array.from(event.target.files);
                files.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => { this.previews.push(e.target.result); };
                    reader.readAsDataURL(file);
                });
            },
            removePhoto(index) {
                this.previews.splice(index, 1);
            }
        }
    }
</script>

<style>
    .card-title { font-size: 0.75rem; letter-spacing: 0.5px; }
    .form-control-lg { font-size: 1.5rem; font-weight: 700; border-bottom: 2px solid #eee !important; }
    .form-control-lg:focus { border-bottom-color: #007bff !important; background: transparent; box-shadow: none; }
    .bg-light-alt { background-color: #f8f9fa; }
    .custom-file-label::after { content: "Browse"; }
    .btn-xs { padding: 1px 5px; font-size: 12px; line-height: 1.5; }
</style>
@endsection