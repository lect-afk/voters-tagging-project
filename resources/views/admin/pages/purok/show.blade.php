@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Show Purok</h1>
        <div class="form-group">
            <strong>Name:</strong>
            {{ $purok->name }}
        </div>
        <div class="form-group">
            <strong>Barangay:</strong>
            {{ $purok->barangays->name }}
        </div>
        <a href="{{ route('purok.index') }}" class="btn btn-primary mt-2">Back</a>
    </div>
@endsection
