@extends('layouts.test')

@section('content')
    <div class="container-fluid">
        <div id="map" class="col-md-12"></div>
        <br>
        <div id="result"></div>
        <button id="convert" class="btn btn-dark col-md-12">Simpan GeoJSON</button>
        <a href="/">Lihat Hasil</a>
    </div>
@endsection


@push('addon-script')
    <script>
        var map = L.map('map').setView([-0.06304903208178843, 109.35290734591857], 17);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        // FeatureGroup is to store editable layers
        var drawnItems = new L.FeatureGroup();
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
        })



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
            var hasil = (JSON.stringify(drawnItems.toGeoJSON()));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('maps/store') }}",
                type: 'POST',
                data: {
                    'result': hasil
                },
                success: function(data) {
                    $('#result').html(data);
                }
            });
        }
    </script>
@endpush
