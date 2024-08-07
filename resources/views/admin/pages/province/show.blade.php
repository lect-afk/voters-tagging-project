@extends('layouts.backend')
<style>
.container {
    max-width: 600px;
    margin: 0 auto;
}

.card {
    border: none;
    border-radius: 0.5rem;
}

.card-body {
    padding: 2rem;
}

.card-title {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
}

.card-subtitle {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.card-text {
    font-size: 1.1rem;
    margin-bottom: 1rem;
}

.btn {
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.25rem;
}

.btn-outline-secondary {
    color: #6c757d;
    border-color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: #fff;
}


</style>
@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Province Details</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Name:</strong>
                    <p class="card-text">{{ $province->name }}</p>
                </div>
                <div class="mt-2">
                    <a class="button-index" href="{{ route('province.index') }}">
                        <i class="fa-solid fa-arrow-turn-down fa-rotate-90 fa-md"></i>
                          <span class="fw-semibold ms-2">Return to Province List</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
