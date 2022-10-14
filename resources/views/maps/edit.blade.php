@extends('layouts.test')

@section('content')
    <div class="container-fluid">
        <h2>Halaman Edit Point atau Poligon</h2>
        <div id="map" class="col-md-12"></div>
        <br>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="checkbox1" value="false">
            <label class="form-check-label" for="checkbox1">Aktifkan Pengeditan</label>
        </div>

        <input type="hidden" id="result">
        <button id="convert" class="btn btn-dark col-md-12">Edit GeoJSON</button>
        <a href="{{ route('maps.create') }}">Kembali Ke Halaman Create</a>
    </div>
@endsection


@push('addon-script')
    <script>
        var map = L.map('map').setView([-0.06304903208178843, 109.35290734591857], 17);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);


        var drawnItems = L.geoJson(<?php echo $map->geojson; ?>).addTo(map);

        drawnItems.eachLayer(function(layer) {
            layer.bindPopup(layer.feature.properties.title);
        });

        map.addLayer(drawnItems);
        var drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            }
        });
        map.addControl(drawControl);

        map.on('draw:created', function(event) {
            var layer = event.layer,
                feature = layer.feature = layer.feature || {};
            feature.type = feature.type || "Feature";
            var props = feature.properties = feature.properties || {};
            drawnItems.addLayer(layer);
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        document.getElementById("convert").addEventListener("click", function() {
            var hasil = $('#result').html(JSON.stringify(drawnItems.toGeoJSON()));
            var data_geo = document.getElementById('result').innerHTML;
            if (data_geo == '{"type":"FeatureCollection","features":[]}') {
                alert('data kosong');
            } else {
                ajax_simpan();
            }
        });

        function ajax_simpan() {
            let status = $("#checkbox1").val()
            var hasil = (JSON.stringify(drawnItems.toGeoJSON()));

            $.ajax({
                url: "{{ route('maps.update', $map->id) }}",
                type: 'POST',
                data: {
                    '_method': 'PUT',
                    'status': status,
                    'result': hasil,
                    'id': {{ $map->id }}
                },
                success: function(data) {
                    // $('#result').html(data);
                    window.location = '/maps/create'
                }
            });
        }

        // true false wilayah atau parkir
        $("#checkbox1").on('change', function() {
            if ($(this).is(':checked')) {
                $(this).attr('value', 'true');
            } else {
                $(this).attr('value', 'false');
            }
        });
    </script>
@endpush
