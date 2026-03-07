@extends('admin.layouts.app')

@section('title', 'HFRO - Create Project')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-plus-circle mr-2 text-primary"></i>Create New Project
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
                    <li class="breadcrumb-item active">New</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content pb-5">
    <div class="container-fluid">
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" 
              x-data="{ photoPreview: null, documents: [] }">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary text-uppercase small">Project Essentials</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label for="title" class="font-weight-bold">Project Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title"
                                    class="form-control form-control-lg border-2 @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}" required placeholder="Enter a clear, descriptive name">
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-4">
                                    <label for="cause_id" class="font-weight-bold small uppercase text-muted">Mission Category</label>
                                    <select name="cause_id" id="cause_id" class="custom-select @error('cause_id') is-invalid @enderror">
                                        <option value="">Select an associated cause</option>
                                        @foreach($causes as $cause)
                                            <option value="{{ $cause->id }}" {{ old('cause_id') == $cause->id ? 'selected' : '' }}>
                                                {{ $cause->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cause_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 form-group mb-4">
                                    <label for="summary" class="font-weight-bold small uppercase text-muted">Tagline / Short Summary</label>
                                    <input type="text" name="summary" class="form-control @error('summary') is-invalid @enderror" 
                                           value="{{ old('summary') }}" placeholder="Brief one-sentence summary">
                                    @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="myeditorinstance" class="font-weight-bold small uppercase text-muted">In-Depth Description</label>
                                <textarea name="description" id="myeditorinstance" rows="12"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary text-uppercase small">Supporting Documents</h5>
                        </div>
                        <div class="card-body">
                            <div class="upload-zone p-4 border rounded text-center bg-light mb-3">
                                <i class="fas fa-file-pdf fa-2x text-muted mb-2"></i>
                                <p class="mb-2">Select any reports, PDFs, or spreadsheets</p>
                                <input type="file" name="documents[]" id="documents" class="d-none" multiple 
                                       @change="documents = Array.from($event.target.files)">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('documents').click()">
                                    Browse Files
                                </button>
                            </div>

                            <div x-show="documents.length > 0">
                                <ul class="list-group list-group-flush border rounded">
                                    <template x-for="(file, index) in documents" :key="index">
                                        <li class="list-group-item d-flex justify-content-between align-items-center bg-white">
                                            <span><i class="far fa-file mr-2 text-primary"></i> <span x-text="file.name"></span></span>
                                            <span class="badge badge-pill badge-light border" x-text="Math.round(file.size / 1024) + ' KB'"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary text-uppercase small">Featured Image</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 text-center">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="img-fluid rounded shadow-sm border mb-3" style="width: 100%; height: 200px; object-fit: cover;">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center mb-3" style="width: 100%; height: 200px;">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted opacity-25"></i>
                                    </div>
                                </template>
                                <div class="custom-file">
                                    <input type="file" name="photo" id="photo" class="custom-file-input" accept="image/*"
                                           @change="photoPreview = URL.createObjectURL($event.target.files[0])">
                                    <label class="custom-file-label text-left" for="photo">Choose image</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title font-weight-bold mb-0 text-secondary text-uppercase small">Project Logistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold">Current Status</label>
                                <select name="status" id="status" class="form-control border-primary">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="paused" {{ old('status') == 'paused' ? 'selected' : '' }}>Paused</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label class="small font-weight-bold d-flex justify-content-between">
                                    <span>Target Budget</span>
                                    <span class="text-muted">RWF</span>
                                </label>
                                <input type="number" name="budget" value="{{ old('budget') }}" class="form-control" placeholder="0.00">
                            </div>

                            <div class="form-group mb-4">
                                <label class="small font-weight-bold">Target Beneficiaries</label>
                                <input type="number" name="beneficiaries" value="{{ old('beneficiaries') }}" class="form-control" placeholder="Number of people">
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-6">
                                    <label class="small font-weight-bold">Start Date</label>
                                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control form-control-sm">
                                </div>
                                <div class="col-6">
                                    <label class="small font-weight-bold">End Date</label>
                                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 bg-primary">
                        <div class="card-body">
                            <button type="submit" class="btn btn-white btn-block btn-lg font-weight-bold text-primary shadow-sm mb-2">
                                <i class="fas fa-check-circle mr-1"></i> Create Project
                            </button>
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-block btn-link text-white-50 small">
                                Cancel and go back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<style>
    .border-2 { border-width: 2px !important; }
    .btn-white { background-color: #fff; border-color: #fff; }
    .btn-white:hover { background-color: #f8f9fa; }
    .custom-file-label::after { background-color: #631084; color: white; content: "Upload"; }
    .upload-zone { border: 2px dashed #dee2e6 !important; }
</style>
@endsection