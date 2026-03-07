@extends('admin.layouts.app')
@section('title', 'Projects')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-project-diagram mr-2 text-primary"></i>Project Management
                </h1>
                <p class="text-muted small mb-0">Manage and track the progress of all HFRO initiatives.</p>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.projects.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-plus-circle mr-1"></i> New Project
                </a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="border-0 pl-4">Project Details</th>
                                <th class="border-0">Cause</th>
                                <th class="border-0 text-center">Budget</th>
                                <th class="border-0">Progress</th>
                                <th class="border-0">Status</th>
                                <th class="border-0 text-right pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td class="pl-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                @if($project->project_photo)
                                                    <img src="{{ asset('storage/' . $project->project_photo->file_path) }}" 
                                                         alt="" class="rounded shadow-sm" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #fff;">
                                                @else
                                                    <div class="rounded bg-light d-flex align-items-center justify-content-center shadow-sm" 
                                                         style="width: 50px; height: 50px; border: 2px solid #fff;">
                                                        <i class="fas fa-image text-muted opacity-50"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark mb-0">{{ $project->title }}</div>
                                                <div class="small text-muted">
                                                    <i class="far fa-calendar-alt mr-1"></i> 
                                                    {{ $project->start_date?->format('M d') ?? 'N/A' }} - {{ $project->end_date?->format('M d, Y') ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light px-3 py-2 text-muted border">
                                            {{ $project->cause?->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="text-center font-weight-bold text-secondary">
                                        {{ $project->budget ? 'RWF ' . number_format($project->budget) : '-' }}
                                    </td>
                                    <td style="min-width: 150px;">
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-xxs flex-grow-1 mr-2" style="height: 6px; border-radius: 10px;">
                                                <div class="progress-bar {{ $project->progress == 100 ? 'bg-success' : 'bg-primary' }} {{ $project->progress < 100 && $project->progress > 0 ? 'progress-bar-animated progress-bar-striped' : '' }}" 
                                                     role="progressbar" style="width: {{ $project->progress }}%;"></div>
                                            </div>
                                            <span class="small font-weight-bold">{{ $project->progress }}%</span>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match(strtolower($project->status)) {
                                                'completed' => 'badge-success',
                                                'active' => 'badge-primary',
                                                'pending' => 'badge-warning',
                                                'on hold' => 'badge-danger',
                                                default => 'badge-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }} px-2 py-1 small shadow-none">
                                            <i class="fas fa-circle mr-1" style="font-size: 8px;"></i> {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td class="text-right pr-4">
                                        <div class="btn-group shadow-sm">
                                            <a href="{{ route('admin.projects.edit', $project->id) }}" 
                                               class="btn btn-white btn-sm border" title="Edit">
                                                <i class="fas fa-pencil-alt text-primary"></i>
                                            </a>
                                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" 
                                                  class="d-inline" onsubmit="return confirm('Archive this project?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-white btn-sm border" title="Delete">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 bg-white">
                                        <img src="https://illustrations.popsy.co/gray/not-found.svg" style="width: 150px;" class="mb-3 opacity-50">
                                        <h5 class="text-muted">No projects found.</h5>
                                        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm mt-2 px-4">Create your first project</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($projects->hasPages())
                <div class="card-footer bg-white border-0">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .table td, .table th { vertical-align: middle; }
    .btn-white { background: #fff; }
    .btn-white:hover { background: #f8f9fa; }
    .progress-xxs { background-color: #e9ecef; }
    .badge { font-weight: 500; letter-spacing: 0.3px; }
    /* Soft colors for status badges */
    .badge-success { background-color: #d1e7dd !important; color: #0f5132 !important; }
    .badge-primary { background-color: #cfe2ff !important; color: #084298 !important; }
    .badge-warning { background-color: #fff3cd !important; color: #664d03 !important; }
    .badge-danger { background-color: #f8d7da !important; color: #842029 !important; }
</style>
@endsection