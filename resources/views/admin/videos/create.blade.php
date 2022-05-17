@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => 'active', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => 'active', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Videos',
    'from' => 'Admin',
    'to' => 'Video',
  ])
@endsection
@section('content')

<div class="box-header">
    <div class="box-title">Video Create Form</div>
  </div>
  {!! Form::open(['method' => 'POST', 'action' => 'AdminVideoController@store', 'files' => true]) !!}
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
        
    </div>
    <div class="box-footer">
      <div class="btn-group pull-left">
        {!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!}
        {!! Form::submit("Create", ['class' => 'btn btn-add btn-default']) !!}
      </div>
    </div>
  {!! Form::close() !!}
  @endsection




<!-- <html lang="en">
<head>
 
  <script src="jquery/1.9.1/jquery.js"></script>
  <link rel="stylesheet" href="3.3.6/css/bootstrap.min.css">
</head>
<body>


<div class="container lst">


@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Sorry!</strong> There were more problems with your HTML input.<br><br>
    <ul>
      @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
      @endforeach
    </ul>
</div>
@endif


@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div> 
@endif



<form method="post" action="{{url('admin/videos')}}" enctype="multipart/form-data">
  {{csrf_field()}}


    <div class="input-group hdtuto control-group lst increment" >
      <input type="file" name="video_url[]" class="myfrm form-control">
      <div class="input-group-btn"> 
        <button class="btn btn-success" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>Add</button>
      </div>
    </div>
    <div class="clone hide">
      <div class="hdtuto control-group lst input-group" style="margin-top:10px">
        <input type="file" name="video_url[]" class="myfrm form-control">
        <div class="input-group-btn"> 
          <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
        </div>
      </div>
    </div>


    <button type="submit" class="btn btn-success" style="margin-top:10px">Submit</button>


</form>        
</div>


<script type="text/javascript">
    $(document).ready(function() {
      $(".btn-success").click(function(){ 
          var lsthmtl = $(".clone").html();
          $(".increment").after(lsthmtl);
      });
      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".hdtuto control-group lst").remove();
      });
    });
</script>


</body>
</html> -->

