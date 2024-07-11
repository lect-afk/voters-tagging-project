<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/083ba5d621.js" crossorigin="anonymous"></script>

</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route("dashboard") }}">
                    <span>VOTERS TAGGING</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('voter_profile.namelist') }}">Voters</a>
                        </li>  
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Admin settings -->

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Create
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="{{ route('province.index') }}">Province</a></li>
                              <li><a class="dropdown-item" href="{{ route('legislative_district.index') }}">District</a></li>
                              <li><a class="dropdown-item" href="{{ route('city.index') }}">City</a></li>
                              <li><a class="dropdown-item" href="{{ route('barangay.index') }}">Barangay</a></li>
                              <li><a class="dropdown-item" href="{{ route('purok.index') }}">Purok</a></li>
                              <li><a class="dropdown-item" href="{{ route('sitio.index') }}">Sitio</a></li>
                              <li><a class="dropdown-item" href="{{ route('voters_profile.index') }}">Voters Profile</a></li>
                              <li><a class="dropdown-item" href="{{ route('group.index') }}">Group</a></li>
                              <li><a class="dropdown-item" href="{{ route('precinct.index') }}">Precinct</a></li>
                            </ul>
                        </div>
                        
                        <div class="ms-2">
                            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                Offcanvas
                            </button>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Offcanvas menu -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasExampleLabel">User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body ps-5">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="">Menu 1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Menu 2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Menu 3</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Menu 4</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Menu 5</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Menu 6</a>
                    </li>    
                </ul>
                <div>
                    <a class="" href="" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="fa-solid fa-right-from-bracket fa-xl"></i>
                          <span class="fw-semibold ms-2">Logout</span>
                    </a>
                </div>
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

</body>
<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
</html>
