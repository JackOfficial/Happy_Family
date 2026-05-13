@extends('admin.layouts.app')

@section('title')
<title>Happy Family | Dashboard</title>
@endsection

@section('content')
   
<section class="content mt-3">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- Projects Progress Card -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ number_format($averageProgress, 0) }}<sup style="font-size: 20px">%</sup></h3>
              <p>Avg Project Progress</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ url('/admin/projects') }}" class="small-box-footer">View {{ $projectsCount }} Projects <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Career Applications Card -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $totalApplications }}</h3>
              <p>Total Job Applications</p>
              @if($pendingApplications > 0)
                <span class="badge badge-warning text-dark">{{ $pendingApplications }} New/Pending</span>
              @endif
            </div>
            <div class="icon">
              <i class="ion ion-document-text"></i>
            </div>
            <a href="{{ url('/admin/applications') }}" class="small-box-footer">Review Applications <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Causes Card -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>{{ $causes }}</h3>
              <p>Active Causes</p>
            </div>
            <div class="icon">
              <i class="ion ion-heart"></i>
            </div>
            <a href="{{ url('/admin/causes') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Volunteers Card -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $volunteers }}</h3>
              <p>Volunteers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="{{ url('/admin/volunteers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

      <!-- Recent Applications Table Row -->
      <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h3 class="card-title font-weight-bold">Recent Job Applications</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Applicant Name</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th>Applied Date</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentApplications as $app)
                                <tr>
                                    <td class="font-weight-bold">{{ $app->full_name }}</td>
                                    <td>{{ $app->job->title ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge @if($app->status == 'pending') badge-warning @elseif($app->status == 'rejected') badge-danger @else badge-success @endif">
                                            {{ ucfirst($app->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $app->created_at->format('d M, Y') }}</td>
                                    <td class="text-right">
                                        <a href="{{ url('/admin/applications/'.$app->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No recent applications found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ url('/admin/applications') }}" class="text-uppercase small font-weight-bold">View All Applications</a>
                </div>
            </div>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </section>
@endsection