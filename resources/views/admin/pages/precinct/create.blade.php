@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Create Precinct</h1>
        <form action="{{ route('precinct.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="number">Number</label>
                <input type="text" name="number" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="barangay">Barangay:</label>
                <select name="barangay" class="form-control" required>
                    @foreach ($barangay as $barangay)
                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
@endsection
