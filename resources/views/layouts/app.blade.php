<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/jquery.treegrid.css" rel="stylesheet">
    <link href="/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css"/>

    <!-- Scripts -->
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if(!Auth::guest())
                            <li><a href="{{ url('/components') }}">@lang('navigation.components')</a></li>
                            <li><a href="{{ url('/storage') }}">@lang('navigation.storage')</a></li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <footer>
            <div class="container">
                <p class="text-muted">
                    Copyright &copy; Jonas Bernemann 2017.
                    <a href="https://github.com/devchucknorris/lagerverwaltung">GitHub</a>
                </p>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.treegrid.min.js"></script>
    <script src="/js/jquery.treegrid.bootstrap3.js"></script>
    <script src="/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>
</body>
</html>
