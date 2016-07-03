<!DOCTYPE html>
<html>
<head>
    @yield('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />

    <title>{{$page_title or ''}} - Neven</title>
</head>
<body>
        @yield('landing')
        @include('menu')
        @yield('content')
        @yield('password_reset')
        @yield('login')
        @yield('register')
        @include('footer')

<script src="{{ asset('js/jquery-2.2.0.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/script.js') }}" type="text/javascript"></script>
@yield('scripts')

</body>


</html>


