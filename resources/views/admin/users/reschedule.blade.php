@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => 'active', 'appointment' => 'active', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
    'cleanersBookings' => '', 'all_bookings' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Reschedule Bookings',
    'from' => 'Admin',
    'to' => 'Reschedule Bookings',
  ])
@endsection

@section('content')   

<div class="box-header with-border">
  
  <div class="box-title">Reschedule Form</div>
</div>
{!! Form::open(['method' => 'POST', 'action' => ['AdminUsersController@Reschedule',$bookedAppointmentId,$cleanerId,$userId], 'files' => true]) !!}

  <div class="box-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group{{ $errors->has('booking_date') ? ' has-error' : '' }}">
            {!! Form::label('booking_date', 'Date') !!}
            {!! Form::text('booking_date', null, ['class' => 'form-control date-pick myform','placeholder'=>'Date' , 'autocomplete'=>"off",'id'=>'booking_rescheduleval']) !!}
            <small class="text-danger">{{ $errors->first('booking_date') }}</small>
          </div>
        </div>
        <div class="col-md-6">
              {!! Form::label('slot_time', 'Slots') !!}
              <div id="slots_booking">
              {!! Form::select('slot_time', [""=>"Choose Slots"], null, ['class' => 'form-control', 'id'=>'']) !!}
              </div>
              <small class="text-danger">{{ $errors->first('slot_time') }}</small> 
        </div>
        </div> 
     
    </div>
  <div class="box-footer">
    <div class="btn-group pull-center">
      @if(isset( $errors) && count($errors) > 0)
        <a class='btn btn-yellow btn-default' href="">Reset</a>
      @else
        {!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!}
      @endif
      {!! Form::submit("Reschedule", ['class' => 'btn btn-add btn-default']) !!}
    </div>
  </div>
{!! Form::close() !!}

<script>

function formatDate(date) {
  var d = new Date(date),
  month = '' + (d.getMonth() + 1),
  day = '' + d.getDate(),
  year = d.getFullYear();

  if (month.length < 2) 
  month = '0' + month;
  if (day.length < 2) 
  day = '0' + day;

  return [year, month, day].join('-');
}

$( document ).ready(function() {
  $('.date-pick').datepicker({
        format    : "yyyy-mm-dd",
    startDate : new Date('{{$minDate}}'),
    endDate   : new Date('{{$maxDate }}')
  }).on('changeDate', function(val) {
      let cleaner_id    = "{{$cleanerId}}";
      let selectedDate  = formatDate(val.date);
      $.ajax({
        type: "POST",
        url: "{{route('Api.getValidBookingShedule')}}",
        data:  {
          "cleaner_id":cleaner_id,
          "selected_date":selectedDate,
          "from":"admin",
        },
        success: function (response) {   
          var toAppend = '';
          if(response.status == "success"){
            toAppend += '<select class="form-control" id="slots_booking" name="slot_time"><option value="" selected="selected">Choose Slots</option>';
            $.each(response.data,function(index,val){
              toAppend += '<option value='+val.value+'>'+val.label+'</option>';
            });
            toAppend += '</select>';
          }
          $('#slots_booking').html(toAppend);         
        },
      });
      // `e` here contains the extra attributes
  });
});
</script>
@endsection

