@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Show Sitio</h1>
        <div class="form-group">
            <strong>Name:</strong>
            {{ $sitio->name }}
        </div>
        <div class="form-group">
            <strong>Barangay:</strong>
            {{ $sitio->barangays->name }}
        </div>
        <div class="form-group">
            <strong>Purok:</strong>
            {{ $sitio->puroks->name }}
        </div>
        <a href="{{ route('sitio.index') }}" class="btn btn-primary mt-2">Back</a>
    </div>
@endsection
