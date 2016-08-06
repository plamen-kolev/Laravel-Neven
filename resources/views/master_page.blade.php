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

<script src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
<script defer src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script defer src="{{ asset('js/script.js') }}" type="text/javascript"></script>
@yield('scripts')

</body>


</html>


