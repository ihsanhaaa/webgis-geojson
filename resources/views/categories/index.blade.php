@extends('layouts.test')

@section('content')
    <div class="container-fluid">
        <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;Tambah Kategori</a>

        @php $increment = 0 @endphp
        @forelse($categories as $category)
            <tr>
                <td>{{ $increment += 1 }}</td>
                <td>{{ $category->name }}</td>
            </tr>
        @empty
            <h4 class="text-center">Tidak ada data</h4>
        @endforelse


    </div>
@endsection
