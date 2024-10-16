@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <h5>Edit Voter Profile</h5>
    </div>
    <div class="card-body dashboard_card_body">
        <form action="{{ route('voters_profile.update', $votersProfile->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <label for="alliances_status">Alliances Status</label>
                <select name="alliances_status" class="form-control" required>
                    <option disabled selected value="">Select</option>
                    <option value="None" {{ $votersProfile->alliances_status == 'None' ? 'selected' : '' }}>None</option>
                    <option value="Green" {{ $votersProfile->alliances_status == 'Green' ? 'selected' : '' }}>Blue</option>
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
                    @foreach ($barangay as $barangay)
                        <option value="{{ $barangay->id }}" {{ $votersProfile->barangay == $barangay->id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="purok">Purok</label>
                <select name="purok" id="purok" class="form-control">
                    <!-- Purok options will be populated by JavaScript -->
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="sitio">Sitio</label>
                <select name="sitio" id="sitio" class="form-control">
                    <!-- Sitio options will be populated by JavaScript -->
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="precinct">Precinct</label>
                <select name="precinct" id="precinct" class="form-control">
                    <!-- Precinct options will be populated by JavaScript -->
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="leader">Leader</label>
                <select name="leader" class="form-control" required>
                    <option value="None" {{ $votersProfile->leader == 'None' ? 'selected' : '' }}>None</option>
                    <option value="Purok" {{ $votersProfile->leader == 'Purok' ? 'selected' : '' }}>Purok</option>
                    <option value="Barangay" {{ $votersProfile->leader == 'Barangay' ? 'selected' : '' }}>Barangay</option>
                    <option value="Cluster" {{ $votersProfile->leader == 'Cluster' ? 'selected' : '' }}>Cluster</option>
                    <option value="Municipal" {{ $votersProfile->leader == 'Municipal' ? 'selected' : '' }}>Municipal</option>
                    <option value="District" {{ $votersProfile->leader == 'District' ? 'selected' : '' }}>District</option>
                    <option value="Provincial" {{ $votersProfile->leader == 'Provincial' ? 'selected' : '' }}>Provincial</option>
                    <option value="Regional" {{ $votersProfile->leader == 'Regional' ? 'selected' : '' }}>Regional</option>
                </select>
            </div>
            <button type="submit" class="button-index">
                <i class="fa-solid fa-pen-to-square fa-md"></i>
                <span class="fw-semibold ms-2">Update</span>
            </button>
            <a href="{{ route('voters_profile.index') }}" class="button-index">
                <i class="fa-solid fa-ban fa-md"></i>
                <span class="fw-semibold ms-2">Cancel</span>
            </a>
        </form>
    </div>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var initialBarangayID = '{{ $votersProfile->barangay }}';
            var initialPurokID = '{{ $votersProfile->purok }}';
            var initialSitioID = '{{ $votersProfile->sitio }}';
            var initialPrecinctID = '{{ $votersProfile->precinct }}';

            if (initialBarangayID) {
                fetchPurokOptions(initialBarangayID, initialPurokID, initialSitioID);
                fetchPrecinctOptions(initialBarangayID, initialPrecinctID);
            }

            $('#barangay').change(function() {
                var barangayID = $(this).val();
                if (barangayID) {
                    fetchPurokOptions(barangayID);
                    fetchPrecinctOptions(barangayID);
                } else {
                    $('#purok').empty().append('<option value="">Select (or None)</option>');
                    $('#sitio').empty().append('<option value="">Select (or None)</option>');
                    $('#precinct').empty().append('<option value="">Select (or None)</option>');
                }
            });

            $('#purok').change(function() {
                var purokID = $(this).val();
                if (purokID) {
                    fetchSitioOptions(purokID);
                } else {
                    $('#sitio').empty().append('<option value="">Select (or None)</option>');
                }
            });

            function fetchPurokOptions(barangayID, selectedPurokID = null, selectedSitioID = null) {
                $.ajax({
                    url: '/getPurok/' + barangayID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#purok').empty().append('<option value="">Select (or None)</option>');
                        $.each(data, function(key, value) {
                            $('#purok').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        $('#sitio').empty().append('<option value="">Select (or None)</option>');
                        if (selectedPurokID) {
                            $('#purok').val(selectedPurokID).trigger('change');
                            if (selectedSitioID) {
                                fetchSitioOptions(selectedPurokID, selectedSitioID);
                            }
                        }
                    }
                });
            }

            function fetchSitioOptions(purokID, selectedSitioID = null) {
                $.ajax({
                    url: '/getSitio/' + purokID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#sitio').empty().append('<option value="">Select (or None)</option>');
                        $.each(data, function(key, value) {
                            $('#sitio').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        if (selectedSitioID) {
                            $('#sitio').val(selectedSitioID);
                        }
                    }
                });
            }

            function fetchPrecinctOptions(barangayID, selectedPrecinctID = null) {
                $.ajax({
                    url: '/getPrecinct/' + barangayID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#precinct').empty().append('<option value="">Select (or None)</option>');
                        $.each(data, function(key, value) {
                            $('#precinct').append('<option value="' + value.id + '">' + value.number + '</option>');
                        });
                        if (selectedPrecinctID) {
                            $('#precinct').val(selectedPrecinctID);
                        }
                    }
                });
            }
        });
    </script>
@endsection
