@extends('admin.layouts.app')

@section('title', 'Project Details - ' . $project->title)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-eye mr-2 text-primary"></i>Project Overview
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary rounded-pill px-4 mr-2">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-edit mr-1"></i> Edit Project
                </a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="info-box shadow-sm border-0">
                    <span class="info-box-icon bg-primary-gradient"><i class="fas fa-tasks"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted small text-uppercase font-weight-bold">Status</span>
                        <span class="info-box-number text-primary">{{ $project->status }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box shadow-sm border-0">
                    <span class="info-box-icon bg-success-gradient"><i class="fas fa-chart-line"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted small text-uppercase font-weight-bold">Progress</span>
                        <span class="info-box-number text-success">{{ $project->progress }}%</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box shadow-sm border-0">
                    <span class="info-box-icon bg-info-gradient"><i class="fas fa-wallet"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted small text-uppercase font-weight-bold">Budget</span>
                        <span class="info-box-number text-info">RWF {{ number_format($project->budget) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box shadow-sm border-0">
                    <span class="info-box-icon bg-warning-gradient"><i class="fas fa-calendar-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted small text-uppercase font-weight-bold">Duration</span>
                        <span class="info-box-number text-warning">{{ $project->duration ?? 'Ongoing' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h2 class="font-weight-bold text-dark mb-3">{{ $project->title }}</h2>
                        
                        <div class="mb-4">
                            @foreach($project->causes as $cause)
                                <span class="badge badge-light border px-3 py-2 mr-1">
                                    <i class="fas fa-tag mr-1 text-primary"></i> {{ $cause->name }}
                                </span>
                            @endforeach
                        </div>

                        <hr>

                        <div class="project-description text-secondary" style="line-height: 1.8;">
                            {!! $project->description !!}
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="card-title font-weight-bold mb-0 small text-uppercase">Project Gallery</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($project->project_photos as $photo)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ asset('storage/' . $photo->file_path) }}" target="_blank">
                                        <div class="img-container rounded shadow-sm">
                                            <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                                 class="img-fluid rounded" 
                                                 style="height: 180px; width: 100%; object-fit: cover;">
                                            @if($photo->is_featured)
                                                <div class="badge-featured">Featured</div>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="col-12 text-center py-4">
                                    <p class="text-muted">No photos available for this project.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title font-weight-bold mb-0 small text-uppercase">Execution Details</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="text-muted"><i class="far fa-calendar-alt mr-2"></i> Start Date</span>
                                <span class="font-weight-bold">{{ $project->start_date ? $project->start_date->format('M d, Y') : 'Not Set' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="text-muted"><i class="fas fa-hourglass-half mr-2"></i> Estimated Duration</span>
                                <span class="font-weight-bold">{{ $project->duration }}</span>
                            </li>
                            <li class="list-group-item py-3">
                                <span class="text-muted d-block mb-2"><i class="fas fa-spinner mr-2"></i> Real-time Progress</span>
                                <div class="progress progress-sm" style="height: 10px; border-radius: 5px;">
                                    <div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: {{ $project->progress }}%"></div>
                                </div>
                                <small class="text-right d-block mt-1 font-weight-bold">{{ $project->progress }}% Complete</small>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="card-title font-weight-bold mb-0 small text-uppercase">Attached Documents</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($project->documents->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($project->documents as $doc)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <i class="far fa-file-pdf fa-2x text-danger mr-3"></i>
                                        <div>
                                            <div class="text-dark font-weight-bold mb-0 text-truncate" style="max-width: 200px;">{{ $doc->title }}</div>
                                            <small class="text-muted">Click to view/download</small>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 text-center">
                                <i class="fas fa-folder-open text-muted mb-2"></i>
                                <p class="small text-muted mb-0">No documents attached.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .bg-primary-gradient { background: linear-gradient(45deg, #007bff, #00c6ff); color: white; }
    .bg-success-gradient { background: linear-gradient(45deg, #28a745, #5ddc7a); color: white; }
    .bg-info-gradient { background: linear-gradient(45deg, #17a2b8, #36d1dc); color: white; }
    .bg-warning-gradient { background: linear-gradient(45deg, #ffc107, #f8d05a); color: white; }
    
    .img-container { position: relative; overflow: hidden; transition: 0.3s; }
    .img-container:hover { transform: translateY(-5px); }
    
    .badge-featured {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255, 193, 7, 0.9);
        color: #000;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .project-description img { max-width: 100%; border-radius: 8px; }
</style>
@endsection