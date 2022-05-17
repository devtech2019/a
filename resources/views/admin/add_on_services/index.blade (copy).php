@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => 'active', 'all_plan' => '', 'plan_price' => 'active',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Add On Services',
    'from' => 'Admin',
    'to' => 'Add On Services',
  ])
@endsection

@section('content')
  <div class="teams-table-block table-responsive">
  <table class="table table-hover teams-table">
    <thead>
      <tr class="info">
        <th>S.No.</th>
        <th>Name</th>
        <th>Price</th>
        <th>Duration</th>
      
        <th>Status</th>
        <th colspan="3" style=" position: relative;margin-right: 50px">Action</th>
      </tr>
    </thead>
    <tbody>
      @if ($add_on_services)
        @php($i = 1)
        @foreach ($add_on_services as $add_on_services)
          <tr>
            <td>
              {{$i}}
              @php($i++)
            </td>
            
          
            <td>{{$add_on_services->name}}</td>
            <td>{{$add_on_services->price}}</td>
            <td>{{$add_on_services->duration}}</td>
           
          
            <td>{{$add_on_services->status == 'A' ? 'Active' : 'Inactive'}}</td>
           
                               
           
            <td>
              <!-- edit button -->
              <a href="{{route('add_on_services.edit', $add_on_services->id)}}" class="btn btn-info btn-sm">Edit</a>
           
             
              <!-- edit button -->
             
            
              <!-- Delete button -->
              <button type="button" class="btn btn-info btn-sm btn-danger" data-toggle="modal" data-target="#{{$add_on_services->id}}deleteModal">Delete</button>
              <!-- Delete Modal -->
              <div id="{{$add_on_services->id}}deleteModal" class="delete-modal modal fade" role="dialog">
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
                      {!! Form::open(['method' => 'DELETE', 'action' => ['AdminAddOnServicesController@destroy', $add_on_services->id]]) !!}
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
