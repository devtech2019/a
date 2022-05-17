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
    'faq' => 'active','all_faq'=>'active','all_faq_cat'=>'','all_faq_cat_create'=>'','cms'=> 'active',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Edit Faq',
    'from' => 'Admin',
    'to' => 'Edit Faq',
  ])
@endsection

@section('content')

 <div class="box-header">
  {!! Form::model($item, ['method' => 'POST', 'action' => ['AdminFAQController@update', $item->id], 'files' => true]) !!} 
  <div class="card-body">
    <fieldset>
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group {{ $errors->has('question') ? ' has-error' : '' }}">{!! Form::label('question', 'Question') !!} {!! Form::text('question', null, ['class' => 'form-control', 'placeholder' => 'Enter your question']) !!} <small class="text-danger">{{ $errors->first('question') }}</small>
          </div>

        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            {!! Form::label('category_id', 'Category') !!} {!! Form::select('category_id', [""=>"Please select a category"]+$categories, null, ['class' => 'form-control', 'id'=>'category_id', ]) !!} <small class="text-danger">{{ $errors->first('category_id') }}</small>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="answer">Answer</label>
        <textarea class="form-control summernote" id="content" name="answer" rows="10">{{ ($errors && $errors->any()? old('answer') : (isset($item)? $item->answer : '')) }}</textarea> <small class="text-danger">{{ $errors->first('answer') }}</small>
      </div>
    </fieldset>
    <div class="box-footer">
      <div class="btn-group pull-left">{!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!} {!! Form::submit("Update", ['class' => 'btn btn-add btn-default']) !!}</div>
    </div>
  </div>
</div>

     
    <script type="text/javascript" src="{{asset('public/js/summernote.min.js')}}"></script>
<!-- summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script> -->
  
        <script type="text/javascript" charset="utf-8">
         $(document).ready(function() {
          $('.summernote').summernote();
        });
    </script>
@endsection

