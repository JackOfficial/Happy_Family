@extends('admin.layouts.app')

@section('title', 'HFRO - Edit Project')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-edit mr-2 text-primary"></i>Edit Project
                </h1>
            </div>
            <div class="col-sm-6">
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
            x-data="{ 
                photoPreview: null, 
                currentPhoto: '{{ $project->project_photo ? asset('storage/' . $project->project_photo->file_path) : '' }}',
                documents: [] 
            }">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary">General Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label for="title" class="font-weight-bold">Project Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title"
                                    class="form-control form-control-lg border-2 @error('title') is-invalid @enderror"
                                    value="{{ old('title', $project->title) }}" required placeholder="Enter a descriptive title">
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-4">
                                    <label for="cause_id" class="font-weight-bold text-muted small uppercase">Associated Cause</label>
                                    <select name="cause_id" id="cause_id" class="custom-select rounded-2 @error('cause_id') is-invalid @enderror">
                                        <option value="">Select a cause</option>
                                        @foreach($causes as $cause)
                                            <option value="{{ $cause->id }}" {{ old('cause_id', $project->cause_id) == $cause->id ? 'selected' : '' }}>
                                                {{ $cause->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cause_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 form-group mb-4">
                                    <label for="status" class="font-weight-bold text-muted small uppercase">Current Status</label>
                                    <select name="status" id="status" class="custom-select rounded-2">
                                        <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="paused" {{ old('status', $project->status) == 'paused' ? 'selected' : '' }}>Paused</option>
                                        <option value="cancelled" {{ old('status', $project->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="myeditorinstance" class="font-weight-bold text-muted small uppercase">Full Project Description</label>
                                <textarea name="description" id="myeditorinstance" rows="10"
                                    class="form-control rounded-2 @error('description') is-invalid @enderror">{{ old('description', $project->description) }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary">Media & Documents</h5>
                        </div>
                        <div class="card-body">
                            <label class="font-weight-bold mb-2">Upload Project Documents</label>
                            <div class="custom-file mb-3">
                                <input type="file" name="documents[]" id="documents" class="custom-file-input" multiple
                                       @change="documents = Array.from($event.target.files)">
                                <label class="custom-file-label" for="documents">Choose files...</label>
                            </div>

                            <div x-show="documents.length > 0" class="mb-4">
                                <p class="small text-primary font-weight-bold mb-2">Files to be uploaded:</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <template x-for="(file, index) in documents" :key="index">
                                        <span class="badge badge-info p-2 mr-2 mb-2">
                                            <i class="fas fa-file-upload mr-1"></i> <span x-text="file.name"></span>
                                        </span>
                                    </template>
                                </div>
                            </div>

                            @if($project->documents && $project->documents->count())
                                <p class="small text-muted font-weight-bold mb-2 uppercase">Currently Stored Files:</p>
                                <div class="list-group list-group-flush border rounded">
                                    @foreach($project->documents as $doc)
                                        <div class="list-group-item d-flex justify-content-between align-items-center bg-light-50">
                                            <div>
                                                <i class="far fa-file-alt text-primary mr-2"></i>
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-dark">{{ basename($doc->file_path) }}</a>
                                            </div>
                                            <span class="badge badge-secondary badge-pill uppercase">{{ $doc->file_extension }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary">Display Image</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="img-fluid rounded shadow-sm border" style="width: 100%; height: 200px; object-fit: cover;">
                                </template>
                                <template x-if="!photoPreview && currentPhoto">
                                    <img :src="currentPhoto" class="img-fluid rounded shadow-sm border" style="width: 100%; height: 200px; object-fit: cover;">
                                </template>
                                <template x-if="!photoPreview && !currentPhoto">
                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center" style="width: 100%; height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted opacity-20"></i>
                                    </div>
                                </template>
                            </div>
                            <div class="custom-file text-left">
                                <input type="file" name="photo" id="photo" class="custom-file-input" accept="image/*"
                                       @change="photoPreview = URL.createObjectURL($event.target.files[0])">
                                <label class="custom-file-label" for="photo">Update Photo</label>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary">Metrics & Timeline</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold small">Budget (RWF)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">₣</span></div>
                                    <input type="number" name="budget" value="{{ old('budget', $project->budget) }}" class="form-control font-weight-bold text-success">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold small d-flex justify-content-between">
                                    <span>Progress</span>
                                    <span class="text-primary" id="progressLabel">{{ old('progress', $project->progress) }}%</span>
                                </label>
                                <input type="range" name="progress" class="custom-range" min="0" max="100" 
                                       value="{{ old('progress', $project->progress) }}"
                                       oninput="document.getElementById('progressLabel').innerText = this.value + '%'">
                            </div>

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold uppercase text-muted">Timeline</label>
                                <input type="date" name="start_date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}" class="form-control mb-2" placeholder="Start Date">
                                <input type="date" name="end_date" value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}" class="form-control" placeholder="End Date">
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm mb-2">
                                <i class="fas fa-save mr-1"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-link btn-block text-muted small">Discard Changes</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<style>
    .bg-light-50 { background-color: rgba(0,0,0,0.02); }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .custom-range::-webkit-slider-thumb { background: #631084; }
    .custom-range::-moz-range-thumb { background: #631084; }
    .custom-range::-ms-thumb { background: #631084; }
    .border-2 { border-width: 2px !important; }
    .form-control:focus { border-color: #631084; box-shadow: none; }
</style>
@endsection