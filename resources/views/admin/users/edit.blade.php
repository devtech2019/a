@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => 'active', 'all_user' => 'active', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
    'cleanersBookings' => '', 'all_bookings' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Edit User',
    'from' => 'Admin',
    'to' => 'User Edit',
  ])
@endsection

@section('content')
  <div class="box-header">
    <div class="box-title">User Edit Form</div>
  </div>
    

  {!! Form::model($user, ['method' => 'POST','action'=>['AdminUsersController@update',$user->id], 'files' => true]) !!}
  
    <div class="box-body">
     
      <div class="row">
        <div class="col-md-3">
        @if(isset($user->photo) && !empty($user->photo))
     
          <div class="user-img-block">
            <img src="{{asset('public/images/users')}}/{{$user->photo}}" alt="" class="img-responsive img-thumbnail" >
          </div>
          @elseif($user->gender == 'M' && empty($user->photo) )
         
          <div class="user-img-block">
            <img src="{{asset('public/images/male-blank-profile.jpg')}}" alt="" class="img-responsive img-thumbnail" >
          </div>
        @elseif($user->gender == 'F' && empty($user->photo))
        <div class="user-img-block">
            <img src="{{asset('public/images/female-blank.jpg')}}" alt="" class="img-responsive img-thumbnail" >
          </div>
          @else
        <div class="user-img-block">
            <img src="{{asset('public/images/male-blank-profile.jpg')}}" alt="" class="img-responsive img-thumbnail" >
          </div>
        @endif
        </div>
       
        <div class="col-md-3">
          @if (Auth::user()->role == 'A')
            <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
              {!! Form::label('role', 'Role') !!}
              {!! Form::select('role', [""=>"Choose Role","S"=>"Franchise","U"=>"Customer","C"=>"Cleaner","A"=>"Admin"], null, ['class' => 'form-control','id'=>'roles','disabled']) !!}
              <input type="hidden" id="hdn_role" name="role" />

              <small class="text-danger">{{ $errors->first('role') }}</small>
            </div>
          @endif
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter your name']) !!}
            <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
          <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Email address') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'eg: foo@bar.com']) !!}
            <small class="text-danger">{{ $errors->first('email') }}</small>
          </div>
          <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::label('password', 'Password') !!}
              {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter Password']) !!}
              <small class="text-danger">{{ $errors->first('password') }}</small>
          </div>
          <div class="form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
            {!! Form::label('dob', 'Date Of Birth') !!}
            {!! Form::text('dob', null, ['id' => '', 'class' => 'form-control date-pick', 'required' => 'required', 'placeholder' => 'Date of birth']) !!}
            <small class="text-danger">{{ $errors->first('dob') }}</small>
          </div>
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
        <div class="col-md-3">
          <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }}">
            {!! Form::label('mobile', 'Mobile') !!}
            {!! Form::text('mobile', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Mobile no']) !!}
            <small class="text-danger">{{ $errors->first('mobile') }}</small>
          </div>
          <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
            {!! Form::label('phone', 'Phone') !!}
            {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone no']) !!}
            <small class="text-danger">{{ $errors->first('phone') }}</small>
          </div>
          <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}" style="width: 50rem;">
            {!! Form::label('address', 'Address') !!}
            {!! Form::textarea('address', null, ['class' => 'form-control', 'rows'=>'5', 'required' => 'required', 'placeholder' => 'Enter your address']) !!}
            <small class="text-danger">{{ $errors->first('address') }}</small>
          </div>
          <div class="form-group {{ $errors->has('tracker_device_driver_id') ? ' has-error' : '' }}">
            {!! Form::label('Tracker device driver id', 'Tracker device driver id') !!}
            {!! Form::text('tracker_device_driver_id', null, ['class' => 'form-control', 'placeholder' => 'Enter your tracker device driver id']) !!}
            <small class="text-danger">{{ $errors->first('tracker_device_driver_id') }}</small>
          </div>
         
          <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}" >
            {!! Form::label('photo', 'Image') !!}
            {!! Form::file('photo') !!}
           
            <small class="text-danger">{{ $errors->first('photo') }}</small>
          </div> 
          <div class="radio  {{ $errors->has('gender') ? ' has-error' : '' }} user-create-radio {{$user->role && $user->role == 'S' ? 'hide' : ''}}">
            <span>Gender</span>
            <label for="" class="checkbox">
              {!! Form::radio('gender', 'M',  null, ['id' => 'gender', ]) !!} Male
            </label>
            <label for="" class="checkbox">
              {!! Form::radio('gender', 'F',  null, ['id' => 'gender']) !!} Female
            </label>
               <small class="text-danger">{{ $errors->first('gender') }}</small>
          </div>
          
        </div>
        <div class="col-md-3">
          
          
          <div class="form-group{{ $errors->has('franchise_id') ? ' has-error' : '' }}" id="hidden">
            {!! Form::label('Franchisee', 'Franchisee') !!}
            {!! Form::select('franchise_id', [""=>"Choose franchisee",""=>$franchiseList], null, ['class' => 'form-control ','id'=>'hidden', ]) !!}
            <small class="text-danger">{{ $errors->first('franchise_id') }}</small>
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

        $(function() {
          var select_val = $('#roles option:selected').val();
          $('#hdn_role').val(select_val);
        });
    </script>
@endsection
