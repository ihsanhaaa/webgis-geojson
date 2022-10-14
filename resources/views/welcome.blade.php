@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="side-bar" class="col-md-12">
                <br>
                <button id="find_user_location" class="btn btn-success col-md-12">Find Location</button>
                <br><br>
                <button id="go_to" class="btn btn-info col-md-12">Ke Keraton Sambas</button>
                <br>
                <br>
                <h5>Zoom Level: <span id="zoom_level"></span></h5>
                <h5>Map Center: <span id="map_center"></span></h5>
                <h5>Mouse Location: <span id="mouse_location"></span></h5>

            </div>

            <div id="map_div" class="col-md-12"></div>
        </div>
    </div>




    <script>
        var myMap;
        var lyrOSM;
        var lyrOpenTopoMap;
        var lyrWorldImagery;
        var baseLayers;
        var overlays;
        var mrkField;
        var polyField;

        var mrkCurrentLocation;
        var popsomething;
        var ctrlPan;
        var ctrlMousePosisition;
        var ctrlMeasure;
        var ctrlEasyButton;
        var ctrlEasyButtonSidebar;
        var ctrlSidebar;
        // var ctrlRuler;

        $(document).ready(function() {

            // create map object
            myMap = L.map('map_div', {
                center: [-0.06648139098248239, 109.38395165398344],
                zoom: 16
            });

            // add base map layer
            // lyrOSM = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png');
            lyrOSM = L.tileLayer.provider('OpenStreetMap.Mapnik');
            lyrOpenTopoMap = L.tileLayer.provider('OpenTopoMap');
            lyrWorldImagery = L.tileLayer.provider('Esri.WorldImagery');
            myMap.addLayer(lyrOSM);


            // point
            mrkField = L.marker([-0.051553957096374926, 109.34590499634447], {
                draggable: true
            }).addTo(myMap);
            mrkField.bindTooltip('Ayani Megamall');

            // polygon
            // polyField = L.polygon([], {
            //     fillColor: "red",
            // }).addTo(myMap);

            // polyline
            // lineField = L.polyline([], {
            //     color: 'red',
            //     weight: 5
            // }).addTo(myMap);

            baseLayers = {
                "OpenStreetMap": lyrOSM,
                "OpenTopoMap": lyrOpenTopoMap,
                "Esri-WorldImagery": lyrWorldImagery
            };

            overlays = {
                // "OpenStreetMap": lyrOSM,
                // "OpenTopoMap": lyrOpenTopoMap,
                // "Esri-WorldImagery": lyrWorldImagery
                "Point": mrkField
            };

            L.control.layers(baseLayers, overlays).addTo(myMap);


            // plugins
            // ctrlPan = L.control.pan().addTo(myMap);
            ctrlMousePosisition = L.control.mousePosition().addTo(myMap);

            ctrlMeasure = L.control.polylineMeasure().addTo(myMap);
            // ctrlRuler = L.control.ruler().addTo(myMap);
            ctrlEasyButton = L.easyButton('fa-map-marker', function() {
                myMap.locate();
            }).addTo(myMap);

            ctrlSidebar = L.control.sidebar('side-bar').addTo(myMap);
            ctrlEasyButtonSidebar = L.easyButton('fa-exchange', function() {
                ctrlSidebar.toggle();
            }).addTo(myMap);

            // popup untuk suatu tempat
            popsomething = L.popup();
            popsomething.setLatLng([-0.04879525023604582, 109.34348446171197]);
            popsomething.setContent("<p>Hotel Ibis!<br />Kota Pontianak.</p>" +
                "<img src='{{ asset('img/hotel-ibis.jpg') }}' style='width: 100px;' >");
            // popsomething.openOn(myMap);

            // klik kanan untuk mendapatkan lat long
            // myMap.on('click', function(e) {
            //     alert(e.latlng.toString());
            // });

            // klik kanan dan menambahkan titik
            myMap.on('contextmenu', function(e) {
                L.marker(e.latlng).addTo(myMap).bindPopup(e.latlng.toString());
            });

            // cek lokasi user
            myMap.on('keypress', function(e) {
                if (e.originalEvent.key = 'l') {
                    myMap.locate();
                }
            });

            myMap.on('locationfound', function(e) {
                if (mrkCurrentLocation) {
                    mrkCurrentLocation.remove();
                }
                mrkCurrentLocation = L.circleMarker(e.latlng).addTo(myMap);
                myMap.setView(e.latlng, 18);
            });

            myMap.on('locationerror', function(e) {
                alert("lokasi tidak ditemukan");
            });

            // go to location spesific
            $('#go_to').click(function() {
                myMap.setView([-0.04879525023604582, 109.34348446171197], 18);
                myMap.openPopup(popsomething);
            });

            // get user location
            $('#find_user_location').click(function() {
                myMap.locate();
            });

            // get zoom
            myMap.on('zoomend', function() {
                $('#zoom_level').html(myMap.getZoom());
            });

            // get map center
            myMap.on('moveend', function(e) {
                $('#map_center').html(lat_lng_to_string(myMap.getCenter()));
            });

            // get mouse location
            myMap.on('mousemove', function(e) {
                $('#mouse_location').html(lat_lng_to_string(e.latlng));
            });

            mrkField.on('dragend', function() {
                mrkField.setTooltipContent('Current Location: ' + mrkField.getLatLng().toString());
            });

            // custom function
            function lat_lng_to_string(ll) {
                return "[" + ll.lat.toFixed(5) + "," +
                    ll.lng.toFixed(5) + "]";
            }

        });
    </script>
@endsection
