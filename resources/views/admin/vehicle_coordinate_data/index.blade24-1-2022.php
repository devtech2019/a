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
'title' => 'Create postal code',
'from' => 'Admin',
'to' => 'Franchise Create',
])
@endsection
@section('content')
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<div class="box-header with-border">
   <div class="box-title">Create postal code</div>
</div>
{{ Form::open(['role' => 'form','route' => ["vehicle.add"],'class' => 'mws-form', 'files' => true,"autocomplete"=>"off"]) }}
<div class="box-body">
   <div class="row">
          <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('vehicle_number', 'Vehicle Number') !!}
                    <select name="vehicle_number" id="" class="form-control" >
                      <option value="">Select Vehicle Number</option>
                      <option value="TN90A1210">TN90A1210</option>
                      <option value="TN90A1210">TN90A1210</option>
                      <option value="TN90A1210">TN90A1210</option>
                      <option value="TN90A1210">TN90A1210</option>
                    </select>
                    <small class="text-danger">{{ $errors->first('vehicle_number') }}</small>
                  </div>
              </div>


        <div class="col-md-4">
          <div class="form-group">
              {!! Form::label('start_time', 'Start Time') !!}
              <div class='col-sm-12 input-group date dtpickerdemo' id=''>
                <input type='text' class="form-control" name="start_time"/>
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
              <div class='col-sm-12 input-group date dtpickerdemo' id=''>
                <input type='text' class="form-control" name="end_time" />
                <span class="input-group-addon">
                <span class="fa fa-calendar"></span>
                </span>
              </div>
              <small class="text-danger">{{ $errors->first('end_time') }}</small>
          </div>
        </div>
   </div>
</div>
<div class="box-footer">
   <div class="btn-group pull-center">
      {!! Form::submit("Submit", ['class' => 'btn btn-add btn-default']) !!}
   </div>
</div>
{!! Form::close() !!}
<div class="row">
   <div class="col-md-8">
      <div class="form-group">
         {!! Form::label('location', 'Location') !!}
         <div id="inputDiv"></div>
         <div id="map"></div>
         <div id="results"></div>
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
<script
   src="http://maps.googleapis.com/maps/api/js"></script>
<script>
   
   
   $(document).ready(function(){
       initialize();    
       $("#startvalue").on('keydown',function(event){
           if (event.keyCode == 13 ) {
               createLine();
               $(this).val("");
               $(this).focus();
           }
       });
   
   })
   var locations = [["The Barn","10.072841","77.97768"],["Brenda's French Soul Food","10.064798","77.979564"]];
   var directionDisplay;
   var directionsService = new google.maps.DirectionsService();
   var map;

   function initialize(){
        map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: new google.maps.LatLng(locations[0][1],locations[0][2]),
        mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;
        

           for (i = 0; i < locations.length; i++) {  
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
            }
        })(marker, i));
        }

       setZoom();
   
       var input = /** @type {HTMLInputElement} */(
       document.getElementById('startvalue'));
   
       var searchBox = new google.maps.places.SearchBox(
       /** @type {HTMLInputElement} */(input));
   
   }

   function calcRoute(directionsService, directionsDisplay){
    var firstItem = locations[0];
        var lastItem = locations[locations.length-1];
            start = new google.maps.LatLng(firstItem[1], firstItem[2]);
            end = new google.maps.LatLng(lastItem[1], lastItem[2]);


    //code for marker in map 
    var marker, i,Firstmarker;
    var infowindow = new google.maps.InfoWindow();
    for (i = 0; i < locations.length; i++) {  
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
    });
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
        infowindow.setContent(locations[i][0]);
        infowindow.open(map, marker);
        }
    })(marker, i));
    }



    var request = {
        origin: start,
        destination: end,
        waypoints: waypts,
        optimizeWaypoints: true,
        travelMode: google.maps.DirectionsTravelMode.DRIVING,
        // travelMode: google.maps.TravelMode[selectedMode],

    };

    var previous_distance
    var previous_time

    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
        
      
        }



  
    });

   }
   


   
</script>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBK6nZeAvYmGJMahrmpJcOFsrHOT5508y0&callback=initAutocomplete&libraries=places&v=weekly"
      async
    ></script>
@endsection