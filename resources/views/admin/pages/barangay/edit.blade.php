@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Edit Barangay</h1>
        <form action="{{ route('barangay.update', $barangay->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $barangay->name }}" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <select name="city" class="form-control" required>
                    @foreach ($city as $city)
                        <option value="{{ $city->id }}" {{ $barangay->city == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
@endsection
