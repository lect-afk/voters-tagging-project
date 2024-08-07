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
                        <label for="barangay">Barangay</label>
                        <select name="barangay" id="barangay" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            @foreach ($barangay as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="purok">Purok</label>
                        <select name="purok" id="purok" class="form-control">
                            <option disabled selected value="">Select</option>
                            <option value="">None</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="sitio">Sitio</label>
                        <select name="sitio" id="sitio" class="form-control">
                            <option disabled selected value="">Select</option>
                            <option value="">None</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="precinct">Precinct</label>
                        <select name="precinct" id="precinct" class="form-control">
                            <option disabled selected value="">Select</option>
                            <option value="">None</option>
                            {{-- @foreach ($precinct as $precinct)
                                <option value="{{ $precinct->id }}">{{ $precinct->number }}</option>
                            @endforeach --}}
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
                        <i class="fa-solid fa-pen-to-square fa-md"></i>
                        <span class="fw-semibold ms-2">Submit</span>
                    </button>
                    <a href="{{ route('voters_profile.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-md"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#barangay').change(function() {
            var barangayID = $(this).val();
            if (barangayID) {
                $.ajax({
                    url: '/getPurok/' + barangayID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#purok').empty();
                        $('#purok').append('<option value="">Select (or None)</option>');
                        $('#sitio').empty();
                        $('#sitio').append('<option value="">Select (or None)</option>');
                        $.each(data, function(key, value) {
                            $('#purok').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#purok').empty();
                $('#purok').append('<option value="">Select (or None)</option>');
                
            }
        });

        $('#purok').change(function() {
            var purokID = $(this).val();
            if (purokID) {
                $.ajax({
                    url: '/getSitio/' + purokID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#sitio').empty();
                        $('#sitio').append('<option value="">Select (or None)</option>');
                        $.each(data, function(key, value) {
                            $('#sitio').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#sitio').empty();
                $('#sitio').append('<option value="">Select (or None)</option>');
            }
        });

        $('#barangay').change(function() {
            var barangayID = $(this).val();
            if (barangayID) {
                $.ajax({
                    url: '/getPrecinct/' + barangayID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#precinct').empty();
                        $('#precinct').append('<option value="">Select (or None)</option>');
                        $.each(data, function(key, value) {
                            $('#precinct').append('<option value="' + value.id + '">' + value.number + '</option>');
                        });
                    }
                });
            } else {
                $('#precinct').empty();
                $('#precinct').append('<option value="">Select (or None)</option>');
            }
        });
    });
</script>
@endsection
