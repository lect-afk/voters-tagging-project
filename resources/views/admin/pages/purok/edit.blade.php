@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Edit Purok</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('purok.update', $purok->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $purok->name }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="barangay">Barangay</label>
                        <select name="barangay" class="form-control" required>
                            @foreach ($barangay as $barangay)
                                <option value="{{ $barangay->id }}" @if ($purok->barangay == $barangay->id) selected @endif>{{ $barangay->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Update</span>
                    </button>
                    <a href="{{ route('purok.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-xl"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
