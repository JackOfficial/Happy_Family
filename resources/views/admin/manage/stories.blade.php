@extends('admin.layouts.app')
@section('title', 'Success Stories')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="font-weight-bold">Success Stories <span class="badge badge-secondary ml-2">{{ $stories->count() }}</span></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item active">Stories</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title text-muted font-weight-light">Community Voices & Impact</h3>
                <a href="{{ route('admin.stories.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
                    <i class="fa fa-plus-circle mr-1"></i> Write New Story
                </a>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="example1" class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase small font-weight-bold">
                        <tr>
                            <th class="pl-4" style="width: 50px">#</th>
                            <th style="width: 120px">Thumbnail</th>
                            <th>Story Info</th>
                            <th>Status</th>
                            <th>Author</th>
                            <th class="text-right pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stories as $story)
                        <tr>
                            <td class="pl-4 text-muted">{{ $loop->iteration }}</td>
                            <td>
                                @if($story->photo)
                                    <div class="img-container rounded shadow-sm border" style="width: 80px; height: 55px; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $story->photo->file_path) }}" 
                                             alt="{{ $story->title }}" 
                                             class="w-100 h-100" 
                                             style="object-fit: cover;" />
                                    </div>
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 80px; height: 55px;">
                                        <i class="far fa-image small"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="d-block font-weight-bold text-dark">{{ Str::limit($story->title, 50) }}</span>
                                <small class="text-muted d-block">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ $story->created_at->format('M d, Y') }}
                                    <span class="mx-1">•</span>
                                    <i class="fas fa-link mr-1"></i> {{ $story->slug }}
                                </small>
                            </td>
                            <td>
                                <span class="badge badge-pill px-3 
                                    {{ $story->status == 'published' ? 'badge-success' : ($story->status == 'draft' ? 'badge-warning' : 'badge-secondary') }}">
                                    {{ ucfirst($story->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary rounded-circle text-white d-flex align-items-center justify-content-center mr-2" style="width: 25px; height: 25px; font-size: 10px;">
                                        {{ strtoupper(substr($story->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="small">{{ $story->user->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td class="text-right pr-4">
                                <div class="btn-group">
                                    <a class="btn btn-outline-info btn-sm shadow-sm mr-2" href="{{ route('admin.stories.edit', $story->slug) }}" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <form action="{{ route('admin.stories.destroy', $story->slug) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this story?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-book-open fa-3x mb-3"></i>
                                    <p>No stories found. Share your first impact story!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<style>
    .align-middle td { vertical-align: middle !important; }
    .badge-pill { font-weight: 500; border-radius: 50px; }
    .table thead th { border-top: none; border-bottom: 2px solid #f4f6f9; }
    .img-container img { transition: transform .2s; }
    .img-container:hover img { transform: scale(1.1); }
</style>
@endsection