<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <title>
    @hasSection('title')
        @yield('title') &mdash; {{ config('app.name') }}
    @else
        {{ config('app.name') }}
    @endif
    </title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Bootstrap4 files-->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Font awesome 5 -->
    <link href="{{ asset('fonts/fontawesome/css/all.min.css') }}" type="text/css" rel="stylesheet">

    <!-- custom style -->
    <link href="{{ asset('css/ui.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" />
    @stack('stylesheet')

</head>
<body>

    @include('partials.front.header')

    @yield('header')

    @yield('content')

    @include('partials.front.footer')

    <!-- custom javascript -->
    <script src="{{ asset('js/manifest.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/front.js') }}" type="text/javascript"></script>
    <script>
        $(function() {
            $('#logoutBtn').on('click', function (e) {
                e.preventDefault();
                $('#formLogout').submit();
            })
        })
    </script>
    @stack('javascript')

</body>
</html>
