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
    'coupon' => 'active','all_coupon'=>'active','create_coupon'=>''
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'My Coupons ',
    'from' => 'Admin',
    'to' => 'My Coupons',
  ])
@endsection

@section('content')
<div class="teams-table-block table-responsive">
  <table class="table table-hover teams-table">
    <thead>
      <tr class="info">
        <th>S.No.</th>
        <th>Applicable for</th>
        <th>Coupon Code</th>
        <th>Title</th>
        <th>Description</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Status</th>
        <th colspan="3" style=" position: relative;margin-right: 50px">Action</th>
      </tr>
    </thead>
    <tbody>
      @if ($coupons)
        @php($i = 1)
        @foreach ($coupons as $coupons)
          <tr>
            <td>
              {{$i}}
              @php($i++)
            </td>
            
           <td>
              @if(isset($coupons))
                 @if($coupons->applicable_for == 'I')
                  <span class="badge">Instant Booking</span>
                  @endif
               @if($coupons->applicable_for == 'P')
                <span class="badge">{{"Pre Booking"}}</span>
                @endif
                 @if($coupons->applicable_for == 'B')
                <span class="badge">{{"Both"}}</span>
                @endif
  
                
                @endif
              </td>
               <td>{{strtoupper($coupons->coupon_code)}}</td>
            <td>{{$coupons->title}}</td>
            <td>{{$coupons->description}}</td>
            <td>{{$coupons->start_date}}</td>
            <td>{{$coupons->end_date}}</td>
          
            <td>{{$coupons->status == 'A' ? 'Active' : 'Inactive'}}</td>
           
                               
           
            <td>
              <!-- edit button -->
              <a href="{{route('coupons.edit', $coupons->id)}}" class="btn btn-info btn-sm">Edit</a>
            </td>
             
              <!-- edit button -->
             
            <td>
              <!-- Delete button -->
              <button type="button" class="btn btn-info btn-sm btn-danger" data-toggle="modal" data-target="#{{$coupons->id}}deleteModal">Delete</button>
              <!-- Delete Modal -->
              <div id="{{$coupons->id}}deleteModal" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">Are You Sure ?</h4>
                      <p>Do you really want to delete these coupons?</p>
                    </div>
                    <div class="modal-footer">
                      {!! Form::open(['method' => 'DELETE', 'action' => ['AdminCouponController@destroy', $coupons->id]]) !!}
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
