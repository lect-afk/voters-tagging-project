@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Edit City</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('city.update', $city->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $city->name }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="district" class="form-label">District</label>
                        <select name="district" id="district" class="form-control" required>
                            @foreach ($district as $dist)
                                <option value="{{ $dist->id }}" {{ $city->district == $dist->id ? 'selected' : '' }}>{{ $dist->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="province" class="form-label">Province</label>
                        <select name="province" id="province" class="form-control" required>
                            @foreach ($province as $prov)
                                <option value="{{ $prov->id }}" {{ $city->province == $prov->id ? 'selected' : '' }}>{{ $prov->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Update</span>
                    </button>
                    <a href="{{ route('city.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-xl"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
