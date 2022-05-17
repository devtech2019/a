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
    'title' => 'Create Cleaners Vehicles',
    'from' => 'Admin',
    'to' => 'Create Cleaners Vehicles',
  ])
@endsection

@section('content')
  <div class="box-header">
    <div class="box-title">Cleaners Vehicles Create Form</div>
  </div>
   
   {!! Form::model($item,['method' => 'POST', 'action' => ['AdminTeamController@CleanersVehicles',$id,$franchiseid], 'files' => true]) !!}      
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
     
           <div class="form-group{{ $errors->has('vehicle_company') ? ' has-error' : '' }}">
            {!! Form::label('vehicle_company', 'vehicle company') !!}
            {!! Form::text('vehicle_company',  null, ['class' => 'form-control', 'placeholder' => 'Please Enter vehicle company']) !!}
            <small class="text-danger">{{ $errors->first('vehicle_company') }}</small>
          </div>
          
            
          <div class="form-group{{ $errors->has('vehicle_model') ? ' has-error' : '' }}">
            {!! Form::label('vehicle_model', 'vehicle model') !!}
            {!! Form::text('vehicle_model',  null, ['class' => 'form-control', 'placeholder' => 'Please Enter vehicle model']) !!}
            <small class="text-danger">{{ $errors->first('vehicle_model') }}</small>
          </div>
          
          <div class="form-group{{ $errors->has('puc_no') ? ' has-error' : '' }}">
            {!! Form::label('puc_no', 'PUC Details') !!}
            {!! Form::file('puc_no') !!}
          
            <small class="text-danger">{{ $errors->first('puc_no') }}</small>
          </div>
        </div>
        <div class="col-md-4">
           <div class="form-group{{ $errors->has('vehicle_registration_no') ? ' has-error' : '' }}">
            {!! Form::label('vehicle_registration_no', 'vehicle registration no') !!}
            {!! Form::text('vehicle_registration_no', null, ['class' => 'form-control', 'placeholder' => 'Please Enter vehicle registration no']) !!}
            <small class="text-danger">{{ $errors->first('vehicle_registration_no') }}</small>
          </div>
           <div class="form-group{{ $errors->has('vehicle_name') ? ' has-error' : '' }}">
            {!! Form::label('vehicle_name', 'Vehicle Name') !!}
            {!! Form::text('vehicle_name', null, ['class' => 'form-control', 'placeholder' => 'Please Enter vehicle name']) !!}
            <small class="text-danger">{{ $errors->first('vehicle_name') }}</small>
          </div>
        
          <div class="form-group{{ $errors->has('franchise_id') ? ' has-error' : '' }}">
           
            {{ Form::hidden('franchise_id') }}
           
          </div>
           <div class="form-group{{ $errors->has('cleaner_id') ? ' has-error' : '' }}">
           
            {{ Form::hidden('cleaner_id') }}
           
          </div>
           <div class="form-group{{ $errors->has('added_by') ? ' has-error' : '' }}">
           
            {{ Form::hidden('added_by') }}
           
          </div>
         
        </div>
       
  <div class="col-md-4">
              <div class="form-group{{ $errors->has('vehicle_insurance_no') ? ' has-error' : '' }}">
            {!! Form::label('vehicle_insurance_no', 'vehicle insurance no') !!}
            {!! Form::text('vehicle_insurance_no', null, ['class' => 'form-control', 'placeholder' => 'Please Enter vehicle insurance no']) !!}
            <small class="text-danger">{{ $errors->first('vehicle_insurance_no') }}</small>
          </div>
          <div class="form-group{{ $errors->has('vehicle_icon') ? ' has-error' : '' }}">
            {!! Form::label('vehicle_icon', 'vehicle_icon') !!}
            {!! Form::text('vehicle_icon', null, ['class' => 'form-control iconpicker-custom', 'placeholder' => 'Please Enter vehicle icon','autocomplete'=>"off",'readonly'=>'readonly']) !!}
            <small class="text-danger">{{ $errors->first('vehicle_icon') }}</small>
          </div>
         
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

 