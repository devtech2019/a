@extends('layouts.admin')
@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => 'active', 'all_user' => '', 'create_user' => 'active',
    'teams' => 'active', 'all_team' => 'active', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
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
  
  <div class="box-header with-border">
    <div class="box-title">Create postal code</div>
  </div>

  {!! Form::open(['method' => 'POST', 'files' => true]) !!}
      <div class="box-body">

        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
            
              {!! Form::label('location', 'Location') !!}
              <input id="searchInput"  type="text" class="controls form-control " id="location" name="location" placeholder="Enter location" value="{{ ($errors && $errors->any()? old('location') : (isset($team)? $team['location'] : '')) }}">
               <small class="text-danger">{{ $errors->first('location') }}</small>
              <input type="hidden" value="" id="lat" name="latitude">
              <input type="hidden" value="" id="lon" name="longitude">
              <!-- Google map -->
              <div id="map"></div>
            </div>
          </div>

          <div class="col-md-4">
              <?php $checkedInput = (isset($team['postal_code']) && $team['postal_code'])? $team['postal_code']:''?>
            <div class="form-group {{ $errors->has('postal_code') ? ' has-error' : '' }}">
              {!! Form::label('postal_code', 'postal_code') !!}
             
              {!! Form::text('postal_code',$checkedInput, ['class' => 'form-control','id' => 'postal_code', 'placeholder' => 'Enter your postal code', 'autofocus']) !!}
              <small class="text-danger">{{ $errors->first('postal_code') }}</small>
            </div>
          </div>
        </div>
      </div>
    <div class="box-footer">
      <div class="btn-group pull-center">
        {!! Form::reset("Reset", ['class' => 'btn btn-yellow btn-default']) !!}
        {!! Form::submit("Create ZipCode", ['class' => 'btn btn-add btn-default']) !!}
      </div>
    </div>
  {!! Form::close() !!}

<style>
    /* Always set the map height explicitly to define the size of the div
     element that contains the map. */
    #map {
       min-height: 500px;
    }
    #searchInput {
        margin-left: 12px;
        padding: 0 11px 0 13px;
        width: 50%;
            height: 40px;
        margin-top: 10px;
    }
   

</style>
   <script>

    var latvalue     =   "<?php echo isset($team) && !empty($team)?$team['latitude']:'';?>";
    var lonvalue     =   "<?php echo isset($team) && !empty($team)?$team['longitude']:'';?>"; 
    </script>
    <script>
        function myFunction() {
            // Get the checkbox
            var checkBox = document.getElementById("myCheck");
            // Get the output text
            var text = document.getElementById("text");
            // If the checkbox is checked, display the output text
            if (checkBox.checked == true){
                text.style.display = "flex";
            } else {
                text.style.display = "none";
            }
        }

        myFunction();

        $('.timepicker').datetimepicker({
            format: 'HH:mm:ss'
        }); 
    </script>
  <!--   <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
    <script >
    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    function initAutocomplete() {
      const map = new google.maps.Map(document.getElementById("map"), {
 
        center: { lat: parseFloat(latvalue), lng: parseFloat(lonvalue)?lat:26.912434,lng:75.787270 },

        center: { lat: parseFloat(latvalue), lng: parseFloat(lonvalue) ,lat: -34, lng: 151},
       

        zoom: 9,
        mapTypeId: "roadmap",
      });
      // Create the search box and link it to the UI element.
      const input = document.getElementById("searchInput");
      const searchBox = new google.maps.places.SearchBox(input);
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
      // Bias the SearchBox results towards current map's viewport.
      map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
      });
      let markers = [];
      // Listen for the event fired when the user selects a prediction and retrieve
      // more details for that place.
      searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();
        document.getElementById('postal_code').value     =   '';

        if (places.length == 0) {
          return;
        }
        // Clear out the old markers.
        markers.forEach((marker) => {
          marker.setMap(null);
        });
        markers = [];
        // For each place, get the icon, name and location.
        const bounds = new google.maps.LatLngBounds();
        places.forEach((place) => {

          if (!place.geometry || !place.geometry.location) {
            console.log("Returned place contains no geometry");
            return;
          }
          const icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25),
          };
          // Create a marker for each place.
          markers.push(
            new google.maps.Marker({
              map,
              icon,
              title: place.name,
              position: place.geometry.location,
            })
          );

          if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }

          for (var i = 0; i < place.address_components.length; i++) {
              if(place.address_components[i].types[0] == 'postal_code'){
                  document.getElementById('postal_code').value = place.address_components[i].long_name;
              }
             
          }

            document.getElementById('lat').value = place.geometry.location.lat();

            document.getElementById('lon').value = place.geometry.location.lng();
        });
        map.fitBounds(bounds);
      });

      map.setCenter(myMarker.position);
    myMarker.setMap(map);
    }
    </script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBK6nZeAvYmGJMahrmpJcOFsrHOT5508y0&callback=initAutocomplete&libraries=places&v=weekly"
      async
    ></script>
@endsection