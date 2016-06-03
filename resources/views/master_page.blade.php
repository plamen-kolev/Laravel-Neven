<!DOCTYPE html>
<html>
<head>
    <script src="{{ asset('js/jquery-2.2.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/script.js') }}" type="text/javascript"></script>
    @yield('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="/image/png"/>

    <title>Neven</title>
</head>
<body>
        @include('menu')
        @yield('content')
        @yield('password_reset')
        @yield('login')
        @yield('register')
        @include('footer')
        @yield('scripts')
        <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>

</body>
</html>


