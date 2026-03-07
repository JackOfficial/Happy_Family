@extends('admin.layouts.app')
@section('title', 'HFRO | Edit Event')

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
    <form method="POST" action="{{ route('admin.events.update', $event->id) }}" enctype="multipart/form-data">
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
            </div>

            <div class="col-md-4">
                {{-- Schedule Card --}}
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

                {{-- Location & Link --}}
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
                <div class="card shadow-sm border-0" x-data="{ 
                    photoPreviews: [], 
                    existingPhotos: @json($event->event_photos),
                    removedPhotoIds: []
                }">
                    <div class="card-header bg-white font-weight-bold"><i class="far fa-images mr-1 text-info"></i> Event Gallery</div>
                    <div class="card-body">
                        {{-- Existing Photos Grid --}}
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
                            <template x-if="existingPhotos.length === 0">
                                <p class="text-muted small italic">No photos currently attached.</p>
                            </template>
                        </div>

                        {{-- New Uploads --}}
                        <label class="small text-muted uppercase">Upload New</label>
                        <div class="custom-file mb-2">
                            <input type="file" name="photos[]" id="photos" class="custom-file-input" 
                                   accept="image/*" multiple
                                   @change="
                                        photoPreviews = [];
                                        Array.from($event.target.files).forEach(file => {
                                            photoPreviews.push(URL.createObjectURL(file));
                                        })
                                   ">
                            <label class="custom-file-label" for="photos">Add more...</label>
                        </div>

                        <div class="mt-2 d-flex flex-wrap" style="gap: 8px;">
                            <template x-for="src in photoPreviews" :key="src">
                                <img :src="src" class="img-thumbnail border-primary" style="width: 70px; height: 70px; object-fit: cover; opacity: 0.7;">
                            </template>
                        </div>

                        {{-- Hidden input for removal --}}
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

<style>
    .card { border-radius: 12px; }
    .uppercase { text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px; font-weight: bold; display: block; }
    .btn-xs { padding: 1px 5px; font-size: 12px; line-height: 1.5; }
    .custom-file-label::after { content: "Browse"; }
</style>
@endsection

@push('scripts')
<script>
    // File input label update
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName || 'Add more...');
    });
</script>
@endpush