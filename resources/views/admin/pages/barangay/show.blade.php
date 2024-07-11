@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Show Barangay</h1>
        <div class="form-group">
            <strong>Name:</strong>
            {{ $barangay->name }}
        </div>
        <div class="form-group">
            <strong>City:</strong>
            {{ $barangay->cities->name }}
        </div>
        <a href="{{ route('barangay.index') }}" class="btn btn-primary mt-2">Back</a>
    </div>
@endsection
