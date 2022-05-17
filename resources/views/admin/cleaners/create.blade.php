@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => 'active', 'all_user' => '', 'create_user' => 'active',
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
    'title' => 'Create Cleaner',
    'from' => 'Admin',
    'to' => 'Create Cleaner',
  ])
@endsection

@section('content')
  <div class="box-header with-border">
    <div class="box-title">Cleaner Create Form</div>
  </div>
  {!! Form::open(['method' => 'POST', 'action' => 'AdminCleanerController@store', 'files' => true]) !!}

    <div class="box-body">

      <div class="row">
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control',  'placeholder' => 'Enter your name', 'autofocus']) !!}
            <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
          <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
            {!! Form::label('dob', 'Date Of Birth') !!}
            {!! Form::text('dob', null, ['id' => '', 'class' => 'form-control date-pick',  'placeholder' => 'Date of birth']) !!}
            <small class="text-danger">{{ $errors->first('dob') }}</small>
          </div>


          <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            {!! Form::label('phone', 'Phone') !!}
            {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone no']) !!}
            <small class="text-danger">{{ $errors->first('phone') }}</small>
          </div>
          
          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::label('password', 'Password') !!}
              {!! Form::password('password', ['class' => 'form-control',  'placeholder' => 'Enter Password']) !!}
              <small class="text-danger">{{ $errors->first('password') }}</small>
          </div>
         

          <div class="radio{{ $errors->has('sex') ? ' has-error' : '' }} user-create-radio">
            <span>Gender</span>
            <label for="sex" class="checkbox">
              {!! Form::radio('sex', 'M',  null, [
                  'id'    => 'sex',
              ]) !!} Male
            </label>
            <label for="sex" class="checkbox">
              {!! Form::radio('sex', 'F',  null, [
                  'id'    => 'sex',
              ]) !!} Female
            </label>
          </div>
        </div>
        <div class="col-md-4">
         <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Email address') !!}
            {!! Form::email('email', null, ['class' => 'form-control',  'placeholder' => 'eg: foo@bar.com']) !!}
            <small class="text-danger">{{ $errors->first('email') }}</small>
          </div>
           <div class="form-group{{ $errors->has('zip_code') ? ' has-error' : '' }}">
            {!! Form::label('zip_code', 'Zip Code') !!}
           {!! Form::text('zip_code', null, ['class' => 'form-control',  'placeholder' => 'Enter your zip_code', 'autofocus']) !!}
            <small class="text-danger">{{ $errors->first('zip_code') }}</small>
          </div>
           <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            {!! Form::label('address', 'Address') !!}
            {!! Form::textarea('address', null, ['class' => 'form-control', 'rows'=>'5',  'placeholder' => 'Enter your address']) !!}
            <small class="text-danger">{{ $errors->first('address') }}</small>
          </div>

          <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
            {!! Form::label('photo', 'Image') !!}
            {!! Form::file('photo') !!}
            <p class="help-block">Help block text</p>
            <small class="text-danger">{{ $errors->first('photo') }}</small>
          </div>
        </div>







        <div class="col-md-4">

           <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
            {!! Form::label('mobile', 'Mobile') !!}
            {!! Form::text('mobile', null, ['class' => 'form-control',  'placeholder' => 'Mobile no']) !!}
            <small class="text-danger">{{ $errors->first('mobile') }}</small>
          </div>
          @if(Auth::user()->role  !=  "S")
            <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
              {!! Form::label('role', 'Role') !!}
              {!! Form::select('role', [""=>"Choose Role","C"=>"Cleaner"], null, ['class' => 'form-control', 'id'=>'roles', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('role') }}</small>
            </div>
            <div class="col-md-12" id="hidden">
              <div class="form-group{{ $errors->has('franchise_id') ? ' has-error' : '' }}">
                {!! Form::label('Franchisee', 'Franchisee') !!}
               
                {!! Form::select('franchise_id', [""=>$franchiseList], null, ['class' => 'form-control ','id'=>'hidden', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('franchise_id') }}</small>
              </div>
            </div>  
          @endif


          <div class="form-group {{ $errors->has('license_no') ? ' has-error' : '' }}" id="hidden1">
            {!! Form::label('license_no', 'License No') !!}
            {!! Form::text('license_no', null, ['class' => 'form-control','placeholder' => 'Enter your license_no']) !!}
            <small class="text-danger">{{ $errors->first('license_no') }}</small>
          </div>
           <div class="form-group radio {{ $errors->has('police_clearance') ? ' has-error' : '' }} user-create-radio" id="hidden2">
            <span>Police Clearance</span>
            <label for="" class="checkbox">
              {!! Form::radio('police_clearance', 'Yes',  null, [
                  'id'    => 'police_clearance',
              ]) !!} Yes
            </label>
            <label for="" class="checkbox">
              {!! Form::radio('police_clearance', 'N0',  null, ['id'=> 'police_clearance',]) !!} No
            </label>
            <small class="text-danger">{{ $errors->first('police_clearance') }}</small>
          </div>




        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="btn-group pull-center">
        {!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!}
        {!! Form::submit("Create User", ['class' => 'btn btn-add btn-default']) !!}
      </div>
    </div>
  {!! Form::close() !!}
  @if(Auth::user()->role  !=  "S")
    <script type="text/javascript" charset="utf-8">
        $(function () {
           $('#hidden').hide(); 
          // Session Popup
          $( document ).ready(function() {
            $('#roles').change(function(){
                if($('#roles').val() == 'C') {

                    $('#hidden').show(); 
                } else {
                    $('#hidden').hide(); 
                } 
            });
          });
        });
    </script>
  @endif
@endsection
