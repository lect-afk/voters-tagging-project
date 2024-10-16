@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <h5>Edit Candidates</h5>
    </div>
    <div class="card-body dashboard_card_body">
        <form action="{{ route('candidates.update', $candidate->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <label for="firstname">Fullname:</label>
                <input type="text" name="fullname" class="form-control" value="{{ $candidate->fullname }}" required>
            </div>
            <div class="form-group mb-4">
                <label for="position">Position</label>
                <select name="position" class="form-control" required>
                    <option disabled selected value="">Select</option>
                    <option value="Councilor" {{ $candidate->position == 'Councilor' ? 'selected' : '' }}>Councilor</option>
                    <option value="Vice-Mayor" {{ $candidate->position == 'Vice-Mayor' ? 'selected' : '' }}>Vice-Mayor</option>
                    <option value="Mayor" {{ $candidate->position == 'Mayor' ? 'selected' : '' }}>Mayor</option>
                    <option value="Board Member" {{ $candidate->position == 'Board Member' ? 'selected' : '' }}>Board Member</option>
                    <option value="Congressman" {{ $candidate->position == 'Congressman' ? 'selected' : '' }}>Congressman</option>
                    <option value="Vice-Governor" {{ $candidate->position == 'Vice-Governor' ? 'selected' : '' }}>Vice-Governor</option>
                    <option value="Governor" {{ $candidate->position == 'Governor' ? 'selected' : '' }}>Governor</option>
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="province">Province</label>
                <select name="province" id="province" class="form-control" required>
                    <option disabled selected value="">Select</option>
                    @foreach ($province as $province)
                        <option value="{{ $province->id }}" {{ $province->id == $candidate->province ? 'selected' : '' }}>{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="district">District</label>
                <select name="district" id="district" class="form-control" required>
                    <!-- District options will be populated by JavaScript -->
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="city">City</label>
                <select name="city" id="city" class="form-control" required>
                    <!-- City options will be populated by JavaScript -->
                </select>
            </div>
            <button type="submit" class="button-index">
                <i class="fa-solid fa-pen-to-square fa-md"></i>
                <span class="fw-semibold ms-2">Submit</span>
            </button>
            <a href="{{ route('candidates.index') }}" class="button-index">
                <i class="fa-solid fa-ban fa-md"></i>
                <span class="fw-semibold ms-2">Cancel</span>
            </a>
        </form>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var initialProvinceID = '{{ $candidate->province }}';
        var initialDistrictID = '{{ $candidate->district }}';
        var initialCityID = '{{ $candidate->city }}';

        if (initialProvinceID) {
            fetchDistrictOptions(initialProvinceID, initialDistrictID, initialCityID);
        }

        $('#province').change(function() {
            var provinceID = $(this).val();
            if (provinceID) {
                fetchDistrictOptions(provinceID);
            } else {
                $('#district').empty().append('<option value="">Select</option>');
                $('#city').empty().append('<option value="">Select</option>');
            }
        });

        $('#district').change(function() {
            var districtID = $(this).val();
            if (districtID) {
                fetchCityOptions(districtID);
            } else {
                $('#city').empty().append('<option value="">Select</option>');
            }
        });

        function fetchDistrictOptions(provinceID, selectedDistrictID = null, selectedCityID = null) {
            $.ajax({
                url: '/getDistrict/' + provinceID,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#district').empty().append('<option value="">Select</option>');
                    $.each(data, function(key, value) {
                        $('#district').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#city').empty().append('<option value="">Select</option>');
                    if (selectedDistrictID) {
                        $('#district').val(selectedDistrictID).trigger('change');
                        if (selectedCityID) {
                            fetchCityOptions(selectedDistrictID, selectedCityID);
                        }
                    }
                }
            });
        }

        function fetchCityOptions(districtID, selectedCityID = null) {
            $.ajax({
                url: '/getCity/' + districtID,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#city').empty().append('<option value="">Select</option>');
                    $.each(data, function(key, value) {
                        $('#city').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    if (selectedCityID) {
                        $('#city').val(selectedCityID);
                    }
                }
            });
        }

    });
</script>
@endsection
