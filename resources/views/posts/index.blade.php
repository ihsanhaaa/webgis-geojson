@extends('layouts.test')

@section('content')
    <div class="container-fluid">
        <h2>Halaman Post</h2>

        <div id="map" class="col-md-12"></div>

    </div>
@endsection


@push('addon-script')
    <script>
        var mrkCurrentLocation;
        var ctrlEasyButton;

        var map = L.map('map').setView([-0.06304903208178843, 109.35290734591857], 17);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach ($posts as $post)
            var drawnItems = L.geoJson(<?php echo $post->map->geojson; ?>, {
                fillColor: "red"
            }).addTo(map);

            @if ($post->map->status == 'true')
                drawnItems.eachLayer(function(layer) {
                    layer.bindPopup("<strong>Nama: </strong>" + layer.feature.properties.title + "<br>" +
                        "Id: {{ $post->map->id }}" + "<br>" + "status: {{ $post->map->status }}" + "<br>" +
                        "Kategori: {{ $post->map->category->name ?? 'None' }}" + "<br>" + "<br>" +
                        "Luas: {{ $post->luas ?? 'None' }}" + "<br>" +
                        "Kapasitas: {{ $post->kapasitas ?? 'None' }}" + "<br>" +
                        "<a class='label label-warning ' href='{{ route('posts.detail', $post->id) }} '>Tambah Atribut</a>"
                    )
                });
            @else
                drawnItems.eachLayer(function(layer) {
                    layer.bindPopup("<strong>Nama: </strong>" + layer.feature.properties.title + "<br>" +
                        "Id: {{ $post->map->id }}" + "<br>" + "status: {{ $post->map->status }}" + "<br>" +
                        "Kategori: {{ $post->map->category->name ?? 'None' }}"
                    )
                });
            @endif
        @endforeach





        // plugin
        ctlPan = L.control.pan({
            position: 'topright'
        }).addTo(map);

        ctlZoomslider = L.control.zoomslider({
            position: 'topright'
        }).addTo(map);

        ctrlEasyButton = L.easyButton('fa-map-marker', function() {
            map.locate();
        }).addTo(map);


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("body").on("click", "#createNewCompany", function(e) {

            e.preventDefault;
            $('#userCrudModal').html("Create company");
            $('#submit').val("Create company");
            $('#modal-id').modal('show');
            $('#company_id').val('');
            $('#companydata').trigger("reset");

        });

        //Save data into database
        $('body').on('click', '#submit', function(event) {
            event.preventDefault()
            var id = $("#company_id").val();
            var name = $("#name").val();
            var address = $("#address").val();

            $.ajax({
                url: store,
                type: "POST",
                data: {
                    id: id,
                    name: name,
                    address: address
                },
                dataType: 'json',
                success: function(data) {

                    $('#companydata').trigger("reset");
                    $('#modal-id').modal('hide');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    get_company_data()
                },
                error: function(data) {
                    console.log('Error......');
                }
            });
        });

        // cek lokasi user
        map.on('keypress', function(e) {
            if (e.originalEvent.key = 'l') {
                map.locate();
            }
        });

        map.on('locationfound', function(e) {
            if (mrkCurrentLocation) {
                mrkCurrentLocation.remove();
            }
            mrkCurrentLocation = L.circleMarker(e.latlng).addTo(map);
            map.setView(e.latlng, 18);
        });

        map.on('locationerror', function(e) {
            alert("lokasi tidak ditemukan");
        });
    </script>
@endpush
