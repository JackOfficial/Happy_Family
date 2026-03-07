@extends('admin.layouts.app')
@section('title', 'Our Gallery')

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

    @push('styles')
     <style>
        .file-card { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid transparent; }
        .file-card:hover { transform: translateY(-4px); box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important; }
        .selected-card { border: 2px solid #007bff !important; background: #f0f7ff; }
        .file-preview { height: 140px; position: relative; overflow: hidden; }
        .file-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.3); backdrop-filter: blur(2px); display: flex; align-items: center; justify-content: center; opacity: 0; transition: 0.2s; }
        .file-card:hover .file-overlay { opacity: 1; }
        .x-small { font-size: 0.7rem; }
        .bg-primary-subtle { background-color: #e7f1ff; }
        .border-dashed { border: 2px dashed #cbd5e0; }
        [x-cloak] { display: none !important; }
    </style>
    @endpush
@endsection
