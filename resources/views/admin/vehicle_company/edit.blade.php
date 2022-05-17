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
    'title' => 'Vehicle Companies',
    'from' => 'Admin',
    'to' => 'Vehicle company',
  ])
@endsection

@section('content')
  <div class="box-header">
    <h5 class="box-title">Vehicle Company Edit Form</h5>
  </div>
  {!! Form::model( $vehicle_company, ['method' => 'POST', 'action' => ['AdminVehicleCompController@update',  $vehicle_company->id], 'files' => true]) !!}
   
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('vehicle_company') ? ' has-error' : '' }}">
                {!! Form::label('vehicle_company', 'Vehicle Company') !!}
                {!! Form::text('vehicle_company', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Enter Vehicle Company']) !!}
                <small class="text-danger">{{ $errors->first('vehicle_company') }}</small>
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
