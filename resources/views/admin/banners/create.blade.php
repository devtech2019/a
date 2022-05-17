@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'banners' => 'active', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '','all_banners'=>'','all_create_banners'=>''
   
  ])
@endsection
@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Create banners',
    'from' => 'Admin',
    'to' => 'Create banners',
  ])
@endsection
@section('content')  

<div class="box-header with-border">
    <div class="box-title">Banners Create Form</div>
  </div>
  {!! Form::open(['method' => 'POST', 'action' => 'BannersController@store', 'files' => true]) !!}
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
             {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Please Enter name']) !!}
            <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
          <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Description') !!}
            {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Please Enter description']) !!}
            <small class="text-danger">{{ $errors->first('description') }}</small>
          </div>
            <div class="form-group{{ $errors->has('button_name') ? ' has-error' : '' }}">
            {!! Form::label('button_name', 'Button Name') !!}
            {!! Form::text('button_name', null, ['class' => 'form-control', 'placeholder'=>' Please Enter button name']) !!}
            <small class="text-danger">{{ $errors->first('button_name') }}</small>
          </div>
         
           
        </div>
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('action_url') ? ' has-error' : '' }}">
            {!! Form::label('action_url', 'Action Url') !!}
            {!! Form::text('action_url', null, ['class' => 'form-control', 'placeholder' => 'Please Enter title']) !!}
            <small class="text-danger">{{ $errors->first('action_url') }}</small>
          </div>

         <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            {!! Form::label('image', 'Image') !!}
            {!! Form::file('image') !!}
             <small class="text-danger">{{ $errors->first('image') }}</small>
          </div>
        </div>  
        <div class="col-md-4">
          <div class="form-group radio{{ $errors->has('type') ? ' has-error' : '' }} user-create-radio">
            <span>Banner Type</span>
            <label for="" class="checkbox">
              {!! Form::radio('type', '1',  null, [
                  'id'    => 'type',
              ]) !!} App
            </label>
            <label for="" class="checkbox">
              {!! Form::radio('type', '0',  null, [
                  'id'    => 'type',
              ]) !!} Web
            </label> 
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
    </div>
    
@endsection


   