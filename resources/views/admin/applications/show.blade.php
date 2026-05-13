@extends('admin.layouts.app')

@section('title')
<title>View Application | {{ $application->full_name }}</title>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-jost">Candidate Profile</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-secondary font-inter">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar: Candidate Summary & Status -->
            <div class="col-md-4">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-body box-profile">
                        <div class="text-center mb-3">
                            <div class="bg-light rounded-circle d-inline-block p-4">
                                <h2 class="m-0 text-primary fw-bold font-jost">{{ substr($application->first_name, 0, 1) }}{{ substr($application->last_name, 0, 1) }}</h2>
                            </div>
                        </div>

                        <h3 class="profile-username text-center font-jost fw-bold">{{ $application->full_name }}</h3>
                        <p class="text-muted text-center font-inter">{{ $application->job->title ?? 'General Applicant' }}</p>

                        <ul class="list-group list-group-unbordered mb-3 font-inter">
                            <li class="list-group-item border-0">
                                <b>Status</b> 
                                <span class="float-right badge @if($application->status == 'pending') badge-warning @elseif($application->status == 'rejected') badge-danger @else badge-success @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </li>
                            <li class="list-group-item border-0">
                                <b>Location</b> <span class="float-right text-muted">{{ $application->city }}, {{ $application->country->name }}</span>
                            </li>
                            <li class="list-group-item border-0">
                                <b>Applied</b> <span class="float-right text-muted">{{ $application->created_at->format('d M, Y') }}</span>
                            </li>
                        </ul>

                        <form action="{{ route('admin.applications.updateStatus', $application->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label class="small font-weight-bold">Update Pipeline Status:</label>
                                <select name="status" class="form-control form-control-sm mb-2" onchange="this.form.submit()">
                                    <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending Review</option>
                                    <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                    <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Interviewing</option>
                                    <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted / Hired</option>
                                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Info Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white"><h3 class="card-title font-jost fw-bold">Contact Details</h3></div>
                    <div class="card-body font-inter">
                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                        <p class="text-muted">{{ $application->email }}</p>
                        <hr>
                        <strong><i class="fas fa-phone mr-1"></i> Phone</strong>
                        <p class="text-muted">{{ $application->phone }}</p>
                        <hr>
                        <strong><i class="fab fa-linkedin mr-1"></i> LinkedIn</strong>
                        <p class="text-muted">
                            @if($application->linkedin_url)
                                <a href="{{ $application->linkedin_url }}" target="_blank">View Profile</a>
                            @else N/A @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Content: Experience & Documents -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header p-2 bg-white">
                        <ul class="nav nav-pills font-jost fw-bold">
                            <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab">Experience & Education</a></li>
                            <li class="nav-item"><a class="nav-link" href="#documents" data-toggle="tab">Attachments ({{ $application->attachments->count() }})</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Details Tab -->
                            <div class="active tab-pane" id="details">
                                <h5 class="text-primary font-jost fw-bold"><i class="fas fa-graduation-cap"></i> Education</h5>
                                <p class="mb-1"><strong>Level:</strong> {{ $application->level_of_education }}</p>
                                <p><strong>Field of Study:</strong> {{ $application->field_of_study }}</p>

                                <hr>

                                <h5 class="text-primary font-jost fw-bold"><i class="fas fa-briefcase"></i> Professional Summary</h5>
                                <p class="mb-1"><strong>Experience:</strong> {{ $application->years_of_experience }} years</p>
                                <p class="mb-1"><strong>Desired Salary:</strong> {{ $application->currency }} {{ number_format($application->desired_salary, 0) }}</p>
                                <p><strong>Notice Period:</strong> {{ $application->notice_period }}</p>

                                <hr>

                                <h5 class="text-primary font-jost fw-bold"><i class="fas fa-pencil-alt"></i> Additional Notes</h5>
                                <p class="text-muted font-italic">{{ $application->additional_notes ?? 'No extra notes provided by applicant.' }}</p>
                            </div>

                            <!-- Documents Tab -->
                            <div class="tab-pane" id="documents">
                                <div class="row">
                                    @forelse($application->attachments as $file)
                                    <div class="col-sm-6 mb-3">
                                        <div class="info-box shadow-none border">
                                            <span class="info-box-icon bg-light"><i class="far fa-file-pdf text-danger"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-truncate">{{ $file->file_name }}</span>
                                                <a href="{{ route('admin.attachments.download', $file->id) }}" class="btn btn-xs btn-primary mt-1">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-12 text-center py-4">
                                        <p class="text-muted">No documents uploaded.</p>
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
    .nav-pills .nav-link.active { background-color: #007bff; }
</style>
@endpush