@extends('layouts.test')

@section('content')
    <div class="container-fluid">
        <h2>Halaman Tambah Kategori</h2>
        <form action="{{ route('categories.store') }}" class="needs-validation" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <label class="lable-text" for="name"> Nama Kategori</label>
                    <input class="input-1" type="text" placeholder="Nama Kategori" name="name" id="name" required
                        autofocus value="{{ old('name') }}">
                </div>
            </div>

            <div class="row">
                <br />
                <div class="col-md-12 text-center">
                    <button class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;Tambah Data</button>
                </div>

            </div>

        </form>
    </div>
@endsection
