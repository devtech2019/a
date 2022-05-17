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
                      <option value="MH14JL3079">MH14JL3079</option>
                    </select>
                    <small class="text-danger">{{ $errors->first('vehicle_number') }}</small>
                  </div>
              </div>


        <div class="col-md-4">
          <div class="form-group">
              {!! Form::label('start_time', 'Start Time') !!}
              <div class='col-sm-12 input-group ' id=''>
                <input type='text' class="form-control dtpickerdemo" name="start_time"/>
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
                <input type='text' class="form-control dtpickerdemo" name="end_time" />
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

<div style="display:'';">

</div>
<div class="row">
    <!-- <div class="col-md-4">
       <b>Start:</b>
       <select id="start">
          <option value="Halifax, NS">Halifax, NS</option>
          <option value="Boston, MA">Boston, MA</option>
          <option value="New York, NY">New York, NY</option>
          <option value="Miami, FL">Miami, FL</option>
       </select>
    </div>
    <div class="col-md-4">
       <b>Waypoints:</b> <br />
       <i>(Ctrl+Click or Cmd+Click for multiple selection)</i> <br />
       <select multiple id="waypoints">
          <option value="Chakan - Nanekarwadi - Pune, Bopkhel, Pimpri-Chinchwad, Maharashtra 411034, India">Montreal, QBC</option>
          <option value="Wakad - Bhosari BRTS Road, MIDC, Bhosari, Pimpri-Chinchwad, Maharashtra 411026, India">Toronto, ONT</option>
          <option value="Chakan - Nanekarwadi - Pune, MIDC, Pimpri Colony, Pimpri-Chinchwad, Maharashtra 411026, India">Chicago</option>
          <option value="C-10/11-13-A, MIDC, Bhosari, Pimpri-Chinchwad, Maharashtra 411026, India">Winnipeg</option>
          <option value="460/2568, Rajmata Jijau Marg, Sant Tukaram Nagar, …lony, Pimpri-Chinchwad, Maharashtra 411018, India">Fargo</option>
          <option value="calgary, ab">Calgary</option>
          <option value="spokane, wa">Spokane</option>
       </select>
    </div>
    <div class="col-md-4">
       <b>End:</b>
       <select id="end">
          <option value="Vancouver, BC">Vancouver, BC</option>
          <option value="Seattle, WA">Seattle, WA</option>
          <option value="San Francisco, CA">San Francisco, CA</option>
          <option value="Los Angeles, CA">Los Angeles, CA</option>
       </select>
    </div>
    <br />
    <input type="submit" id="submit" />
    <div> -->
</div>

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
 
   function initialize(){
    const directionsService = new google.maps.DirectionsService();
  const directionsRenderer = new google.maps.DirectionsRenderer();
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 6,
    center: { lat: 41.85, lng: -87.65 },
  });

  directionsRenderer.setMap(map);
  document.getElementById("submit").addEventListener("click", () => {
    calculateAndDisplayRoute(directionsService, directionsRenderer);
  });
   
   }

   function calculateAndDisplayRoute(directionsService, directionsRenderer) {

  const waypts = [];
  const checkboxArray = document.getElementById("waypoints");

  for (let i = 0; i < checkboxArray.length; i++) {
    if (checkboxArray.options[i].selected) {
      waypts.push({
        location: checkboxArray[i].value,
        stopover: true,
      });
    }
  }

  directionsService
    .route({
      origin: document.getElementById("start").value,
      destination: document.getElementById("end").value,
      waypoints: waypts,
      optimizeWaypoints: true,
      travelMode: google.maps.TravelMode.DRIVING,
    })
    .then((response) => {
      directionsRenderer.setDirections(response);

      const route = response.routes[0];
      const summaryPanel = document.getElementById("directions-panel");

      summaryPanel.innerHTML = "";

      // For each route, display summary information.
      for (let i = 0; i < route.legs.length; i++) {
        const routeSegment = i + 1;

        summaryPanel.innerHTML +=
          "<b>Route Segment: " + routeSegment + "</b><br>";
        summaryPanel.innerHTML += route.legs[i].start_address + " to ";
        summaryPanel.innerHTML += route.legs[i].end_address + "<br>";
        summaryPanel.innerHTML += route.legs[i].distance.text + "<br><br>";
      }
    })
    .catch((e) => window.alert("Directions request failed due to " + status));
}
   


   
</script>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBK6nZeAvYmGJMahrmpJcOFsrHOT5508y0&callback=initialize&libraries=places&v=weekly"
      async
    ></script>
@endsection