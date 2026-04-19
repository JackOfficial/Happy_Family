@extends('admin.layouts.app')
@section('title', 'Admin | Event Details')

@push('styles')
<style>
    .info-label { text-transform: uppercase; font-size: 0.7rem; color: #888; letter-spacing: 0.5px; font-weight: bold; }
    .info-value { color: #333; font-weight: 500; display: block; margin-bottom: 1rem; }
    .admin-card { border-radius: 12px; border: none; }
    .gallery-img { width: 100%; height: 120px; object-fit: cover; border-radius: 8px; transition: 0.2s; }
    .gallery-img:hover { opacity: 0.8; }
    .doc-preview { background: #fdfdfd; border: 1px solid #edf2f7; border-radius: 8px; }
</style>
@endpush

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="font-weight-bold text-dark">
                    <i class="fas fa-file-invoice mr-2 text-muted"></i>Event Overview
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <div class="btn-group shadow-sm">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-white border">
                        <i class="fas fa-arrow-left mr-1 text-muted"></i> Back
                    </a>
                    {{-- PDF Download Button --}}
                    <a href="{{ route('admin.events.download-pdf', $event->slug) }}" class="btn btn-outline-danger border-left-0">
                        <i class="fas fa-file-pdf mr-1"></i> Download PDF
                    </a>
                    <a href="{{ route('admin.events.edit', $event->slug) }}" class="btn btn-info">
                        <i class="fas fa-pencil-alt mr-1"></i> Edit Event
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- Main Data --}}
            <div class="col-md-8">
                <div class="card admin-card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold">Content & Description</h5>
                    </div>
                    <div class="card-body">
                        <h2 class="font-weight-bold text-dark mb-3">{{ $event->title }}</h2>
                        <div class="mb-4">
                             <span class="badge badge-light border text-muted">Slug: {{ $event->slug }}</span>
                             <span class="badge badge-{{ $event->status == 'active' ? 'success' : 'secondary' }} ml-2 px-3">
                                Status: {{ ucfirst($event->status) }}
                             </span>
                        </div>
                        
                        <div class="text-muted" style="line-height: 1.6;">
                            {!! $event->description !!}
                        </div>
                    </div>
                </div>

                {{-- Gallery Preview --}}
                <div class="card admin-card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="far fa-images mr-2 text-info"></i>Gallery ({{ $event->event_photos->count() }})</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($event->event_photos as $photo)
                                <div class="col-6 col-sm-4 col-md-3 mb-3">
                                    <a href="{{ asset('storage/' . $photo->file_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $photo->file_path) }}" class="gallery-img border">
                                    </a>
                                </div>
                            @empty
                                <div class="col-12 text-center py-4 text-muted small">No photos uploaded.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Technical Info --}}
            <div class="col-md-4">
                {{-- Logistic Card --}}
                <div class="card admin-card shadow-sm mb-4">
                    <div class="card-header bg-primary py-3">
                        <h5 class="mb-0 font-weight-bold text-white"><i class="fas fa-info-circle mr-2"></i>Logistics</h5>
                    </div>
                    <div class="card-body">
                        <label class="info-label">Event Date</label>
                        <span class="info-value">{{ $event->date ? $event->date->format('D, M d, Y') : 'Not Set' }}</span>

                        <label class="info-label">Event Time</label>
                        <span class="info-value">{{ $event->time ?? '--:--' }}</span>

                        <label class="info-label">Venue / Location</label>
                        <span class="info-value"><i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $event->location ?? 'N/A' }}</span>

                        <label class="info-label">External Registration Link</label>
                        <span class="info-value text-truncate">
                            @if($event->link)
                                <a href="{{ $event->link }}" target="_blank">{{ $event->link }}</a>
                            @else
                                <span class="text-muted font-italic">No link provided</span>
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Documents Card --}}
                <div class="card admin-card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-paperclip mr-2 text-muted"></i>Admin Documents</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($event->documents as $doc)
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <div class="text-truncate mr-2" style="max-width: 80%;">
                                        <i class="far fa-file-alt text-primary mr-2"></i>
                                        <span class="small font-weight-bold">{{ $doc->title }}</span>
                                    </div>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted py-4 small">No attachments.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- Audit Card --}}
                <div class="card admin-card shadow-sm">
                    <div class="card-body bg-light rounded shadow-inner" style="font-size: 0.85rem;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Created At:</span>
                            <span class="font-weight-bold">{{ $event->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-0">
                            <span class="text-muted">Last Updated:</span>
                            <span class="font-weight-bold">{{ $event->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection