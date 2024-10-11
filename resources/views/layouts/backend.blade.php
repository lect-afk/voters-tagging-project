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
        <nav class="navbar navbar-expand-md">
            <div class="topbar d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <img class="me-3" src="{{ asset('/image/DMlogo02.png') }}" alt="Logo" class="logo-image" style="height: 30px; width: auto;">
                    <a class="navbar-brand" href="{{ route('dashboard') }}">
                        <span class="button">VotersTagging</span>
                    </a>
                </div>

                <div class="d-flex align-items-center">
                    <ul class="navbar-nav ms-auto">
                        <div class="dropdown dropstart">
                            <a class="icon-hover" role="button" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="LOCATION"><i class="fa-solid fa-map fa-lg"></i></a>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="{{ route('province.index') }}">Province</a></li>
                              <li><a class="dropdown-item" href="{{ route('legislative_district.index') }}">District</a></li>
                              <li><a class="dropdown-item" href="{{ route('city.index') }}">City</a></li>
                              <li><a class="dropdown-item" href="{{ route('barangay.index') }}">Barangay</a></li>
                              <li><a class="dropdown-item" href="{{ route('purok.index') }}">Purok</a></li>
                              <li><a class="dropdown-item" href="{{ route('sitio.index') }}">Sitio</a></li>
                            </ul>
                        </div>

                        
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="d-flex">
            <div class="sidebar">
                <a class="sidebar_a" href="{{ route('precinct.index') }}" title="Precinct"><i class="fa-solid fa-map-pin"></i></a>
                <a class="sidebar_a" href="{{ route('group.index') }}" title="Group"><i class="fa-solid fa-people-group"></i></a>
                <a class="sidebar_a" href="{{ route('voters_profile.index') }}" title="Voters Profile"><i class="fa-solid fa-id-card"></i></a>
                <div class="dropdown dropend d-flex flex-column sidebar_dropdown">
                    <a class="icon-hover" role="button" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="TAGGING"><i class="fa-solid fa-users-gear"></i></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('voter_profile.namelist') }}">Manage Leaders</a></li>
                        <li><a class="dropdown-item" href="{{ route('voters.barangaysummary') }}">Barangay Summary</a></li>
                        <li><a class="dropdown-item" href="{{ route('voters.precinctsummary') }}">Precinct Summary</a></li>
                        <li><a class="dropdown-item" href="{{ route('voters.alliancetagging') }}">Alliance Tagging</a></li>
                        <li><a class="dropdown-item" href="{{ route('voters.alliancetaggingsummary') }}">Alliance Tagging Summary</a></li>
                    </ul>
                </div>

                <div class="dropdown dropend d-flex flex-column sidebar_dropdown">
                    <a class="icon-hover" role="button" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="ELECTION"><i class="fa-solid fa-user-tie"></i></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('candidates.index') }}">Manage Candidates</a></li>
                        <li><a class="dropdown-item" href="{{ route('votes.index') }}">Manage Votes</a></li>
                        <li><a class="dropdown-item" href="{{ route('voters.votecomparison') }}">Vote Comparison</a></li>
                    </ul>
                </div>

                <div class="d-flex flex-column mt-4 sidebar_dropdown">
                    <a class="" href="" data-bs-toggle="modal" data-bs-target="#logoutModal" title="Logout">
                        <i class="fa-solid fa-right-from-bracket fa-lg"></i>
                    </a>
                </div>
            </div>
        
            <div class="main-content">
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
        
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    
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
</body>
</html>
