@extends('admin.layouts.app')

@section('title')
<title>View Application | {{ $application->full_name }}</title>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-jost text-dark">Candidate Profile</h1>
                <p class="text-muted font-inter small mb-0">Managing application for <strong>{{ $application->job->title ?? 'General Role' }}</strong></p>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.applications.index') }}" class="btn btn-white border shadow-sm font-inter">
                    <i class="fas fa-chevron-left mr-1"></i> Back to Applications
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Left Sidebar: Profile Summary -->
            <div class="col-md-4">
                <div class="card card-primary card-outline shadow-sm border-0">
                    <div class="card-body box-profile">
                        <div class="text-center mb-3">
                            <div class="avatar-initials bg-soft-primary text-primary rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm">
                                <h2 class="m-0 font-jost fw-bold">{{ substr($application->first_name, 0, 1) }}{{ substr($application->last_name, 0, 1) }}</h2>
                            </div>
                        </div>

                        <h3 class="profile-username text-center font-jost fw-bold mb-0">{{ $application->full_name }}</h3>
                        <p class="text-muted text-center font-inter small mb-3">{{ $application->city }}, {{ $application->country->name }}</p>

                        <div class="text-center mb-4">
                            @php
                                $statusColors = [
                                    'pending' => 'badge-warning',
                                    'shortlisted' => 'badge-info',
                                    'interview' => 'badge-primary',
                                    'accepted' => 'badge-success',
                                    'rejected' => 'badge-danger'
                                ];
                                $currentStatusColor = $statusColors[$application->status] ?? 'badge-secondary';
                            @endphp
                            <span class="badge {{ $currentStatusColor }} px-4 py-2 text-uppercase letter-spacing-1">
                                {{ $application->status }}
                            </span>
                        </div>

                        <form action="{{ route('admin.applications.updateStatus', $application->id) }}" method="POST" class="bg-light p-3 rounded border">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mb-0">
                                <label class="small font-weight-bold text-uppercase text-muted">Move to Stage:</label>
                                <select name="status" class="form-control custom-select shadow-none" onchange="this.form.submit()">
                                    <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>🕒 Pending Review</option>
                                    <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>⭐ Shortlisted</option>
                                    <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>🎤 Interviewing</option>
                                    <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>✅ Hire Candidate</option>
                                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>❌ Reject Application</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Quick Actions -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white"><h3 class="card-title font-jost fw-bold">Contact Info</h3></div>
                    <div class="card-body font-inter p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center py-3">
                                <div class="icon-box bg-light mr-3"><i class="fas fa-envelope text-primary"></i></div>
                                <div>
                                    <small class="text-muted d-block">Email Address</small>
                                    <a href="mailto:{{ $application->email }}" class="text-dark font-weight-bold">{{ $application->email }}</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center py-3">
                                <div class="icon-box bg-light mr-3"><i class="fas fa-phone text-success"></i></div>
                                <div>
                                    <small class="text-muted d-block">Phone Number</small>
                                    <a href="tel:{{ $application->phone }}" class="text-dark font-weight-bold">{{ $application->phone }}</a>
                                </div>
                            </li>
                            @if($application->linkedin_url)
                            <li class="list-group-item d-flex align-items-center py-3">
                                <div class="icon-box bg-light mr-3"><i class="fab fa-linkedin text-info"></i></div>
                                <div>
                                    <small class="text-muted d-block">LinkedIn Profile</small>
                                    <a href="{{ $application->linkedin_url }}" target="_blank" class="text-primary font-weight-bold font-sm">View External Profile <i class="fas fa-external-link-alt ml-1 small"></i></a>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content: Professional Details -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header p-0 bg-white border-bottom">
                        <ul class="nav nav-tabs nav-fill font-jost fw-bold border-0" id="applicationTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active py-3 border-0" id="details-tab" data-toggle="tab" href="#details" role="tab">
                                    <i class="fas fa-user-tie mr-2"></i> Qualifications
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 border-0" id="documents-tab" data-toggle="tab" href="#documents" role="tab">
                                    <i class="fas fa-paperclip mr-2"></i> Documents ({{ $application->attachments->count() }})
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body font-inter">
                        <div class="tab-content">
                            <!-- Details Tab -->
                            <div class="tab-pane fade show active" id="details" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <h6 class="text-uppercase text-muted font-weight-bold small mb-3">Education Background</h6>
                                        <div class="p-3 bg-light rounded shadow-xs">
                                            <p class="mb-1"><strong>{{ $application->level_of_education }}</strong></p>
                                            <p class="text-muted mb-0 small">{{ $application->field_of_study }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <h6 class="text-uppercase text-muted font-weight-bold small mb-3">Experience & Salary</h6>
                                        <div class="p-3 bg-light rounded shadow-xs">
                                            <p class="mb-1"><strong>{{ $application->years_of_experience }} Years</strong> Experience</p>
                                            <p class="text-muted mb-0 small">Expected: {{ $application->currency }} {{ number_format($application->desired_salary, 0) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="text-uppercase text-muted font-weight-bold small mb-3">Notice Period</h6>
                                    <p class="badge badge-light border px-3 py-2 text-dark">{{ $application->notice_period }}</p>
                                </div>

                                <div class="mb-0">
                                    <h6 class="text-uppercase text-muted font-weight-bold small mb-3">Applicant's Cover Note</h6>
                                    <div class="p-3 bg-soft-light rounded border-left border-primary" style="background-color: #fcfcfc;">
                                        <p class="text-dark mb-0" style="line-height: 1.6;">
                                            {{ $application->additional_notes ?? 'Candidate did not provide additional notes.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Documents Tab -->
                            <div class="tab-pane fade" id="documents" role="tabpanel">
                                <div class="row">
                                    @forelse($application->attachments as $file)
                                    <div class="col-sm-6 mb-3">
                                        <div class="attachment-item d-flex align-items-center p-3 border rounded">
                                            <div class="file-icon mr-3">
                                                @if(Str::endsWith($file->file_name, '.pdf'))
                                                    <i class="far fa-file-pdf fa-2x text-danger"></i>
                                                @else
                                                    <i class="far fa-file-word fa-2x text-primary"></i>
                                                @endif
                                            </div>
                                            <div class="file-info overflow-hidden">
                                                <span class="d-block text-truncate font-weight-bold small">{{ $file->file_name }}</span>
                                                <a href="{{ route('admin.attachments.download', $file->id) }}" class="text-primary small">
                                                    <i class="fas fa-download mr-1"></i> Download File
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-12 text-center py-5">
                                        <i class="fas fa-folder-open fa-3x text-light mb-3"></i>
                                        <p class="text-muted">No attachments available for this profile.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
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
    .fw-bold { font-weight: 700; }
    .bg-soft-primary { background-color: #e7f1ff; }
    .avatar-initials { width: 80px; height: 80px; font-size: 1.5rem; }
    .icon-box { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; }
    .nav-tabs .nav-link.active { color: #007bff; border-bottom: 2px solid #007bff !important; background: transparent; }
    .letter-spacing-1 { letter-spacing: 1px; font-size: 0.7rem; font-weight: 800; }
    .btn-white { background: #fff; color: #333; }
    .attachment-item:hover { background-color: #f8f9fa; border-color: #dee2e6; }
    .bg-soft-light { background-color: #f9f9f9; }
</style>
@endpush