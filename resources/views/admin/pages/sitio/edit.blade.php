@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Edit Sitio</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('sitio.update', $sitio->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $sitio->name }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="barangay">Barangay</label>
                        <select name="barangay" id="barangay" class="form-control" required>
                            @foreach ($barangay as $barangay)
                                <option value="{{ $barangay->id }}" {{ $barangay->id == $sitio->barangay_id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="purok">Purok</label>
                        <select name="purok" id="purok" class="form-control" required>
                            @foreach ($purok as $purok)
                                <option value="{{ $purok->id }}" {{ $purok->id == $sitio->purok_id ? 'selected' : '' }}>{{ $purok->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Update</span>
                    </button>
                    <a href="{{ route('sitio.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-xl"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
