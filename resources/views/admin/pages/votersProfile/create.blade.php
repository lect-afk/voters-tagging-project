@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Create Voters Profile</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('voters_profile.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="alliances_status">Alliances Status</label>
                        <select name="alliances_status" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            <option value="None">None</option>
                            <option value="Green">Green</option>
                            <option value="Yellow">Yellow</option>
                            <option value="Orange">Orange</option>
                            <option value="Red">Red</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="firstname">Firstname:</label>
                        <input type="text" name="firstname" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="middlename">Middlename:</label>
                        <input type="text" name="middlename" class="form-control">
                    </div>
                    <div class="form-group mb-4">
                        <label for="lastname">Lastname:</label>
                        <input type="text" name="lastname" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="sitio">Sitio</label>
                        <select name="sitio" class="form-control">
                            <option disabled selected value="">Select</option>
                            <option value="">None</option>
                            @foreach ($sitio as $sitio)
                                <option value="{{ $sitio->id }}">{{ $sitio->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="purok">Purok</label>
                        <select name="purok" class="form-control">
                            <option disabled selected value="">Select</option>
                            <option value="">None</option>
                            @foreach ($purok as $purok)
                                <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="barangay">Barangay</label>
                        <select name="barangay" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            @foreach ($barangay as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="precinct">Precinct</label>
                        <select name="precinct" class="form-control">
                            <option disabled selected value="">Select</option>
                            <option value="">None</option>
                            @foreach ($precinct as $precinct)
                                <option value="{{ $precinct->id }}">{{ $precinct->number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="leader">Leader</label>
                        <select name="leader" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            <option value="None">None</option>
                            <option value="Purok">Purok</option>
                            <option value="Barangay">Barangay</option>
                            <option value="Municipal">Municipal</option>
                            <option value="District">District</option>
                            <option value="Provincial">Provincial</option>
                            <option value="Regional">Regional</option>
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Submit</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
