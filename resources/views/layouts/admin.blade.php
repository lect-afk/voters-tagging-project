<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet"> <!-- Font Awesome -->
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 60px;
            background-color: #343a40;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 10px;
        }
        .sidebar a {
            color: white;
            padding: 10px 0;
            text-align: center;
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            height: 50px;
            background-color: #343a40;
            display: flex;
            align-items: center;
            color: white;
            padding: 0 15px;
        }
        .main-content {
            flex-grow: 1;
            padding: 15px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#"><i class="fas fa-home"></i></a>
        <a href="#"><i class="fas fa-user"></i></a>
        <a href="#"><i class="fas fa-cog"></i></a>
        <!-- Add more sidebar icons as needed -->
    </div>
    <div class="content">
        <div class="navbar">
            <span class="navbar-brand mb-0 h1">Brand</span>
        </div>
        <div class="main-content">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
