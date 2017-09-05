<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
    <link rel="apple-touch-icon" sizes="180x180" href="/imgs/icons/App_Icon_2_3x.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/imgs/icons/App_Icon_2_3x.png">
	
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
	
	<!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    
    <style>
        body {
	        background-image: url(/imgs/mono.svg);
	        background-size: 250px;
	        background-color: white;
	        background-repeat: inital;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}" style="position: relative">
                        <img src="{{asset('imgs/logo_white.svg')}}" class="img-responsive" width="100"
                             style="display: inline">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (Auth::check())
		                    <li><a href="{{ route('home') }}">{{__("Learning")}}</a></li>
		                    <li><a href="{{ route('show.events') }}">{{__("Find your class")}}</a></li>
		                    <li><a href="{{ route('show.resources') }}">{{__("Resources")}}</a></li>
	                    @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
	                    @if (Auth::guest())
		                    <li><a href="{{ route('login') }}">{{__("Login")}}</a></li>
		                    <li><a href="{{ route('register') }}">{{__("Register")}}</a></li>
	                    @else
		                    <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('show.myevents')}}">{{__("My Class")}}</a></li>
                                    <li><a href="{{route('profile')}}">{{__("My Profile")}}</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{__("Logout")}}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
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
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/front.js') }}"></script>
    @yield('scripts')
</body>
</html>
