<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Agrocare</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <!-- <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> -->
    <!-- include the script -->
    <script src="{{ asset('alertifyjs/alertify.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">




    <!-- include the style -->
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/alertify.min.css') }}" />
    <!-- include a theme -->
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/themes/default.min.css') }}" />
</head>

<body>
    <div id="app" class="bg-secondary">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/feede') }}">
                    <img src="{{ asset('img/logo-agro-s.png') }}" class="w-50" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto"></ul>
                    <form class="form-inline my-2 my-md-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" />
                        <a class="nav-link fa fa-search fa-lg" href="#"></a>
                    </form>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __("Login") }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __("Register") }}</a>
                        </li>
                        @endif @else

                        <li class="nav-item text-center mx-2 mx-lg-1 dropdown">
                            <a id="notifDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <div>
                                    <i class="fa fa-bell fa-lg mb-1"></i>
                                    <span class="badge rounded-pill badge-notification badge-danger">20</span>
                                </div>
                                {{ __("Notifikasi") }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notifDropdown">
                                <a class="dropdown-item">
                                    {{ __("Notifikasi 1") }}
                                </a>
                            </div>
                        </li>
                        <li class="nav-item text-center mx-2 mx-lg-1 dropdown">
                            <a id="mesDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <div>
                                    <i class="fa fa-envelope fa-lg mb-1">
                                    </i>
                                    <span class="badge rounded-pill badge-notification badge-danger">9</span>
                                </div>
                                {{ __("Pesan") }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="mesDropdown">
                                <a class="dropdown-item">
                                    {{ __("Pesan 1") }}
                                </a>
                            </div>
                        </li>
                        <li class="nav-item text-center dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <div>
                                    <img class="rounded-circle" style="width: 100%;
                                    height: 22px;
                                    max-width: 22px;" src="{{
                                                asset('storage/img/'.Auth::user()->photo_profile)
                                            }}" alt="profile_default" />
                                </div>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a href="{{ route('expert.edite') }}" class="dropdown-item">
                                    {{ __("Edit Profile") }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __("Logout") }}
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
        <div class="container my-3">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card bg-light mb-3">
                        <div class="card-body mb-2 text-center">
                            <div>
                                <a href="{{ route('expert.edite') }}" role="button">
                                    <img src="{{
                                            asset('storage/img/'.Auth::user()->photo_profile)
                                        }}" class="rounded-circle" style="width: 100%;
                                        height: 200px;
                                        max-width: 200px;" alt="photo_profile" />
                                </a>
                            </div>
                            <h3 class="card-title">
                                {{Auth::user()->name}}
                            </h3>
                            <h6 class="card-text">
                                &#64;{{Auth::user()->username}}
                            </h6>
                        </div>
                        <div class="list-group list-group-flush text-center">

                            <a href="{{ route('expert.feede') }}"
                                class="list-group-item list-group-item-action  {{ Request::route()->getName() == 'expert.feede' ? 'active' : ''}}">Berita</a>
                            <a href="{{ route('expert.konsultasie') }}"
                                class="list-group-item list-group-item-action {{ Request::route()->getName() == 'expert.konsultasie' ? 'active' : ''}}">Konsultasi</a>

                        </div>
                    </div>
                </div>
                @if(Request::route()->getName()== "expert.reade")
                <main class="col-lg-9">@yield('content')</main>
                @else

                <main class="col-lg-6">@yield('content')</main>
                @endif
                <main class="col-lg-3">@yield('side')</main>
            </div>
        </div>
    </div>
    @yield('scripts')
</body>

</html>