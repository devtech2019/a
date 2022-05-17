@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => 'active', 'all_team' => 'active', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '','panalty'=>''
    
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Cleaners Availability',
    'from' => 'Admin',
    'to' => 'Cleaners Availability',
  ])
@endsection

@section('content')
<div class="box-header">
   
  {!! Form::model($item,['method' => 'POST', 'action' => ['AdminTeamController@CleanersAvailability',$franchiseid,$id], 'files' => true]) !!}
<!-- <input name="_token" type="hidden" value="{{ csrf_token() }}"> -->
  
<h5 class="box-title">Cleaners Availability Form</h5>
</div>
            <div class="box-body opening-hours-main-block">
              
              <?php 
              $weekDays = Config::get('app.WEEK_DAYS'); 
              $i =  1;
              ?>
              
              @foreach($weekDays as $key => $value)

           
                  <div class="col-sm-12">

                  </div>
                  <div class="bootstrap-timepicker col-sm-2">
                    <div class="form-group{{ $errors->has('day_check') ? ' has-error' : '' }} bootstrap-timepicker">
                      
                       <?php
                       if(isset($item)){
                          for($j=0; $j<count($item) ;$j++){
                             if($item[$j]['day']==$value){
                               $checkedInput ='checked';
                                break;
                             }
                             else{
                              $checkedInput ='';
                            }
                        } 
                       
                       }
                      ?>  
                      <input {{$checkedInput??''}} id="day_check"  name="day_check_{{$i}}"  type="checkbox" >
                      
                      <!--   {!! Form::label('day_check', 'Day Check') !!} -->
                        
                        <small class="text-danger">{{ $errors->first('day_check') }}</small>
                    </div>
                  </div>
                  <div class="form-group col-sm-2">

                      {!! Form::label('day', $value) !!}
                      {!! Form::hidden('day_'.$i, $value) !!}
                  </div>
                  <div class=" col-sm-2">
                    <div class="form-group{{ $errors->has('opening_time') ? ' has-error' : '' }}">
 
                      <?php
                       if(isset($item)){
                          for($j=0; $j<count($item) ;$j++){
                            if($item[$j]['day']==$value){
                                $openingtime =$item[$j]['opening_time'];
                                break;
                             }
                             else{
                               $openingtime ='';
                            }              
                        } 
                       
                       }
                      ?> 

                       {!! Form::label('opening_time', 'Opening Time') !!}
                       <input {{$openingtime??''}} class="form-control start" type="text" data-val="{{$i}}" id="opening_time_{{$i}}" name="opening_time_{{$i}}" value="{{$openingtime??''}}" />
                   <!--   <input {{$openingtime??''}} id="opening_time" class="form-control timepicker" name="opening_time_{{$i}}" type="text"> -->


                      <small class="text-danger">{{ $errors->first('opening_time') }}</small>
                    </div>
                  </div>
               
                  <div class="col-sm-2">
                    <div class="form-group{{ $errors->has('closing_time') ? ' has-error' : '' }} ">
                        <?php
                       if(isset($item)){
                          for($j=0; $j<count($item) ;$j++){
                            if($item[$j]['day']==$value){
                                $closingtime =$item[$j]['closing_time'];
                                break;
                             }
                             else{
                               $closingtime ='';
                            }              
                        } 
                       
                       }
                      ?> 

                        {!! Form::label('closing_time', 'Closing Time') !!}

                        <input {{$closingtime??''}} class="form-control end" type="text" id="closing_time_{{$i}}" name="closing_time_{{$i}}"  value="{{$closingtime??''}}">
                        <small class="text-danger">{{ $errors->first('closing_time') }}</small>
                    </div>  
                </div>
                 <div class="bootstrap-timepicker col-sm-2">
                    <div class="form-group{{ $errors->has('lunch_opening_time') ? ' has-error' : '' }} bootstrap-timepicker">
                      <?php
                        if(isset($item)){
                          for($j=0; $j<count($item) ;$j++){
                            if($item[$j]['day']==$value){
                                $lunchopeningtime =$item[$j]['lunch_opening_time'];
                                break;
                             }
                             else{
                               $lunchopeningtime ='';
                            }              
                          } 
                        }
                      ?> 
                        {!! Form::label('lunch_opening_time', 'Lunch Opening Time') !!}
                      <input {{$lunchopeningtime?? ''}} class="form-control start_lunch" type="text" data-id="{{$i}}" placeholder="eg: 8:00 pm" id="lunch_opening_time_{{$i}}"  name="lunch_opening_time_{{$i}}" value="{{$lunchopeningtime??''}}">
                        <small class="text-danger">{{ $errors->first('lunch_opening_time') }}</small>
                    </div>  
                </div>
                 <div class="bootstrap-timepicker col-sm-2">
                    <div class="form-group{{ $errors->has('lunch_closing_time') ? ' has-error' : '' }} bootstrap-timepicker">
                      <?php
                        if(isset($item)){
                          for($j=0; $j<count($item) ;$j++){
                            if($item[$j]['day']==$value){
                                $lunchclosingtime =$item[$j]['lunch_closing_time'];
                                break;
                             }
                             else{
                               $lunchclosingtime ='HH:mm:ss';
                            }              
                        } 
                       
                       }
                      ?> 
                        {!! Form::label('lunch_closing_time', ' Lunch Closing Time') !!}
                         <input {{$lunchclosingtime??''}} class="form-control end_lunch" placeholder="eg: 8:00 pm" id="lunch_closing_time_{{$i}}"  name="lunch_closing_time_{{$i}}" type="text" value="{{$lunchclosingtime??''}}">
                        <small class="text-danger">{{ $errors->first('lunch_closing_time') }}</small>
                    </div>  
                </div>

           <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
           
            {{ Form::hidden('user_id') }}
           
          </div>
              @php $i++; @endphp
              @endforeach
            </div>

 <div class="box-footer">
      <div class="btn-group pull-left">{!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!} {!! Form::submit("Update", ['class' => 'btn btn-add btn-default']) !!}</div>
    </div>
    <!-- <link rel="stylesheet" href="https://www.jonthornton.com/jquery-timepicker/jquery.timepicker.css">
    <script src="https://www.jonthornton.com/jquery-timepicker/jquery.timepicker.js"></script> -->
    
<script>
  function interval() {

  }

$(function() {
  for (var i = 5; i <= 60; i += 5) {
    $('#meeting').append('<option value="' + i + '">' + i + '   min' + '</option>');
  }

  function setEndTime(valueField) {
    var meetingLength = parseInt($('#meeting').find('option:selected').val() || 0),
    selectedTime = $('#opening_time_'+valueField).timepicker('getTime');
    selectedTime.setMinutes(selectedTime.getMinutes() + parseInt(meetingLength, 10), 0);
    selectedTimeVal = $('#opening_time_'+valueField).attr('data-val');
    $('#closing_time_'+valueField).timepicker('option', 'minTime', selectedTime);
    $('#closing_time_'+valueField).timepicker('setTime', selectedTime);
    $('#lunch_opening_time_'+valueField).timepicker('option', 'minTime', selectedTime);
    // console.log($('#lunch_opening_time_'+valueField).val());
    $('#lunch_opening_time_'+valueField).timepicker('setTime', selectedTime);
    
  }
  function setLunchEndTime(valueField) {
    var meetingLength = parseInt($('#meeting').find('option:selected').val() || 0),
    selectedTime = $('#lunch_opening_time_'+valueField).timepicker('getTime');
    selectedTime.setMinutes(selectedTime.getMinutes() + parseInt(meetingLength, 10), 0);
    selectedTimeVal = $('#lunch_opening_time_'+valueField).attr('data-id');
    $('#lunch_closing_time_'+valueField).timepicker('option', 'minTime', selectedTime);
    $('#lunch_closing_time_'+valueField).timepicker('setTime', selectedTime);
  }

  

  $('.start').timepicker({
    'minTime': '12:00 AM',
    'maxTime': '11:59 PM',
    'step': 5
  }).on('changeTime', function(e) {
    let value = e.target.getAttribute('data-val');
    setEndTime(value);
  });

  $('.end').timepicker({
    'minTime': '12:00 AM',
    'maxTime': '11:59 PM',
    'step': function() {
      return parseInt(60);
    }
  });
  $('.start_lunch').timepicker({
    'minTime': '12:00 AM',
    'maxTime': '11:59 PM',
    'step': function() {
      return parseInt(60);
    },
  }).on('changeTime', function(e) {
    let value = e.target.getAttribute('data-id');
    setLunchEndTime(value);
  });
 
  $('.end_lunch').timepicker({
    'minTime': '12:00 AM',
    'maxTime': '11:59 PM',
    'step': function() {
      return parseInt(60);
    }
  });
  
});

  </script>


@endsection

