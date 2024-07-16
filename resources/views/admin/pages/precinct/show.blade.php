@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Precinct Details</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Number:</strong>
                    <p class="card-text">{{ $precinct->number }}</p>
                    <strong>Barangay:</strong>
                    <p class="card-text">{{ $precinct->barangays->name }}</p>
                </div>
                <div class="mt-2">
                    <a class="button-index" href="{{ route('precinct.index') }}">
                        <i class="fa-solid fa-arrow-turn-down fa-rotate-90 fa-xl"></i>
                          <span class="fw-semibold ms-2">Return to Precinct List</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

