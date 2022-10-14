@extends('layouts.test')

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
                <br>
                <br>

            </div>

            <div id="map_div" class="col-md-12"></div>
        </div>
    </div>
@endsection


@push('addon-script')
    <script>
        var myMap;
        var lyrOSM;
        var lyrOpenTopoMap;
        var lyrWorldImagery;
        var baseLayers;
        var overlays;

        var mrkField;
        var lineField;
        var polyField;
        var fgLayer;

        var mrkCurrentLocation;
        var popsomething;
        var ctrlPan;
        var ctrlMousePosisition;
        var ctrlMeasure;
        var ctrlEasyButton;
        var ctrlEasyButtonSidebar;
        var ctrlSidebar;
        // var ctrlRuler;

        var ctlDraw;
        var fDrawGroup;
        var ctlStyle;

        $(document).ready(function() {

            // create map object
            myMap = L.map('map_div', {
                center: [-0.06304903208178843, 109.35290734591857],
                zoom: 17
            });

            // add base map layer
            // lyrOSM = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png');
            lyrOSM = L.tileLayer.provider('OpenStreetMap.Mapnik');
            lyrOpenTopoMap = L.tileLayer.provider('OpenTopoMap');
            lyrWorldImagery = L.tileLayer.provider('Esri.WorldImagery');
            myMap.addLayer(lyrOSM);


            var latlngs = [
                [
                    [29.66534, 72.64021],
                    [29.66535, 72.63819],
                    [29.66376, 72.63817],
                    [29.66372, 72.63749],
                    [29.66352, 72.63749],
                    [29.66352, 72.63749],
                    [29.66353, 72.63713]
                ],
                [
                    [29.66536, 72.63683],
                    [29.66373, 72.63681],
                    [29.66372, 72.63714],
                    [29.66353, 72.63713]
                ]
            ];


            // polygon
            polyField = L.polygon([
                [
                    [29.66536, 72.63683],
                    [29.66322, 72.63681],
                    [29.66324, 72.64023],
                    [29.66534, 72.64023]
                ],
                [
                    [29.66403, 72.63885],
                    [29.66401, 72.6395],
                    [29.66373, 72.63949],
                    [29.66374, 72.63885]
                ]
            ], {
                color: "red",
                fillColor: "yellow",
                fillOpacity: 0.6
            });
            // polyline
            lineField = L.polyline(latlngs, {
                color: 'blue',
                weight: 5
            });

            // point
            mrkField = L.marker([29.66350, 72.63713], {
                draggable: true
            });
            mrkField.bindTooltip('Field No. 6');

            fgLayer = L.featureGroup([polyField, lineField, mrkField]).bindPopup('Hello world!').addTo(myMap);
            fDrawGroup = new L.featureGroup().addTo(myMap);

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
                // "Point": mrkField,
                // "Polygon": polyField,
                // "Polyline": lineField,
                "FieldData": fgLayer,
                "Draw Items": fDrawGroup
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

            // add and edit button
            ctlDraw = new L.Control.Draw({
                edit: {
                    featureGroup: fDrawGroup
                }

            });
            ctlDraw.addTo(myMap);

            myMap.on('draw:created', function(e) {
                fDrawGroup.addLayer(e.layer);
                alert(JSON.stringify(e.layer.toGeoJSON()));
            });

            ctlStyle = L.control.styleEditor({
                position: 'topleft'
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
@endpush
