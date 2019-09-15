<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Park Your Car</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1549984893" />

    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="http://js.api.here.com/v3/3.0/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
    <script src="http://js.api.here.com/v3/3.0/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>



    <style>
        .sidebar {
            height: 40%;
            width: 0;
            margin-top: 155px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #f1f1f1;
            overflow-x: hidden;
            transition: 0.5s;

        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;

            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }

        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 25px;

            margin-left: 50px;
        }

        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #f1f1f1;
            color: white;
            padding: 10px 15px;
            border: none;
        }

        .openbtn:hover {
            background-color: #444;
        }

        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
        @media screen and (max-height: 450px) {
            .sidebar {
                padding-top: 15px;
            }

            .sidebar a {
                font-size: 18px;
            }
        }
    </style>

</head>

<body>

    <nav class="navbar  navbar-fixed-top navbar-expand-lg navbar-light " style="background-color: #e3f2fd" ;>

        <a class="navbar-brand" href="#">ParkYourCar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </ul>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <form class="form-inline my-2 my-lg-8">

                    <div id="panel" style="position:absolute; width:49%; left:20%; height:100%; background:inherit"></div>
                </form>
            </ul>
        </div>

    </nav>
    <div id="map" style="position:absolute; width:100%; height:100%; background:grey"></div>

    <p id="demo"></p>
    <script type="text/javascript" charset="UTF-8">
        var AUTOCOMPLETION_URL = 'https://autocomplete.geocoder.api.here.com/6.2/suggest.json',
            ajaxRequest = new XMLHttpRequest(),
            query = '';

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


        /**
         * If the text in the text box  has changed, and is not empty,
         * send a geocoding auto-completion request to the server.
         *
         * @param {Object} textBox the textBox DOM object linked to this event
         * @param {Object} event the DOM event which fired this listener
         */
        function autoCompleteListener(textBox, event) {

            if (query != textBox.value) {
                if (textBox.value.length >= 1) {

                    /**
                     * A full list of available request parameters can be found in the Geocoder Autocompletion
                     * API documentation.
                     *
                     */
                    var params = '?' +
                        'query=' + encodeURIComponent(textBox.value) + // The search text which is the basis of the query
                        '&beginHighlight=' + encodeURIComponent('<mark>') + //  Mark the beginning of the match in a token.
                        '&endHighlight=' + encodeURIComponent('</mark>') + //  Mark the end of the match in a token.
                        '&maxresults=5' + // The upper limit the for number of suggestions to be included
                        // in the response.  Default is set to 5.
                        '&app_id=' + 'ZW4keVO2D9YSwfEFrYU4' +
                        '&app_code=' + '1AsCY1LLoVFXuHAkBNWtSA';
                    ajaxRequest.open('GET', AUTOCOMPLETION_URL + params);
                    ajaxRequest.send();
                }
            }
            query = textBox.value;
        }


        /**
         *  This is the event listener which processes the XMLHttpRequest response returned from the server.
         */
        function onAutoCompleteSuccess() {
            /*
             * The styling of the suggestions response on the map is entirely under the developer's control.
             * A representitive styling can be found the full JS + HTML code of this example
             * in the functions below:
             */
            clearOldSuggestions();
            // addSuggestionsToPanel(this.response);  // In this context, 'this' means the XMLHttpRequest itself.
            addSuggestionsToMap(this.response);
        }


        /**
         * This function will be called if a communication error occurs during the XMLHttpRequest
         */
        function onAutoCompleteFailed() {
            alert('Ooops!');
        }

        // Attach the event listeners to the XMLHttpRequest object
        ajaxRequest.addEventListener("load", onAutoCompleteSuccess);
        ajaxRequest.addEventListener("error", onAutoCompleteFailed);
        ajaxRequest.responseType = "json";


        /**
         * Boilerplate map initialization code starts below:
         */


        // set up containers for the map  + panel
        var mapContainer = document.getElementById('map'),
            suggestionsContainer = document.getElementById('panel');

        //Step 1: initialize communication with the platform
        var APPLICATION_ID = 'ZW4keVO2D9YSwfEFrYU4',
            APPLICATION_CODE = '1AsCY1LLoVFXuHAkBNWtSA';

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

        // Hold a reference to any infobubble opened
        var bubble;

        /**
         * Function to Open/Close an infobubble on the map.
         * @param  {H.geo.Point} position     The location on the map.
         * @param  {String} text              The contents of the infobubble.
         */
        function openBubble(position, text) {
            if (!bubble) {
                bubble = new H.ui.InfoBubble(
                    position,
                    // The FO property holds the province name.
                    {
                        content: '<small>' + text + '</small>'
                    });
                ui.addBubble(bubble);
            } else {
                bubble.setPosition(position);
                bubble.setContent('<small>' + text + '</small>');
                bubble.open();
            }
        }


        /**
         * The Geocoder Autocomplete API response retrieves a complete addresses and a `locationId`.
         * for each suggestion.
         *
         * You can subsequently use the Geocoder API to geocode the address based on the ID and
         * thus obtain the geographic coordinates of the address.
         *
         * For demonstration purposes only, this function makes a geocoding request
         * for every `locationId` found in the array of suggestions and displays it on the map.
         *
         * A more typical use-case would only make a single geocoding request - for example
         * when the user has selected a single suggestion from a list.
         *
         * @param {Object} response
         */
        function addSuggestionsToMap(response) {
            /**
             * This function will be called once the Geocoder REST API provides a response
             * @param  {Object} result          A JSONP object representing the  location(s) found.
             */
            var onGeocodeSuccess = function(result) {
                    var marker,
                        locations = result.Response.View[0].Result,
                        i;

                    // Add a marker for each location found
                    for (i = 0; i < locations.length; i++) {
                        marker = new H.map.Marker({
                            lat: locations[i].Location.DisplayPosition.Latitude,
                            lng: locations[i].Location.DisplayPosition.Longitude
                        });
                        marker.setData(locations[i].Location.Address.Label);
                        group.addObject(marker);
                    }

                    map.setViewBounds(group.getBounds());
                    if (group.getObjects().length < 2) {
                        map.setZoom(15);
                    }
                },
                /**
                 * This function will be called if a communication error occurs during the JSON-P request
                 * @param  {Object} error  The error message received.
                 */
                onGeocodeError = function(error) {
                    alert('Ooops!');
                },
                /**
                 * This function uses the geocoder service to calculate and display information
                 * about a location based on its unique `locationId`.
                 *
                 * A full list of available request parameters can be found in the Geocoder API documentation.
                 * see: http://developer.here.com/rest-apis/documentation/geocoder/topics/resource-search.html
                 *
                 * @param {string} locationId    The id assigned to a given location
                 */
                geocodeByLocationId = function(locationId) {
                    geocodingParameters = {
                        locationId: locationId
                    };

                    geocoder.geocode(
                        geocodingParameters,
                        onGeocodeSuccess,
                        onGeocodeError
                    );
                }

            /*
             * Loop through all the geocoding suggestions and make a request to the geocoder service
             * to find out more information about them.
             */

            response.suggestions.forEach(function(item, index, array) {
                geocodeByLocationId(item.locationId);
            });
        }


        /**
         * Removes all H.map.Marker points from the map and adds closes the info bubble
         */
        function clearOldSuggestions() {
            group.removeAll();
            if (bubble) {
                bubble.close();
            }
        }

        /**
         * Format the geocoding autocompletion repsonse object's data for display
         *
         * @param {Object} response
         */
        function addSuggestionsToPanel(response) {
            var suggestions = document.getElementById('suggestions');
            suggestions.innerHTML = JSON.stringify(response, null, ' ');
        }



        // var content = '<strong style="font-size: large;">' + '' + '</strong></br>';

        var content = '<br/><input type="text" id="auto-complete" placeholder="search" style="margin-left:5%; margin-right:5%; min-width:90%;background:inherit;border:2px solid #555;"  onkeyup="return autoCompleteListener(this, event);"><br/>';
        // content += '<br/><strong>Response:</strong><br/>';
        content += '<div style="margin-left:5%; margin-right:5%;"><pre style="max-height:235px"><code  id="suggestions" style="font-size: small;">' + '</code></pre></div>';

        suggestionsContainer.innerHTML = content;


        function markCurrentPosition(position) {
            currentLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            // sets map center to current location

            map.setCenter(currentLocation);
            map.setZoom(12);
          
 });

            // puts a draggable marker on current location
            addDraggableMarker(currentLocation, map, behavior);
            // use dragMarker.getGeometry() to get the draggable marker's
            // lat and lng info
        }



        // restricts map only to move within Bangladesh
        restrictMap(map);


        function markParkingSpots(map) {
            var parkingSpots = <?php echo json_encode($locations); ?>;
            var marker;
            var icon;

            for (var i = 0; i < parkingSpots.length; i++) {
                icon = new H.map.Icon('image/icon.png');
                marker = new H.map.Marker(parkingSpots[i], {
                    icon: icon
                });
                map.addObject(marker);
            }
        }

        markParkingSpots(map);

        // get current position and puts a draggable marker on it
        navigator.geolocation.getCurrentPosition(markCurrentPosition);
    </script>



</body>

</html>
