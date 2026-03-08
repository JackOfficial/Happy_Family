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

<section class="content" x-data="{ 
    search: '',
    visibleCount: {{ $events->count() }},
    filterRow(el) {
        let content = el.innerText.toLowerCase();
        let query = this.search.toLowerCase();
        let match = content.includes(query);
        return match;
    }
}">
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
            {{-- Alpine Search Bar --}}
            <div class="card-header bg-white border-0 pt-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <h3 class="card-title text-muted uppercase" style="font-size: 0.7rem; letter-spacing: 1px; font-weight: bold;">Event Directory</h3>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group shadow-sm border rounded-pill overflow-hidden bg-light">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted"></i></span>
                            </div>
                            <input type="text" x-model="search" class="form-control border-0 bg-transparent" placeholder="Search title, location, or status...">
                            <template x-if="search.length > 0">
                                <div class="input-group-append" @click="search = ''" style="cursor: pointer">
                                    <span class="input-group-text bg-transparent border-0"><i class="fas fa-times-circle text-muted"></i></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0"> 
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-top-0 pl-4" style="width: 50px;">#</th>
                                <th class="border-top-0">Event Details</th>
                                <th class="border-top-0">Schedule</th>
                                <th class="border-top-0">Location</th>
                                <th class="border-top-0">Assets</th>
                                <th class="border-top-0">Status</th>
                                <th class="border-top-0 pr-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                                <tr x-show="filterRow($el)" 
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100">
                                    <td class="pl-4 text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                @if($event->event_photos->count() > 0)
                                                    <img src="{{ asset('storage/' . $event->event_photos->first()->file_path) }}" 
                                                         class="rounded border shadow-xs" style="width: 42px; height: 42px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 42px; height: 42px;">
                                                        <i class="far fa-image text-muted small"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark mb-0" style="line-height: 1.2;">{{ $event->title }}</div>
                                                <small class="text-muted d-block mt-1">Slug: {{ $event->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small font-weight-bold text-dark"><i class="far fa-calendar-alt text-primary mr-1"></i> {{ $event->date ? $event->date->format('M d, Y') : 'TBD' }}</div>
                                        <div class="small text-muted mt-1"><i class="far fa-clock mr-1"></i> {{ $event->time ?? '--:--' }}</div>
                                    </td>
                                    <td>
                                        <div class="small text-dark">
                                            <i class="fas fa-map-pin text-danger mr-1"></i> {{ $event->location ?? 'Virtual' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column" style="gap: 4px;">
                                            <span class="badge badge-pill badge-light border text-info px-2 py-1" style="font-size: 0.7rem;">
                                                <i class="far fa-images mr-1"></i> {{ $event->event_photos->count() }} Photos
                                            </span>
                                            @if($event->documents->count() > 0)
                                                <span class="badge badge-pill badge-light border text-dark px-2 py-1" style="font-size: 0.7rem;">
                                                    <i class="fas fa-paperclip mr-1 text-muted"></i> {{ $event->documents->count() }} Docs
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'active' => 'badge-success',
                                                'inactive' => 'badge-secondary',
                                                'completed' => 'badge-info',
                                                'cancelled' => 'badge-danger'
                                            ];
                                            $color = $statusColors[$event->status] ?? 'badge-warning';
                                        @endphp
                                        <span class="badge {{ $color }} px-2 py-1 shadow-xs" style="font-weight: 500; min-width: 70px; border-radius: 4px;">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </td>
                                    <td class="pr-4 text-center">
                                       <td class="pr-4 text-center">
    <div class="btn-group border rounded shadow-sm overflow-hidden bg-white">
        {{-- View/Show Button --}}
        <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-white btn-sm px-3 border-0" title="View Details">
            <i class="fas fa-eye text-primary"></i>
        </a>
        
        {{-- Edit Button --}}
        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-white btn-sm px-3 border-0 border-left" title="Edit Event">
            <i class="fas fa-pencil-alt text-info"></i>
        </a>
        
        {{-- Delete Button --}}
        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline m-0">
            @csrf @method('DELETE')
            <button type="button" class="btn btn-white btn-sm delete-btn px-3 border-0 border-left" title="Delete Event">
                <i class="fas fa-trash text-danger"></i>
            </button>
        </form>
    </div>
</td>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-folder-open fa-3x text-light mb-3"></i>
                                        <p class="text-muted">No events found in the database.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Alpine Search Empty State --}}
            <div x-show="search.length > 0 && $el.closest('.card').querySelectorAll('tbody tr[style*=\'display: none\']').length === {{ $events->count() }}" 
                 class="text-center py-5 bg-white border-top" x-cloak>
                <div class="py-3">
                    <i class="fas fa-search fa-3x text-light mb-3"></i>
                    <h5 class="text-dark">No matches found</h5>
                    <p class="text-muted">No events match your search "<span x-text="search" class="font-weight-bold"></span>"</p>
                    <button @click="search = ''" class="btn btn-sm btn-outline-primary rounded-pill px-3">Clear Search</button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .table thead th { 
        font-size: 0.72rem; 
        text-transform: uppercase; 
        letter-spacing: 0.8px; 
        font-weight: 800; 
        color: #555; 
        padding: 15px;
        background-color: #fcfcfc;
    }
    .table tbody td { padding: 12px 15px; }
    .align-middle td { vertical-align: middle !important; }
    .btn-white { background: #fff; }
    .btn-white:hover { background: #f8f9fa; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    [x-cloak] { display: none !important; }
    .rounded-pill { border-radius: 50px !important; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.delete-btn', function() {
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Confirm Deletion',
            text: "This will permanently delete this event and all associated files.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
</script>
@endpush