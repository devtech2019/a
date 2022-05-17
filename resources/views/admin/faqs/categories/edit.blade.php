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
    'faq' => 'active','all_faq'=>'','all_faq_cat'=>'active','all_faq_cat_create'=>'','cms'=> 'active',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Edit faq Category',
    'from' => 'Admin',
    'to' => 'Edit faq Category',
  ])
@endsection

@section('content')
  <div class="box-header">
    <div class="box-title">Faq  Category Edit Form</div>
  </div>
  {!! Form::model($item, ['method' => 'POST', 'action' => ['AdminCategoriesController@update', $item->id], 'files' => true]) !!}
    <div class="box-body">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Category') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter your name']) !!}
            <small class="text-danger">{{ $errors->first('name') }}</small>
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

   
@endsection
