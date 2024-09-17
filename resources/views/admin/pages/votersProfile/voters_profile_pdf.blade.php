@extends('layouts.pdf')

@section('content')
    <div class="container my-5">
        <table class="table mt-2 table-light table-hover">
            <thead class="thead-dark">
                <tr><h6>Precinct Number: {{ $precinct_number }}</h6></tr>
                <tr>
                    <th>No.</th>
                    <th>Voter's Name</th>
                    <th>Barangay</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($voters_profiles as $index => $voters_profile)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $voters_profile->lastname }} {{ $voters_profile->firstname }} {{ $voters_profile->middlename }}</td>
                        <td>{{ $voters_profile->barangays->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
