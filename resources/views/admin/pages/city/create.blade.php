@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Create City</h1>
        <form action="{{ route('city.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="district">District</label>
                <select name="district" class="form-control" required>
                    @foreach ($district as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="province">Province</label>
                <select name="province" class="form-control" required>
                    @foreach ($province as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
@endsection
