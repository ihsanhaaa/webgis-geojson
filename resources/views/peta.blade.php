@extends('layouts.test')

@section('content')
    <div class="container-fluid">
        <div id="map" class="col-md-12"></div>
        <br>
        <div id="result"></div>
        <button id="convert" class="btn btn-dark col-md-12">Simpan GeoJSON</button>
        <a href="maps">Tambah Point atau Poligon</a>
    </div>
@endsection


@push('addon-script')
    <script>
        var map = L.map('map').setView([-0.06304903208178843, 109.35290734591857], 17);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach ($post as $key)
            var drawnItems = L.geoJson({{ $key->GeoJson }}).addTo(map);
        @endforeach
    </script>
@endpush
