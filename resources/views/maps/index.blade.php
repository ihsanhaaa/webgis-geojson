@extends('layouts.test')

@section('content')
    <div class="container-fluid">
        <h2>Halaman Index</h2>
        <a href="{{ route('maps.create') }}">Tambah Peta</a>
        <div id="map" class="col-md-12"></div>
        <br>

    </div>
@endsection


@push('addon-script')
    <script>
        var map = L.map('map').setView([-0.06304903208178843, 109.35290734591857], 17);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var hash = new L.Hash(map);

        @foreach ($map as $key)
            var drawnItems = L.geoJson(<?php echo $key->geojson; ?>, {
                fillColor: "red"
            }).addTo(map);

            @if ($key->status == 'true')
                drawnItems.eachLayer(function(layer) {
                    layer.bindPopup("<strong>Nama: </strong>" + layer.feature.properties.title + "<br>" +
                        "Id: {{ $key->id }}" + "<br>" + "status: {{ $key->status }}" + "<br>" +
                        "Kategori: {{ $key->category->name }}" + "<br>" +
                        "<a class='label label-warning ' href='{{ route('maps.edit', $key->id) }} '>edit</a>" +
                        "<br>" +
                        "<a href='{{ route('maps.destroy', $key->id) }}' id='deleteMap' data-id='{{ $key->id }}'> Delete </a>" +
                        "<br>" +
                        "<a class='label label-warning ' href='{{ route('maps.detail', $key->id) }} '>Tambah Atribut</a>"
                    )
                });
            @else
                drawnItems.eachLayer(function(layer) {
                    layer.bindPopup("<strong>Nama: </strong>" + layer.feature.properties.title + "<br>" +
                        "Id: {{ $key->id }}" + "<br>" + "status: {{ $key->status }}" + "<br>" +
                        "Kategori: {{ $key->category->name }}"
                    )
                });
            @endif
        @endforeach
    </script>
@endpush
