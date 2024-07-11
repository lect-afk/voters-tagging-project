@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Sitio</h1>
        <a href="{{ route('sitio.create') }}" class="btn btn-primary">Add Sitio</a>
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
                <th>Barangay</th>
                <th>Purok</th>
                <th>Actions</th>
            </tr>
            @foreach ($sitio as $sitio)
                <tr>
                    <td>{{ $sitio->name }}</td>
                    <td>{{ $sitio->barangays->name}}</td>
                    <td>{{ $sitio->puroks->name }}</td>
                    <td>
                        <a href="{{ route('sitio.show', $sitio->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('sitio.edit', $sitio->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('sitio.destroy', $sitio->id) }}" method="POST" style="display:inline;">
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
