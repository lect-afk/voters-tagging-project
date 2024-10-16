@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <h5>Edit Precinct</h5>
    </div>
    <div class="card-body dashboard_card_body">
        <form action="{{ route('precinct.update', $precinct->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <label for="number">Number</label>
                <input type="text" name="number" class="form-control" value="{{ $precinct->number }}" required>
            </div>
            <div class="form-group mb-4">
                <label for="barangay">Barangay:</label>
                <select name="barangay" class="form-control" required>
                    @foreach ($barangay as $barangay)
                        <option value="{{ $barangay->id }}" {{ $precinct->barangay == $barangay->id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="button-index">
                <i class="fa-solid fa-pen-to-square fa-md"></i>
                <span class="fw-semibold ms-2">Update</span>
            </button>
            <a href="{{ route('precinct.index') }}" class="button-index">
                <i class="fa-solid fa-ban fa-md"></i>
                <span class="fw-semibold ms-2">Cancel</span>
            </a>
        </form>
    </div>
</div>
@endsection
