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
                <th>Firstname</th>
                <th>Middlename</th>
                <th>Lastname</th>
                <th>Sitio</th>
                <th>Purok</th>
                <th>Barangay</th>
                <th>Precinct</th>
                <th>Leader</th>
                <th>Actions</th>
            </tr>
            @foreach ($voters_profile as $voters_profile)
                <tr>
                    <td>{{ $voters_profile->firstname }}</td>
                    <td>{{ $voters_profile->middlename }}</td>
                    <td>{{ $voters_profile->lastname }}</td>
                    <td>{{ $voters_profile->sitios->name }}</td>
                    <td>{{ $voters_profile->puroks->name }}</td>
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
