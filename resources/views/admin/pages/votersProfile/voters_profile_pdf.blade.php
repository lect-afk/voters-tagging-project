@extends('layouts.pdf')

@section('content')
    <div class="container my-5">
        <h1>Voters Profiles</h1>
        <table class="table mt-2 table-light table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Alliance Status</th>
                    <th>Full Name</th>
                    <th>Barangay</th>
                    <th>Precinct</th>
                    <th>Leader</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($voters_profiles as $voters_profile)
                    @php
                        $backgroundColor = '#6c757d'; 
                        switch ($voters_profile->alliances_status) {
                            case 'Green':
                                $backgroundColor = '#0466c8'; 
                                break;
                            case 'Yellow':
                                $backgroundColor = '#ffd60a'; 
                                break;
                            case 'Orange':
                                $backgroundColor = '#fb8500'; 
                                break;
                            case 'Red':
                                $backgroundColor = '#d00000'; 
                                break;
                        }
                    @endphp
                    <tr>
                        <td><div class="status-color" style="background-color: {{ $backgroundColor }};"></div></td>
                        <td>{{ $voters_profile->lastname }} {{ $voters_profile->firstname }} {{ $voters_profile->middlename }}</td>
                        <td>{{ $voters_profile->barangays->name }}</td>
                        <td>{{ $voters_profile->precincts->number ?? 'None' }}</td>
                        <td>{{ $voters_profile->leader != 'None' ? $voters_profile->leader : 'None' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
