<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Unifiedtransform') }}</title>

    <link rel="shortcut icon" href="{{asset('favicon_io/favicon.ico')}}">
    <link rel="shortcut icon" sizes="16x16" href="{{asset('favicon_io/favicon-16x16.png')}}">
    <link rel="shortcut icon" sizes="32x32" href="{{asset('favicon_io/favicon-32x32.png')}}">
    <link rel="apple-touch-icon" href="{{asset('favicon_io/apple-touch-icon.png')}}">
    <link rel="icon" href="{{asset('favicon_io/android-chrome-192x192.png')}}" sizes="192x192">
    <link rel="icon" href="{{asset('favicon_io/android-chrome-512x512.png')}}" sizes="512x512">

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js?v=1.0') }}"></script>
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" rel="stylesheet" type="text/css" />

   
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css1/style.css?v=1.4') }}" rel="stylesheet">
    <link href="{{ asset('css1/style.bundle.css?v=1.6') }}" rel="stylesheet">

    <link href="{{ asset('css1/fix_claro.css?v=1.9') }}" rel="stylesheet">
    <link href="{{ asset('css1/material-dashboard.css?v=1.0') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.23/dist/sweetalert2.css" rel="stylesheet">

    <!-- Common scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment-with-locales.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.23/dist/sweetalert2.all.min.js" type="text/javascript"></script>
    <script src="{{ asset('js/popover/bootstrap-tooltip.js') }}"></script>
    <script src="{{ asset('js/popover/bootstrap-popover.js') }}"></script>
    <script src="{{ asset('js/datedropper-jquery.js') }}"></script>
    
    <link href="{{ asset('css1/select2.min.css')}}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>  
    <script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>

</head>
<body>

    <div id="app">
        <nav class="navbar sticky-top navbar-expand-md navbar-light bg-white border-btm-e6">
            <div class="container">
                <img src="{{url('imgs/logo-2.png')}}" style="width:80px" />
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <h4 style="margin-left: 15px"><b> {{ config('app.name', 'Laravel') }}</b> {{\App\Models\School::where('id', Auth::user()->school_id)->first()->name}} -
                    @auth
                        @php
                            $latest_school_session = \App\Models\SchoolSession::latest()->where('school_id', Auth::user()->school_id)->first();
                            $current_school_session_name = null;
                            if($latest_school_session){
                                $current_school_session_name = $latest_school_session->session_name;
                            }
                        @endphp

                            @if (session()->has('browse_session_name') && session('browse_session_name') !== $current_school_session_name)
                                 @lang('Browsing as Academic Session'): {{session('browse_session_name')}}
                            @elseif(\App\Models\SchoolSession::latest()->count() > 0)
                                {{$current_school_session_name}}
                            @else
                               @lang('Create an Academic Session').
                            @endif
                    </h4>
                    @endauth
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item text-center">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item  w-100 dropdown text-center">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="material-icons">face</span> 
                               <br>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('password.edit')}}">
                                    <i class="bi bi-key me-2"></i> @lang('Change Password')
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="bi bi-door-open me-2"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            @yield('content')
        </main>
    </div>

    <div id="watermark">
        <p>Ciencia y Justicia</p>
    </div>
</body>
</html>
<div id="loadgif" class="loading">
  <div class="lds-circle">
<div>
</div>

