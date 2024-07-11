@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Show Voter Profile</h1>
        <div class="form-group">
            <strong>Firstname::</strong>
            {{ $votersProfile->firstname }}
        </div>
        <div class="form-group">
            <strong>Middlename:</strong>
            {{ $votersProfile->middlename }}
        </div>
        <div class="form-group">
            <strong>Lastname:</strong>
            {{ $votersProfile->lastname }}
        </div>
        <div class="form-group">
            <strong>Sitio:</strong>
            {{ $votersProfile->sitios->name }}
        </div>
        <div class="form-group">
            <strong>Purok:</strong>
            {{ $votersProfile->puroks->name }}
        </div>
        <div class="form-group">
            <strong>Barangay:</strong>
            {{ $votersProfile->barangays->name }}
        </div>
        <div class="form-group">
            <strong>Precinct:</strong>
            {{ $votersProfile->precincts->number }}
        </div>
        <div class="form-group">
            <strong>Leader:</strong>
            {{ $votersProfile->leader }}
        </div>
        <a href="{{ route('voters_profile.index') }}" class="btn btn-primary mt-2">Back</a>
    </div>
@endsection
