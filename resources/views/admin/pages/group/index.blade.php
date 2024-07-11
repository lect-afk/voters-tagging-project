@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Group</h1>
        <a href="{{ route('group.create') }}" class="btn btn-primary">Add Group</a>
        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table mt-2">
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            @foreach ($group as $group)
                <tr>
                    <td>{{ $group->name }}</td>
                    <td>
                        <a href="{{ route('group.show', $group->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('group.edit', $group->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('group.destroy', $group->id) }}" method="POST" style="display:inline;">
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
