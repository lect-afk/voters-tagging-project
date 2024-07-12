@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Voters Profiles</h1>
        <a href="{{ route('voters_profile.create') }}" class="btn btn-primary">Add Voters Profiles</a>
        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table mt-2">
            <tr>
                <th>Alliance Status</th>
                <th>Full Name</th>
                <th>Barangay</th>
                <th>Precinct</th>
                <th>Leader</th>
                <th>Actions</th>
            </tr>
            @foreach ($voters_profile as $voters_profile)
                @php
                    $backgroundColor = '#6c757d'; 
                    switch ($voters_profile->alliances_status) {
                        case 'Green':
                            $backgroundColor = '#70e000'; 
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
                    <td><div class="rounded-circle" style="width: 30px; height: 30px; background-color: {{ $backgroundColor }};"></div></td>
                    <td>{{ $voters_profile->firstname }} {{ $voters_profile->middlename }} {{ $voters_profile->lastname }}</td>
                    <td>{{ $voters_profile->barangays->name }}</td>
                    <td>{{ $voters_profile->precincts->number }}</td>
                    <td>{{ $voters_profile->leader }}</td>
                    <td>
                        <a href="{{ route('voters_profile.show', $voters_profile->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('voters_profile.edit', $voters_profile->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('voters_profile.destroy', $voters_profile->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
