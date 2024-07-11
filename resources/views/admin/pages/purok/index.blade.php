@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Purok</h1>
        <a href="{{ route('purok.create') }}" class="btn btn-primary">Add Purok</a>
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
                <th>Actions</th>
            </tr>
            @foreach ($purok as $purok)
                <tr>
                    <td>{{ $purok->name }}</td>
                    <td>{{ $purok->barangays->name }}</td>
                    <td>
                        <a href="{{ route('purok.show', $purok->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('purok.edit', $purok->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('purok.destroy', $purok->id) }}" method="POST" style="display:inline;">
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
