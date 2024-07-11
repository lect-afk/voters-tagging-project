@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Edit Legislative District</h1>
        <form action="{{ route('legislative_district.update', $legislativeDistrict->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $legislativeDistrict->name }}" required>
            </div>
            <div class="form-group">
                <label for="province">Province:</label>
                <select name="province" id="province" class="form-control" required>
                    @foreach ($province as $province)
                        <option value="{{ $province->id }}" {{ $province->id == $legislativeDistrict->province ? 'selected' : '' }}>{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
@endsection
