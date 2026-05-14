@extends('admin.layouts.app')

@section('title')
<title>Applications | Admin Dashboard</title>
@endsection

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-jost">Job Applications</h1>
                <p class="text-muted font-inter small">Review and manage candidate submissions for open vacancies.</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right font-inter">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
                    <div class="card-header bg-white py-3">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <h3 class="card-title font-jost fw-bold m-0">Recent Submissions</h3>
                            </div>
                            <div class="col-md-8">
                                <form action="{{ route('admin.applications.index') }}" method="GET" class="form-inline justify-content-md-end">
                                    <!-- Status Filter -->
                                    <select name="status" class="form-control form-control-sm mr-2 font-inter" onchange="this.form.submit()">
                                        <option value="">All Statuses</option>
                                        @foreach(['pending', 'shortlisted', 'interview', 'accepted', 'rejected'] as $status)
                                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <!-- Search -->
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <input type="text" name="search" class="form-control float-right font-inter" 
                                               placeholder="Name, email or ID..." value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    @if(request()->has('search') || request()->has('status'))
                                        <a href="{{ route('admin.applications.index') }}" class="ml-2 btn btn-sm btn-outline-secondary">Clear</a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Table Body -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap font-inter mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-top-0">ID</th>
                                    <th class="border-top-0">Candidate Details</th>
                                    <th class="border-top-0">Applied For</th>
                                    <th class="border-top-0">Origin</th>
                                    <th class="border-top-0">Current Status</th>
                                    <th class="border-top-0">Submission Date</th>
                                    <th class="border-top-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $application)
                                <tr>
                                    <td class="text-muted font-weight-light small">#{{ $application->id }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="font-weight-bold text-dark">{{ $application->full_name }}</span>
                                            <span class="small text-muted">
                                                <i class="fas fa-envelope mr-1 text-xs"></i> {{ $application->email }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-outline-secondary border font-weight-normal">
                                            {{ $application->job->title ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="small font-weight-bold">{{ $application->country->name ?? 'N/A' }}</span>
                                    </td>
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
                                        <span class="badge {{ $badgeClass }} px-3 py-2 text-uppercase" style="font-size: 10px;">
                                            {{ $application->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="small text-dark">{{ $application->created_at->format('d M, Y') }}</span>
                                        <small class="d-block text-muted text-xs">{{ $application->created_at->format('H:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.applications.show', $application->id) }}" 
                                               class="btn btn-sm btn-white border shadow-sm" title="View Application Details">
                                                <i class="fas fa-eye text-info"></i> View
                                            </a>
                                            
                                            <form action="{{ route('admin.applications.destroy', $application->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Archive this application? This will not notify the candidate.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-white border shadow-sm ml-1" title="Archive">
                                                    <i class="fas fa-archive text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state py-4">
                                            <i class="fas fa-folder-open fa-4x text-light mb-3"></i>
                                            <h5 class="text-muted">No applications found</h5>
                                            <p class="text-muted small">Try adjusting your filters or search terms.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($applications->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted font-inter">
                                Showing {{ $applications->firstItem() }} to {{ $applications->lastItem() }} of {{ $applications->total() }} applications
                            </span>
                            <div class="pagination-sm">
                                {{ $applications->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    .table td { vertical-align: middle; }
    .badge { font-weight: 600; letter-spacing: 0.5px; border-radius: 4px; }
    .badge-outline-secondary { color: #6c757d; background-color: transparent; }
    .text-xs { font-size: 0.75rem; }
    .btn-white { background-color: #fff; color: #444; }
    .btn-white:hover { background-color: #f8f9fa; }
</style>
@endpush