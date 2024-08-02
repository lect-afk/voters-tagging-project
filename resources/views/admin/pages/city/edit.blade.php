@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Edit City</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('city.update', $city->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $city->name }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="province" class="form-label">Province</label>
                        <select name="province" id="province" class="form-control" required>
                            @foreach ($province as $prov)
                                <option value="{{ $prov->id }}" {{ $city->province == $prov->id ? 'selected' : '' }}>{{ $prov->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="district" class="form-label">District</label>
                        <select name="district" id="district" class="form-control" required>
                            <!-- District options will be populated by JavaScript -->
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Update</span>
                    </button>
                    <a href="{{ route('city.index') }}" class="button-index">
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
            var initialProvinceID = '{{ $city->province }}';
            var initialDistrictID = '{{ $city->district }}';
    
            if (initialProvinceID) {
                fetchDistrictOptions(initialProvinceID, initialDistrictID);
            }
    
            $('#province').change(function() {
                var provinceID = $(this).val();
                if (provinceID) {
                    fetchDistrictOptions(provinceID);
                } else {
                    $('#district').empty().append('<option disabled selected value="">Select</option>');
                }
            });
    
            function fetchDistrictOptions(provinceID, selectedDistrictID = null) {
                $.ajax({
                    url: '/getDistrict4City/' + provinceID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#district').empty().append('<option disabled selected value="">Select</option>');
                        $.each(data, function(key, value) {
                            $('#district').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        if (selectedDistrictID) {
                            $('#district').val(selectedDistrictID);
                        }
                    }
                });
            }
        });
    </script>
@endsection
