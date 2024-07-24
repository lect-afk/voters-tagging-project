@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Create a Legislative District</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('legislative_district.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
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
                    <a href="{{ route('legislative_district.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-xl"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
