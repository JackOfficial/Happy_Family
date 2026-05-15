@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Volunteer Applications</h2>
            <p class="text-muted">Manage and review people who want to join Happy Family Rwanda.</p>
        </div>
        <a href="{{ route('volunteer.apply') }}" class="btn btn-dark rounded-pill">
            <i class="bi bi-plus-lg"></i> Add New Volunteer
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Volunteer</th>
                            <th>Location</th>
                            <th>Occupation</th>
                            <th>Status</th>
                            <th>Applied Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($volunteers as $volunteer)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #e7f1ff;">
                                        {{ strtoupper(substr($volunteer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $volunteer->name }}</div>
                                        <small class="text-muted">{{ $volunteer->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="bi bi-geo-alt text-muted me-1"></i>
                                {{ $volunteer->address->city ?? 'N/A' }}, {{ $volunteer->country->name ?? 'N/A' }}
                            </td>
                            <td>{{ $volunteer->occupation ?? '—' }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $volunteer->status == 'active' ? 'success' : ($volunteer->status == 'pending' ? 'warning text-dark' : 'secondary') }}">
                                    {{ ucfirst($volunteer->status) }}
                                </span>
                            </td>
                            <td>{{ $volunteer->created_at->format('d M, Y') }}</td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i> View Details</a></li>
                                        <li><a class="dropdown-item" href="mailto:{{ $volunteer->email }}"><i class="bi bi-envelope me-2"></i> Send Email</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="#" method="POST" onsubmit="return confirm('Archive this application?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i> Archive</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/gray/no-messages.svg" alt="No data" style="width: 150px;" class="mb-3">
                                <p class="text-muted">No volunteer applications found yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        {{ $volunteers->links() }}
    </div>
</div>
@endsection