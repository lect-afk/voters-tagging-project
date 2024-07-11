@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Show Precinct</h1>
        <div class="form-group">
            <strong>Number:</strong>
            {{ $precinct->number }}
        </div>
        <div class="form-group">
            <strong>Barangay:</strong>
            {{ $precinct->barangays->name }}
        </div>
        <a href="{{ route('precinct.index') }}" class="btn btn-primary mt-2">Back</a>
    </div>
@endsection

