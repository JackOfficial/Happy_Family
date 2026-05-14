@extends('admin.layouts.app')

@section('title')
<title>Edit Category | Admin Dashboard</title>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-jost">Edit Job Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.job-categories.index') }}" class="btn btn-outline-secondary font-inter">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- Alpine Component for real-time Icon preview -->
                <div class="card shadow-sm border-0" x-data="{ iconClass: '{{ old('icon', $category->icon) }}' }">
                    <div class="card-body font-inter">
                        <form action="{{ route('admin.job-categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $category->name) }}" 
                                       required>
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="icon">FontAwesome Icon Class</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">
                                            <!-- Preview changes instantly via Alpine binding -->
                                            <i :class="iconClass ? iconClass : 'fas fa-folder'"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="icon" 
                                           class="form-control @error('icon') is-invalid @enderror" 
                                           x-model="iconClass"
                                           placeholder="e.g. fas fa-code">
                                </div>
                                <small class="text-muted">Example: <code>fas fa-briefcase</code> or <code>fas fa-heartbeat</code></small>
                                @error('icon') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description (Optional)</label>
                                <textarea name="description" rows="4" 
                                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
                                @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary font-jost px-4">
                                    <i class="fas fa-save mr-1"></i> Update Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Stats/Info Sidebar -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body font-inter text-center">
                        <h5 class="text-muted mb-3">Category Usage</h5>
                        <div class="display-4 font-jost text-primary">{{ $category->jobs_count ?? $category->jobs()->count() }}</div>
                        <p class="mb-0">Active Vacancies</p>
                    </div>
                </div>
                
                @if($category->jobs_count > 0)
                <div class="alert alert-warning border-0 shadow-sm mt-3 font-inter">
                    <i class="fas fa-exclamation-triangle"></i> This category is currently linked to live jobs. Changes will reflect immediately on the frontend.
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
</style>
@endpush