@extends('admin.layouts.app')
@section('title', 'Causes')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="font-weight-bold">Causes <span class="badge badge-secondary ml-2">{{ $causes->count() }}</span></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item active">Impact Areas</li>
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
                <h3 class="card-title text-muted">Management List</h3>
                <a href="{{ route('admin.causes.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
                    <i class="fa fa-plus-circle mr-1"></i> Add New Cause
                </a>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="example1" class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="pl-4" style="width: 50px">#</th>
                            <th style="width: 120px">Preview</th>
                            <th>Cause Details</th>
                            <th>Description Snippet</th>
                            <th class="text-center">Status</th>
                            <th class="text-right pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($causes as $cause)
                        <tr>
                            <td class="pl-4 font-weight-bold text-muted">{{ $loop->iteration }}</td>
                            <td>
                                @if($cause->mainPhoto)
                                    <div class="img-container rounded shadow-sm" style="width: 80px; height: 60px; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $cause->mainPhoto->file_path) }}" 
                                             alt="{{ $cause->name }}" 
                                             class="w-100 h-100" 
                                             style="object-fit: cover;" />
                                    </div>
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted small" style="width: 80px; height: 60px;">
                                        <i class="far fa-image fa-2x"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="d-block font-weight-bold text-dark">{{ $cause->name }}</span>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ $cause->created_at->format('M d, Y') }}
                                </small>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ Str::limit(strip_tags($cause->description), 60) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($cause->status == 1)
                                    <span class="badge badge-pill badge-success px-3">Active</span>
                                @else
                                    <span class="badge badge-pill badge-danger px-3">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right pr-4">
                                <div class="btn-group">
                                    <a class="btn btn-outline-info btn-sm shadow-sm mr-2" href="{{ route('admin.causes.edit', $cause->id) }}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.causes.destroy', $cause->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Careful! This will remove the cause and all associated photos. Continue?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm shadow-sm" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                No impact areas found. Start by creating your first cause.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($causes instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="card-footer bg-white">
            {{ $causes->links() }}
        </div>
        @endif
    </div>
</section>

<style>
    .align-middle td {
        vertical-align: middle !important;
    }
    .badge-pill {
        border-radius: 50px;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    .btn-group .btn {
        border-radius: 8px !important;
    }
</style>
@endsection