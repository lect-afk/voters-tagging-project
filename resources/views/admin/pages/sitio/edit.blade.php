@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Edit Sitio</h1>
        <form action="{{ route('sitio.update', $sitio->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $sitio->name }}" required>
            </div>
            <div class="form-group">
                <label for="barangay">Barangay</label>
                <select name="barangay" class="form-control" required>
                    @foreach ($barangay as $barangay)
                        <option value="{{ $barangay->id }}" {{ $barangay->id == $sitio->barangay_id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="purok">Purok</label>
                <select name="purok" class="form-control" required>
                    @foreach ($purok as $purok)
                        <option value="{{ $purok->id }}" {{ $purok->id == $sitio->purok_id ? 'selected' : '' }}>{{ $purok->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
@endsection
