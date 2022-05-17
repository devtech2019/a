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
    'coupon' => 'active','all_coupon'=>'','create_coupon'=>'active'
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Create Coupon',
    'from' => 'Admin',
    'to' => 'Create Coupon',
  ])
@endsection

@section('content')
  <div class="box-header">
    <div class="box-title">Coupon Create Form</div>
  </div>
  {!! Form::open(['method' => 'POST', 'action' => 'AdminCouponController@store', 'files' => true]) !!}
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
            {!! Form::label('Applicable_for', 'Applicable For') !!}
            {!! Form::select('applicable_for', [""=>"Choose Role","I"=>"Instant Booking","P"=>"Pre-Booking","B"=>"Both"], null, ['class' => 'form-control', 'id'=>'applicable_for', ]) !!}
            <small class="text-danger">{{ $errors->first('applicable_for') }}</small>
          </div>
          <div class="form-group{{ $errors->has('coupon_code') ? ' has-error' : '' }}">
            {!! Form::label('coupon_code', 'Coupon Code') !!}
            {!! Form::text('coupon_code', null, ['class' => 'form-control', 'placeholder' => 'Please Enter coupon']) !!}
            <small class="text-danger">{{ $errors->first('coupon_code') }}</small>
          </div>
            <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
            {!! Form::label('start date', 'Start Date') !!}
            {!! Form::text('start_date', null, ['class' => 'form-control date-pick', 'placeholder'=>'Start Date','readonly' => 'true']) !!}
            <small class="text-danger">{{ $errors->first('start_date') }}</small>
          </div>
         
           <div class="form-group radio{{ $errors->has('value_type') ? ' has-error' : '' }} user-create-radio" id="hidden2">
            <span>Value Type</span>
            <label for="" class="checkbox">
              {!! Form::radio('value_type', '%',  null, ['id' => 'value_type']) !!}  % ( Percent )
            </label>
            <label for="" class="checkbox">
              {!! Form::radio('value_type', 'Fixed price',  null, ['id'=> 'value_type',
              ]) !!} Fixed price
            </label>
            <small class="text-danger">{{ $errors->first('value_type') }}</small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Please Enter title']) !!}
            <small class="text-danger">{{ $errors->first('title') }}</small>
          </div>

         <div class="form-group{{ $errors->has('coupon_limit') ? ' has-error' : '' }}">
            {!! Form::label('coupon_limit', 'Coupon Limit') !!}
           {!! Form::text('coupon_limit', null, ['class' => 'form-control', 'placeholder' => 'Please Enter coupon limit']) !!}
            <small class="text-danger">{{ $errors->first('coupon_limit') }}</small>
          </div>
          <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
            {!! Form::label('end date', 'End Date') !!}
            {!! Form::text('end_date', null, ['class' => 'form-control date-pick', 'placeholder'=>'End Date','readonly' => 'true']) !!}
            <small class="text-danger">{{ $errors->first('end_date') }}</small>
          </div>
          <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
            {!! Form::label('value', 'Value') !!}
            {!! Form::text('value', null, ['class' => 'form-control', 'placeholder'=>' please enter a value']) !!}
            <small class="text-danger">{{ $errors->first('value') }}</small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Description') !!}
            {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Please Enter description']) !!}
            <small class="text-danger">{{ $errors->first('description') }}</small>
          </div>

           <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            {!! Form::label('status', 'Status') !!}
            {!! Form::select('status', [""=>"Chooes Status", "A"=>"Active", "D"=>"Inactive"], null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('status') }}</small>
          </div>
           <div class="col-md-4">

           <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
           
            {{ Form::hidden('user_id') }}
           
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

 