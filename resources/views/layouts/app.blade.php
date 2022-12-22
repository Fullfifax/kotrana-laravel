<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Notify css -->
    @notifyCss

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="{{ route('todos.index') }}" class="nav-link">Todos</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about') }}" class="nav-link">About</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @auth
                        <!-- Notifications -->
                        <div class="dropdown show mx-3">
                            <a class="dropdown-toggle d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="mt-2" src="{{ asset('icons/notification.png') }}" style="height:25px;width:25px;" alt="notifications">
                                <span class="text-light bg-danger px-1">
                                    @if(count(Auth::User()->unreadNotifications) > 0)
                                        {{ count(Auth::User()->unreadNotifications) }}
                                    @endif
                                </span>
                            </a>
                            <div class="dropdown-menu" style="width:250px;" aria-labelledby="dropdownMenuLink">
                                @if(count(Auth::User()->unreadNotifications) > 0)
                                <div id="notificationsContainer" class="notifications-container">
                                    @foreach (Auth::User()->unreadNotifications as $notification)
                                        <div class="notifications-body">
                                            <h5 class="font-bold px-3">Notification</h5>
                                            <p class="notification-texte mx-auto px-3">
                                                <small>
                                                    <span>
                                                        {{ $notification->data['affected_by'] }}
                                                        has affected todo "{{ $notification->data['todo_name'] }}"
                                                    </span>
                                                </small>
                                            </p>
                                        </div>
                                        {{ Auth::User()->unreadNotifications->markAsRead() }}
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @endauth

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Notify JS -->
    <x:notify-messages />
    @notifyJs
</body>
</html>
