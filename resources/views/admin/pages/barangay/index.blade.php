@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Barangay</h1>
        <a href="{{ route('barangay.create') }}" class="btn btn-primary">Add Barangay</a>
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
                <th>City</th>
                <th>Actions</th>
            </tr>
            @foreach ($barangay as $barangay)
                <tr>
                    <td>{{ $barangay->name }}</td>
                    <td>{{ $barangay->cities->name }}</td>
                    <td>
                        <a href="{{ route('barangay.show', $barangay->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('barangay.edit', $barangay->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('barangay.destroy', $barangay->id) }}" method="POST" style="display:inline;">
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
