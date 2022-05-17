@extends('layouts.admin')
@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
    'cleanersBookings' => '', 'all_bookings' => '',
  ])
@endsection

@if (Auth::user()->role == 'A')
  @section('breadcum')
    @include('include.breadcum', [
      'title' => 'Dashboard',
      'from' => 'Dashboard',
      'to' => 'Admin',
    ])
  @endsection
  @section('dashboard')
    <div class="dashboard-main-block">
      <div class="row">
        <div class="col-md-7">
          <div class="row">
            <div class="col-md-6">
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3>{{$u_count}}</h3>
                  <p>User Registrations</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="{{url('/admin/users')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-md-6">
              <div class="small-box bg-maroon">
                <div class="inner">
                  <h3>{{$teams}}</h3>
                  <p>Franchise</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="{{url('/admin/team')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- <div class="col-md-4">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$team_task}}</h3>
                  <p>Team Tasks</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{url('/admin/team_task')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div> -->
            <div class="col-md-6">
              <div class="small-box bg-purple">
                <div class="inner">
                  <h3>{{$washing_plan}}</h3>
                  <p>Washing Plans</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('/admin/washing_plan')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- <div class="col-md-4">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$appointment}}</h3>
                  <p>Appointments Booked!</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{url('/admin/appointment')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div> -->
            <div class="col-md-6">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{$services}}</h3>
                  <p>All Services</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('/admin/services')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- <div class="col-md-4">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$blogs}}</h3>
                  <p>All Blogs</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('/admin/blog')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div> -->
            <div class="col-md-6">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{$testimonials}}</h3>
                  <p>All Testimonials</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="{{url('/admin/testimonial')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="box boxdashboard box-danger">
            <div class="box-header with-border">
              <h4 class="box-title" style="color: white;">Latest Members</h4>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
                @if ($users)
                  @foreach ($users as $user)
                    <li>
                      {{-- {{$user}} --}}

                      @if(isset($user->photo) && !empty($user->photo) && file_exists(public_path('images/users/'.$user->photo)))
                        <img class="user_dashboard_img" src="{{asset('public/images/users')}}/{{$user->photo}}" alt="User Image">
                      @else
                        <img class="user_dashboard_img" src="{{asset('public/images/blank-profile.png')}}" alt="User Image">
                      @endif
                      <a class="users-list-name" href="{{url('admin/users/'.'edit/'.$user->id)}}" title="{{$user->name}}">{{$user->name}}</a>
                      <span class="users-list-date">{{$user->created_at->diffForHumans()}}</span>
                    </li>
                  @endforeach
                @endif
              </ul>
              <!-- /.users-list -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center box-footer-manual btn-add">
              <a href="{{url('/admin/users')}}" class="uppercase">View All Users</a>
            </div>
            <!-- /.box-footer -->
          </div>
        </div>
      </div>
    </div>
  @endsection

  @section('content')
    <div class="dashboard-btn-block box-body">
      <a href="{{url('/admin/users')}}" class="btn btn-primary btn-add">All Users</a>
      <a href="{{url('/admin/team')}}" class="btn btn-primary btn-add">Franchises</a>
      <a href="{{url('/admin/team_task')}}" class="btn btn-primary btn-add">Franchise Task</a>
      <a href="{{url('/admin/washing_plan')}}" class="btn btn-primary btn-add">Washing Plans</a>
      <a href="{{url('/admin/vehicle_type')}}" class="btn btn-primary btn-add">Vehicle Type</a>
      <!-- <a href="{{url('/admin/appointment')}}" class="btn btn-default btn-add">Appointment</a> -->
      <!-- <a href="{{url('/admin/status')}}" class="btn btn-default btn-add">Status</a>
      <a href="{{url('/admin/services')}}" class="btn btn-default btn-add">Services</a>
      <a href="{{url('/admin/gallery')}}" class="btn btn-default btn-add">Gallery</a>
      <a href="{{url('/admin/facts')}}" class="btn btn-default btn-add">Facts</a>
      <a href="{{url('/admin/testimonial')}}" class="btn btn-default btn-add">Testimonials</a>
      <a href="{{url('/admin/blog')}}" class="btn btn-default btn-add">Blogs</a>
      <a href="{{url('/admin/clients')}}" class="btn btn-default btn-add">Clients</a>
      <a href="{{url('/admin/contact')}}" class="btn btn-default btn-add">Contact</a> -->
    </div>
  @endsection

@endif

@if (Auth::user()->role == 'S')
  @section('breadcum')
    @include('include.breadcum', [
      'title' => 'Dashboard',
      'from' => 'User',
      'to' => 'Dashboard',
    ])
  @endsection
  @section('content')
    <div class="dashboard-btn-block box-body">
    <div class="dashboard-main-block">
      <div class="row">
        <div class="col-md-7">
          <div class="row">
            <div class="col-md-6">
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3>{{$cleaners_count}}</h3>
                  <p>All Cleaners</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="{{url('/admin/users')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-md-6">
              <div class="small-box bg-maroon">
                <div class="inner">
                  <h3>{{$bookingCleaners }}</h3>
                  <p>All Appointments</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <!-- <a href="{{url('/admin/team')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a> -->
                <a href="" class="small-box-footer"><i class=""></i>  
                </a>
              </div>
            </div>

           <!--  <div class="col-md-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{ $payment_count }}</h3>
                  <p>Total Earnings </p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="" class="small-box-footer"><i class=""></i>
                 
                </a>
              </div>
            </div> -->
            <!-- <div class="col-md-4">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$team_task}}</h3>
                  <p>Team Tasks</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{url('/admin/team_task')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div> -->
            <!-- <div class="col-md-6">
              <div class="small-box bg-purple">
                <div class="inner">
                  <h3>{{$washing_plan}}</h3>
                  <p>Washing Plans</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('/admin/washing_plan')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div> -->
            <!-- <div class="col-md-4">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$appointment}}</h3>
                  <p>Appointments Booked!</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{url('/admin/appointment')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div> -->
            <!-- <div class="col-md-6">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{$services}}</h3>
                  <p>All Services</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('/admin/services')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div> -->
            <!-- <div class="col-md-4">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$blogs}}</h3>
                  <p>All Blogs</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('/admin/blog')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div> -->
            <!-- <div class="col-md-6">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{$testimonials}}</h3>
                  <p>All Testimonials</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="{{url('/admin/testimonial')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div> -->
          </div>
        </div>
        <div class="col-md-5">
          <div class="box boxdashboard box-danger">
            <div class="box-header with-border">
              <h4 class="box-title" style="color: white;">Latest Members</h4>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
                @if ($franchise_cleaners )
                  @foreach ($franchise_cleaners as $user)
                    <li>
                      {{-- {{$user}} --}}

                      @if(isset($user->photo) && !empty($user->photo) && file_exists(public_path('images/users/'.$user->photo)))
                        <img class="user_dashboard_img" src="{{asset('public/images/users')}}/{{$user->photo}}" alt="User Image">
                      @else
                        <img class="user_dashboard_img" src="{{asset('public/images/blank-profile.png')}}" alt="User Image">
                      @endif
                      <a class="users-list-name" href="{{url('admin/users/'.'edit/'.$user->id)}}" title="{{$user->name}}">{{$user->name}}</a>
                      <span class="users-list-date">{{$user->created_at->diffForHumans()}}</span>
                    </li>
                  @endforeach
                @endif
              
              </ul>
              <!-- /.users-list -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center box-footer-manual btn-add">
              <a href="{{url('/admin/users')}}" class="uppercase">View All Cleaners</a>
            </div>
            <!-- /.box-footer -->
          </div>
        </div>
      </div>
    </div>
      <!-- <a href="{{url('/admin/profile')}}" class="btn btn-default btn-add">Profile</a> -->
      <!-- <a href="{{url('/admin/appointment')}}" class="btn btn-default btn-add">Appointments</a> -->
    </div>
  @endsection  @endif