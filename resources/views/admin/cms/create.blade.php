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
'cms' => 'active','create_cms' => 'active',
])
@endsection
@section('breadcum')
@include('include.breadcum', [
'title' => 'Create Pages',
'from' => 'Admin',
'to' => 'Create Pages',
])
@endsection
@section('content')  
<div class="box-header">
   <div class="box-title">Pages Create Form</div>
</div>
{!! Form::open(['method' => 'POST', 'action' => 'CMSController@store', 'files' => true]) !!}
<div class="box-body">
   <div class="row">
       <div class="col-12 col-md-6">
              <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                 <label for="name">Name</label>

                 <input type="text" class="form-control input-generate-slug" id="name" name="name" placeholder="Enter Name" value="{{ ($errors && $errors->any()? old('name') : (isset($item)? $item->name : '')) }}"> 
                 <small class="text-danger">{{ $errors->first('name') }}</small> 
              </div>
        </div>
          
          <div class="col-12 col-md-6">
              <div class="form-group {{ $errors->has('slug') ? ' has-error' : '' }}">
                 <label for="slug">Slug</label>
                 <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter Slug" value="{{ ($errors && $errors->any()? old('slug') : (isset($item)? $item->slug : '')) }}"> 

                  
                 <small class="text-danger">{{ $errors->first('slug') }}</small> 
              </div>
           </div>
        <div class="col-md-12">
          <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="body">Desciption</label>
            <textarea class="form-control summernote" id="content" name="description" >
            {{ ($errors && $errors->any()? old('description') : (isset($item)? $item->description : '')) }}
            </textarea> 
            <small class="text-danger">{{ $errors->first('description') }}</small> 
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

<script type="text/javascript" src="{{asset('public/js/summernote.min.js')}}"></script>
<!-- summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="{{asset('public/css/summernote1.min.css')}}"> -->
<!-- <link rel="stylesheet" href="{{asset('public/css/summernote-bs.min.css')}}"> -->
<!-- <link href="{{asset('public/css/summernote-bs.min.css')}}" rel="stylesheet"> -->
<script type="text/javascript" charset="utf-8">
   $(document).ready(function() {
     $('.summernote').summernote();
   });


    $('.input-generate-slug').change(function ()
        {
            var v = convertStringToSlug($(this).val());
            $("form input[name='slug']").val(v);
        })

        function convertStringToSlug(text)
        {
            return text.toString().toLowerCase().trim()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/&/g, '-and-')         // Replace & with 'and'
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '')             // Trim - from end of text
                .replace(/-$/, '');             // Remove last floating dash if exists
        }
</script>
{!! Form::close() !!}
@endsection