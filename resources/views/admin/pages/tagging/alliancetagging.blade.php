@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <h5>Alliance Tagging</h5>
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
                <select name="precinct" class="form-control">
                    <option value="" {{ request('precinct') == '' ? 'selected' : '' }}>All Precinct</option>
                    @foreach ($precinct as $precinct)
                        <option value="{{ $precinct->id }}" {{ request('precinct') == $precinct->id ? 'selected' : '' }}>{{ $precinct->number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-1 d-flex">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-md"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
        </form>
    
        <div class="col-12 col-md-5 d-flex flex-wrap justify-content-between gap-2">
            <button type="button" class="btn btn-sm buttonAT_blue flex-fill" onclick="updateAllianceStatus('Green')">BLUE</button>
            <button type="button" class="btn btn-sm buttonAT_none flex-fill" onclick="updateAllianceStatus('None')">NONE</button>
            <button type="button" class="btn btn-sm buttonAT_yellow flex-fill" onclick="updateAllianceStatus('Yellow')">YELLOW</button>
            <button type="button" class="btn btn-sm buttonAT_orange flex-fill" onclick="updateAllianceStatus('Orange')">ORANGE</button>
            <button type="button" class="btn btn-sm buttonAT_red flex-fill" onclick="updateAllianceStatus('Red')">RED</button>
        </div>
    </div>
    <div class="card-body dashboard_card_body">
        <form id="allianceForm" method="POST" action="{{ route('voters_profile.updateAllianceStatus') }}">
            @csrf
            <input type="hidden" name="alliance_status" id="alliance_status">
            <div class="table-responsive">
                <table class="table mt-2 table-light table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Full Name</th>
                            <th>Barangay</th>
                            <th>Alliance Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voters_profiles as $voters_profile)
                            @php
                                $backgroundColor = '#6c757d'; 
                                switch ($voters_profile->alliances_status) {
                                    case 'Green':
                                        $backgroundColor = '#0466c8'; 
                                        break;
                                    case 'Yellow':
                                        $backgroundColor = '#ffd60a'; 
                                        break;
                                    case 'Orange':
                                        $backgroundColor = '#fb8500'; 
                                        break;
                                    case 'Red':
                                        $backgroundColor = '#d00000'; 
                                        break;
                                }
                            @endphp
                            <tr>
                                <td class="align-middle">
                                    <input class="form-check-input" type="checkbox" name="selected_profiles[]" value="{{ $voters_profile->id }}">
                                </td>
                                <td class="align-middle">{{ $voters_profile->lastname }} {{ $voters_profile->firstname }} {{ $voters_profile->middlename }}</td>
                                <td class="align-middle">{{ $voters_profile->barangays->name }}</td>
                                <td class="align-middle">
                                    <div class="rounded-circle" style="width: 30px; height: 30px; background-color: {{ $backgroundColor }};"></div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mb-5">
                {{ $voters_profiles->appends([
                    'precinct' => request('precinct')
                ])->links('admin.pages.partials.pagination') }}
            </div>
                    
        </form>
    </div>
</div>
<script>
    function updateAllianceStatus(status) {
        document.getElementById('alliance_status').value = status;
        document.getElementById('allianceForm').submit();
    }
</script>
@endsection
