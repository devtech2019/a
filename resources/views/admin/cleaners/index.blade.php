@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => 'active', 'all_user' => 'active', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'My Cleaners',
    'from' => 'Admin',
    'to' => 'My Cleaners',
  ])
@endsection

@section('content')
  <div class="table-responsive">
    <table class="table table-hover users-table">
      <thead>
        <tr class="info">
          <th>S.No.</th>
          <th>Image</th>
          <th>Name</th>
          <th>Email</th>
          <!-- <th>Gender</th> -->
          <th>Date Of Birth</th>
          <th>Mobile</th>
         
          <th>Action</th>
         
        </tr>
      </thead>
      <tbody>
        @if ($users)
          @php($i = 1)
          @foreach ($users as $value)
            <tr>
              <td>
                {{$i}}
                @php($i++)
              </td>
              <td><img width="80px" height="80px" src="{{asset('public/images/users/')}}/{{$value['user_cleaners']['photo']??''}}" alt="" class="img-responsive"></td>
            
         
              <td>{{$value['user_cleaners']['name']??''}}</td>

              <td> {{$value['user_cleaners']['email']??''}}</td>
        
              <td> {{$value['user_cleaners']['dob']??''}}</td>
              <td> {{$value['user_cleaners']['mobile']??''}}</td>
            
               <td><a href="{{route('cleaners.edit', $value['user_cleaners']['id'] ??'')}}" class="btn btn-sm btn-info">Edit</a></td>
                 <td>
              <!-- Delete button -->
              <button type="button" class="btn btn-info btn-sm btn-danger" data-toggle="modal" data-target="#{{$value['user_cleaners']['id']??''}}deleteModal">Delete</button>
              <!-- Delete Modal -->
              <div id="{{$value['user_cleaners']['id']??''}}deleteModal" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">Are You Sure ?</h4>
                      <p>Do you really want to delete these records? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                      {!! Form::open(['method' => 'DELETE', 'action' => ['AdminCleanerController@destroy', $value['user_cleaners']['id']??'']]) !!}
                          {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                          {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
              </div>
            </td>
              
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
@endsection
