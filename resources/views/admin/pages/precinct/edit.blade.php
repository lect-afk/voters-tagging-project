@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Edit Precinct</h1>
        <form action="{{ route('precinct.update', $precinct->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="number">Number</label>
                <input type="text" name="number" class="form-control" value="{{ $precinct->number }}" required>
            </div>
            <div class="form-group">
                <label for="barangay">Barangay:</label>
                <select name="barangay" class="form-control" required>
                    @foreach ($barangay as $barangay)
                        <option value="{{ $barangay->id }}" {{ $precinct->barangay == $barangay->id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
@endsection
