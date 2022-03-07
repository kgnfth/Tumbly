<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }} ">

    @if(session()->has('oauth_token'))
    <title>@yield('title')</title>
    @else
    <title>{{ config('app.name', 'Laravel') }}</title>
    @endif

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="https://kit.fontawesome.com/5d9c060c1d.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="flex flex-col min-h-full font-sans antialiased text-gray-600">
    @if(session()->has('oauth_token'))
        @include('partials.nav')
        
        @yield('content')

    @else

        @yield('content')

    @endif

    <!-- Scripts -->
    <div id="scripts">
        <script type="text/javascript" src="{{ mix('js/manifest.js') }}"></script>
        <script type="text/javascript" src="{{ mix('js/vendor.js') }}"></script>
        <script type="text/javascript" src="{{ mix('js/scripts.js') }}"></script>
        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ mix('js/fancybox.js') }}"></script>
        @yield('footer')
    </div>
</body>
</html>
