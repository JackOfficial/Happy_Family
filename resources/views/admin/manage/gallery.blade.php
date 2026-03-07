@extends('admin.layouts.app')
@section('title', 'Our Gallery')

@push('styles')
<style>
    .file-card { transition: all 0.2s ease; border: 2px solid transparent !important; }
    .file-card:hover { transform: translateY(-4px); box-shadow: 0 10px 15px rgba(0,0,0,0.1) !important; }
    .file-preview .file-overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.3);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: 0.2s; backdrop-filter: blur(2px);
    }
    .file-card:hover .file-overlay { opacity: 1; }
    .border-dashed { border: 2px dashed #ddd; }
    [x-cloak] { display: none !important; }
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
