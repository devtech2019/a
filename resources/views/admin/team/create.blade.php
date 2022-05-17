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
    'title' => 'Create Franchise',
    'from' => 'Admin',
    'to' => 'Create Franchise',
  ])
@endsection

@section('content')
  <div class="box-header">
    <div class="box-title">Franchise Create Form</div>
  </div>
  {!! Form::open(['method' => 'POST', 'action' => 'AdminTeamController@store', 'files' => true, 'autocomplete' =>'off']) !!}
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Enter Name']) !!}
            <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Email address') !!}
            {!! Form::email('email', null, ['class' => 'form-control myform', 'placeholder' => 'eg: foo@bar.com']) !!}
            <small class="text-danger">{{ $errors->first('email') }}</small>
          </div>
          <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
            {!! Form::label('mobile', 'Mobile') !!}
            {!! Form::text('mobile', null, ['class' => 'form-control',  'placeholder'=>'Mobile No.']) !!}
            <small class="text-danger">{{ $errors->first('mobile') }}</small>
          </div>
          <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            {!! Form::label('phone', 'Phone') !!}
            {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder'=>'Phone No.']) !!}
            <small class="text-danger">{{ $errors->first('phone') }}</small>
          </div>
          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::label('password', 'Password') !!}
              {!! Form::password('password', ['class' => 'form-control myform',  'placeholder' => 'Enter Password']) !!}
              <small class="text-danger">{{ $errors->first('password') }}</small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
            {!! Form::label('dob', 'Foundation Date') !!}
            {!! Form::text('dob', null, ['class' => 'form-control date-pick myform','placeholder'=>'Foundation Date' , 'autocomplete'=>"off"]) !!}
            <small class="text-danger">{{ $errors->first('dob') }}</small>
          </div>

          <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            {!! Form::label('status', 'Status') !!}
            {!! Form::select('status', [""=>"Chooes Status", "A"=>"Active", "D"=>"Inactive"], null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('status') }}</small>
          </div>
          <div class="form-group{{ $errors->has('post') ? ' has-error' : '' }}">
            {!! Form::label('post', 'Enter Post') !!}
            {!! Form::text('post', null, ['class' => 'form-control', 'placeholder'=>'Enter Post']) !!}
            <small class="text-danger">{{ $errors->first('post') }}</small>
          </div>
          <div class="form-group{{ $errors->has('join_date') ? ' has-error' : '' }}">
            {!! Form::label('join_date', 'Join Date') !!}
            {!! Form::text('join_date', null, ['class' => 'form-control date-pick','id'=>'datepicker', 'placeholder'=>'Join Date','autocomplete'=>"off"]) !!}
            <small class="text-danger">{{ $errors->first('join_date') }}</small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            {!! Form::label('address', 'Address') !!}
            {!! Form::textarea('address', null, ['class' => 'form-control', 'rows'=>'4', 'placeholder'=>'Enter Your Address']) !!}
            <small class="text-danger">{{ $errors->first('address') }}</small>
          </div>
           <div class="col-md-4">

           <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
           
            {{ Form::hidden('user_id') }}
           
          </div>

          <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
            {!! Form::label('photo', 'Image') !!}
            {!! Form::file('photo') !!}
          
            <small class="text-danger">{{ $errors->first('photo') }}</small>
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

 <script>

$.validator.addMethod("maxDate", function (value, element) {
    var max = new Date(<?php echo date("U",strtotime("-18 year"));?>);
    var inputDate = new Date(value);
    if (inputDate > max)
        return false;
    return true;
}, "Minimum Age 18 Years");


</script> 
 