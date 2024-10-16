@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <h5>Events Tagging</h5>
            </div>
        </div>
    
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @elseif ($message = Session::get('error'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @endif
    
        <form class="row g-2 mb-3" method="GET" action="" role="search">
            <div class="col-12 col-md-3">
                <input type="text" name="full_name" class="form-control" placeholder="Search Full Name" value="{{ request('full_name') }}">
            </div>
            <div class="col-12 col-md-3">
                <select name="precinct" class="form-control">
                    <option value="" {{ request('precinct') == '' ? 'selected' : '' }}>All Precinct</option>
                    @foreach ($precincts as $precinct)
                        <option value="{{ $precinct->id }}" {{ request('precinct') == $precinct->id ? 'selected' : '' }}>{{ $precinct->number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <select name="barangay" class="form-control">
                    <option value="" {{ request('barangay') == '' ? 'selected' : '' }}>All Barangay</option>
                    @foreach ($barangays as $barangay)
                        <option value="{{ $barangay->id }}" {{ request('barangay') == $barangay->id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-1">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-md"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
        </form>
    </div>
    <div class="card-body dashboard_card_body">
        <form id="eventForm" method="POST" action="{{ route('voters_profile.tagEvents') }}">
            @csrf
            <div class="row g-2 mb-3">
                <div class="col-12 col-md-1">
                    <a class="button-index w-100" href="{{ route('voters.eventstagging') }}">
                        <i class="fa-solid fa-arrow-turn-down fa-rotate-90 fa-md"></i>
                        <span class="fw-semibold ms-2">Return</span>
                    </a>
                </div>
                <div class="col-12 col-md-1">
                    <button class="button-index w-100" type="submit">
                        <span class="fw-semibold ms-2">Change</span>
                    </button>
                </div>
                <div class="col-12 col-md-3">
                    <input hidden name="tagevent" value="{{ $manageevent->id }}">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table mt-2 table-light table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Full Name</th>
                            <th>Barangay</th>
                            <th>Attendance Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voters_profiles as $voters_profile)
                            <tr>
                                <td class="align-middle">
                                    <input class="form-check-input" type="checkbox" name="selected_profiles[]" value="{{ $voters_profile->id }}">
                                </td>
                                <td class="align-middle">{{ $voters_profile->lastname }} {{ $voters_profile->firstname }} {{ $voters_profile->middlename }}</td>
                                <td class="align-middle">{{ $voters_profile->barangays->name }}</td>
                                <td class="align-middle">{{ $voters_profile->attendance_status }}</td> <!-- Use the new property -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $voters_profiles->appends(request()->query())->links('admin.pages.partials.pagination') }}
            </div>        
        </form>
    </div>
</div>
@endsection
