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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backendview.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/083ba5d621.js" crossorigin="anonymous"></script>

</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route("dashboard") }}">
                    <span class="button">VOTERS TAGGING</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        {{-- <li class="nav-item">
                            <a class="fw-semibold" href="{{ route('voter_profile.namelist') }}">Voters</a>
                        </li>   --}}
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Admin settings -->

                        <div class="dropdown me-2">
                            <button class="button-30 dropdown-button" role="button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-map-location-dot fa-2xs"></i>
                                <span class="fw-semibold ms-2">LOCATION</span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="{{ route('province.index') }}">Province</a></li>
                              <li><a class="dropdown-item" href="{{ route('legislative_district.index') }}">District</a></li>
                              <li><a class="dropdown-item" href="{{ route('city.index') }}">City</a></li>
                              <li><a class="dropdown-item" href="{{ route('barangay.index') }}">Barangay</a></li>
                              <li><a class="dropdown-item" href="{{ route('purok.index') }}">Purok</a></li>
                              <li><a class="dropdown-item" href="{{ route('sitio.index') }}">Sitio</a></li>
                            </ul>
                        </div>

                        <div class="dropdown me-2">
                            <button class="button-30 dropdown-button" role="button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-plus-minus fa-2xs"></i>
                                <span class="fw-semibold ms-2">CREATE</span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="{{ route('precinct.index') }}">Precinct</a></li>
                              <li><a class="dropdown-item" href="{{ route('group.index') }}">Group</a></li>
                              <li><a class="dropdown-item" href="{{ route('voters_profile.index') }}">Voters Profile</a></li>
                            </ul>
                        </div>
                        
                        <div class="dropdown me-2">
                            <button class="button-30 dropdown-button" role="button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-users-gear fa-2xs"></i>
                                <span class="fw-semibold ms-2">TAGGING</span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="{{ route('voter_profile.namelist') }}">Manage Leaders</a></li>
                              <li><a class="dropdown-item" href="{{ route('voters.barangaysummary') }}">Barangay Summary</a></li>
                              <li><a class="dropdown-item" href="{{ route('voters.precinctsummary') }}">Precinct Summary</a></li>
                              <li><a class="dropdown-item" href="{{ route('voters.alliancetagging') }}">Alliance Tagging</a></li>
                            </ul>
                        </div>

                        <div class="dropdown me-2">
                            <button class="button-30 dropdown-button" role="button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user-tie fa-2xs"></i>
                                <span class="fw-semibold ms-2">ELECTION</span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="{{ route('candidates.index') }}">Manage Candidates</a></li>
                              <li><a class="dropdown-item" href="{{ route('votes.index') }}">Manage Votes</a></li>
                              <li><a class="dropdown-item" href="{{ route('voters.votecomparison') }}">Vote Comparison</a></li>
                            </ul>
                        </div>
                        
                        {{-- <div class="ms-2">
                            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                Offcanvas
                            </button>
                        </div> --}}
                        <div class="ms-4 d-flex align-items-center">
                            <a class="" href="" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="fa-solid fa-right-from-bracket fa-xl"></i>
                                  <span class="fw-semibold ms-2">Logout</span>
                            </a>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>

        <nav class="navbar navbar-expand-md shadow-sm fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route("dashboard") }}">
                    <span class="button">VOTERS TAGGING</span>
                </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="offcanvas menu_offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <div class="dropdown me-2">
                        <button class="button-30 dropdown-button" role="button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-map-location-dot fa-2xs"></i>
                            <span class="fw-semibold ms-2">LOCATION</span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="{{ route('province.index') }}">Province</a></li>
                          <li><a class="dropdown-item" href="{{ route('legislative_district.index') }}">District</a></li>
                          <li><a class="dropdown-item" href="{{ route('city.index') }}">City</a></li>
                          <li><a class="dropdown-item" href="{{ route('barangay.index') }}">Barangay</a></li>
                          <li><a class="dropdown-item" href="{{ route('purok.index') }}">Purok</a></li>
                          <li><a class="dropdown-item" href="{{ route('sitio.index') }}">Sitio</a></li>
                        </ul>
                    </div>

                    <div class="dropdown me-2">
                        <button class="button-30 dropdown-button" role="button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-plus-minus fa-2xs"></i>
                            <span class="fw-semibold ms-2">CREATE</span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="{{ route('precinct.index') }}">Precinct</a></li>
                          <li><a class="dropdown-item" href="{{ route('group.index') }}">Group</a></li>
                          <li><a class="dropdown-item" href="{{ route('voters_profile.index') }}">Voters Profile</a></li>
                        </ul>
                    </div>
                    
                    <div class="dropdown me-2">
                        <button class="button-30 dropdown-button" role="button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-users-gear fa-2xs"></i>
                            <span class="fw-semibold ms-2">TAGGING</span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="{{ route('voter_profile.namelist') }}">Manage Leaders</a></li>
                          <li><a class="dropdown-item" href="{{ route('voters.barangaysummary') }}">Barangay Summary</a></li>
                          <li><a class="dropdown-item" href="{{ route('voters.precinctsummary') }}">Precinct Summary</a></li>
                          <li><a class="dropdown-item" href="{{ route('voters.alliancetagging') }}">Alliance Tagging</a></li>
                        </ul>
                    </div>

                    <div class="dropdown me-5">
                        <button class="button-30 dropdown-button" role="button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-tie fa-2xs"></i>
                            <span class="fw-semibold ms-2">ELECTION</span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="{{ route('candidates.index') }}">Manage Candidates</a></li>
                          <li><a class="dropdown-item" href="{{ route('votes.index') }}">Manage Votes</a></li>
                          <li><a class="dropdown-item" href="{{ route('voters.votecomparison') }}">Vote Comparison</a></li>
                        </ul>
                    </div>
                    
                    {{-- <div class="ms-2">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                            Offcanvas
                        </button>
                    </div> --}}
                    <div class="logout_btn d-flex align-items-center">
                        <a class="" href="" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fa-solid fa-right-from-bracket fa-xl"></i>
                              <span class="fw-semibold ms-2">Logout</span>
                        </a>
                    </div>
                  </ul>
                </div>
              </div>
            </div>
          </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
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
