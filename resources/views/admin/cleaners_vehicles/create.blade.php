@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => 'active', 'all_team' => '', 'create_team' => 'active', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Create Cleaners Vehicles',
    'from' => 'Admin',
    'to' => 'Create Cleaners Vehicles',
  ])
@endsection

@section('content')
  <div class="box-header">
    <div class="box-title">Cleaners Vehicles Create Form</div>
  </div>
   
   {!! Form::model($item,['method' => 'POST', 'action' => ['AdminTeamController@CleanersVehicles',$franchiseid,$id], 'files' => true]) !!}    
   
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
       
         <!--   <div class="form-group{{ $errors->has('vehicle_make') ? ' has-error' : '' }}">
            {!! Form::label('vehicle_make', 'Vehicle Make') !!}
            {!! Form::text('vehicle_make',  null, ['class' => 'form-control', 'placeholder' => 'Please Enter vehicle company']) !!}
            <small class="text-danger">{{ $errors->first('vehicle_make') }}</small>
          </div>
          
            
          <div class="form-group{{ $errors->has('vehicle_model') ? ' has-error' : '' }}">
            {!! Form::label('vehicle_model', 'Vehicle Model') !!}
            {!! Form::text('vehicle_model',  null, ['class' => 'form-control', 'placeholder' => 'Please Enter vehicle model']) !!}
            <small class="text-danger">{{ $errors->first('vehicle_model') }}</small>
          </div> -->
          <div class="form-group{{ $errors->has('vehicle_registration_no') ? ' has-error' : '' }}">
            {!! Form::label('vehicle_registration_no', 'Vehicle Registration No') !!}
            {!! Form::text('vehicle_registration_no', null, ['class' => 'form-control', 'placeholder' => 'Please Enter vehicle registration no']) !!}
            <small class="text-danger">{{ $errors->first('vehicle_registration_no') }}</small>
          </div>
          
          	
          <div class="form-group{{ $errors->has('puc_no') ? ' has-error' : '' }}">
            {!! Form::label('puc_no', 'PUC Details') !!}
            {!! Form::file('puc_no') !!}
            <input type="hidden" name="puc_no" value="{{ $item['puc_no'] ??''}}  ">

          
            <small class="text-danger">{{ $errors->first('puc_no') }}</small>
          </div>
          
          @if(isset($item['puc_no']) && !empty($item['puc_no']))
          	<img class="img_call" src="{{ url('/public/images/teams/'.$item['puc_no']) ??''}}">
          @endif
        </div>
        <div class="col-md-4">
          
           <!-- <div class="form-group{{ $errors->has('vehicle_name') ? ' has-error' : '' }}">
            {!! Form::label('vehicle_name', 'Vehicle Name') !!}
            {!! Form::text('vehicle_name', null, ['class' => 'form-control', 'placeholder' => 'Please Enter vehicle name']) !!}
            <small class="text-danger">{{ $errors->first('vehicle_name') }}</small>
          </div> -->
          <div class="form-group{{ $errors->has('car_registration_img') ? ' has-error' : '' }}">
            {!! Form::label('car_registration_img', 'Photo For Car Registration') !!}
            {!! Form::file(' car_registration_img') !!}
            <input type="hidden" name="car_registration_img" value="{{ $item['car_registration_img'] ??''}}">
            <small class="text-danger">{{ $errors->first('car_registration_img') }}</small>
          </div>
          @if(isset($item['car_registration_img']) && !empty($item['car_registration_img']))
          	<img class="img_call" src="{{ url('/public/images/teams/'.$item['car_registration_img']) ??''}}">
          @endif
          <div class="form-group {{ $errors->has('tracker_device_driver_id') ? ' has-error' : '' }}">
            {!! Form::label('Tracker device driver id', 'Tracker Device Driver Id') !!}
            {!! Form::text('tracker_device_driver_id', null, ['class' => 'form-control', 'placeholder' => 'Enter your tracker device driver id']) !!}
            <small class="text-danger">{{ $errors->first('tracker_device_driver_id') }}</small>
          </div>
        
          <div class="form-group{{ $errors->has('franchise_id') ? ' has-error' : '' }}">
           
            {{ Form::hidden('franchise_id') }}
           
           
          </div>
          <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
           
            
            {{ Form::hidden('id') }}
           
          </div>
           <div class="form-group{{ $errors->has('cleaner_id') ? ' has-error' : '' }}">
           
            {{ Form::hidden('cleaner_id') }}
           
          </div>
           <div class="form-group{{ $errors->has('added_by') ? ' has-error' : '' }}">
           
            {{ Form::hidden('added_by') }}
           
          </div>
         
        </div>
       
          <div class="col-md-4">
              <div class="form-group{{ $errors->has('vehicle_insurance_no') ? ' has-error' : '' }}">
              {!! Form::label('vehicle_insurance_no', 'Vehicle Insurance Details') !!}
              {!! Form::file(' vehicle_insurance_no') !!}
              <input type="hidden" name="vehicle_insurance_no" value="{{ $item['vehicle_insurance_no'] ??''}}">
            <small class="text-danger">{{ $errors->first('vehicle_insurance_no') }}</small>
          </div>
          @if(isset($item['vehicle_insurance_no']) && !empty($item['vehicle_insurance_no']))
          	<img class="img_call" src="{{ url('/public/images/teams/'.$item['vehicle_insurance_no']) ??''}}">
          @endif
          <!-- <div class="form-group{{ $errors->has('vehicle_icon') ? ' has-error' : '' }}">
            {!! Form::label('vehicle_icon', 'vehicle_icon') !!}
            {!! Form::text('vehicle_icon', null, ['class' => 'form-control iconpicker-custom', 'placeholder' => 'Please Enter vehicle icon','autocomplete'=>"off",'readonly'=>'readonly']) !!}
            <small class="text-danger">{{ $errors->first('vehicle_icon') }}</small>
          </div> -->
         
        </div>  
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="btn-group pull-left">
        {!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!}
        {!! Form::submit("Create", ['class' => 'btn btn-add btn-default']) !!}
      </div>
    </div>
  {!! Form::close() !!}

<style>
.img_call {
    width: 50px;
    height: 50px;
    border-radius: 100px;
}
</style>
@endsection

 