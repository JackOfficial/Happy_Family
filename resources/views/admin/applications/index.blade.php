@extends('admin.layouts.app')

@section('title')
<title>Applications | Admin Dashboard</title>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-jost">Job Applications</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right font-inter">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item active">Applications</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-jost fw-bold">Recent Submissions</h3>
                        <div class="card-tools">
                            <form action="{{ route('admin.applications.index') }}" method="GET" class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="Search applicant...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap font-inter">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Applicant Name</th>
                                    <th>Position</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <th>Applied On</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $application)
                                <tr>
                                    <td>#{{ $application->id }}</td>
                                    <td class="font-weight-bold">{{ $application->full_name }}</td>
                                    <td>
                                        <span class="text-muted small d-block">Position:</span>
                                        {{ $application->job->title ?? 'N/A' }}
                                    </td>
                                    <td>{{ $application->country->name ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $badgeClass = [
                                                'pending' => 'badge-warning',
                                                'shortlisted' => 'badge-info',
                                                'interview' => 'badge-primary',
                                                'accepted' => 'badge-success',
                                                'rejected' => 'badge-danger'
                                            ][$application->status] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} px-3 py-2">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $application->created_at->format('M d, Y') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.applications.show', $application->id) }}" 
                                               class="btn btn-sm btn-info shadow-sm" title="View Profile">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.applications.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Move this application to trash?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger shadow-sm ms-1">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <img src="{{ asset('adminlte/dist/img/no-data.svg') }}" style="height: 100px;" class="mb-3 opacity-50">
                                        <p class="text-muted">No applications found in the system.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer bg-white clearfix">
                        <div class="float-right">
                            {{ $applications->links() }}
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    .table td, .table th { vertical-align: middle; }
    .badge { font-weight: 500; letter-spacing: 0.3px; }
</style>
@endpush