@extends('layouts.test')

@section('content')
    <div class="container-fluid">
        <h2>Halaman Tambah Point atau Poligon</h2>

        <br>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Masukkan title">
        </div>
        <br>

        <div class="form-group">
            <label for="category_id">Pilih Kategori</label>
            <select class="form-control" name="category_id" id="category_id">
                <option>Pilih Kategori</option>
                @foreach ($categories as $category)
                    @if (old('$category_id') == $category->id)
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                    @else
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="checkbox1" value="false">
            <label class="form-check-label" for="checkbox1">Aktifkan Pengeditan</label>
        </div>

        <input type="hidden" id="result">
        <button id="convert" class="btn btn-dark col-md-12">Simpan Data</button>
        <br>
        <br>

        <a href="{{ route('maps.index') }}">Kembali Ke Halaman Index</a>

        <div id="map" class="col-md-12"></div>

    </div>
@endsection


@push('addon-script')
    <script>
        var map = L.map('map').setView([-0.06304903208178843, 109.35290734591857], 17);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach ($map as $key)
            var drawnItems = L.geoJson(<?php echo $key->geojson; ?>, {
                fillColor: "red"
            }).addTo(map);

            drawnItems.eachLayer(function(layer) {
                layer.bindPopup("<strong>Nama: </strong>" + layer.feature.properties.title + "<br>" +
                    "Id: {{ $key->id }}" + "<br>" + "status: {{ $key->status }}" + "<br>" +
                    "Kategori: {{ $key->category->name }}" + "<br>" +
                    "<a class='label label-warning ' href='{{ route('maps.edit', $key->id) }} '>edit</a>" +
                    "<br>" +
                    "<a href='{{ route('maps.destroy', $key->id) }}' id='deleteMap' data-id='{{ $key->id }}'> Delete </a>"
                )
            });
        @endforeach

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
            var props = feature.properties = feature.properties || {
                title: $("#title").val()
            };
            drawnItems.addLayer(layer);

            // debug
            // alert(JSON.stringify(event.layer.toGeoJSON()));
        });

        // plugin
        ctlPan = L.control.pan({
            position: 'topright'
        }).addTo(map);

        ctlZoomslider = L.control.zoomslider({
            position: 'topright'
        }).addTo(map);


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
            let category_id = $("#category_id").val()
            let title = $('#title').val();
            let status = $("#checkbox1").val()
            var hasil = (JSON.stringify(drawnItems.toGeoJSON()));

            $.ajax({
                url: "{{ route('maps.store') }}",
                type: 'POST',
                data: {
                    'category_id': category_id,
                    'title': title,
                    'status': status,
                    'result': hasil
                },
                success: function(data) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    window.location = '/maps/create'
                },
                complete: function() {
                    swal.hideLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal.hideLoading();
                    swal.fire("!Opps ", "Something went wrong, try again later", "error");
                }
            });
        }

        $(document).ready(function() {

            $("body").on("click", "#deleteMap", function(e) {

                if (!confirm("Do you really want to do this?")) {
                    return false;
                }

                e.preventDefault();

                var id = $(this).data("id");
                var url = e.target;

                $.ajax({
                    url: url.href, //or you can use url: "company/"+id,
                    type: 'DELETE',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        window.location = '/maps/create'
                        Swal.fire(
                            'Data Dihapus',
                            'Company deleted successfully!',
                            'success'
                        )
                    },
                    complete: function() {
                        swal.hideLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal.hideLoading();
                        swal.fire("!Opps ", "Something went wrong, try again later", "error");
                    }
                });
                return false;
            });

            // true false wilayah atau parkir
            $("#checkbox1").on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).attr('value', 'true');
                } else {
                    $(this).attr('value', 'false');
                }
            });
        });
    </script>
@endpush
