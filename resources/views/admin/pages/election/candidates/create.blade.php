@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Create Candidates</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('candidates.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="firstname">Fullname:</label>
                        <input type="text" name="fullname" class="form-control" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="position">Position</label>
                        <select name="position" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            <option value="Councilor">Councilor</option>
                            <option value="Vice-Mayor">Vice-Mayor</option>
                            <option value="Mayor">Mayor</option>
                            <option value="Board Member">Board Member</option>
                            <option value="Congressman">Congressman</option>
                            <option value="Vice-Governor">Vice-Governor</option>
                            <option value="Governor">Governor</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="province">Province</label>
                        <select name="province" id="province" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            @foreach ($province as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="district">District</label>
                        <select name="district" id="district" class="form-control">
                            <option disabled selected value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="city">City</label>
                        <select name="city" id="city" class="form-control">
                            <option disabled selected value="">Select</option>
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Submit</span>
                    </button>
                    <a href="{{ route('candidates.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-xl"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#province').change(function() {
                var provinceID = $(this).val();
                if (provinceID) {
                    $.ajax({
                        url: '/getDistrict/' + provinceID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#district').empty();
                            $('#district').append('<option value="">Select</option>');
                            $('#city').empty();
                            $('#city').append('<option value="">Select</option>');
                            $.each(data, function(key, value) {
                                $('#district').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#district').empty();
                    $('#district').append('<option value="">Select</option>');
                    $('#city').empty();
                    $('#city').append('<option value="">Select</option>');
                }
            });
    
            $('#district').change(function() {
                var districtID = $(this).val();
                if (districtID) {
                    $.ajax({
                        url: '/getCity/' + districtID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#city').empty();
                            $('#city').append('<option value="">Select</option>');
                            $.each(data, function(key, value) {
                                $('#city').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#city').empty();
                    $('#city').append('<option value="">Select</option>');
                }
            });
        });
    </script>
@endsection
