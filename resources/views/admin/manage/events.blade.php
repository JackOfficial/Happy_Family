@extends('admin.layouts.app')
@section('title', 'Events Management')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-6">
                <h1 class="font-weight-bold"><i class="far fa-calendar-alt mr-2 text-primary"></i>Events <span class="badge badge-pill badge-light border ml-2 text-muted" style="font-size: 0.5em;">{{ $events->count() }} Total</span></h1>
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
            <div class="card-body p-0"> <table id="eventsTable" class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-top-0 pl-4">#</th>
                            <th class="border-top-0">Event Details</th>
                            <th class="border-top-0">Schedule</th>
                            <th class="border-top-0">Location</th>
                            <th class="border-top-0">Media</th>
                            <th class="border-top-0">Status</th>
                            <th class="border-top-0 pr-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td class="pl-4 text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            @if($event->event_photos->count() > 0)
                                                <img src="{{ asset('storage/' . $event->event_photos->first()->file_path) }}" 
                                                     class="rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                    <i class="far fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ Str::limit($event->title, 40) }}</div>
                                            <small class="text-muted">ID: #{{ $event->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small font-weight-bold"><i class="far fa-calendar text-primary mr-1"></i> {{ $event->date ? $event->date->format('M d, Y') : 'N/A' }}</div>
                                    <div class="small text-muted"><i class="far fa-clock mr-1"></i> {{ $event->time ?? '--:--' }}</div>
                                </td>
                                <td>
                                    <span class="small text-muted">
                                        <i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $event->location ?? 'Online/TBD' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-info-light text-info border border-info px-2">
                                        <i class="far fa-images mr-1"></i> {{ $event->event_photos->count() }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'active' => 'badge-success',
                                            'completed' => 'badge-secondary',
                                            'cancelled' => 'badge-danger'
                                        ][$event->status] ?? 'badge-warning';
                                    @endphp
                                    <span class="badge {{ $statusClass }} px-3 py-2" style="border-radius: 30px;">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>
                                <td class="pr-4 text-center">
                                    <div class="btn-group shadow-sm" role="group">
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-white btn-sm" title="Edit">
                                            <i class="fas fa-pencil-alt text-info"></i>
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-white btn-sm delete-btn" title="Delete">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 80px; opacity: 0.3;">
                                    <p class="mt-3 text-muted">No events found in the database.</p>
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
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; color: #6c757d; }
    .align-middle td { vertical-align: middle !important; }
    .badge-info-light { background-color: rgba(23, 162, 184, 0.1); }
    .btn-white { background: #fff; border: 1px solid #dee2e6; }
    .btn-white:hover { background: #f8f9fa; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(function () {
    $('#eventsTable').DataTable({
      "responsive": true,
      "autoWidth": false,
      "pageLength": 10,
      "columnDefs": [{ "targets": 6, "orderable": false }] // Disable ordering on Action column
    });

    // Modern Delete Confirmation
    $('.delete-btn').on('click', function(e) {
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Delete Event?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
  });
</script>
@endpush