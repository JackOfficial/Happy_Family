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
                <ol class="breadcrumb float-sm-right">
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
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        {{-- Event Title --}}
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Event Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" 
                                   class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   placeholder="e.g. Annual Charity Gala 2026" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Event Description --}}
                        <div class="form-group">
                            <label for="myeditorinstance" class="font-weight-bold">Detailed Description</label>
                            <textarea name="description" id="myeditorinstance" rows="12" 
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Document Upload Card --}}
                <div class="card shadow-sm border-0 mt-4" x-data="{ docNames: [] }">
                    <div class="card-header bg-white font-weight-bold">
                        <i class="fas fa-file-pdf mr-1 text-danger"></i> Event Documents
                    </div>
                    <div class="card-body">
                        <div class="custom-file">
                            <input type="file" name="documents[]" id="documents" class="custom-file-input" 
                                   accept=".pdf,.doc,.docx,.zip,.xlsx" multiple
                                   @change="docNames = Array.from($event.target.files).map(f => f.name)">
                            <label class="custom-file-label" for="documents">Choose documents (PDF, Doc, Zip)</label>
                        </div>
                        
                        {{-- Document List Preview --}}
                        <template x-if="docNames.length > 0">
                            <ul class="list-group list-group-flush mt-3 border rounded">
                                <template x-for="name in docNames" :key="name">
                                    <li class="list-group-item d-flex align-items-center py-2">
                                        <i class="far fa-file-alt mr-2 text-muted"></i>
                                        <span x-text="name" class="small text-truncate"></span>
                                    </li>
                                </template>
                            </ul>
                        </template>
                        <small class="text-muted mt-2 d-block">Attach reports, programs, or registration forms.</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                {{-- Schedule & Location --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white font-weight-bold">Schedule & Location</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label><i class="far fa-calendar-alt mr-1"></i> Date</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
                        </div>
                        <div class="form-group">
                            <label><i class="far fa-clock mr-1"></i> Time</label>
                            <input type="time" name="time" class="form-control @error('time') is-invalid @enderror" value="{{ old('time') }}">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-map-marker-alt mr-1"></i> Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Physical address or Online" value="{{ old('location') }}">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-link mr-1"></i> Registration Link</label>
                            <input type="url" name="link" class="form-control" placeholder="https://..." value="{{ old('link') }}">
                        </div>
                    </div>
                </div>

                {{-- Status Card --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white font-weight-bold">Visibility</div>
                    <div class="card-body">
                        <div class="form-group">
                            <select name="status" class="form-control custom-select">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Public (Active)</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Draft (Inactive)</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Photo Upload Card --}}
                <div class="card shadow-sm border-0" x-data="{ photoPreviews: [] }">
                    <div class="card-header bg-white font-weight-bold"><i class="far fa-images mr-1 text-info"></i> Event Media</div>
                    <div class="card-body">
                        <div class="custom-file">
                            <input type="file" name="photos[]" id="photos" class="custom-file-input" 
                                   accept="image/*" multiple
                                   @change="
                                        photoPreviews.forEach(p => URL.revokeObjectURL(p));
                                        photoPreviews = Array.from($event.target.files).map(file => URL.createObjectURL(file));
                                   ">
                            <label class="custom-file-label" for="photos">Choose images</label>
                        </div>
                        <small class="text-muted mt-2 d-block">You can select multiple photos.</small>

                        <div class="mt-3 d-flex flex-wrap" style="gap: 10px;">
                            <template x-for="src in photoPreviews" :key="src">
                                <div class="position-relative">
                                    <img :src="src" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm">
                        <i class="fas fa-save mr-1"></i> Publish Event
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-link btn-block text-muted">Discard Draft</a>
                </div>
            </div>
        </div>
    </form>
</section>

<style>
    .card { border-radius: 10px; }
    .form-control:focus { border-color: #007bff; box-shadow: none; }
    .font-weight-bold { color: #444; }
    .custom-file-label::after { content: "Browse"; }
</style>
@endsection

@push('scripts')
<script>
    // To show file name in the custom file input label for single/multiple files
    $(document).on('change', '.custom-file-input', function() {
        let files = $(this)[0].files;
        let label = $(this).next('.custom-file-label');
        if (files.length > 1) {
            label.addClass("selected").html(files.length + " files selected");
        } else {
            let fileName = $(this).val().split('\\').pop();
            label.addClass("selected").html(fileName || 'Choose file');
        }
    });
</script>
@endpush