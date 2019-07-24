/**
 * Restricts a moveable map to a given rectangle.
 *
 * @param {H.Map} map   A HERE Map instance within the application
 *
 */
function restrictMap(map) {

    var bounds = new H.geo.Rect(20.6, 87.9, 26.65, 92.68);

    map.getViewModel().addEventListener('sync', function () {
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

    // disable the default draggability of the underlying map
    // when starting to drag a marker object:
    map.addEventListener('dragstart', function (ev) {
        var target = ev.target;
        if (target instanceof H.map.Marker) {
            behavior.disable();
        }
    }, false);


    // re-enable the default draggability of the underlying map
    // when dragging has completed
    map.addEventListener('dragend', function (ev) {
        var target = ev.target;
        if (target instanceof H.map.Marker) {
            behavior.enable();
        }
    }, false);

    // Listen to the drag event and move the position of the marker
    // as necessary
    map.addEventListener('drag', function (ev) {
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

group.addEventListener('tap', function (evt) {
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