@extends('admin.layouts.app')

@section('title', 'HFRO - Settings')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-6">
                <h1 class="font-weight-bold text-dark"><i class="fas fa-building mr-2 text-primary"></i>Organization Settings</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item active">Organization</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-11 mx-auto">
                <form method="POST" action="{{ route('admin.organization.update', $organization->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card shadow-sm border-0 card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="orgTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active px-4 py-3" id="basic-tab" data-toggle="pill" href="#basic" role="tab">
                                        <i class="fas fa-info-circle mr-1"></i> Basic Identity
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-4 py-3" id="contact-tab" data-toggle="pill" href="#contact" role="tab">
                                        <i class="fas fa-envelope mr-1"></i> Contact & Social
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-4 py-3" id="details-tab" data-toggle="pill" href="#details" role="tab">
                                        <i class="fas fa-bullseye mr-1"></i> Mission & Vision
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="orgTabContent">
                                
                                {{-- Tab 1: Basic Identity --}}
                                <div class="tab-pane fade show active py-3" id="basic" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Organization Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name', $organization->name) }}" required>
                                                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Official Website</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-globe"></i></span></div>
                                                    <input type="url" name="website" class="form-control" value="{{ old('website', $organization->website) }}" placeholder="https://happyfamilyrwanda.org">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-center border-left" x-data="{ logoPreview: '{{ asset('storage/'.$organization->logo) }}' }">
                                            <label class="font-weight-bold d-block">Brand Logo</label>
                                            <div class="mb-3">
                                                <img :src="logoPreview" class="img-thumbnail shadow-sm bg-light" style="height: 120px; width: 120px; object-fit: contain;">
                                            </div>
                                            <div class="custom-file w-75 mx-auto">
                                                <input type="file" name="logo" class="custom-file-input" id="logoInput" accept="image/*" @change="logoPreview = URL.createObjectURL($event.target.files[0])">
                                                <label class="custom-file-label text-left" for="logoInput">Change Logo</label>
                                            </div>
                                            <small class="text-muted d-block mt-2">Transparent PNG recommended (Max 2MB)</small>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tab 2: Contact Info --}}
                                <div class="tab-pane fade py-3" id="contact" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Primary Email</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-at"></i></span></div>
                                                    <input type="email" name="email" class="form-control" value="{{ old('email', $organization->email) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Phone Number</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
                                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $organization->phone) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Physical Address</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span></div>
                                                    <input type="text" name="address" class="form-control" value="{{ old('address', $organization->address) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tab 3: Mission, Vision, About --}}
                                <div class="tab-pane fade py-3" id="details" role="tabpanel">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">Our Mission</label>
                                        <textarea name="mission" id="missionEditor" class="form-control">{{ old('mission', $organization->mission) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">Our Vision</label>
                                        <textarea name="vision" id="visionEditor" class="form-control">{{ old('vision', $organization->vision) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">About Organization</label>
                                        <textarea name="about" id="aboutEditor" class="form-control" rows="6">{{ old('about', $organization->about) }}</textarea>
                                    </div>
                                </div>

                            </div> {{-- End Tab Content --}}
                        </div> {{-- End Card Body --}}

                        <div class="card-footer bg-light p-4 shadow-sm border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="small text-muted mb-0"><i class="fas fa-sync mr-1"></i> Last updated: {{ $organization->updated_at->diffForHumans() }}</p>
                                <div>
                                    <a href="{{ route('admin.organization.index') }}" class="btn btn-link text-muted mr-3">Discard Changes</a>
                                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                                        <i class="fas fa-save mr-2"></i> Update Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    .nav-tabs .nav-link { border: none; color: #6c757d; font-weight: 500; }
    .nav-tabs .nav-link.active { border-bottom: 3px solid #007bff; color: #007bff; background: transparent; }
    .card-outline-tabs { border-top: none; }
    .form-control-lg { border-radius: 8px; }
    .input-group-text { background-color: #f8f9fa; border-right: none; color: #adb5bd; }
    .input-group .form-control { border-left: none; }
    .img-thumbnail { border-radius: 15px; padding: 10px; }
</style>

@endsection

@push('scripts')
<script>
    // Show selected filename in the custom file input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    // 1. Initialize TinyMCE for all target IDs
    tinymce.init({
        selector: '#missionEditor, #visionEditor, #aboutEditor',
        height: 300,
        menubar: false,
        plugins: 'advlist autolink lists link charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
        toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });

    // 2. Fix for Bootstrap Tabs (TinyMCE sometimes glitches when initialized in a hidden tab)
    $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
        // This ensures the editor renders correctly when the user clicks the "Mission & Vision" tab
        tinymce.triggerSave();
    });

    // 3. File Input filename helper (Keep this as is)
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush