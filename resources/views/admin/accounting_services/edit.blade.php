@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => 'active', 'all_team' => 'active', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Edit Franchise',
    'from' => 'Admin',
    'to' => 'Edit Franchise',
  ])
@endsection

@section('content')
  <div class="box-header">
    <h5 class="box-title">Franchise Edit Form</h5>
  </div>
  {!! Form::model($accounts, ['method' => 'POST', 'action' => ['AdminAccountingServicesController@update', $accounts->id], 'files' => true]) !!}
  <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', 'Amount') !!}
            {!! Form::text('amount', null, ['class' => 'form-control', 'placeholder'=>'Enter Amount']) !!}
            <small class="text-danger">{{ $errors->first('amount') }}</small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
            {!! Form::label('date', 'Date') !!}
            {!! Form::text('date', null, ['class' => 'form-control date-pick myform','placeholder'=>'Date' , 'autocomplete'=>"off",'readonly'=>"readonly"]) !!}
            <small class="text-danger">{{ $errors->first('date') }}</small>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="btn-group pull-left">
        {!! Form::submit("Update", ['class' => 'btn btn-add btn-default']) !!}
      </div>
    </div>
  {!! Form::close() !!}
@endsection
