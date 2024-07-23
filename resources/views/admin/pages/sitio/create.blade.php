@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Create Sitio</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('sitio.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="barangay">Barangay</label>
                        <select name="barangay" id="barangay" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            @foreach ($barangay as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="purok">Purok</label>
                        <select name="purok" id="purok" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            {{-- @foreach ($purok as $purok)
                                <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                            @endforeach --}}
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
