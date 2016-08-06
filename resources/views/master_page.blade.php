<!DOCTYPE html>
<html>
<head>
    @yield('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"/>
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

<script defer src="{{ asset('js/all.js') }}" type="text/javascript"></script>
@yield('scripts')

</body>


</html>


