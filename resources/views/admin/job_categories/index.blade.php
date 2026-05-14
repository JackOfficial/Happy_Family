@extends('admin.layouts.app')

@section('title')
<title>Job Categories | Admin Dashboard</title>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-jost">Job Categories</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-primary font-inter shadow-sm" data-toggle="modal" data-target="#modal-add-category">
                    <i class="fas fa-plus-circle mr-1"></i> Add New Category
                </button>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-jost fw-bold">Management</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap font-inter">
                            <thead>
                                <tr>
                                    <th style="width: 80px">Icon</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th class="text-center">Open Jobs</th>
                                    <th>Created At</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td>
                                        <div class="bg-light rounded text-center py-2">
                                            <i class="{{ $category->icon ?? 'fas fa-folder' }} text-primary"></i>
                                        </div>
                                    </td>
                                    <td class="font-weight-bold">{{ $category->name }}</td>
                                    <td><code>{{ $category->slug }}</code></td>
                                    <td class="text-center">
                                        <span class="badge badge-pill badge-light border px-3">
                                            {{ $category->jobs_count }}
                                        </span>
                                    </td>
                                    <td>{{ $category->created_at->format('d M, Y') }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.job-categories.edit', $category->id) }}" class="btn btn-sm btn-outline-info mr-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.job-categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        No categories defined yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Category Modal -->
<div class="modal fade" id="modal-add-category">
    <div class="modal-dialog">
        <form action="{{ route('admin.job-categories.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-jost fw-bold">Create Job Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body font-inter">
                    <div class="form-group">
                        <label for="name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Health Support" required>
                    </div>
                    <div class="form-group">
                        <label for="icon">Icon Class (FontAwesome)</label>
                        <input type="text" name="icon" class="form-control" placeholder="e.g. fas fa-medkit">
                        <small class="text-muted">Default: <code>fas fa-folder</code></small>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Briefly describe this department..."></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    .table td { vertical-align: middle; }
</style>
@endpush