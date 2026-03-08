@extends('admin.layouts.app')
@section('title', 'Events Management')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-6">
                <h1 class="font-weight-bold">
                    <i class="far fa-calendar-alt mr-2 text-primary"></i>Events 
                    <span class="badge badge-pill badge-light border ml-2 text-muted" style="font-size: 0.5em;">{{ $events->count() }} Total</span>
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fa fa-plus-circle mr-1"></i> Create New Event
                </a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0"> 
                <table id="eventsTable" class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-top-0 pl-4">#</th>
                            <th class="border-top-0">Event Details</th>
                            <th class="border-top-0">Schedule</th>
                            <th class="border-top-0">Location</th>
                            <th class="border-top-0">Media</th>
                            <th class="border-top-0">Attachments</th>
                            <th class="border-top-0">Status</th>
                            <th class="border-top-0 pr-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td class="pl-4 text-muted small">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            @if($event->event_photos->count() > 0)
                                                <img src="{{ asset('storage/' . $event->event_photos->first()->file_path) }}" 
                                                     class="rounded shadow-sm border" style="width: 45px; height: 45px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                                                    <i class="far fa-image text-muted small"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark" style="line-height: 1.2;">{{ Str::limit($event->title, 40) }}</div>
                                            <small class="text-muted">Slug: {{ Str::limit($event->slug, 20) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small font-weight-bold"><i class="far fa-calendar text-primary mr-1"></i> {{ $event->date ? $event->date->format('M d, Y') : 'N/A' }}</div>
                                    <div class="small text-muted"><i class="far fa-clock mr-1"></i> {{ $event->time ?? '--:--' }}</div>
                                </td>
                                <td>
                                    <span class="small text-muted">
                                        <i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ Str::limit($event->location ?? 'Online/TBD', 20) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="badge badge-info-light text-info border border-info px-2 py-1">
                                        <i class="far fa-images mr-1"></i> {{ $event->event_photos->count() }}
                                    </div>
                                </td>
                                <td>
                                    @if($event->documents->count() > 0)
                                        <div class="badge badge-light border text-dark px-2 py-1">
                                            <i class="fas fa-paperclip mr-1 text-muted"></i> {{ $event->documents->count() }} Files
                                        </div>
                                    @else
                                        <span class="text-muted small">None</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'active' => 'badge-success',
                                            'inactive' => 'badge-secondary',
                                            'completed' => 'badge-info',
                                            'cancelled' => 'badge-danger'
                                        ][$event->status] ?? 'badge-warning';
                                    @endphp
                                    <span class="badge {{ $statusClass }} px-2 py-1" style="border-radius: 4px; font-size: 0.8rem; font-weight: 500;">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>
                                <td class="pr-4 text-center">
                                    <div class="btn-group shadow-sm border rounded overflow-hidden" role="group">
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-white btn-sm px-3" title="Edit">
                                            <i class="fas fa-pencil-alt text-info"></i>
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-white btn-sm delete-btn px-3" title="Delete">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 bg-white">
                                    <div class="py-4">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3" style="opacity: 0.2;"></i>
                                        <p class="text-muted">No events found. Start by creating a new one!</p>
                                        <a href="{{ route('admin.events.create') }}" class="btn btn-sm btn-primary">Add Your First Event</a>
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
    .table thead th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; color: #6c757d; padding: 12px 15px; }
    .table tbody td { padding: 12px 15px; }
    .align-middle td { vertical-align: middle !important; }
    .badge-info-light { background-color: rgba(23, 162, 184, 0.08); }
    .btn-white { background: #fff; border: none; }
    .btn-white:hover { background: #f8f9fa; }
    .btn-group .btn-white:not(:last-child) { border-right: 1px solid #eee; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(function () {
    if ($('#eventsTable tbody tr').length > 1) { // Only init if table has data
        $('#eventsTable').DataTable({
          "responsive": true,
          "autoWidth": false,
          "pageLength": 10,
          "order": [[0, "asc"]],
          "columnDefs": [{ "targets": [7], "orderable": false }] 
        });
    }

    // Modern Delete Confirmation
    $(document).on('click', '.delete-btn', function(e) {
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Delete Event?',
            text: "All associated images and documents will be permanently removed.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
  });
</script>
@endpush