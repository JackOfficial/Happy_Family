@extends('admin.layouts.app')
@section('title', 'Our Gallery')

@push('styles')
<style>
  /* Professional UI Essentials */
.rounded-lg { border-radius: 15px !important; }
.bg-soft-light { background-color: #f8f9fc; }
.badge-primary-soft { background-color: #e0e7ff; color: #4e73df; font-weight: 800; }

/* File Card Effects */
.file-card {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    cursor: default;
    border: 2px solid transparent !important;
}
.file-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}
.selected-border { border: 2px solid #e83e8c !important; }

/* Overlay UI */
.file-preview { height: 140px; overflow: hidden; position: relative; }
.file-preview img { width: 100%; height: 100%; object-fit: cover; }
.file-actions-overlay {
    position: absolute; inset: 0; background: rgba(0,0,0,0.4);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: 0.3s; backdrop-filter: blur(3px);
}
.file-card:hover .file-actions-overlay { opacity: 1; }

/* Upload Zone */
.upload-area {
    border: 2px dashed #dee2e6; border-radius: 15px; padding: 40px;
    text-align: center; cursor: pointer; transition: 0.3s; background: #fafafa;
}
.upload-area:hover, .upload-area.dragging {
    background: #f0f7ff; border-color: #4e73df;
}

/* Skeleton Loader */
.skeleton-card {
    height: 180px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%; animation: loading 1.5s infinite; border-radius: 12px;
}
@keyframes loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

/* Custom Checkbox */
.custom-checkbox-container {
    position: absolute; top: 10px; left: 10px; z-index: 20; cursor: pointer;
}
.btn-upload { background-color: #e83e8c; border-radius: 20px; transition: 0.3s; }
.btn-upload:hover { background-color: #d81b60; transform: scale(1.05); }

/* Modal Custom Backdrop */
.modal-backdrop-custom {
    position: fixed; inset: 0; background: rgba(0,0,0,0.6);
    display: flex; align-items: center; justify-content: center; z-index: 2000;
    backdrop-filter: blur(4px);
}
</style>
@endpush
    
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Our Gallery</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">Gallery</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Livewire Component -->
    <livewire:admin.file-manager />


@endsection
