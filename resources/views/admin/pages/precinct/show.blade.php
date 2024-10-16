@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <h5>Precinct Details</h5>
    </div>
    <div class="card-body dashboard_card_body">
        <div class="mb-3">
            <strong>Number:</strong>
            <p class="card-text">{{ $precinct->number }}</p>
            <strong>Barangay:</strong>
            <p class="card-text">{{ $precinct->barangays->name }}</p>
        </div>
        <div class="mt-2">
            <a class="button-index" href="{{ route('precinct.index') }}">
                <i class="fa-solid fa-arrow-turn-down fa-rotate-90 fa-md"></i>
                  <span class="fw-semibold ms-2">Return to Precinct List</span>
            </a>
        </div>
    </div>
</div>
@endsection

