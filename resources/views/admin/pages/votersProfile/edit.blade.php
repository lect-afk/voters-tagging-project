@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Edit Voter Profile</h1>
        <form action="{{ route('voters_profile.update', $votersProfile->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="alliances_status">Alliances Status</label>
                <select name="alliances_status" class="form-control" required>
                    <option disabled selected value="">Select</option>
                    <option value="Green" {{ $votersProfile->alliances_status == 'Green' ? 'selected' : '' }}>Green</option>
                    <option value="Yellow" {{ $votersProfile->alliances_status == 'Yellow' ? 'selected' : '' }}>Yellow</option>
                    <option value="Orange" {{ $votersProfile->alliances_status == 'Orange' ? 'selected' : '' }}>Orange</option>
                    <option value="Red" {{ $votersProfile->alliances_status == 'Red' ? 'selected' : '' }}>Red</option>
                </select>
            </div>
            <div class="form-group">
                <label for="firstname">Firstname:</label>
                <input type="text" name="firstname" class="form-control" value="{{ $votersProfile->firstname }}" required>
            </div>
            <div class="form-group">
                <label for="middlename">Middlename:</label>
                <input type="text" name="middlename" class="form-control" value="{{ $votersProfile->middlename }}" required>
            </div>
            <div class="form-group">
                <label for="lastname">Lastname:</label>
                <input type="text" name="lastname" class="form-control" value="{{ $votersProfile->lastname }}" required>
            </div>
            <div class="form-group">
                <label for="sitio">Sitio</label>
                <select name="sitio" class="form-control" required>
                    @foreach ($sitio as $sitio)
                        <option value="{{ $sitio->id }}" {{ $votersProfile->sitio == $sitio->id ? 'selected' : '' }}>{{ $sitio->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="purok">Purok</label>
                <select name="purok" class="form-control" required>
                    @foreach ($purok as $purok)
                    <option value="{{ $purok->id }}" {{ $votersProfile->purok == $purok->id ? 'selected' : '' }}>{{ $purok->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="barangay">Barangay</label>
                <select name="barangay" class="form-control" required>
                    @foreach ($barangay as $barangay)
                    <option value="{{ $barangay->id }}" {{ $votersProfile->barangay == $barangay->id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="precinct">Precinct</label>
                <select name="precinct" class="form-control" required>
                    @foreach ($precinct as $precinct)
                    <option value="{{ $precinct->id }}" {{ $votersProfile->precinct == $precinct->id ? 'selected' : '' }}>{{ $precinct->number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="leader">Leader</label>
                <select name="leader" class="form-control" required>
                    <option value="None" {{ $votersProfile->leader == 'None' ? 'selected' : '' }}>None</option>
                    <option value="Barangay" {{ $votersProfile->leader == 'Barangay' ? 'selected' : '' }}>Barangay</option>
                    <option value="Municipal" {{ $votersProfile->leader == 'Municipal' ? 'selected' : '' }}>Municipal</option>
                    <option value="District" {{ $votersProfile->leader == 'District' ? 'selected' : '' }}>District</option>
                    <option value="Provincial" {{ $votersProfile->leader == 'Provincial' ? 'selected' : '' }}>Provincial</option>
                    <option value="Regional" {{ $votersProfile->leader == 'Regional' ? 'selected' : '' }}>Regional</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
@endsection
