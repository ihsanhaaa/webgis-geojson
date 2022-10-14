@extends('layouts.test')

@section('content')
    <div class="container-fluid">
        <h2>Halaman Coba Tambah Point atau Poligon</h2>

        <div id="map" class="col-md-12"></div>

        <div class="modal fade" id="modal-id">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="userCrudModal"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form id="companydata">

                            <input type="hidden" id="company_id" name="company_id" value="">
                            <input type="text" id="name" name="name" value="">
                            <input type="text" id="address" name="address" value="">
                            </label><br>

                            <input type="submit" value="Submit" id="submit" class="btn btn-sm btn-outline-danger py-0"
                                style="font-size: 0.8em;">

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection


@push('addon-script')
    <script>
        var map = L.map('map').setView([-0.06304903208178843, 109.35290734591857], 17);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach ($post as $key)
            var drawnItems = L.geoJson(<?php echo $key->geojson; ?>).addTo(map);

            drawnItems.eachLayer(function(layer) {
                layer.bindPopup("<strong>Nama: </strong>" + layer.feature.properties.title + "<br>" +
                    "<strong>Id: </strong> {{ $key->id }}" + "<br>" +
                    "<strong>name: </strong>{{ $key->name }}" + "<br>" +
                    "<strong>Luas: </strong> {{ $key->luas }}" + "<br>" +
                    "<strong>Kapasitas: </strong> {{ $key->kapasitas }}" + "<br>" +
                    "<strong>Tarif: </strong> {{ $key->tarif }}" +
                    "<br>" +
                    "<a class='label label-warning ' href='{{ route('coba.edit', $key->id) }} '>Tambah Atribut</a>" +
                    "<br>" + "<br>" +
                    "<a class='label label-warning ' href='javascript:void(0)' id='createNewReport'>Pengaduan Masalah</a>"
                )
            });
        @endforeach

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
    </script>
@endpush
