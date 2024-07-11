@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Province</h1>
        <a href="{{ route('province.create') }}" class="btn btn-primary">Add Province</a>
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
                <th>Actions</th>
            </tr>
            @foreach ($province as $province)
                <tr>
                    <td>{{ $province->name }}</td>
                    <td>
                        <a href="{{ route('province.show', $province->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('province.edit', $province->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('province.destroy', $province->id) }}" method="POST" style="display:inline;">
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
