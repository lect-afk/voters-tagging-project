@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>City</h1>
        <a href="{{ route('city.create') }}" class="btn btn-primary">Add City</a>
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
                <th>Name</th>
                <th>District</th>
                <th>Province</th>
                <th>Actions</th>
            </tr>
            @foreach ($city as $city)
                <tr>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->districts->name }}</td>
                    <td>{{ $city->provinces->name }}</td>
                    <td>
                        <a href="{{ route('city.show', $city->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('city.edit', $city->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('city.destroy', $city->id) }}" method="POST" style="display:inline;">
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
