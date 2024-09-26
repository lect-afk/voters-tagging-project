<!DOCTYPE html>
<html>
<head>
    <title>Voters Profiles PDF</title>
    <style>
        /* Add your PDF-specific styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .status-color {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <span style="display: block;">Province: <b>{{$voters_profile->barangays->cities->provinces->name}}</b></span>
        <span style="display: block;">City/Municipality: <b>{{$voters_profile->barangays->cities->name}}</b></span>
        <span style="display: block;">Barangay: <b>{{$voters_profile->barangays->name}}</b></span>
        <h4>LIST OF VOTERS (PRECINCT LEVEL)</h4>
    </div>       
    @yield('content')
</body>
</html>
