@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => 'active', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '','add_on_services' => '','create_add_on_services'=>'active' 
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Create AddOn Services',
    'from' => 'Admin',
    'to' => 'Create AddOn Services',
  ])
@endsection

@section('content')
  <div class="box-header">
    <div class="box-title">AddOn Create Form</div>
  </div>
  {!! Form::open(['method' => 'POST', 'action' => 'AdminAddOnServicesController@store', 'files' => true]) !!}
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
         <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Please Enter name']) !!}
            <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
         
            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            {!! Form::label('status', 'Status') !!}
            {!! Form::select('status', [""=>"Chooes Status", "A"=>"Active", "D"=>"Inactive"], null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('status') }}</small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
            {!! Form::label('price', 'Price') !!}
            {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Please Enter price']) !!}
            <small class="text-danger">{{ $errors->first('price') }}</small>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}">
            {!! Form::label('duration', 'Duration') !!}
            {!! Form::text('duration', null, ['class' => 'form-control','placeholder' => 'Please Enter duration']) !!}
            <small class="text-danger">{{ $errors->first('duration') }}</small>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description', null, ['class' => 'form-control','placeholder' => 'Please Enter description','rows'=>5]) !!}
            <small class="text-danger">{{ $errors->first('description') }}</small>
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

 
</script> 
 