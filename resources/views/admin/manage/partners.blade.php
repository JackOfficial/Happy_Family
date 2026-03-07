@extends('admin.layouts.app')
@section('title', 'Partners Management')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 fw-bold text-dark">Partners <span class="badge badge-pill badge-secondary ml-2" style="font-size: 0.5em; vertical-align: middle;">{{ $partners->count() }} Total</span></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent p-0 mt-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Partners</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible border-0 shadow-sm fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title text-muted font-weight-bold">Partner List</h3>
                <a href="{{ route('admin.partners.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="fa fa-plus-circle mr-1"></i> Add New Partner
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="partnersTable" class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="pl-4" style="width: 50px;">#</th>
                            <th>Partner Details</th>
                            <th>Website</th>
                            <th>Organization</th>
                            <th>Added Date</th>
                            <th class="text-right pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($partners as $partner)
                        <tr>
                            <td class="pl-4 text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="partner-logo-preview mr-3 shadow-sm border rounded">
                                        @if($partner->logo)
                                            <img src="{{ asset('storage/' . $partner->logo) }}" 
                                                 alt="{{ $partner->name }}" 
                                                 style="width: 60px; height: 40px; object-fit: contain; background: #f8f9fa;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                                <i class="fas fa-image text-muted small"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark mb-0">{{ $partner->name }}</div>
                                        <small class="text-muted">{{ Str::limit(strip_tags($partner->description), 45) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($partner->website)
                                    <a href="{{ $partner->website }}" target="_blank" class="btn btn-xs btn-outline-secondary rounded-pill px-2">
                                        <i class="fas fa-external-link-alt mr-1"></i> Visit Site
                                    </a>
                                @else
                                    <span class="text-muted small">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-light border px-2 py-1">
                                    {{ $partner->organization->name ?? 'Default' }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ $partner->created_at->format('M d, Y') }}
                                </small>
                            </td>
                            <td class="text-right pr-4">
                                <div class="btn-group shadow-sm" role="group">
                                    <a href="{{ route('admin.partners.edit', $partner->slug) }}" class="btn btn-white btn-sm" title="Edit">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>
                                    <button type="button" class="btn btn-white btn-sm text-danger" 
                                            onclick="confirmDelete('{{ $partner->id }}')" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $partner->id }}" action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-5 text-center text-muted">
                                <i class="fas fa-handshake fa-3x mb-3 opacity-20"></i>
                                <p>No partners found. Start by adding a new one!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($partners->hasPages())
        <div class="card-footer bg-white">
            {{ $partners->links() }}
        </div>
        @endif
    </div>
</section>

@push('styles')
<style>
    .partner-logo-preview {
        overflow: hidden;
        background: #fff;
        padding: 2px;
    }
    .align-middle td {
        vertical-align: middle !important;
    }
    .btn-white {
        background: #fff;
        border: 1px solid #dee2e6;
    }
    .btn-white:hover {
        background: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this partner?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection