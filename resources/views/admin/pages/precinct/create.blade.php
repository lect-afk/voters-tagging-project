@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Create Precinct</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('precinct.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="number">Number</label>
                        <input type="text" name="number" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="barangay">Barangay:</label>
                        <select name="barangay" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            @foreach ($barangay as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Submit</span>
                    </button>
                    <a href="{{ route('precinct.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-xl"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
