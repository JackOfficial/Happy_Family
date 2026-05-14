@extends('admin.layouts.app')

@section('title', 'Blog Categories')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-jost fw-bold text-dark">
                    Categories <span class="badge badge-soft-success ml-2">{{ $categories->total() }}</span>
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-primary shadow-sm px-4">
                    <i class="fas fa-folder-plus mr-1"></i> New Category
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h3 class="card-title font-inter fw-bold text-muted text-uppercase small" style="letter-spacing: 1px;">
                    Classification List
                </h3>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="pl-4" style="width: 70px;">#</th>
                                <th>Category Name</th>
                                <th>Thumbnail</th>
                                <th>Slug</th>
                                <th>Date Created</th>
                                <th class="text-right pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="font-inter">
                            @forelse ($categories as $category)
                                <tr>
                                    <td class="pl-4 text-muted small">#{{ $category->id }}</td>
                                    <td>
                                        <span class="font-weight-bold text-dark">{{ $category->name }}</span>
                                    </td>
                                    <td>
                                        @if($category->categoryPhoto)
                                            <a href="{{ asset('storage/' . $category->categoryPhoto->file_path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $category->categoryPhoto->file_path) }}" 
                                                     alt="cat-img" 
                                                     class="rounded shadow-xs border"
                                                     style="width: 50px; height: 35px; object-fit: cover;">
                                            </a>
                                        @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center border shadow-xs" style="width: 50px; height: 35px;">
                                                <i class="far fa-folder text-muted" style="font-size: 0.8rem;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <code class="small text-secondary bg-light px-2 py-1 rounded">{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        <span class="small text-muted">{{ $category->created_at->format('d M, Y') }}</span>
                                    </td>
                                    <td class="text-right pr-4">
                                        <div class="btn-group border rounded shadow-xs bg-white">
                                            <a href="{{ route('admin.blog-categories.edit', $category->id) }}" class="btn btn-sm px-3" title="Edit">
                                                <i class="fas fa-edit text-info"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm px-3 delete-btn" 
                                                    data-id="{{ $category->id }}" 
                                                    data-url="{{ route('admin.blog-categories.destroy', $category->id) }}"
                                                    title="Delete">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-tags fa-3x text-light mb-3"></i>
                                            <p class="text-muted">No categories available. Add one to start organizing your blogs.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($categories->hasPages())
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-center">
                        {{ $categories->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Standardized Delete Form -->
<form id="delete-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
    .font-jost { font-family: 'Jost', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    .fw-bold { font-weight: 700; }
    .badge-soft-success { background-color: #dcfce7; color: #15803d; }
    .shadow-xs { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .table thead th { border-top: none; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.8px; color: #6b7280; border-bottom: 1px solid #f3f4f6; }
    .table td { vertical-align: middle; border-top: 1px solid #f3f4f6; padding: 1rem 0.75rem; }
    .btn-group .btn:hover { background-color: #f9fafb; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.delete-btn', function() {
        const url = $(this).data('url');
        
        Swal.fire({
            title: 'Delete Category?',
            text: "Blogs under this category might become uncategorized.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = $('#delete-form');
                form.attr('action', url);
                form.submit();
            }
        });
    });
</script>
@endpush