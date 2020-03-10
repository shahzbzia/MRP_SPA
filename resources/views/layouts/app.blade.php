<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset(mix('js/app.js')) }}" defer></script>  {{-- asset(mix('public/js/app.js'))  on production (live server)--}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> --}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <!-- Fonts -->

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="icon" type="image/png" href="https://my.artcoresociety.com/app/themes/artcore_mine/assets/img/favicons/favicon-32x32.png?v=1.3" sizes="32x32" />
    <link rel="icon" type="image/png" href="https://my.artcoresociety.com/app/themes/artcore_mine/assets/img/favicons/favicon-16x16.png?v=1.3" sizes="16x16" />

    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">  {{-- asset(mix('public/css/app.css')) on production (live server)--}}
</head>
<body>
    
    @yield('jumbotron')

    @yield('heroImageRooms')

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('landingPage', app()->getLocale()) }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('app.Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @foreach (config('app.available_locales') as $locale)
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(),array_merge(Route::current()->parameters(),['locale' => $locale])) }}"
                                    @if (app()->getLocale() == $locale) style="font-weight: bold; text-decoration: underline" @endif>{{ strtoupper($locale) }}</a>
                            </li>
                        @endforeach
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login', app()->getLocale()) }}">{{ __('auth.Login') }}</a>
                            </li>
{{--                             @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register', app()->getLocale()) }}">{{ __('auth.Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown app" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                    <router-link :to="{ name: 'myBookings'}"> <a class="dropdown-item">My Bookings</a> </router-link>

                                    <router-link :to="{ name: 'editProfile'}"><a class="dropdown-item">{{ __('auth.Edit Profile') }}</a></router-link>
                                    

                                    @if (Auth::check() && Auth::user()->checkRole()==1)   
                                        <form class="mb-0" action="{{ route('deactivateUser', [app()->getLocale(), Auth::user()->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" >{{ __('app.Deactivate Account') }}</button>
                                        </form>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('api') .'?api_token=' . Auth::user()->api_token }}">API</a>

                                    <a class="dropdown-item" href="{{ route('logout', app()->getLocale()) }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('auth.Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>                                    
                                </div>     
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{session()->get('success')}}
                    </div>
                @endif

                @if(session()->has('fail'))
                    <div class="alert alert-danger">
                        {{session()->get('fail')}}
                    </div>
                @endif
            
                 @if (Auth::check() && Auth::user()->checkRole()==2)     
                    
                    <div class="row">
                        
                        <div class="col-md-4">
                                
                                <ul class="list-group">

                                    <li class="list-group-item">
                                        
                                        <a href="{{ route('adminHome') }}">Admin Dashboard</a>

                                    </li>

                                    <li class="list-group-item">
                                        
                                        <a href="{{ route('listAdmins') }}">Admins</a>

                                    </li>

                                    <li class="list-group-item">
                                        
                                        <a href="{{ route('listUsers') }}">Users</a>

                                    </li>
                                    
                                    <li class="list-group-item">
                                        
                                        <a href="{{ route('rooms.index') }}">Rooms</a>

                                    </li> 

                                </ul>


                                <ul class="list-group mt-5">

                                    <li class="list-group-item">
                                        
                                        <a href="{{ route('trashed-users.index') }}">Trashed Users</a>

                                    </li>

                                    <li class="list-group-item">
                                        
                                        <a href="{{ route('trashed-rooms.index') }}">Trashed Rooms</a>

                                    </li>


                                </ul>

                                <ul class="list-group mt-5">

                                    <li class="list-group-item">
                                        
                                        <a href="{{ route('inviteForm') }}">Invite Users</a>

                                    </li>

                                </ul>

                                <ul class="list-group mt-5">

                                    <li class="list-group-item">
                                        
                                        <a href="{{ route('users.export') }}">Export Users</a>

                                    </li>

                                    <li class="list-group-item">
                                        
                                        <a href="{{ route('rooms.export') }}">Export Rooms</a>

                                    </li>


                                </ul>

                                <ul class="list-group mt-5">

                                    <li class="list-group-item">
                                        
                                        <a href="{{ route('import') }}">Import Rooms</a>

                                    </li>

                                </ul>

                        </div>

                        <div class="col-md-8">

                            @yield('content')
                        </div>

                    </div>         

            @else
                @yield('content')

            @endif
        </div>
        </main>
    </div>
        
    </body>
</html>
