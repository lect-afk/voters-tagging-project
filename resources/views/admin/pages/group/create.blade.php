@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Create Group</h1>
        <form action="{{ route('group.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
@endsection
