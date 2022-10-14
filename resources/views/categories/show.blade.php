@extends('layouts.admin')

@section('title')
    Kerjasa | Detail Kategori
@endsection

@section('content')
    <section class="section-side-image clearfix">
        <div class="img-holder col-md-12 col-sm-12 col-xs-12">
            <div class="background-imgholder" style="background:url(https://source.unsplash.com/1500x1000?computer);"><img
                    class="nodisplay-image" /> </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 clearfix nopadding">
                    <div class="header-inner less-height">
                        <div class="overlay">
                            <div class="text text-center">
                                <h3 class="uppercase text-white less-mar-1 title">Detail Kategori:
                                    {{ $category->name }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class=" clearfix"></div>

    <section class="sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6 margin-bottom"> <img src="{{ asset('storage/' . $category->image) }}" alt=""
                        class="img-responsive" />
                </div>
                <!--end item-->

                <div class="col-md-6 margin-bottom">
                    <h3 class="uppercase">{{ $category->name }}</h3>
                    <br />
                    <p>
                        <strong>Slug: </strong>{{ $category->slug }}
                    </p>
                    <p>
                        <strong>Dibuat Pada: </strong>{{ $category->created_at }}
                    </p>
                    <p>
                        <strong>Diubah Pada: </strong>{{ $category->updated_at }}
                    </p>

                    <div class="clearfix"></div>
                    <br /><br />
                    <a class="btn btn-info" href="{{ route('admin.categories.index') }}"><i
                            class="fas fa-angle-left"></i>&nbsp;Kembali</a>

                    <a class="btn btn-warning" href="{{ route('admin.categories.edit', $category->id) }}"><i
                            class="fas fa-edit"></i>&nbsp;edit</a>
                </div>

            </div>
        </div>
    </section>
    <div class="clearfix"></div>
@endsection
