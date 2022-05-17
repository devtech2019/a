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

<form id="cleaners_availability">
            <div class="box-body opening-hours-main-block">
              
              <?php 
              $weekDays =  array('Monday'=>'Monday', 'Tuesday'=>'Tuesday', 'Wednesday'=>'Wednesday', 'Thursday'=>'Thursday', 'Friday'=>'Friday', 'Saturday'=>'Saturday', 'Sunday'=>'Sunday'); 
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
                      <input {{$checkedInput??''}} id="day_check"  name="day_check_{{$i}}"  type="checkbox">
                      
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
                       <input  class="form-control start" type="text" data-val="{{$i}}" id="opening_time_{{$i}}" name="opening_time_{{$i}}" value="{{$openingtime??''}}" required/>
                 
                       <?php
                                 //echo $id = $value->id;
                                 $errorMessage = 'opening_time_.'.$i;
                                
                                ?>
                         {{--  
                       @if($i==1)
                       <small class="text-danger">{{ $errors->first('opening_time_1') }}</small> 
                       @endif
                       @if($i==2)
                       <small class="text-danger">{{ $errors->first('opening_time_2') }}</small> 
                       @endif
                       @if($i==3)
                       <small class="text-danger">{{ $errors->first('opening_time_3') }}</small> 
                       @endif
                       @if($i==4)
                       <small class="text-danger">{{ $errors->first('opening_time_4') }}</small> 
                       @endif
                       @if($i==5)
                       <small class="text-danger">{{ $errors->first('opening_time_5') }}</small> 
                       @endif
                       @if($i==6)
                       <small class="text-danger">{{ $errors->first('opening_time_6') }}</small> 
                       @endif
                       @if($i==7)
                       <small class="text-danger">{{ $errors->first('opening_time_7') }}</small> 
                       @endif
                       --}} 
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

                        <input {{$closingtime??''}} class="form-control end" data-val="{{$i}}"  type="text" id="closing_time_{{$i}}" name="closing_time_{{$i}}"  value="{{$closingtime??''}}" required>
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
                      <input {{$lunchopeningtime?? ''}} class="form-control start_lunch" type="text" data-id="{{$i}}" placeholder="eg: 8:00 pm" id="lunch_opening_time_{{$i}}"  name="lunch_opening_time_{{$i}}" value="{{$lunchopeningtime??''}}" required>
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
                               $lunchclosingtime ='';
                            }              
                        } 
                       
                       }
                      ?> 
                        {!! Form::label('lunch_closing_time', ' Lunch Closing Time') !!}
                        <input {{$lunchclosingtime??''}} class="form-control end_lunch" type="text" data-id="{{$i}}" placeholder="eg: 8:00 pm" id="lunch_closing_time_{{$i}}"  name="lunch_closing_time_{{$i}}" value="{{$lunchclosingtime??''}}" required>
    
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
 </form>
    <!-- <link rel="stylesheet" href="https://www.jonthornton.com/jquery-timepicker/jquery.timepicker.css">
    <script src="https://www.jonthornton.com/jquery-timepicker/jquery.timepicker.js"></script> -->
    <script src="{{asset('public/js/moment.min1.js')}}"></script>
<script>
  function interval() {

  }

  $( document ).ready(function() {
  for (var i = 5; i <= 60; i += 5) {
    $('#meeting').append('<option value="' + i + '">' + i + '   min' + '</option>');
  }
  

  function setEndTime(valueField) {
    var meetingLength = parseInt($('#meeting').find('option:selected').val() || 0),
    selectedTime = $('#opening_time_'+valueField).timepicker('getTime');
    selectedTimeForClosing = moment($('#opening_time_'+valueField).timepicker('getTime'), 'h:mm A').format('hh:mm A');
    selectedTimeForOpening = moment($('#opening_time_'+valueField).timepicker('getTime'), 'h:mm A').add('hours', 1).format('hh:mm A');
    selectedTimeForClosingTime = moment("12:00 AM", ["hh:mm A"]).format("hh:mm A");
   
  
  
    selectedTime.setMinutes(selectedTime.getMinutes() + parseInt(meetingLength, 10), 0);
    selectedTimeVal = $('#opening_time_'+valueField).attr('data-val');
    $('#closing_time_'+valueField).timepicker('option', 'minTime', selectedTimeForOpening );
    if(selectedTimeForClosing == '11:00 PM' ){
     
      // $('#closing_time_'+valueField).timepicker( 'option', 'minTime',selectedTimeForClosingTime );
      $('#closing_time_'+valueField).timepicker( 'option', 'maxTime',selectedTimeForClosingTime );
}
    // $('#closing_time_'+valueField).timepicker('option', 'minTime', selectedTimeForOpening );
    // $('#closing_time_'+valueField).timepicker('setTime', selectedTime);
    $('#lunch_opening_time_'+valueField).timepicker('option', 'minTime', selectedTime);
   
    // $('#lunch_opening_time_'+valueField).timepicker('setTime', selectedTime);
  }
//   var twoHoursBefore = new Date();
// twoHoursBefore.setHours(twoHoursBefore.getHours() - 2);
// const d = new Date();

// let dtOffset = new Date( selectedTime - 1);
  function setEndLunchTime(valueField) {
    var meetingLength = parseInt($('#meeting').find('option:selected').val() || 0),
    selectedTime = $('#closing_time_'+valueField).timepicker('getTime');
    selectedTimeForOpening = moment($('#closing_time_'+valueField).timepicker('getTime'), 'h:mm A').subtract('hours', 1).format('hh:mm A');
    selectedTime.setMinutes(selectedTime.getMinutes() + parseInt(meetingLength, 10), 0);
    selectedTimeVal = $('#closing_time_'+valueField).attr('data-val');
   
    $('#lunch_opening_time_'+valueField).timepicker('option', 'maxTime',selectedTimeForOpening);
   
    // $('#lunch_opening_time_'+valueField).timepicker('setTime', selectedTime);
   
    $('#lunch_closing_time_'+valueField).timepicker('option', 'maxTime', selectedTime);
    // $('#lunch_closing_time_'+valueField).timepicker('setTime', selectedTime);
    
  }

  function setLunchEndTime(valueField) {
    var meetingLength = parseInt($('#meeting').find('option:selected').val() || 0),
    selectedTime = $('#lunch_opening_time_'+valueField).timepicker('getTime');
    selectedTime.setMinutes(selectedTime.getMinutes() + parseInt(meetingLength, 10), 0);
    selectedTimeVal = $('#lunch_opening_time_'+valueField).attr('data-id');
    $('#lunch_closing_time_'+valueField).timepicker('option', 'minTime', selectedTime);
    // $('#lunch_closing_time_'+valueField).timepicker('setTime', selectedTime);
  }

for(var i = 1; i <= 7; i++){

  $('#opening_time_'+i).timepicker({
    'minTime': '12:00 AM',
    'maxTime': '11:59 PM',
    'step': function() {
      return parseInt(60);
    }
  }).on('changeTime', function(e) {
    let value = e.target.getAttribute('data-val');
    setEndTime(value);
  });

  var opening_time1   =  $('#opening_time_'+i).val();
  var opening_time2 = moment(opening_time1,'h:mm A').add({hours:1}).format('h:mm A');
  var opening_time3 = moment("12:00 AM", ["hh:mm A"]).format("hh:mm A");
  // console.log($('#opening_time_'+i).val(),"Sdfsadfad");

 if($('#opening_time_'+i).val() == '11:00pm'){
  $('#closing_time_'+i).timepicker({
    'minTime': opening_time3,
    'maxTime': opening_time3,
    'step': function() {
      return parseInt(60);
    }
  }).on('changeTime', function(e) {
    let value = e.target.getAttribute('data-val');
    setEndLunchTime(value);
  });
 }else{
  $('#closing_time_'+i).timepicker({
   
   'minTime':   opening_time2,
   'maxTime': '11:59 PM',
   'step': function() {
     return parseInt(60);
   }
 }).on('changeTime', function(e) {
   let value = e.target.getAttribute('data-val');
   setEndLunchTime(value);
 });

 }
  
  var day1 = $('#closing_time_'+i).val();
  var day2 = moment(day1, 'h:mm A').subtract('hours', 1).format('h:mm A');

  

  // var minutes = parseTime(EndTIme) - parseTime(StartTime);
  
// var day2 = "1:00:Am";

// var difference = day2.getTime() - day1.getTime();

  $('#lunch_opening_time_'+i).timepicker({
    'minTime':  $('#opening_time_'+i).val(),   
    'maxTime':  day2,
    'step': function(e) {
        return parseInt(60);
    },
  }).on('changeTime', function(e) {
    let value = e.target.getAttribute('data-id');
    setLunchEndTime(value);
  });

  $('#lunch_closing_time_'+i).timepicker({
    'minTime':  $('#lunch_opening_time_'+i).val(),
    'maxTime':  $('#closing_time_'+i).val(),
   
    'step': function() {
      return parseInt(60);
    }
  });



  
//validating cleaners availability 
  if(!$('#closing_time_'+i).val()){
    $('#closing_time_'+i).removeAttr('required')
  }
  if(!$('#opening_time_'+i).val()){
    
    $('#opening_time_'+i).removeAttr('required')
  }
  if(!$('#lunch_opening_time_'+i).val()){
    $('#lunch_opening_time_'+i).removeAttr('required')
  }
  if(!$('#lunch_closing_time_'+i).val()){
    $('#lunch_closing_time_'+i).removeAttr('required')
  }
}
 
  $(document).on("change",".start", function(){
     var data_val  = $(this).data("val");
     $('#closing_time_'+data_val).prop('required',true);
     $('#opening_time_'+data_val).prop('required',true);
     $('#lunch_opening_time_'+data_val).prop('required',true);
     $('#lunch_closing_time_'+data_val).prop('required',true);
  });

  
});


// for(var i = 1; i <= 7; i++){
//   if('#opening_time_'+i.val()){
//   $('.start').bootstrapValidator({
//     fields: {
//         opening_time: {
//             validators: { 
//                 notEmpty: {
//                     message: 'Please Enter Your Opening Time.'
//                 },
                                                           
//             }
//         },
//        closing_time: {
//             validators: {
//                 notEmpty: {
//                     message: 'Please Enter Your Closing Time.'
//                 },
                                
//             },
//         },
        
         
//     }
// });
// } 
// }
$(".start").keypress(function(event) {event.preventDefault();});
$(".end").keypress(function(event) {event.preventDefault();});
$(".start_lunch").keypress(function(event) {event.preventDefault();});
$(".end_lunch").keypress(function(event) {event.preventDefault();});
</script>
@endsection

