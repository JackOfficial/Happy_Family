@extends('admin.layouts.app')

@section('title')
<title>Job Vacancies | Admin Dashboard</title>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-jost">Manage Job Vacancies</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary font-inter">
                    <i class="fas fa-plus-circle"></i> Post New Job
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 font-inter">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-top-0">Job Title</th>
                                <th class="border-top-0">Category</th>
                                <th class="border-top-0">Type</th>
                                <th class="border-top-0 text-center">Applications</th>
                                <th class="border-top-0">Status</th>
                                <th class="border-top-0">Deadline</th>
                                <th class="border-top-0 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $job)
                            <tr>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $job->title }}</div>
                                    <small class="text-muted"><i class="fas fa-map-marker-alt mr-1"></i> {{ $job->location }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-outline-secondary border">
                                        <i class="{{ $job->category->icon ?? 'fas fa-tag' }} mr-1"></i>
                                        {{ $job->category->name }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $typeBadge = [
                                            'Full-time' => 'badge-primary',
                                            'Part-time' => 'badge-info',
                                            'Contract' => 'badge-warning',
                                            'Volunteer' => 'badge-success',
                                            'Internship' => 'badge-secondary'
                                        ][$job->type] ?? 'badge-light';
                                    @endphp
                                    <span class="badge {{ $typeBadge }}">{{ $job->type }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="badge badge-pill badge-light border px-3">
                                        {{ $job->applications_count }}
                                    </a>
                                </td>
                                <td>
                                    @if($job->is_active)
                                        <span class="text-success"><i class="fas fa-check-circle"></i> Active</span>
                                    @else
                                        <span class="text-muted"><i class="fas fa-times-circle"></i> Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($job->deadline)
                                        <span class="{{ \Carbon\Carbon::parse($job->deadline)->isPast() ? 'text-danger font-weight-bold' : '' }}">
                                            {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted">No Deadline</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-sm btn-outline-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Archive this job vacancy?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Archive">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-briefcase fa-3x mb-3 d-block"></i>
                                    No job vacancies found. Start by posting a new one.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($jobs->hasPages())
            <div class="card-footer bg-white border-top-0">
                <div class="d-flex justify-content-center">
                    {{ $jobs->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    .table td { vertical-align: middle; }
    .badge-outline-secondary { color: #6c757d; background-color: transparent; }
</style>
@endpush