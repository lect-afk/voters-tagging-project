@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Show Province</h1>
        <div class="form-group">
            <strong>Name:</strong>
            {{ $province->name }}
        </div>
        <a href="{{ route('province.index') }}" class="btn btn-primary mt-2">Back</a>
    </div>
@endsection
