@extends('layouts.app')
@section('content')
        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb" style="background: url({{ asset('images/impact.jpg') }}); 
        background-position: center center;
         background-repeat: no-repeat;
         background-size: cover;
         padding: 100px 0 0 0;">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h3 class="text-white display-3 mb-4">Our Impacts</h1>
                <p class="fs-5 text-white mb-4">Together, we’re building a future where every one thrives.</p>
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active text-white">{{ $cause->name }}</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->

       <!-- Services Start -->
       <div class="container-fluid service py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                <h5 class="text-uppercase text-primary">Our Impact</h5>
                <h1 class="mb-0">{{ $cause->name }}</h1>
            </div>
            <div>
              {!! $cause->description !!}   
            </div>
        </div>
        
           <div class="container-fluid causes py-5 {{ $projects->count() > 0 ? '' : 'd-none' }}">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                    <h5 class="text-uppercase text-primary">Recent Projects done in {{ $cause->name }}</h5>
                </div>
                <div class="row g-4">
                    @foreach($projects as $project)
                    <div class="col-lg-3 col-md-3 col-xl-3 mb-4">
    <div class="card shadow-sm border-0 h-100 overflow-hidden project-card">
        <!-- Project Image with Overlay -->
        <div class="position-relative">
            <img src="{{ $project->project_photo?->file_path ? asset('storage/' . $project->project_photo->file_path) : asset('images/default.png') }}" 
                class="card-img-top img-fluid" alt="{{ $project->title }}">
            
            <div class="overlay d-flex flex-column justify-content-between p-3">
                <div>
                    <small class="text-white d-block">
                        <i class="fas fa-chart-bar text-primary me-2"></i> Goal: {{ $project->budget ? number_format($project->budget, 2) : '-' }}
                    </small>
                    <small class="text-white d-block">
                        <i class="fa fa-thumbs-up text-primary me-2"></i> Raised: 0
                    </small>
                </div>
                <div class="text-end">
                    <a href="#" class="btn btn-sm btn-primary text-white py-1 px-3 btn-hover-bg">Donate Now</a>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="progress" style="height:6px;">
            <div class="progress-bar {{ $project->progress == 100 ? 'bg-success' : 'bg-info' }}" 
                 role="progressbar" style="width: {{ $project->progress }}%;" 
                 aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>

        <!-- Project Content -->
        <div class="card-body p-4 d-flex flex-column">
            <h5 class="card-title mb-2">{{ $project->title }}</h5>
            <p class="card-text text-muted mb-4">{{ Str::limit(strip_tags($project->summary), 120) }}</p>
            <div class="mt-auto d-flex justify-content-between align-items-center">
                <span class="badge {{ $project->progress == 100 ? 'bg-success' : 'bg-warning' }}">
                    {{ $project->progress == 100 ? 'Completed' : ucfirst($project->status) }}
                </span>
                <a href="{{ url('project/'.$project->id) }}" class="btn btn-sm btn-outline-primary btn-hover-bg">
                    Read More
                </a>
            </div>
        </div>
    </div>
</div> 
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->
    <style>
.project-card {
    transition: transform 0.3s, box-shadow 0.3s;
    border-radius: 12px;
}
.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.project-card .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    opacity: 0;
    transition: opacity 0.3s;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}
.project-card:hover .overlay {
    opacity: 1;
}
.btn-hover-bg:hover {
    background-color: #0056b3 !important;
    color: #fff !important;
}
.progress {
    border-radius: 0;
    margin-bottom: 0;
}
</style>

@endsection