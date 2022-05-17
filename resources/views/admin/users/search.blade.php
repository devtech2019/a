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
    'title' => 'All User',
    'from' => 'Admin',
    'to' => 'All Users',
  ])
@endsection

@section('content')
  <form action="{{URL ::to('/admin/search')}}" method="POST" role="search">
    {{ csrf_field() }}
    <div class="input-group">
        <input type="text" class="form-control" name="q"
            placeholder="Search users"> <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </span>
    </div>
</form>


<div class="container">
    @if(isset($details))
        <p> The Search results for your query <b> {{ $query }} </b> are :</p>
    <h2>Sample User details</h2>
    <div class="table-responsive">
    <table class="table table-hover users-table">
   
        <thead>
             <tr class="info">
          <th>S.No.</th>
          <th>Image</th>    
          <th>Name</th>
          <th>Email</th>
          <th>Gendor</th>
          <th>Date Of Birth</th>
          <th>Mobile</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Role</th>
          <th>Created At</th>
          <th>Updated At</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
        </thead>
        <tbody>
          
          @php($i = 1)
          
            
            @foreach($details as $user)
           
              <td>
                {{$i}}
                @php($i++)
              </td>
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->sex == 'M' ? 'Male' : 'Female'}}</td>
              <td>{{$user->dob}}</td>
              <td>{{$user->mobile}}</td>
              <td>{{$user->phone ? $user->phone : '-'}}</td>
              <td>{{str_limit($user->address, 10)}}</td>
              <td>
              @if(isset($user))
                 @if($user->role == 'A')
                  <span class="badge">Administrator</span>
                  @endif
               @if($user->role == 'C')
                <span class="badge">{{"Cleaner"}}</span>
                @endif
                 @if($user->role == 'U')
                <span class="badge">{{"Front-User"}}</span>
                @endif
              
              @if($user->role == 'S')
                <span class="badge">{{"Subscriber"}}</span>
                @endif
                
                @endif
              </td>
             
              <td>{{$user->created_at->diffForHumans()}}</td>
              <td>{{$user->updated_at->diffForHumans()}}</td>
              <td><a href="{{route('admin.users.edit', $user->id)}}" class="btn btn-sm btn-info">Edit</a></td>
              <td>
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#{{$user->id}}deleteModal">Delete</button>
                <!-- Modal -->
                <div id="{{$user->id}}deleteModal" class="delete-modal modal fade" role="dialog">
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
                        {!! Form::open(['method' => 'DELETE', 'action' => ['AdminUsersController@destroy', $user->id]]) !!}
                          {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss'=>'modal']) !!}
                          {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
        </tbody>
    </table>
  </div>
    @endif
</div>
@endsection
