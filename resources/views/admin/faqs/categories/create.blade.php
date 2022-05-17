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
    'faq' => 'active','all_faq'=>'','all_faq_cat'=>'','all_faq_cat_create'=>'active','cms'=> 'active',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Create faq category',
    'from' => 'Admin',
    'to' => 'User Create',
  ])
@endsection
@section('content')
<div class="box-header">
       
    <div class="card <!--card-outline--> card-primary">
   {!! Form::open(['method' => 'POST', 'action' => 'AdminCategoriesController@store', 'files' => true]) !!}
   <input name="_token" type="hidden" value="{{ csrf_token() }}">
   <input name="_method" type="hidden" value="{{isset($item)? 'PUT':'POST'}}">
   <div class="card-body">
      <fieldset>
         <div class="row">
            <div class="col-md-12">
               <div class="form-group">
                  <label for="name">Category</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category" value="{{ ($errors && $errors->any()? old('name') : (isset($item)? $item->name : '')) }}">
                  <small class="text-danger">{{ $errors->first('name') }}</small>
               </div>
            </div>
         </div>
      </fieldset>
   </div>
   <div class="box-footer">
      <div class="btn-group pull-center">
        {!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!}
        {!! Form::submit("Create", ['class' => 'btn btn-add btn-default']) !!}
      </div>
    </div>
   {!! Form::close() !!}
</div>
@endsection
