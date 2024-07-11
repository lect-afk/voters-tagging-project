@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Edit Purok</h1>
        <form action="{{ route('purok.update', $purok->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $purok->name }}" required>
            </div>
            <div class="form-group">
                <label for="barangay">Barangay</label>
                <select name="barangay" class="form-control" required>
                    @foreach ($barangay as $barangay)
                        <option value="{{ $barangay->id }}" @if ($purok->barangay == $barangay->id) selected @endif>{{ $barangay->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
@endsection
