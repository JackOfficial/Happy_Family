@extends('admin.layouts.app')

@section('title', 'Manage Blogs')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-jost fw-bold text-dark">Blogs <span class="badge badge-soft-primary ml-2">{{ $blogs->total() }}</span></h1>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary shadow-sm px-4">
                        <i class="fas fa-plus-circle mr-1"></i> Write New Blog
                    </a>
                </div>
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
                    Editorial List
                </h3>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="pl-4" style="width: 50px;">ID</th>
                                <th>Blog Details</th>
                                <th>Category/Cause</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th class="text-right pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="font-inter">
                            @forelse ($blogs as $blog)
                                <tr>
                                    <td class="pl-4 text-muted">#{{ $blog->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                @if($blog->blogPhoto)
                                                    <img src="{{ asset('storage/' . $blog->blogPhoto->file_path) }}" 
                                                         alt="cover" 
                                                         class="rounded shadow-sm"
                                                         style="width: 60px; height: 45px; object-fit: cover;">
                                                @else
                                                    <div class="rounded bg-light d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 45px;">
                                                        <i class="far fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark mb-0">{{ Str::limit($blog->title, 45) }}</div>
                                                <small class="text-primary cursor-pointer">{{ $blog->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border px-2 py-1 text-uppercase small">
                                            {{ $blog->cause->name ?? 'General' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="far fa-user-circle mr-1 text-muted"></i> {{ $blog->user->name ?? 'Admin' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small text-muted">{{ $blog->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="text-right pr-4">
                                        <div class="btn-group shadow-sm border rounded">
                                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-white btn-sm px-3" title="Edit Content">
                                                <i class="fas fa-edit text-info"></i>
                                            </a>
                                            <button type="button" class="btn btn-white btn-sm px-3 delete-btn" 
                                                    data-id="{{ $blog->id }}" 
                                                    data-url="{{ route('admin.blogs.destroy', $blog->id) }}"
                                                    title="Remove Blog">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-feather fa-3x mb-3 d-block opacity-2"></i>
                                        No blogs found. Start writing to reach your audience!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($blogs->hasPages())
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-center">
                    {{ $blogs->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Hidden Delete Form -->
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
    .badge-soft-primary { background-color: #e7f1ff; color: #007bff; }
    .btn-white { background: #fff; }
    .btn-white:hover { background: #f8f9fa; }
    .table thead th { border-top: none; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; color: #888; }
    .opacity-2 { opacity: 0.2; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.delete-btn', function() {
        let url = $(this).data('url');
        
        Swal.fire({
            title: 'Delete this blog?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = $('#delete-form');
                form.attr('action', url);
                form.submit();
            }
        });
    });
</script>
@endpush