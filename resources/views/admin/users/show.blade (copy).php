@extends('layouts.admin')
@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => 'active', 'all_user' => 'active', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'All Appointment Details',
    'from' => 'Admin',
    'to' => 'All Appointment Details',
  ])
@endsection

@section('content')   

@section('admin_developer')
    @parent
    <style>
     
.dataTables_filter {
display: none;
}
.dataTables_paginate {
display: none;
}
.dataTables_info {
display: none;

}

.dataTables_length {
display: none;

}
.sorting:{
  display: none;
}
.list-design-portal {
    display: flex;
    flex-wrap: wrap;
}
.box-design-portal {
    width: 33%;
}

    </style>
@endsection

<script type="text/javascript">
  $(document).ready( function () {$('#tbl-list').dataTable( {
    "ordering": false
  } );
  $('#tbl-list2').dataTable( {
    "ordering": false
  } );
  $('#tbl-list3').dataTable( {
    "ordering": false
  } );
} 
</script>
@section('content')

    <div class="card card-primary primary-shop-sec">
        <div class="card-header">           
        </div>
        <div class="card-body">

            <div class="callout callout-info callout-help bg-light">
              <h4 class="title">User-Cleaner Details</h4>
              <p></p>
            </div>

            <table id="tbl-list" data-order-by="0|desc" data-page-length="25" data-server="false" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th> User Name</th>
                    <th>User Email </th>
                    <th>Cleaner Name </th>  
                    <th>Cleaner Email</th> 
                    <th> Appointment Date</th>                   
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{$appointmentDetail[0]['user']['name']}}</td>
                    <td>{{$appointmentDetail[0]['user']['email']}} </td>
                    <td>{{$appointmentDetail[0]['cleaner']['name']}}</td>
                    <td>{{$appointmentDetail[0]['cleaner']['email']}}</td>
                    <td>{{$appointmentDetail[0]->appointment_date}}</td>
                  </tr>
                
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <div class="callout callout-info callout-help bg-light">
              <h4 class="title">Vehicle Details</h4>
              <p></p>
            </div>
            
            <table id="tbl-list2" data-order-by="0|desc" data-page-length="25" data-server="false" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Vehicle Colour</th>
                    <th>Vehicle Registration no</th>
                     <th>Vehicle Company</th>
                     <th>Vehicle Model</th>
                     <th>Vehicle Type</th>
                  
                
                  
                </tr>

                </thead>
                <tbody>
                  <tr>
                    <td>{{$appointmentDetail[0] ['user_vehicle']['color']}}</td>
                    <td>{{$appointmentDetail[0]['user_vehicle']->vehicle_registration_no}}</td>
                    <td>{{$appointmentDetail[0]['user_vehicle']->vehicleClass->vehicle_company}}</td>
                    <td> {{$appointmentDetail[0]['user_vehicle']->vehicleModel->vehicle_modal }} </td>
                    <td> {{$appointmentDetail[0]['user_vehicle']->VehicleType->type}} </td>
                </tbody>
            </table>
        </div>
        
                 
     <a href="javascript:window.history.back();" class="btn btn-secondary ">
        <i class="fa fa-fw fa-chevron-left"></i> Back
    </a>  
<script type="text/javascript">
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

@endsection












<!-- <td  class="column-header">Initial Price</td>
       <td  class="column-header">Discount %</td>
       <td  class="column-header">Final Price</td>
        -->
  
        @endsection  