@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Edit Barangay</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('barangay.update', $barangay->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $barangay->name }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="city" class="form-label">City</label>
                        <select name="city" id="city" class="form-control" required>
                            @foreach ($city as $cty)
                                <option value="{{ $cty->id }}" {{ $barangay->city == $cty->id ? 'selected' : '' }}>{{ $cty->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Update</span>
                    </button>
                    <a href="{{ route('barangay.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-xl"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
