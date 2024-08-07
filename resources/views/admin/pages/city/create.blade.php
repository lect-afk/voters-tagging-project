@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Create City</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('city.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
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
                        <select name="district" id="district" class="form-control" required>
                            <option disabled selected value="">Select</option>
                        </select>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-md"></i>
                        <span class="fw-semibold ms-2">Submit</span>
                    </button>
                    <a href="{{ route('city.index') }}" class="button-index">
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
            $('#province').change(function() {
                var provinceID = $(this).val();
                if (provinceID) {
                    $.ajax({
                        url: '/getDistrict4City/' + provinceID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#district').empty();
                            $('#district').append('<option value="">Select</option>');
                            $.each(data, function(key, value) {
                                $('#district').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#district').empty();
                    $('#district').append('<option value="">Select</option>');
                }
            });
        });
    </script>
@endsection
