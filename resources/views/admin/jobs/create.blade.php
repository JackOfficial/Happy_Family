@extends('admin.layouts.app')

@section('title')
<title>Post New Job | Admin Dashboard</title>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-jost">Post New Job Vacancy</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary font-inter">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.jobs.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Main Content Column -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body font-inter">
                            <div class="form-group">
                                <label for="title">Job Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="e.g. Senior Social Worker" value="{{ old('title') }}" required>
                                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Job Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="summernote_description" class="summernote @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="requirements">Requirements</label>
                                        <textarea name="requirements" id="summernote_requirements" class="summernote">{{ old('requirements') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="benefits">Benefits</label>
                                        <textarea name="benefits" id="summernote_benefits" class="summernote">{{ old('benefits') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings Sidebar -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white font-jost">
                            <h5 class="mb-0">Job Settings</h5>
                        </div>
                        <div class="card-body font-inter">
                            <div class="form-group">
                                <label for="job_category_id">Category <span class="text-danger">*</span></label>
                                <select name="job_category_id" class="form-control @error('job_category_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('job_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="type">Employment Type</label>
                                <select name="type" class="form-control">
                                    @foreach(['Full-time', 'Part-time', 'Contract', 'Volunteer', 'Internship'] as $type)
                                        <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location', 'Kigali, Rwanda') }}">
                            </div>

                            <div class="form-group">
                                <label for="deadline">Application Deadline</label>
                                <input type="datetime-local" name="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}">
                                @error('deadline') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <hr>

                            <div class="form-group d-flex align-items-center" x-data="{ active: true }">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="is_active" class="custom-control-input" id="isActive" x-model="active" checked>
                                    <label class="custom-control-label" for="isActive">Set as Active</label>
                                </div>
                                <span class="ml-auto badge" :class="active ? 'badge-success' : 'badge-secondary'" x-text="active ? 'Visible' : 'Draft'"></span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block font-jost py-2 mt-3 shadow-sm">
                                <i class="fas fa-paper-plane mr-1"></i> Publish Vacancy
                            </button>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 shadow-sm mt-3 font-inter">
                        <small>
                            <i class="fas fa-info-circle mr-1"></i> 
                            Once published, this job will appear on the public careers page of <strong>happyfamilyrwanda.org</strong>.
                        </small>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    .card-header { border-bottom: 1px solid #f4f4f4; }
    .note-editor.note-frame { border: 1px solid #ced4da; box-shadow: none; border-radius: 0.25rem; }
</style>
@endpush

@push('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Enter detailed information here...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush