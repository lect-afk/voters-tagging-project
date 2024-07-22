@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Create City</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('city.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="district">District</label>
                        <select name="district" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            @foreach ($district as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="province">Province</label>
                        <select name="province" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            @foreach ($province as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Submit</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
