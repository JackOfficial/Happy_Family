@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Story Details</h1>
            <p class="text-muted small">View and manage story assets</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.stories.index') }}" class="btn btn-light border shadow-sm mr-2">
                <i class="fas fa-arrow-left mr-1"></i> Back to List
            </a>
            <a href="{{ route('admin.stories.edit', $story->slug) }}" class="btn btn-info shadow-sm">
                <i class="fas fa-pencil-alt mr-1"></i> Edit Story
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 font-weight-bold mb-3">{{ $story->title }}</h2>
                    <div class="story-content border-top pt-4">
                        {!! $story->content !!}
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-camera mr-2 text-primary"></i> Photos</h5>
                </div>
                <div class="card-body">
                    @if($story->photos->count() > 0)
                        <div class="row g-3">
                            @foreach($story->photos as $photo)
                                <div class="col-md-4 mb-3">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                             class="img-fluid rounded shadow-sm border" 
                                             style="height: 150px; width: 100%; object-fit: cover;">
                                        @if($photo->is_featured)
                                            <span class="badge badge-warning position-absolute" style="top: 10px; left: 10px;">Featured</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">No photos uploaded for this story.</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-file-alt mr-2 text-primary"></i> Documents</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>File Name</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($story->documents as $doc)
                                <tr>
                                    <td>{{ $doc->title }}</td>
                                    <td><span class="badge badge-secondary">{{ strtoupper($doc->file_type) }}</span></td>
                                    <td>{{ number_format($doc->file_size / 1024, 2) }} KB</td>
                                    <td class="text-right">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No documents found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Metadata</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <strong>Status:</strong>
                            <span class="badge badge-{{ $story->status === 'published' ? 'success' : ($story->status === 'draft' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($story->status) }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <strong>Cause:</strong>
                            <span>{{ $story->cause->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <strong>Author:</strong>
                            <span>{{ $story->user->name ?? 'System' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <strong>Created At:</strong>
                            <span>{{ $story->created_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            @if($story->summary)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Summary</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted italic small">{{ $story->summary }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection