@extends('admin.layouts.app')

@section('title', 'All Weekly Reports')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Weekly Reports Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Reports</li>
                </ol>
            </div>
        </div>
    </div>

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">All Staff Submissions</h3>
                    <div class="card-tools">
                        <!-- Search or Filter could go here -->
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Staff Member</th>
                                <th>Category (Reportable)</th>
                                <th>Status</th>
                                <th>PDF</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                            <tr>
                                <td>{{ $report->report_date->format('M d, Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($report->user->name) }}&background=random" class="img-circle elevation-1" width="30">
                                        </div>
                                        <span>{{ $report->user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $badgeColor = match($report->reportable_type) {
                                            'project' => 'badge-info',
                                            'dept' => 'badge-success',
                                            'it_task' => 'badge-warning',
                                            default => 'badge-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeColor }}">
                                        <i class="fas fa-tag mr-1"></i> 
                                        {{ ucfirst($report->reportable_type) }}: 
                                        {{ $report->reportable->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-success"><i class="fas fa-check-circle"></i> Emailed</span>
                                </td>
                                <td>
                                    @if($report->pdf_file)
                                        <a href="{{ asset('storage/reports/' . $report->pdf_file) }}" target="_blank" class="text-danger">
                                            <i class="fas fa-file-pdf fa-lg"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">No file</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-default" title="View Details" 
                                            data-toggle="modal" data-target="#reportModal{{ $report->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No reports have been submitted yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

@foreach($reports as $report)
    <!-- Simple Modal for Viewing Details -->
    <div class="modal fade" id="reportModal{{ $report->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Report Detail: {{ $report->user->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <strong><i class="fas fa-tasks mr-1"></i> Completed Tasks</strong>
                    <p class="text-muted">{{ $report->tasks_completed }}</p>
                    <hr>
                    <strong><i class="fas fa-forward mr-1"></i> Upcoming Tasks</strong>
                    <p class="text-muted">{{ $report->upcoming_tasks }}</p>
                    <hr>
                    <strong><i class="fas fa-exclamation-triangle mr-1"></i> Challenges</strong>
                    <p class="text-muted">{{ $report->challenges ?? 'None reported.' }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection

@push('styles')
    {{-- Integrate your Happy Family Rwanda custom CSS here if needed --}}
    <style>
        .table td { vertical-align: middle; }
    </style>
@endpush

@push('scripts')
    <script>
        console.log('Reports Loaded Successfully');
    </script>
@endpush