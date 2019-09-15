@extends('layouts.app')

@section('meta')

<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="http://js.api.here.com/v3/3.0/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
<script src="http://js.api.here.com/v3/3.0/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="http://j.maxmind.com/app/geoip.js"></script> <!-- For our fallback -->

@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>Add Place</h1>
        {!! Form::open(['id' => 'placeForm','name' => 'placeForm', 'action' => 'PPlacesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">

            {{Form::label('address', 'Address')}}
            {{Form::text('address', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Address'])}}

            <input type="hidden" id="lat" name="lat" value="" />
            <input type="hidden" id="lng" name="lng" value="" />
            <input type="hidden" id="format_address" name="format_address" value="" />

            <br>

            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
            <br>
            <br>

        </div>

        {!! Form::close() !!}
        <div id="map" style="position:absolute; width:100%; height:100%; background:grey"></div>
    </div>
</div>
</div>


<script>
    /**
     * Restricts a moveable map to a given rectangle.
     *
     * @param {H.Map} map   A HERE Map instance within the application
     *
     */
    function restrictMap(map) {

        var bounds = new H.geo.Rect(20.6, 87.9, 26.65, 92.68);

        map.getViewModel().addEventListener('sync', function() {
            var center = map.getCenter();

            if (!bounds.containsPoint(center)) {
                if (center.lat > bounds.getTop()) {
                    center.lat = bounds.getTop();
                } else if (center.lat < bounds.getBottom()) {
                    center.lat = bounds.getBottom();
                }
                if (center.lng < bounds.getLeft()) {
                    center.lng = bounds.getLeft();
                } else if (center.lng > bounds.getRight()) {
                    center.lng = bounds.getRight();
                }
                map.setCenter(center);
            }
        });
        //Debug code to visualize where your restriction is
        /*map.addObject(new H.map.Rect(bounds, {
            style: {
                fillColor: 'rgba(55, 85, 170, 0.1)',
                strokeColor: 'rgba(55, 85, 170, 0.6)',
                lineWidth: 8
            }
        }
        ));*/
    }

    var dragMarker;

    function addDraggableMarker(position, map, behavior) {

        dragMarker = new H.map.Marker(position, {
            // mark the object as volatile for the smooth dragging
            volatility: true
        });
        // Ensure that the marker can receive drag events
        dragMarker.draggable = true;
        map.addObject(dragMarker);

        document.placeForm.lat.value = dragMarker.getGeometry().lat;
        document.placeForm.lng.value = dragMarker.getGeometry().lng;

        // disable the default draggability of the underlying map
        // when starting to drag a marker object:
        map.addEventListener('dragstart', function(ev) {
            var target = ev.target;
            if (target instanceof H.map.Marker) {
                behavior.disable();
            }
        }, false);


        // re-enable the default draggability of the underlying map
        // when dragging has completed
        map.addEventListener('dragend', function(ev) {
            var target = ev.target;
            if (target instanceof H.map.Marker) {
                behavior.enable();
            }

            document.placeForm.lat.value = dragMarker.getGeometry().lat;
            document.placeForm.lng.value = dragMarker.getGeometry().lng;
            var geocoder = new google.maps.Geocoder();
             var yourLocation = new google.maps.LatLng(dragMarker.getGeometry().lat, dragMarker.getGeometry().lng);
             geocoder.geocode({ 'latLng': yourLocation }, function (results) {


            document.placeForm.format_address.value = results[0].formatted_address;
                 console.log(results[0].formatted_address);

           });
        }, false);

        // Listen to the drag event and move the position of the marker
        // as necessary
        map.addEventListener('drag', function(ev) {
            var target = ev.target,
                pointer = ev.currentPointer;
            if (target instanceof H.map.Marker) {
                target.setGeometry(map.screenToGeo(pointer.viewportX, pointer.viewportY));
            }
        }, false);
    }



    // set up containers for the map  + panel
    var mapContainer = document.getElementById('map');
    var suggestionsContainer = document.getElementById('panel');

    //Step 1: initialize communication with the platform
    var APPLICATION_ID = 'ZW4keVO2D9YSwfEFrYU4';
    var APPLICATION_CODE = '1AsCY1LLoVFXuHAkBNWtSA';

    var platform = new H.service.Platform({
        app_id: 'ZW4keVO2D9YSwfEFrYU4',
        app_code: '1AsCY1LLoVFXuHAkBNWtSA',
        useCIT: false,
        useHTTPS: true
    });

    var defaultLayers = platform.createDefaultLayers();
    var geocoder = platform.getGeocodingService();
    var group = new H.map.Group();

    group.addEventListener('tap', function(evt) {
        map.setCenter(evt.target.getPosition());
        openBubble(
            evt.target.getPosition(), evt.target.getData());
    }, false);


    //Step 2: initialize a map - this map is centered over Europe

    var map = new H.Map(mapContainer,
        defaultLayers.normal.map, {
            center: {
                lat: 23.8103,
                lng: -90.4125
            },
            zoom: 5
        });



    //Step 3: make the map interactive
    // MapEvents enables the event system
    // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

    // Create the default UI components
    var ui = H.ui.UI.createDefault(map, defaultLayers);
    restrictMap(map);


    function showPosition(position) {

        currentLocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };

        map.setCenter(currentLocation);
        map.setZoom(14);

        addDraggableMarker(currentLocation, map, behavior);
    }

    navigator.geolocation.getCurrentPosition(showPosition);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKWr287U4lff521_5ckycHN3GdkXykA7w&libraries=places&callback=initMap"
    async defer></script>
@endsection
