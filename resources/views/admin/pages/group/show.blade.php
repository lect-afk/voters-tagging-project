@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Show Group</h1>
        <div class="form-group">
            <strong>Name:</strong>
            {{ $group->name }}
        </div>
        <a href="{{ route('group.index') }}" class="btn btn-primary mt-2">Back</a>
    </div>
@endsection
