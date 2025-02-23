@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>City Details</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Name:</strong>
                    <p class="card-text">{{ $city->name }}</p>
                    <strong>District:</strong>
                    <p class="card-text">{{ $city->districts->name }}</p>
                    <strong>Province:</strong>
                    <p class="card-text">{{ $city->provinces->name }}</p>
                </div>
                <div class="mt-2">
                    <a class="button-index" href="{{ route('city.index') }}">
                        <i class="fa-solid fa-arrow-turn-down fa-rotate-90 fa-md"></i>
                          <span class="fw-semibold ms-2">Return to City List</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
