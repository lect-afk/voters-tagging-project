@extends('layouts.backend')

@section('content')
    

    <div class="container">
        <h1>Create Voters Profile</h1>
        <form action="{{ route('voters_profile.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="alliances_status">Alliances Status</label>
                <select name="alliances_status" class="form-control" required>
                    <option disabled selected value="">Select</option>
                    <option value="Green">Green</option>
                    <option value="Yellow">Yellow</option>
                    <option value="Orange">Orange</option>
                    <option value="Red">Red</option>
                </select>
            </div>
            <div class="form-group">
                <label for="firstname">Firstname:</label>
                <input type="text" name="firstname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="middlename">Middlename:</label>
                <input type="text" name="middlename" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="lastname">Lastname:</label>
                <input type="text" name="lastname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="sitio">Sitio</label>
                <select name="sitio" class="form-control" required>
                    <option disabled selected value="">Select</option>
                    @foreach ($sitio as $sitio)
                        <option value="{{ $sitio->id }}">{{ $sitio->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="purok">Purok</label>
                <select name="purok" class="form-control" required>
                    <option disabled selected value="">Select</option>
                    @foreach ($purok as $purok)
                        <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="barangay">Barangay</label>
                <select name="barangay" class="form-control" required>
                    <option disabled selected value="">Select</option>
                    @foreach ($barangay as $barangay)
                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="precinct">Precinct</label>
                <select name="precinct" class="form-control" required>
                    <option disabled selected value="">Select</option>
                    @foreach ($precinct as $precinct)
                        <option value="{{ $precinct->id }}">{{ $precinct->number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="leader">Leader</label>
                <select name="leader" class="form-control" required>
                    <option disabled selected value="">Select</option>
                    <option value="None">None</option>
                    <option value="Barangay">Barangay</option>
                    <option value="Municipal">Municipal</option>
                    <option value="District">District</option>
                    <option value="Provincial">Provincial</option>
                    <option value="Regional">Regional</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
@endsection
