@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Show City</h1>
        <div class="form-group">
            <strong>Name:</strong>
            {{ $city->name }}
        </div>
        <div class="form-group">
            <strong>District:</strong>
            {{ $city->districts->name }}
        </div>
        <div class="form-group">
            <strong>Province:</strong>
            {{ $city->provinces->name }}
        </div>
        <a href="{{ route('city.index') }}" class="btn btn-primary mt-2">Back</a>
    </div>
@endsection
