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
    <div class="container-fluid">
        {{-- Global Error Alert --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius: 10px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle mr-3 fa-lg"></i>
                    <div>
                        <strong>Validation Error!</strong> Please check the fields below.
                        <ul class="mb-0 mt-1 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- LEFT COLUMN: Event Details --}}
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            {{-- Event Title --}}
                            <div class="form-group">
                                <label for="title" class="font-weight-bold small text-uppercase text-muted">Event Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" 
                                       class="form-control form-control-lg border-0 border-bottom rounded-0 px-0 @error('title') is-invalid @enderror" 
                                       placeholder="e.g. Annual Charity Gala 2026" value="{{ old('title') }}" required autofocus>
                                @error('title')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Event Description --}}
                            <div class="form-group mt-4">
                                <label for="myeditorinstance" class="font-weight-bold small text-uppercase text-muted">Detailed Description</label>
                                <textarea name="description" id="myeditorinstance" 
                                          class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
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
                                <input type="file" name="documents[]" id="documents" class="custom-file-input @error('documents.*') is-invalid @enderror" 
                                       accept=".pdf,.doc,.docx,.zip,.xlsx" multiple
                                       @change="handleDocs($event)">
                                <label class="custom-file-label" for="documents" x-text="docLabel">Choose documents...</label>
                            </div>
                            @error('documents.*')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                            
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
                                @error('date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold"><i class="far fa-clock mr-1"></i> Time</label>
                                <input type="time" name="time" class="form-control @error('time') is-invalid @enderror" value="{{ old('time') }}">
                                @error('time') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold"><i class="fas fa-map-marker-alt mr-1"></i> Location</label>
                                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" placeholder="Address or Online" value="{{ old('location') }}">
                                @error('location') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-0">
                                <label class="small font-weight-bold"><i class="fas fa-link mr-1"></i> Registration Link</label>
                                <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" placeholder="https://..." value="{{ old('link') }}">
                                @error('link') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Visibility Card --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white">
                            <h3 class="card-title font-weight-bold text-muted small text-uppercase">Visibility</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="small font-weight-bold">Status</label>
                                <select name="status" class="form-control custom-select @error('status') is-invalid @enderror">
                                    <option value="upcoming" {{ old('status', 'upcoming') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            
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
                                <input type="file" name="photos[]" id="photos" class="custom-file-input @error('photos.*') is-invalid @enderror" 
                                       accept="image/*" multiple @change="handlePhotos($event)">
                                <label class="custom-file-label" for="photos">Add event photos</label>
                            </div>
                            @error('photos.*') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                            
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
    </div>
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
    .invalid-feedback { font-weight: 500; }
</style>
@endsection