@extends('layouts.backend')

@section('content')
    {{-- <h1>Create Barangay</h1>
    <form action="{{ route('barangay.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <label for="city">City:</label>
        <select name="city" id="city" required>
            @foreach ($city as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
        <button type="submit">Create</button>
    </form> --}}


    <div class="container">
        <h1>Create Barangay</h1>
        <form action="{{ route('barangay.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <select name="city" class="form-control" required>
                    @foreach ($city as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
@endsection
