@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Precinct</h1>
        <a href="{{ route('precinct.create') }}" class="btn btn-primary">Add Precinct</a>
        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
                <p>{{ $message }}</p>
            </div>
        @elseif ($message = Session::get('error'))
            <div class="alert alert-danger mt-2">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table mt-2">
            <tr>
                <th>Number</th>
                <th>Barangay</th>
                <th>Actions</th>
            </tr>
            @foreach ($precinct as $precinct)
                <tr>
                    <td>{{ $precinct->number }}</td>
                    <td>{{ $precinct->barangays->name }}</td>
                    <td>
                        <a href="{{ route('precinct.show', $precinct->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('precinct.edit', $precinct->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('precinct.destroy', $precinct->id) }}" method="POST" style="display:inline;">
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
