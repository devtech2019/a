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
    <div class="box-title">Vehicle Class Create Form</div>
  </div>
  {!! Form::open(['method' => 'POST', 'action' => 'AdminVehicleTypeController@store']) !!}
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
           <div class="form-group {{ $errors->has('icon') ? ' has-error' : '' }} ">
                {!! Form::label('icon', 'Icon Code') !!}
                {!! Form::text('icon', null, ['class' => 'form-control iconpicker-custom', 'placeholder'=>'Choose Icon', 'autocomplete'=>"off"]) !!}
                <small class="text-danger">{{ $errors->first('icon') }}</small>
              </div>
        </div>
             <div class="col-md-6">
                <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }} ">
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
        {!! Form::submit("Create", ['class' => 'btn btn-add btn-default']) !!}
      </div>
    </div>
  {!! Form::close() !!}
@endsection
  

      

 