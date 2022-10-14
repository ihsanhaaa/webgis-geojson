@extends('layouts.test')

@section('content')
    <div class="container-fluid">
        <h2>Halaman Tambah Post</h2>
        <div id="map" class="col-md-12"></div>
        <br>

        <form action="{{ route('posts.store') }}" class="needs-validation" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="map_id" value="{{ $id }}">
            <div class="input-group mb-3">
                <input type="text" name="luas" id="luas" class="form-control" placeholder="Luas"
                    aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <input type="text" name="kapasitas" id="kapasitas" class="form-control" placeholder="Kapasitas"
                    aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <input type="text" name="tarif" id="tarif" class="form-control" placeholder="Tarif"
                    aria-describedby="basic-addon1">
            </div>
            <div class="form-group">
                <label for="image">Upload Gambar</label>
                <input type="file" name="image" id="image" class="form-control-file" onchange="previewImage()">
                <img class="img-preview img-fluid mb-3 col-sm-5">
            </div>
            <br>
            <div class="col-md-12 text-center">
                <button class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;Tambah Data</button>
            </div>

        </form>
    </div>
@endsection


@push('addon-script')
    <script>
        var map = L.map('map').setView([-0.06304903208178843, 109.35290734591857], 17);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);



        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            const blob = URL.createObjectURL(image.files[0]);
            imgPreview.src = blob;
        }
    </script>
@endpush
