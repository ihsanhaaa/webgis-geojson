<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('/leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}">

    {{-- icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- plugins --}}
    <link rel="stylesheet" href="{{ asset('/leaflet/plugins/Pancontrol/L.Control.Pan.css') }}">
    <link rel="stylesheet" href="{{ asset('/leaflet/plugins/MousePosition/L.Control.MousePosition.css') }}">
    <link rel="stylesheet" href="{{ asset('/leaflet/plugins/PolylineMeasure/Leaflet.PolylineMeasure.css') }}">
    <link rel="stylesheet" href="{{ asset('/leaflet/plugins/EasyButton/easy-button.css') }}">
    <link rel="stylesheet" href="{{ asset('/leaflet/plugins/Sidebar/L.Control.Sidebar.css') }}">

    <script src="{{ asset('/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('/leaflet/jquery-3.6.1.js') }}"></script>

    {{-- plugins --}}
    <script src="{{ asset('/leaflet/plugins/Pancontrol/L.Control.Pan.js') }}"></script>
    <script src="{{ asset('/leaflet/plugins/MousePosition/L.Control.MousePosition.js') }}"></script>
    <script src="{{ asset('/leaflet/plugins/PolylineMeasure/Leaflet.PolylineMeasure.js') }}"></script>
    <script src="{{ asset('/leaflet/plugins/EasyButton/easy-button.js') }}"></script>
    <script src="{{ asset('/leaflet/plugins/Sidebar/L.Control.Sidebar.js') }}"></script>
    <script src="{{ asset('/leaflet/plugins/Providers/leaflet-providers.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #map_div {
            height: 100vh;
        }
    </style>

</head>

<body>

    @yield('content')

</body>

</html>
