@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => 'active', 'vehicle_company' => 'active', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Vehicle Modals',
    'from' => 'Admin',
    'to' => 'Vehicle modal',
  ])
@endsection

@section('content')



<div class="box-header">
    <div class="box-title">Vehicle Modal Create Form</div>
  </div>
  {!! Form::open(['method' => 'POST', 'action' => 'AdminVehicleModalController@store']) !!}
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
           <div class="form-group{{ $errors->has('vehicle_company_id') ? ' has-error' : '' }}">
                  {!! Form::label('vehicle_company_id', 'Vehicle Company') !!}
                  {!! Form::select('vehicle_company_id', array(''=>'Select Vehicle Company') + $vehicle_companies, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('vehicle_company_id') }}</small>
                </div>  
        </div>
        <div class="col-md-6">
                <div class="form-group{{ $errors->has('vehicle_modal') ? ' has-error' : '' }}">
                  {!! Form::label('vehicle_modal', 'Vehicle Modal') !!}
                  {!! Form::text('vehicle_modal', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Enter Modal']) !!}
                  <small class="text-danger">{{ $errors->first('vehicle_modal') }}</small>
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
  

      

 