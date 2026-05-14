@extends('admin.layouts.app')

@section('title')
<title>Edit Vacancy | {{ $job->title }}</title>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-jost text-dark">Edit Job Vacancy</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary font-inter">
                    <i class="fas fa-times"></i> Cancel Changes
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Main Content Column -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body font-inter">
                            <div class="form-group">
                                <label for="title">Job Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                       value="{{ old('title', $job->title) }}" required>
                                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Job Description <span class="text-danger">*</span></label>
                                <textarea name="description" rows="12" class="form-control @error('description') is-invalid @enderror" 
                                          required>{{ old('description', $job->description) }}</textarea>
                                @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="requirements">Requirements</label>
                                        <textarea name="requirements" rows="6" class="form-control">{{ old('requirements', $job->requirements) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="benefits">Benefits</label>
                                        <textarea name="benefits" rows="6" class="form-control">{{ old('benefits', $job->benefits) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings Sidebar -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0" x-data="{ active: {{ $job->is_active ? 'true' : 'false' }} }">
                        <div class="card-header bg-white font-jost border-bottom-0">
                            <h5 class="mb-0">Publishing Settings</h5>
                        </div>
                        <div class="card-body font-inter pt-0">
                            <div class="form-group">
                                <label for="job_category_id">Category</label>
                                <select name="job_category_id" class="form-control @error('job_category_id') is-invalid @enderror" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('job_category_id', $job->job_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="type">Employment Type</label>
                                <select name="type" class="form-control">
                                    @foreach(['Full-time', 'Part-time', 'Contract', 'Volunteer', 'Internship'] as $type)
                                        <option value="{{ $type }}" {{ old('type', $job->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location', $job->location) }}">
                            </div>

                            <div class="form-group">
                                <label for="deadline">Application Deadline</label>
                                <input type="datetime-local" name="deadline" class="form-control @error('deadline') is-invalid @enderror" 
                                       value="{{ old('deadline', optional($job->deadline)->format('Y-m-d\TH:i')) }}">
                                @error('deadline') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <hr>

                            <div class="form-group d-flex align-items-center">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="is_active" class="custom-control-input" id="isActive" x-model="active" {{ $job->is_active ? 'checked' : '' }}>
                                    <label class="custom-control-label text-sm" for="isActive">Active Status</label>
                                </div>
                                <span class="ml-auto badge" :class="active ? 'badge-success' : 'badge-secondary'" x-text="active ? 'Visible' : 'Draft'"></span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block font-jost py-2 mt-3 shadow-sm">
                                <i class="fas fa-sync-alt mr-1"></i> Update Vacancy
                            </button>
                        </div>
                        <div class="card-footer bg-light border-top-0 py-3">
                            <small class="text-muted d-block font-inter">
                                <strong>Posted:</strong> {{ $job->created_at->format('d M, Y \a\t H:i') }}
                            </small>
                            <small class="text-muted d-block font-inter mt-1">
                                <strong>Last Update:</strong> {{ $job->updated_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>

                    <!-- Slug Preview Info -->
                    <div class="card shadow-sm border-0 mt-3">
                        <div class="card-body py-2">
                            <small class="text-muted">
                                <i class="fas fa-link mr-1"></i> <strong>Current URL Slug:</strong><br>
                                <span class="text-break">happyfamilyrwanda.org/careers/{{ $job->slug }}</span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('styles')
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    .form-control:focus { border-color: #007bff; box-shadow: none; }
    .form-control-lg { font-size: 1.25rem; font-weight: 600; }
</style>
@endpush