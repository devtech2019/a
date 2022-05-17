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
    'title' => 'Create Faqs',
    'from' => 'Admin',
    'to' => 'Create Faqs',
  ])
@endsection

@section('content')

 <div class="box-header">
{!! Form::open(['method' => 'POST', 'action' => 'AdminFAQController@store', 'files' => true]) !!}
{!! csrf_field() !!}
<input name="_token" type="hidden" value="{{ csrf_token() }}">
<div class="card-body">
   <fieldset>
      <div class="row">
         <div class="col-12 col-md-6">
            <div class="form-group">
               <label for="question">Question</label>
               <input type="text" class="form-control" id="question" name="question" placeholder="Enter question" value="{{ ($errors && $errors->any()? old('question') : (isset($item)? $item->question : '')) }}">
               <small class="text-danger">{{ $errors->first('question') }}</small>
            </div>
         </div>
         <div class="col-12 col-md-6">
            <div class="form-group">
               {!! Form::label('category_id', 'Category') !!}
               {!! Form::select('category_id', [""=>"Please select a category"]+$categories, null, ['class' => 'form-control', 'id'=>'category_id', ]) !!}
               <small class="text-danger">{{ $errors->first('category_id') }}</small>
            </div>
         </div>
      </div>
      <div class="form-group">
         <label for="answer">Answer</label>
         <textarea class="form-control summernote" id="content" name="answer" rows="10">{{ ($errors && $errors->any()? old('answer') : (isset($item)? $item->answer : '')) }}</textarea>
         <small class="text-danger">{{ $errors->first('answer') }}</small>
      </div>
   </fieldset>
</div>
<div class="box-footer">
   <div class="btn-group pull-left">
      {!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!}
      {!! Form::submit("Create", ['class' => 'btn btn-add btn-default']) !!}
   </div>
</div>

    <!-- include libraries(jQuery, bootstrap) -->

<script type="text/javascript" src="{{asset('public/js/summernote.min.js')}}"></script>
<!-- summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script> -->
  
        <script type="text/javascript" charset="utf-8">
         $(document).ready(function() {
          $('.summernote').summernote();
        });
    </script>
    <script type="text/javascript" >

        /**
         * Function to get email action options on change
         */
        $("#action").change(function(e){
            appendConstants();
        });

        /**
         * Function to get email action options on page load
         */
        $(function(){
            appendConstants();
        });

         /**
         * Function to append email constants
         */
        function appendConstants(){
            var value   =   $("#action").val();
            var options =   '<option value="">Please select a constants</option>';
            $("#constants").html(options);
            if(value){
                $.ajax({
                    type    :   "POST",
                      url     :   "{{route('EmailTemplate.getConstant')}}",
                    data    :   {"action" : value},
                    success :   function(response){
                        if(response){
                            var result = JSON.parse(response);
                            //var result = (response.result)   ? response.result :[];
                            result.map(function(records){
                                if(records){
                                    //var res = records.replace('"','');
                                    //options  += "<option value='"+res+"'>"+res+"</option>";
                                    options  += "<option value='"+records+"'>"+records+"</option>";
                                }
                            });


                            $("#constants").html(options);
                            //$('#constants').selectpicker('refresh');
                        }else if(response && response.message){
                            notice(response.status,response.message);
                        }
                    },
                });
            }
        }// end appendConstants()

        /**
        * Insert constant in ckeditor
        */
        function insertHTML(){
            var constant = $("#constants").val();
            if(constant){
                $(".summernote").each(function(index){
                    var id = $(this).attr("id");
                    if(id){
                        var newStr = '{'+constant+'}';
                        $("#"+id).summernote('insertText', newStr);
                    }
                });
            }
        }// end insertHTML()
    </script>


@endsection




