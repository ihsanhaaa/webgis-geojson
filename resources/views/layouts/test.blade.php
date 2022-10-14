<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">

    {{-- js bootsrap --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    {{-- icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- plugins --}}
    <link rel="stylesheet" href="{{ asset('leaflet/plugins/Pancontrol/L.Control.Pan.css') }}">
    <link rel="stylesheet" href="{{ asset('leaflet/plugins/MousePosition/L.Control.MousePosition.css') }}">
    <link rel="stylesheet" href="{{ asset('leaflet/plugins/PolylineMeasure/Leaflet.PolylineMeasure.css') }}">
    <link rel="stylesheet" href="{{ asset('leaflet/plugins/EasyButton/easy-button.css') }}">
    <link rel="stylesheet" href="{{ asset('leaflet/plugins/Sidebar/L.Control.Sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('leaflet/plugins/Zoomslider/L.Control.Zoomslider.css') }}">



    <!--    ***************  Begin  Draw StyleEditor CSS-->
    <link rel="stylesheet" href="{{ asset('leaflet/leaflet-opencage/src/css/L.Control.OpenCageSearch.css') }}">
    <link rel="stylesheet" href="{{ asset('leaflet/leaflet-styleeditor/css/Leaflet.StyleEditor.css') }}">

    <style>
        #map {
            height: 500px;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="{{ route('categories.index') }}">Kategori</a>
                <a class="nav-item nav-link" href="{{ route('maps.index') }}">Peta</a>
                <a class="nav-item nav-link" href="{{ route('posts.index') }}">Post</a>
                <a class="nav-item nav-link" href="{{ route('report.index') }}">Lapor</a>
            </div>
        </div>
    </nav>

    @yield('content')

    <script src="{{ asset('leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('leaflet/jquery-3.6.1.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- plugins --}}
    <script src="{{ asset('leaflet/plugins/Sidebar/L.Control.Sidebar.js') }}"></script>
    <script src="{{ asset('leaflet/plugins/Pancontrol/L.Control.Pan.js') }}"></script>
    <script src="{{ asset('leaflet/plugins/MousePosition/L.Control.MousePosition.js') }}"></script>
    <script src="{{ asset('leaflet/plugins/PolylineMeasure/Leaflet.PolylineMeasure.js') }}"></script>
    <script src="{{ asset('leaflet/plugins/EasyButton/easy-button.js') }}"></script>
    <script src="{{ asset('leaflet/plugins/Providers/leaflet-providers.js') }}"></script>
    <script src="{{ asset('leaflet/plugins/Zoomslider/L.Control.Zoomslider.js') }}"></script>
    <script src="{{ asset('leaflet/plugins/leaflet-hash/leaflet-src.js') }}"></script>

    <!--    ***************  Begin  Draw StyleEditor JS-->
    <script src="{{ asset('leaflet/leaflet-opencage/src/js/L.Control.OpenCageSearch.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-styleeditor/javascript/Leaflet.StyleEditor.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-styleeditor/javascript/Leaflet.StyleForms.js') }}"></script>
    <!--    ***************  Begin  Draw StyleEditor JS-->

    <!--    ***************  Begin Leaflet.Draw-->
    <script src="{{ asset('leaflet/leaflet-draw/Leaflet.draw.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/Leaflet.Draw.Event.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('leaflet/leaflet-draw/leaflet.draw.css') }}" />

    <script src="{{ asset('leaflet/leaflet-draw/Toolbar.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/Tooltip.js') }}"></script>

    <script src="{{ asset('leaflet/leaflet-draw/ext/GeometryUtil.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/ext/LatLngUtil.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/ext/LineUtil.Intersect.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/ext/Polygon.Intersect.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/ext/Polyline.Intersect.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/ext/TouchEvents.js') }}"></script>

    <script src="{{ asset('leaflet/leaflet-draw/draw/DrawToolbar.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/draw/handler/Draw.Feature.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/draw/handler/Draw.SimpleShape.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/draw/handler/Draw.Polyline.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/draw/handler/Draw.Circle.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/draw/handler/Draw.Marker.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/draw/handler/Draw.Polygon.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/draw/handler/Draw.Rectangle.js') }}"></script>


    <script src="{{ asset('leaflet/leaflet-draw/edit/EditToolbar.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/edit/handler/EditToolbar.Edit.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/edit/handler/EditToolbar.Delete.js') }}"></script>

    <script src="{{ asset('leaflet/leaflet-draw/Control.Draw.js') }}"></script>

    <script src="{{ asset('leaflet/leaflet-draw/edit/handler/Edit.Poly.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/edit/handler/Edit.SimpleShape.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/edit/handler/Edit.Circle.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/edit/handler/Edit.Rectangle.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet-draw/edit/handler/Edit.Marker.js') }}"></script>
    <!--    **************  End of Lealet Draw-->

    @stack('addon-script')

</body>

</html>
