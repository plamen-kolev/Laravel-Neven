<!DOCTYPE html>
<html>
<head>
    <script src="{{ secure_asset('js/jquery-2.2.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ secure_asset('js/script.js') }}" type="text/javascript"></script>
    <script src="{{ secure_asset('js/jquery.unveil.js') }}" type="text/javascript"></script>
    @yield('links')
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('style.css') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="{{ secure_asset('favicon.png') }}" />

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
        <script src="{{ secure_asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>

</body>
</html>


