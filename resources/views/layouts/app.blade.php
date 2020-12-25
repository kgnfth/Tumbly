<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" data-stylesheet="light">
    <style type="text/css">
        .grid-item {
    width: 18%;
}
    </style>
</head>
<body>
    <main id="content">
        @if(session()->has('oauth_token'))
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('blog', $tumblr->getUserInfo()->user->name) }}" class="btn btn-dark">My Blog</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                            <li><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        @else

        @yield('content')

        @endif


    </main>

    <!-- Scripts -->
    <div id="scripts">
    <script type="text/javascript" src="{{ mix('js/manifest.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/vendor.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    @yield('footer')
    </div>
</body>
</html>
