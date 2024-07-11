@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Legislative District Details</h1>
        <div class="form-group">
            <strong>Name:</strong>
            {{ $legislativeDistrict->name }}
            <strong>Province:</strong>
            {{ $legislativeDistrict->provinces->name }}
        </div>
        <a href="{{ route('legislative_district.index') }}" class="btn btn-primary mt-2">Back to Legislative Districts</a>
    </div>
@endsection
