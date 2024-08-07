@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Create Sitio</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('sitio.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
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
                        <select name="purok" id="purok" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            <!-- Purok options will be populated by JavaScript -->
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-md"></i>
                        <span class="fw-semibold ms-2">Submit</span>
                    </button>
                    <a href="{{ route('sitio.index') }}" class="button-index">
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
                        $('#purok').append('<option disabled selected value="">Select</option>');
                        $('#sitio').empty();
                        $('#sitio').append('<option disabled selected value="">Select</option>');
                        $.each(data, function(key, value) {
                            $('#purok').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#purok').empty();
                $('#purok').append('<option disabled selected value="">Select</option>');
                
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
                        $('#sitio').append('<option disabled selected value="">Select</option>');
                        $.each(data, function(key, value) {
                            $('#sitio').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#sitio').empty();
                $('#sitio').append('<option disabled selected value="">Select</option>');
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
                        $('#precinct').append('<option disabled selected value="">Select</option>');
                        $.each(data, function(key, value) {
                            $('#precinct').append('<option value="' + value.id + '">' + value.number + '</option>');
                        });
                    }
                });
            } else {
                $('#precinct').empty();
                $('#precinct').append('<option disabled selected value="">Select</option>');
            }
        });
    });
</script>
@endsection
