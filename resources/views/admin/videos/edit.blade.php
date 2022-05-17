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
    'coupon' => 'active','all_coupon'=>'active','create_coupon'=>''
  ])
@endsection
@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Edit Video',
    'from' => 'Admin',
    'to' => 'Edit Video',
  ])
@endsection
@section('content')
  <div class="box-header">
    <h5 class="box-title">Video Edit Form</h5>
  </div>
  {!! Form::model($videos, ['method' => 'POST', 'action' => ['AdminVideoController@update', $videos->id], 'files' => true]) !!}
    {!! csrf_field() !!}
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
         <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Title']) !!}
            <small class="text-danger">{{ $errors->first('title') }}</small>
          </div>
        
          </div>
            <div class="col-md-4">
            <div class="form-group{{ $errors->has('video_image') ? ' has-error' : '' }}">
                {!! Form::label('video_image', 'Video Image') !!}
                {!! Form::file('video_image',array('id' => 'video image')) !!}
                <small class="text-danger">{{ $errors->first('video_image') }}</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group{{ $errors->has('video_url') ? ' has-error' : '' }}">
                {!! Form::label('video_url', 'Video') !!}
                {!! Form::file('video_url',array('id' => 'video')) !!}
                <small class="text-danger">{{ $errors->first('video_url') }}</small>
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
