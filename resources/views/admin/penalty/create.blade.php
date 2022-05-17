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
    'title' => 'Create Penalty',
    'from' => 'Admin',
    'to' => 'Create Penalty',
  ])
@endsection

@section('content')

  <div class="box-header">
    {!! Form::model($item, ['method' => 'POST', 'action' => ['AdminPenaltyCharges@update', $item->id], 'files' => true]) !!}

    <h5 class="box-title">Penalty Create Form</h5>
  </div>
 <!--  -->
    <div class="box-body">
      <div class="row">
        <div class="col-md-3">
          <span>Cancellation before 24hrs</span>  
        </div>


        <div class="col-md-3">
          <div class="form-group radio{{ $errors->has('cancellation_before') ? ' has-error' : '' }} user-create-radio" id="hidden2">
            <span>Cancellation before 24hrs</span>
            <label for="cancellation_before" class="checkbox">
              {!! Form::radio('cancellation_before', '%',  null, ['id' => 'cancellation_before']) !!}  % ( Percent )
            </label>
            <label for="value_type" class="checkbox">
              {!! Form::radio('cancellation_before', 'Fixed price',  null, ['id'=> 'cancellation_before',
              ]) !!} Fixed price
            </label>
            <small class="text-danger">{{ $errors->first('cancellation_before') }}</small>
          </div>
         
          <div class="form-group radio{{ $errors->has('cancellation_within') ? ' has-error' : '' }} user-create-radio" id="hidden2">
            <span>Cancellation within 24hrs</span>
            <label for="cancellation_within" class="checkbox">
              {!! Form::radio('cancellation_within', '%',  null, ['id' => 'cancellation_within']) !!}  % ( Percent )
            </label>
            <label for="cancellation_within" class="checkbox">
              {!! Form::radio('cancellation_within', 'Fixed price',  null, ['id'=> 'cancellation_within',
              ]) !!} Fixed price
            </label>
            <small class="text-danger">{{ $errors->first('cancellation_within') }}</small>
          </div>

             <div class="form-group radio{{ $errors->has('cancellation_after') ? ' has-error' : '' }} user-create-radio" id="hidden2">
            <span>Reschedule within 24hrs</span>
            <label for="cancellation_after" class="checkbox">
              {!! Form::radio('cancellation_after', '%',  null, ['id' => 'cancellation_after']) !!}  % ( Percent )
            </label>
            <label for="cancellation_after" class="checkbox">
              {!! Form::radio('cancellation_after', 'Fixed price',  null, ['id'=> 'cancellation_after',
              ]) !!} Fixed price
            </label>
            <small class="text-danger">{{ $errors->first('cancellation_after') }}</small>
          </div>
        </div>

     <div class="row">
        <div class="col-md-3">

        
        <div class="form-group{{ $errors->has('cancellation_before_value') ? ' has-error' : '' }}">
            {!! Form::label('cancellation_before_value', 'cancellation before value') !!}
            {!! Form::text('cancellation_before_value', null, ['class' => 'form-control', 'placeholder'=>' please enter a value']) !!}
            <small class="text-danger">{{ $errors->first('cancellation_before_value') }}</small>
          </div>
           <div class="form-group{{ $errors->has('cancellation_within_value') ? ' has-error' : '' }}">
            {!! Form::label('cancellation_within_value', 'cancellation_within_value') !!}
            {!! Form::text('cancellation_within_value', null, ['class' => 'form-control', 'placeholder'=>' please enter a value']) !!}
            <small class="text-danger">{{ $errors->first('cancellation_within_value') }}</small>
          </div>
                <div class="form-group{{ $errors->has('cancellation_after_value') ? ' has-error' : '' }}">
            {!! Form::label('cancellation_after_value', 'cancellation_after_value') !!}
            {!! Form::text('cancellation_after_value', null, ['class' => 'form-control', 'placeholder'=>' please enter a value']) !!}
            <small class="text-danger">{{ $errors->first('cancellation_after_value') }}</small>
          </div>   
        </div>
      </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="btn-group pull-left">
        {!! Form::submit("Update", ['class' => 'btn btn-add btn-default']) !!}
      </div>
    </div>






 <!-- <div class="box-header">
       
 {!! Form::open(['method' => 'POST', 'action' => 'AdminPenaltyChargesController@store', 'files' => true]) !!}
        
        {!! csrf_field() !!}

       <div class="box-body">
        {{print_r($errors)}}
      <div class="row">
        <div class="col-md-4">
         <div class="form-group radio user-create-radio">
            <span>Cancellation before 24hrs</span>  
          </div>
        
            <div class="form-group radio user-create-radio">
            <span>Cancellation within 24hrs</span>  
          </div>
          <div class="form-group radio user-create-radio">
            <span>Reschedule within 24hrs</span>  
          </div>
         
        </div>
        <div class="col-md-4">


         <div class="row">
        <div class="col-md-4">
         <div class="form-group radio{{ $errors->has('cancellation_before') ? ' has-error' : '' }} user-create-radio" id="hidden2">
            <span>Cancellation before 24hrs</span>
            <label for="cancellation_before" class="checkbox">
              {!! Form::radio('cancellation_before', '%',  null, ['id' => 'cancellation_before']) !!}  % ( Percent )
            </label>
            <label for="value_type" class="checkbox">
              {!! Form::radio('cancellation_before', 'Fixed price',  null, ['id'=> 'cancellation_before',
              ]) !!} Fixed price
            </label>
            <small class="text-danger">{{ $errors->first('cancellation_before') }}</small>
          </div>
           <div class="form-group radio{{ $errors->has('cancellation_within') ? ' has-error' : '' }} user-create-radio" id="hidden2">
            <span>Cancellation within 24hrs</span>
            <label for="cancellation_within" class="checkbox">
              {!! Form::radio('cancellation_within', '%',  null, ['id' => 'cancellation_within']) !!}  % ( Percent )
            </label>
            <label for="cancellation_within" class="checkbox">
              {!! Form::radio('cancellation_within', 'Fixed price',  null, ['id'=> 'cancellation_within',
              ]) !!} Fixed price
            </label>
            <small class="text-danger">{{ $errors->first('cancellation_within') }}</small>
          </div>
           <div class="form-group radio{{ $errors->has('cancellation_after') ? ' has-error' : '' }} user-create-radio" id="hidden2">
            <span>Reschedule within 24hrs</span>
            <label for="cancellation_after" class="checkbox">
              {!! Form::radio('cancellation_after', '%',  null, ['id' => 'cancellation_after']) !!}  % ( Percent )
            </label>
            <label for="cancellation_after" class="checkbox">
              {!! Form::radio('cancellation_after', 'Fixed price',  null, ['id'=> 'cancellation_after',
              ]) !!} Fixed price
            </label>
            <small class="text-danger">{{ $errors->first('cancellation_after') }}</small>
          </div>
        </div>
      
        <div class="col-md-4">

         <div class="form-group{{ $errors->has('cancellation_before_value') ? ' has-error' : '' }}">
            {!! Form::label('cancellation_before_value', 'cancellation before value') !!}
            {!! Form::text('cancellation_before_value', null, ['class' => 'form-control', 'placeholder'=>' please enter a value']) !!}
            <small class="text-danger">{{ $errors->first('cancellation_before_value') }}</small>
          </div>

           <div class="form-group{{ $errors->has('cancellation_within_value') ? ' has-error' : '' }}">
            {!! Form::label('cancellation_within_value', 'cancellation_within_value') !!}
            {!! Form::text('cancellation_within_value', null, ['class' => 'form-control', 'placeholder'=>' please enter a value']) !!}
            <small class="text-danger">{{ $errors->first('cancellation_within_value') }}</small>
          </div>
                <div class="form-group{{ $errors->has('cancellation_after_value') ? ' has-error' : '' }}">
            {!! Form::label('cancellation_after_value', 'cancellation_after_value') !!}
            {!! Form::text('cancellation_after_value', null, ['class' => 'form-control', 'placeholder'=>' please enter a value']) !!}
            <small class="text-danger">{{ $errors->first('cancellation_after_value') }}</small>
          </div>   

    </div>
       
    </div>
    <div class="box-footer">
      <div class="btn-group pull-left">
        {!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!}
        {!! Form::submit("Create", ['class' => 'btn btn-add btn-default']) !!}
      </div>
    </div> -->
  {!! Form::close() !!}


@endsection




