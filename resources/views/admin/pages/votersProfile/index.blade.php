@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Voters Profiles</h1>
            <a href="{{ route('voters_profile.create') }}" class="button-index">
                <i class="fa-solid fa-circle-plus fa-xl"></i>
                <span class="fw-semibold ms-2">Add</span>
            </a>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @elseif ($message = Session::get('error'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table mt-2 table-light table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Alliance Status</th>
                    <th>Full Name</th>
                    <th>Barangay</th>
                    <th>Precinct</th>
                    <th>Leader</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
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
                    <td>
                        @if ($voters_profile->precincts && $voters_profile->precincts->number)
                            {{ $voters_profile->precincts->number }}
                        @else
                            None
                        @endif
                    </td>
                    <td>{{ $voters_profile->leader }}</td>
                    <td>
                        <a href="{{ route('voters_profile.show', $voters_profile->id) }}" class="icon-link" title="Show">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('voters_profile.edit', $voters_profile->id) }}" class="icon-link" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('voters_profile.destroy', $voters_profile->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-link" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
