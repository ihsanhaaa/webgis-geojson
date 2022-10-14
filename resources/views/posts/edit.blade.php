@extends('layouts.test')

@section('content')
    <div class="container-fluid">
        <h2>Halaman Coba Edit Point atau Poligon</h2>
        <div id="map" class="col-md-12"></div>
        <br>
        <form id="formMhs" method="POST">
            @csrf
            <div class="container">
                <div class="input-group mb-3">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                        aria-describedby="basic-addon1" value="{{ old('name', $post->name) }}">
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="luas" id="luas" class="form-control" placeholder="Luas"
                        aria-describedby="basic-addon1" value="{{ old('luas', $post->luas) }}">
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="foto" id="foto" class="form-control" placeholder="Foto"
                        aria-describedby="basic-addon1" value="{{ old('foto', $post->foto) }}">
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="kapasitas" id="kapasitas" class="form-control" placeholder="Kapasitas"
                        aria-describedby="basic-addon1" value="{{ old('kapasitas', $post->kapasitas) }}">
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="tarif" id="tarif" class="form-control" placeholder="Tarif"
                        aria-describedby="basic-addon1" value="{{ old('tarif', $post->tarif) }}">
                </div>
            </div>
        </form>

        <input type="hidden" id="result">
        <button id="convert" class="btn btn-dark col-md-12">Edit GeoJSON</button>
    </div>
@endsection


@push('addon-script')
    <script>
        var map = L.map('map').setView([-0.06304903208178843, 109.35290734591857], 17);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);


        var drawnItems = L.geoJson(<?php echo $post->GeoJson; ?>).addTo(map);

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
            var props = feature.properties = feature.properties || {
                title: $("#title").val(),
                description: $("#description").val()
            };
            drawnItems.addLayer(layer);
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
            var hasil = (JSON.stringify(drawnItems.toGeoJSON()));
            let name = $('#name').val();
            let luas = $('#luas').val();
            let foto = $('#foto').val();
            let kapasitas = $('#kapasitas').val();
            let tarif = $('#tarif').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('coba.update', $post->id) }}",
                type: 'POST',
                data: {
                    '_method': 'PUT',
                    'name': name,
                    'luas': luas,
                    'foto': foto,
                    'kapasitas': kapasitas,
                    'tarif': tarif,
                    'result': hasil,
                    'id': {{ $post->id }}
                },
                success: function(data) {
                    // $('#result').html(data);
                    window.location = '/coba'
                }
            });
        }
    </script>
@endpush
