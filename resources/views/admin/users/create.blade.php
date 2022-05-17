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
    'title' => 'Create User',
    'from' => 'Admin',
    'to' => 'User Create',
  ])
@endsection

@section('content')

  <div class="box-header with-border">
  
    <div class="box-title">User Create Form</div>
  </div>
  {!! Form::open(['method' => 'POST', 'action' => 'AdminUsersController@store', 'files' => true]) !!}
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          @if(Auth::user()->role  !=  "S")
            <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
              {!! Form::label('role', 'Role') !!}
              {!! Form::select('role', [""=>"Choose Role","C"=>"Cleaner","U"=>"Customer"], null, ['class' => 'form-control', 'id'=>'roles']) !!}
              <small class="text-danger">{{ $errors->first('role') }}</small>
            </div>
            <div  id="hidden">
              <div class="form-group {{ $errors->has('franchise_id') ? ' has-error' : '' }}">
                {!! Form::label('Franchise', 'Franchise') !!}
                {!! Form::select('franchise_id', [""=>"Choose Franchise"]+$franchiseList, null, ['class' => 'form-control ','id'=>'hidden']) !!}
                <small class="text-danger">{{ $errors->first('franchise_id') }}</small>
              </div>
            </div>  
          @endif
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control',  'placeholder' => 'Enter your name', 'autofocus']) !!}
            <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
          <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
            {!! Form::label('dob', 'Date Of Birth') !!}
            {!! Form::text('dob', null, [ 'class' => 'form-control datepicker',  'placeholder' => 'Date of birth' , 'readonly'=>'readonly']) !!}
            <small class="text-danger">{{ $errors->first('dob') }}</small>
          </div>
          <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            {!! Form::label('phone', 'Phone') !!}
            {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone no']) !!}
            <small class="text-danger">{{ $errors->first('phone') }}</small>
          </div>

       <!--    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::label('password', 'Password') !!}
              {!! Form::password('password', ['class' => 'form-control',  'placeholder' => 'Enter Password']) !!}
              <small class="text-danger">{{ $errors->first('password') }}</small>
          </div> -->

          <div class="form-group radio{{ $errors->has('gender') ? ' has-error' : '' }} user-create-radio">
            <span>Gender</span>
            <label for="" class="checkbox">
              {!! Form::radio('gender', 'M',  null, [
                  'id'    => 'gender',
              ]) !!} Male
            </label>
            <label for="" class="checkbox">
              {!! Form::radio('gender', 'F',  null, [
                  'id'    => 'gender',
              ]) !!} Female
            </label> 
            <small class="text-danger">{{ $errors->first('gender') }}</small>
          </div>
          
         
          <div class="form-group radio{{ $errors->has('police_clearance') ? ' has-error' : '' }} user-create-radio" id="hidden2">
            <span>Police Clearance</span>
            <label for="" class="checkbox">
              {!! Form::radio('police_clearance', 'Yes',  null, [
                  'id'    => 'police_clearance',
              ]) !!} Yes
            </label>
            <label for="" class="checkbox">
              {!! Form::radio('police_clearance', 'N0',  null, [
                  'id'    => 'police_clearance',
              ]) !!} No
            </label>
            <small class="text-danger">{{ $errors->first('police_clearance') }}</small>
          </div>
        

        </div>
        <div class="col-md-4">
         <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Email address') !!}
            {!! Form::email('email', null, ['class' => 'form-control myform',  'placeholder' => 'eg: foo@bar.com']) !!}
            <small class="text-danger">{{ $errors->first('email') }}</small>
          </div>
         
           <div class="form-group{{ $errors->has('license_no') ? ' has-error' : '' }}" id="hidden1">
            {!! Form::label('license_no', 'License No') !!}
           {!! Form::text('license_no', null, ['class' => 'form-control',  'placeholder' => 'Enter your license no', 'autofocus']) !!}
            <small class="text-danger">{{ $errors->first('license_no') }}</small>
          </div>
         
        
           <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            {!! Form::label('address', 'Address') !!}
            {!! Form::textarea('address', null, ['class' => 'form-control', 'rows'=>'5',  'placeholder' => 'Enter your address']) !!}
            <small class="text-danger">{{ $errors->first('address') }}</small>
          </div>

          <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
            {!! Form::label('photo', 'Image') !!}
            {!! Form::file('photo') !!}
             <small class="text-danger">{{ $errors->first('photo') }}</small>
          </div>

        </div>

        <div class="col-md-4">

           <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
            {!! Form::label('mobile', 'Mobile') !!}
            {!! Form::text('mobile', null, ['class' => 'form-control',  'placeholder' => 'Mobile no']) !!}
            <small class="text-danger">{{ $errors->first('mobile') }}</small>
          </div>
          
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="btn-group pull-center">
        @if(isset( $errors) && count($errors) > 0)
          <a class='btn btn-yellow btn-default' href="">Reset</a>
        @else
          {!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!}
        @endif
        {!! Form::submit("Create User", ['class' => 'btn btn-add btn-default']) !!}
      </div>
    </div>
  {!! Form::close() !!}

@if(Auth::user()->role  ==  "A")
    <script type="text/javascript" charset="utf-8">
        $(function () {
           $('#hidden').hide();
          // Session Popup
          $( document ).ready(function() {
            $('#roles').change(function(){
                if($('#roles').val() == 'C') {

                    $('#hidden').show();
                     $('#hidden1').show();
                     $('#hidden2').show();
                } else {
                    $('#hidden').hide();
                    $('#hidden1').hide();
                    $('#hidden2').hide();

                }
            });
             if($('#roles').val() == 'C') {

                    $('#hidden').show();
                    $('#hidden1').show();
                    $('#hidden2').show();
                } else {
                    $('#hidden').hide();
                    $('#hidden1').hide();
                    $('#hidden2').hide();
                }
          });

        });

         $(".myform")[0].reset();
 </script>
 @endif
@endsection


   
