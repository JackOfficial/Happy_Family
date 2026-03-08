@extends('admin.layouts.app')
@section('title', 'HFRO | Edit Event')

@push('styles')
<style>
    .card { border-radius: 12px; }
    .uppercase { text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px; font-weight: bold; display: block; }
    .btn-xs { padding: 1px 5px; font-size: 12px; line-height: 1.5; }
    .custom-file-label::after { content: "Browse"; }
    [x-cloak] { display: none !important; }
    .doc-item:hover { background-color: #f8f9fa; }
</style>
@endpush

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="font-weight-bold text-dark">Edit Event</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form method="POST" action="{{ route('admin.events.update', $event->slug) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        {{-- Event Title --}}
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Event Title</label>
                            <input type="text" name="title" id="title" 
                                   class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $event->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Event Description --}}
                        <div class="form-group">
                            <label for="myeditorinstance" class="font-weight-bold">Description</label>
                            <textarea name="description" id="myeditorinstance" rows="12" 
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Document Management Card --}}
                <div class="card shadow-sm border-0 mt-4" 
                     x-data="{ 
                        existingDocs: {{ Js::from($event->documents) }},
                        removedDocIds: [],
                        newDocNames: []
                     }" x-cloak>
                    <div class="card-header bg-white font-weight-bold">
                        <i class="fas fa-file-pdf mr-1 text-danger"></i> Event Documents
                    </div>
                    <div class="card-body">
                        {{-- Current Documents --}}
                        <label class="small text-muted uppercase">Existing Documents</label>
                        <div class="list-group list-group-flush mb-3 border rounded">
                            <template x-for="doc in existingDocs" :key="doc.id">
                                <div class="list-group-item d-flex justify-content-between align-items-center py-2 doc-item">
                                    <div class="text-truncate mr-2">
                                        <i class="far fa-file-alt mr-2 text-muted"></i>
                                        <span x-text="doc.title" class="small"></span>
                                    </div>
                                    <button type="button" @click="removedDocIds.push(doc.id); existingDocs = existingDocs.filter(d => d.id !== doc.id)"
                                            class="btn btn-outline-danger btn-xs border-0">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </template>
                            <template x-if="existingDocs.length === 0">
                                <div class="list-group-item text-muted small italic">No documents currently attached.</div>
                            </template>
                        </div>

                        {{-- Upload New Documents --}}
                        <label class="small text-muted uppercase">Add New Documents</label>
                        <div class="custom-file">
                            <input type="file" name="documents[]" id="documents" class="custom-file-input" 
                                   accept=".pdf,.doc,.docx,.zip,.xlsx" multiple
                                   @change="newDocNames = Array.from($event.target.files).map(f => f.name)">
                            <label class="custom-file-label" for="documents">Choose documents...</label>
                        </div>

                        {{-- New Selection List --}}
                        <template x-if="newDocNames.length > 0">
                            <ul class="list-group mt-2">
                                <template x-for="name in newDocNames" :key="name">
                                    <li class="list-group-item py-1 bg-light small text-primary border-primary">
                                        <i class="fas fa-plus mr-2"></i> <span x-text="name"></span>
                                    </li>
                                </template>
                            </ul>
                        </template>

                        <input type="hidden" name="removed_documents" :value="removedDocIds.join(',')">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                {{-- Schedule & Location --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white font-weight-bold"><i class="far fa-clock mr-1 text-primary"></i> Schedule</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date', $event->date?->format('Y-m-d')) }}">
                        </div>
                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" name="time" class="form-control" value="{{ old('time', $event->time) }}">
                        </div>
                    </div>
                </div>

                {{-- Venue & Status --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white font-weight-bold"><i class="fas fa-map-marker-alt mr-1 text-danger"></i> Venue</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}">
                        </div>
                        <div class="form-group">
                            <label>Registration Link</label>
                            <input type="url" name="link" class="form-control" value="{{ old('link', $event->link) }}">
                        </div>
                        <div class="form-group mb-0">
                            <label>Status</label>
                            <select name="status" class="form-control custom-select">
                                <option value="active" {{ old('status', $event->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $event->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Photo Management Card --}}
                <div class="card shadow-sm border-0" 
                     x-data="{ 
                        photoPreviews: [], 
                        existingPhotos: {{ Js::from($event->event_photos) }},
                        removedPhotoIds: [],
                        handleFileChange(event) {
                            this.photoPreviews = [];
                            Array.from(event.target.files).forEach(file => {
                                const reader = new FileReader();
                                reader.onload = (e) => { this.photoPreviews.push(e.target.result); };
                                reader.readAsDataURL(file);
                            });
                        }
                     }" x-cloak>
                    <div class="card-header bg-white font-weight-bold">
                        <i class="far fa-images mr-1 text-info"></i> Event Gallery
                    </div>
                    <div class="card-body">
                        <label class="small text-muted uppercase">Current Photos</label>
                        <div class="d-flex flex-wrap mb-3" style="gap: 8px;">
                            <template x-for="photo in existingPhotos" :key="photo.id">
                                <div class="position-relative border rounded p-1 shadow-sm">
                                    <img :src="'{{ asset('storage') }}/' + photo.file_path" 
                                         class="rounded" style="width: 70px; height: 70px; object-fit: cover;">
                                    <button type="button" @click="removedPhotoIds.push(photo.id); existingPhotos = existingPhotos.filter(p => p.id !== photo.id)"
                                            class="btn btn-danger btn-xs position-absolute shadow-sm"
                                            style="top: -5px; right: -5px; border-radius: 50%; padding: 0 5px;">
                                        &times;
                                    </button>
                                </div>
                            </template>
                        </div>

                        <label class="small text-muted uppercase">Upload New</label>
                        <div class="custom-file mb-2">
                            <input type="file" name="photos[]" id="photos" class="custom-file-input" 
                                   accept="image/*" multiple @change="handleFileChange($event)">
                            <label class="custom-file-label" for="photos">Add more...</label>
                        </div>

                        <div class="mt-2 d-flex flex-wrap" style="gap: 8px;">
                            <template x-for="(src, index) in photoPreviews" :key="index">
                                <div class="position-relative border rounded p-1 border-primary shadow-sm" style="background-color: #f0f7ff">
                                    <img :src="src" class="rounded" style="width: 70px; height: 70px; object-fit: cover;">
                                </div>
                            </template>
                        </div>

                        <input type="hidden" name="removed_photos" :value="removedPhotoIds.join(',')">
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-success btn-block btn-lg shadow-sm">
                        <i class="fas fa-check-circle mr-1"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-link btn-block text-muted">Go Back</a>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
   $(document).on('change', '.custom-file-input', function() {
        let files = $(this)[0].files;
        let label = files.length > 1 ? files.length + ' files selected' : (files.length === 1 ? files[0].name : 'Choose file');
        $(this).next('.custom-file-label').addClass("selected").html(label);
    });
</script>
@endpush