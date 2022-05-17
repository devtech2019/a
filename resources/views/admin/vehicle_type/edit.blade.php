@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => 'active', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => 'active',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Vehicle Class',
    'from' => 'Admin',
    'to' => 'Vehicle class',
  ])
@endsection

@section('content')
  <div class="box-header">
    <h5 class="box-title">Vehicle Modal Edit Form</h5>
  </div>
  {!! Form::model(  $vehicle_type, ['method' => 'POST', 'action' => ['AdminVehicleTypeController@update',   $vehicle_type->id], 'files' => true]) !!}
   
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
           <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }} ">
                {!! Form::label('icon', 'Icon Code') !!}
                {!! Form::text('icon', null, ['class' => 'form-control iconpicker-custom', 'placeholder'=>'Choose Icon']) !!}
                <small class="text-danger">{{ $errors->first('icon') }}</small>
              </div>
        </div>
        <div class="col-md-6">
                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }} ">
                {!! Form::label('type', 'Vehicle Class') !!}
                {!! Form::text('type', null, ['class' => 'form-control', 'placeholder'=>'Vehicle Class']) !!}
                <small class="text-danger">{{ $errors->first('type') }}</small>
              </div>
              </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="btn-group pull-left">
        {!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!}
        {!! Form::submit("Update", ['class' => 'btn btn-add btn-default']) !!}
      </div>
    </div>
  {!! Form::close() !!}
@endsection