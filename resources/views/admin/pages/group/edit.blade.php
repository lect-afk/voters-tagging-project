@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Edit Group</h1>
        <form action="{{ route('group.update', $group->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $group->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
@endsection
