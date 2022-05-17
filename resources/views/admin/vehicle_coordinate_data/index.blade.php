@extends('layouts.admin')
@section('sidebar_active')
@include('include.sidebar_links', [
'users' => '', 'all_user' => '', 'create_user' => '',
'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
'plan' => '', 'all_plan' => '', 'plan_price' => '',
'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
'settings' => '', 'services' => '', 'gallery' => '', 'facts' => 'active', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
'profile' => '', 'sub_appointment' => '',
])
@endsection
@section('breadcum')
@include('include.breadcum', [
'title' => 'Vehicle Cordinate Data',
'from' => 'Admin',
'to' => 'Franchise Create',
])
@endsection
@section('content')
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
   <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script> -->
<div class="box-header with-border">
   <div class="box-title">Vehicle Cordinate Data</div>
</div>
{{ Form::open(['role' => 'form','class' => 'mws-form', 'files' => true,"autocomplete"=>"off"]) }}
<div class="box-body">
   <div class="row">
      <div class="col-md-4">
         <div class="form-group">
            {!! Form::label('vehicle_number', 'Vehicle Number') !!}
            <select name="vehicle_number" id="vehicle_number" class="form-control" >
               <option value="">Select Vehicle Number</option>
               <option value="TN90A1210">TN90A1210</option>
               <option value="MH14JL3079" >MH14JL3079</option>
            </select>
            <small class="text-danger">{{ $errors->first('vehicle_number') }}</small>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            {!! Form::label('start_time', 'Start Time') !!}
            <div class='col-sm-12 input-group ' id=''>
               <input type='text' class="form-control dtpickerdemo" name="start_time" id="start_time" />
               <span class="input-group-addon">
               <span class="fa fa-calendar"></span>
               </span>
            </div>
            <small class="text-danger">{{ $errors->first('start_time') }}</small>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            {!! Form::label('end_time', 'End Time') !!}
            <div class='col-sm-12 input-group ' id=''>
               <input type='text' class="form-control dtpickerdemo" name="end_time" id="end_time" />
               <span class="input-group-addon">
               <span class="fa fa-calendar"></span>
               </span>
            </div>
            <small class="text-danger">{{ $errors->first('end_time') }}</small>
         </div>
      </div>
   </div>
</div>
        <div class="get-direction-btn-box">
        <div class="get-direction-btn-left">
           {!! Form::submit("Get Directions", ['class' => 'btn btn-add btn-default blue-button','id'=>'submit']) !!}
          
            <a href="{{route('vehicle.index')}}" class="btn btn-add btn-default blue-button" style="margin-left: 12px;">Clear</a>
            </div>
      
               
               <div class="get-direction-btn-right">     <button class="btn btn-add btn-default blue-button" id="location" style="margin-left: 27px;">Track Location</button></div>
                    
            </div>
        </div>

{!! Form::close() !!}
<div class="row">
   <div class="col-md-12">
      <div class="form-group mapBox">
         <div class="spinner-border" id="loading"> 
          <div class="spinner-border-inner"> 
           <img src="{{asset('public/images')}}/loader.gif" class="loader" alt="loader"> 
          </div> 
         </div>
         {!! Form::label('location', 'Location') !!}
         <div id="map_canvas" style="height:500px;"></div>
         <div id="control_panel" style="float:right;width:30%;text-align:left;padding-top:20px">
            <!-- <div id="directions_panel" style="margin:20px;background-color:#FFEE77;"></div> -->
         </div>
      </div>
   </div>
</div>
<style>
   /* Always set the map height explicitly to define the size of the div
   element that contains the map. */
   #map {
   margin: 0;
   padding: 0;
   height: 400px;
   margin-top:30px;
   width:100%;
   }
   #inputDiv{
   position:absolute;
   top:0;
   }
   #startvalue{
   width:300px;
   padding:8px;
   }
</style>
<script type="text/javascript">
   $(function () {
       $('.dtpickerdemo').datetimepicker();
   });
</script>
<script>

$(document).ready(function () {
   $("#location").click(function () {
    $( "#loading" ).show();
    var formData = {
      vehicle_number: $("#vehicle_number").val()
    };
    $.ajax({
            type: "POST",
            url: "{{route('vehicle.location')}}",
            data: {formData, _token: '{{csrf_token()}}'},
            dataType: "json",
            encode: true,
         }).done(function (response) {
             if(response.data[0].data.share_link){
                $( "#loading" ).hide();
            //  alert(response.data[0].data.share_link);
                // var url = "https://jsonplaceholder.typicode.com/users/";
                var url = response.data[0].data.share_link;
                window.open(url, "_blank");
             }
   
    });
   
    event.preventDefault();
   });
   });



   $(document).ready(function () {
   $("#submit").click(function (event) {
   $( "#loading" ).show();
    var formData = {
      vehicle_number: $("#vehicle_number").val(),
      start_time: $("#start_time").val(),
      end_time: $("#end_time").val(),
      superheroAlias: $("#superheroAlias").val(),
    };
    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer();
    $.ajax({
            type: "POST",
            url: "{{route('vehicle.add')}}",
            data: {formData, _token: '{{csrf_token()}}'},
            dataType: "json",
            encode: true,
         }).done(function (response) {
                //  console.log(response);
                 markerspoint = response.addressesArray;
   
               const addresses = [];  
               response.apiresponse.map((item,index)=>{
                 if(item.speed != '0' ){
                    addresses.push(item)
                  }
            })
              calcRoute(addresses,markerspoint);
   
    });
   
    event.preventDefault();
   });
   });

   
   
   var directionDisplay;
   var map;
   var directionsService;
   
   function initialize() {
    
    directionsService = new google.maps.DirectionsService();
   
    directionsDisplay = new google.maps.DirectionsRenderer();
    var chicago = new google.maps.LatLng(41.850033, -87.6500523);
    var myOptions = {
      zoom: 6,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      center: chicago
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    directionsDisplay.setMap(map);
    calcRoute();
   }
   
   function calcRoute(addresses,markerspoint) {
      $( "#loading" ).hide();
      const waypts = [];
      const checkboxArray = addresses;
      for (let i = 1; i < checkboxArray.length-1; i++) {
         waypts.push({
            location: new google.maps.LatLng(checkboxArray[i].lat,checkboxArray[i].long),
            stopover: false
         }) 
      }

      length = checkboxArray.length-1;
      first = new google.maps.LatLng(checkboxArray[0].lat,checkboxArray[0].long);
      last = new google.maps.LatLng(checkboxArray[length].lat,checkboxArray[length].long);
      
      var request = {
         origin:first,
         destination: last,
         waypoints: waypts,
         optimizeWaypoints: true,
         travelMode: google.maps.DirectionsTravelMode.WALKING
      };
      

//   console.log(markerspoint);
  //code for marker in map 


  var marker, i,Firstmarker;
    var infowindow = new google.maps.InfoWindow();
    for (i = 0; i < markerspoint.length; i++) {  
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(markerspoint[i].lat, markerspoint[i].lng),
        map: map
    });
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
        infowindow.setContent('<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h1 id="firstHeading" class="firstHeading">BubbleBath</h1>' +
    '<div id="bodyContent">' +
    "<p><b>Order Id</b>: "+ markerspoint[i].id +" <br>" +
    "<p><b>Vehicle registration no.</b>: "+ markerspoint[i].vehicle_registration_no +" <br>" +
    "<b>Cleaner Name</b>: "+ markerspoint[i].cleaner_name +" <br>" +
    "<b>Date</b>: "+ markerspoint[i].appointment_date +" <br>" +
    "<b>Time</b>: "+ markerspoint[i].time_frame +" <br>" +
    "<b>Address</b>: "+ markerspoint[i].address +" <br>" +
    "</div>" +
    "</div>");
        infowindow.open(map, marker);
        }
    })(marker, i));
    }




      // console.log(request);
      directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
        var route = response.routes[0];
        var summaryPanel = document.getElementById("directions_panel");
        summaryPanel.innerHTML = "";
        // For each route, display summary information.
        for (var i = 0; i < route.legs.length; i++) {
          var routeSegment = i + 1;
          summaryPanel.innerHTML += "<b>Route Segment: " + routeSegment + "</b><br />";
          summaryPanel.innerHTML += route.legs[i].start_address + " to ";
          summaryPanel.innerHTML += route.legs[i].end_address + "<br />";
          summaryPanel.innerHTML += route.legs[i].distance.text + "<br /><br />";
        }
      } else {
        alert("directions response "+status);
      }
    });
   }
   
   
   
</script>
<script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBK6nZeAvYmGJMahrmpJcOFsrHOT5508y0&callback=initialize&libraries=places&v=weekly"
   ></script>
@endsection