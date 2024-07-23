@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Edit Voter Profile</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('voters_profile.update', $votersProfile->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="alliances_status">Alliances Status</label>
                        <select name="alliances_status" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            <option value="None" {{ $votersProfile->alliances_status == 'None' ? 'selected' : '' }}>None</option>
                            <option value="Green" {{ $votersProfile->alliances_status == 'Green' ? 'selected' : '' }}>Green</option>
                            <option value="Yellow" {{ $votersProfile->alliances_status == 'Yellow' ? 'selected' : '' }}>Yellow</option>
                            <option value="Orange" {{ $votersProfile->alliances_status == 'Orange' ? 'selected' : '' }}>Orange</option>
                            <option value="Red" {{ $votersProfile->alliances_status == 'Red' ? 'selected' : '' }}>Red</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="firstname">Firstname:</label>
                        <input type="text" name="firstname" class="form-control" value="{{ $votersProfile->firstname }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="middlename">Middlename:</label>
                        <input type="text" name="middlename" class="form-control" value="{{ $votersProfile->middlename }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="lastname">Lastname:</label>
                        <input type="text" name="lastname" class="form-control" value="{{ $votersProfile->lastname }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="barangay">Barangay</label>
                        <select name="barangay" id="barangay" class="form-control" required>
                            <option value="">None</option>
                            @foreach ($barangay as $barangay)
                            <option value="{{ $barangay->id }}" {{ $votersProfile->barangay == $barangay->id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="purok">Purok</label>
                        <select name="purok" id="purok" class="form-control">
                            <option value="">None</option>
                            
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="sitio">Sitio</label>
                        <select name="sitio" id="sitio" class="form-control">
                            <option value="">None</option>
                            @foreach ($sitio as $sitio)
                                <option value="{{ $sitio->id }}" {{ $votersProfile->sitio == $sitio->id ? 'selected' : '' }}>{{ $sitio->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="precinct">Precinct</label>
                        <select name="precinct" class="form-control">
                            <option value="">None</option>
                            @foreach ($precinct as $precinct)
                            <option value="{{ $precinct->id }}" {{ $votersProfile->precinct == $precinct->id ? 'selected' : '' }}>{{ $precinct->number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="leader">Leader</label>
                        <select name="leader" class="form-control" required>
                            <option value="None" {{ $votersProfile->leader == 'None' ? 'selected' : '' }}>None</option>
                            <option value="Purok" {{ $votersProfile->leader == 'Purok' ? 'selected' : '' }}>Purok</option>
                            <option value="Barangay" {{ $votersProfile->leader == 'Barangay' ? 'selected' : '' }}>Barangay</option>
                            <option value="Municipal" {{ $votersProfile->leader == 'Municipal' ? 'selected' : '' }}>Municipal</option>
                            <option value="District" {{ $votersProfile->leader == 'District' ? 'selected' : '' }}>District</option>
                            <option value="Provincial" {{ $votersProfile->leader == 'Provincial' ? 'selected' : '' }}>Provincial</option>
                            <option value="Regional" {{ $votersProfile->leader == 'Regional' ? 'selected' : '' }}>Regional</option>
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Update</span>
                    </button>
                    <a href="{{ route('voters_profile.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-xl"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>

@endsection
