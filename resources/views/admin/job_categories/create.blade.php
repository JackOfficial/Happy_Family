@extends('admin.layouts.app')

@section('title')
<title>Post New Job | Admin Dashboard</title>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-jost">Post a New Vacancy</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary font-inter">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content" x-data="{ jobType: '{{ old('type', 'Full-time') }}', isActive: true }">
    <div class="container-fluid">
        <form action="{{ route('admin.jobs.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Main Details -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body font-inter">
                            <div class="form-group">
                                <label for="title">Job Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. Senior Project Manager">
                                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Job Description <span class="text-danger">*</span></label>
                                <div x-init="initSummernote($el)">
                                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="requirements">Requirements</label>
                                <div x-init="initSummernote($el)">
                                    <textarea name="requirements" class="form-control">{{ old('requirements') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Settings -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white"><h3 class="card-title font-jost fw-bold">Job Settings</h3></div>
                        <div class="card-body font-inter">
                            <div class="form-group">
                                <label>Category <span class="text-danger">*</span></label>
                                <select name="job_category_id" class="form-control @error('job_category_id') is-invalid @enderror">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('job_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Job Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-control" x-model="jobType">
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Internship">Internship</option>
                                    <option value="Volunteer">Volunteer</option>
                                </select>
                            </div>

                            <!-- Alpine Dynamic Notice for Volunteers -->
                            <div x-show="jobType === 'Volunteer'" x-transition class="alert alert-info py-2 small">
                                <i class="fas fa-info-circle mr-1"></i> This will be listed under community support roles.
                            </div>

                            <div class="form-group">
                                <label>Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control" value="Kigali, Rwanda" placeholder="e.g. Kigali, Rwanda">
                            </div>

                            <div class="form-group">
                                <label>Deadline <span class="text-danger">*</span></label>
                                <input type="date" name="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}">
                            </div>

                            <div class="form-group mt-4">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="is_active" class="custom-control-input" id="isActiveSwitch" x-model="isActive" :checked="isActive">
                                    <label class="custom-control-label" for="isActiveSwitch" x-text="isActive ? 'Publish Immediately' : 'Save as Draft'"></label>
                                </div>
                            </div>

                            <hr>
                            
                            <button type="submit" class="btn btn-primary btn-block py-2 font-jost fw-bold shadow-sm">
                                <i class="fas fa-paper-plane mr-1"></i> Post Job
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    .note-editor { border-radius: 5px; border: 1px solid #ced4da !important; }
    [x-cloak] { display: none !important; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    // Global function to initialize summernote via Alpine x-init
    function initSummernote(el) {
        $(el).find('textarea').summernote({
            placeholder: 'Type details here...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']]
            ],
            callbacks: {
                // Ensure Livewire/Alpine can see changes if needed later
                onChange: function(contents, $editable) {
                    el.querySelector('textarea').value = contents;
                }
            }
        });
    }
</script>
@endpush