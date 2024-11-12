@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <h5>Alliance Tagging</h5>
            </div> 
        </div>
        <!-- Add Spinner HTML -->
        <div id="loadingSpinner" style="display: none;">
            <i class="fas fa-spinner fa-spin"></i> Your PDF is being generated. Please wait and refrain from making any actions until it's finished.
        </div>
        @if ($message = Session::get('success') ?? Session::get('error'))
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header {{ Session::get('success') ? 'bg-success' : 'bg-danger' }} text-white">
                        <strong class="mr-auto">{{ Session::get('success') ? 'Success' : 'Error' }}</strong>
                    </div>
                    <div class="toast-body">
                        {{ $message }}
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('.toast').toast({ delay: 5000 });
                    $('.toast').toast('show');
                });
            </script>
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
            <div class="col-12 col-md-3">
                <select name="alliances_status" class="form-control"> <!-- Corrected input name -->
                    <option value="" {{ request('alliances_status') == '' ? 'selected' : '' }}>All Alliance Status</option>
                    <option value="Green" {{ request('alliances_status') == 'Green' ? 'selected' : '' }}>Allied</option>
                    <option value="Yellow" {{ request('alliances_status') == 'Yellow' ? 'selected' : '' }}>Prospective Ally</option>
                    <option value="Orange" {{ request('alliances_status') == 'Orange' ? 'selected' : '' }}>Unlikely Ally</option>
                    <option value="None" {{ request('alliances_status') == 'None' ? 'selected' : '' }}>Non-participant</option>
                    <option value="Red" {{ request('alliances_status') == 'Red' ? 'selected' : '' }}>Non-supporter</option>
                    <option value="White" {{ request('alliances_status') == 'White' ? 'selected' : '' }}>Unilateral</option>
                    <option value="Black" {{ request('alliances_status') == 'Black' ? 'selected' : '' }}>Unidentified</option>
                </select>
            </div>
            <div class="col-12 col-md-1 d-flex">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-md"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
            <div class="col-12 col-md-2 d-flex">
                <a id="pdfDownloadButton" href="{{ route('alliancetagging.pdf', request()->all()) }}" class="button-index w-100" data-filename="alliancetagging.pdf">
                    <i class="fa-solid fa-file-pdf fa-md"></i>
                    <span class="fw-semibold ms-2">Download</span>
                </a>
            </div>
        </form>
        
    
        <div class="col-12 col-md-9 d-flex flex-wrap justify-content-between gap-2">
            <button type="button" class="btn btn-sm buttonAT_blue flex-fill" onclick="updateAllianceStatus('Green')">Allied</button>
            <button type="button" class="btn btn-sm buttonAT_yellow flex-fill" onclick="updateAllianceStatus('Yellow')">Prospective Ally</button>
            <button type="button" class="btn btn-sm buttonAT_orange flex-fill" onclick="updateAllianceStatus('Orange')">Unlikely Ally</button>
            <button type="button" class="btn btn-sm buttonAT_none flex-fill" onclick="updateAllianceStatus('None')">Non-participant</button>
            <button type="button" class="btn btn-sm buttonAT_red flex-fill" onclick="updateAllianceStatus('Red')">Non-supporter</button>
            <button type="button" class="btn btn-sm buttonAT_white flex-fill" onclick="updateAllianceStatus('White')">Unilateral</button>
            <button type="button" class="btn btn-sm buttonAT_black flex-fill" onclick="updateAllianceStatus('Black')">Unidentified</button>
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
                            <th>Alliance Status</th>
                            <th>Full Name</th>
                            <th>Barangay</th>
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
                                        $backgroundColor = '#99582a'; 
                                        break;
                                    case 'Red':
                                        $backgroundColor = '#d00000'; 
                                        break;
                                    case 'White':
                                        $backgroundColor = '#e0fbfc'; 
                                        break;
                                    case 'Black':
                                        $backgroundColor = '#353535'; 
                                        break;
                                }
                            @endphp
                            <tr>
                                <td class="align-middle">
                                    <input class="form-check-input" type="checkbox" name="selected_profiles[]" value="{{ $voters_profile->id }}">
                                </td>
                                <td class="align-middle">
                                    <div class="rounded-circle" style="width: 30px; height: 30px; background-color: {{ $backgroundColor }};"></div>
                                </td>
                                <td class="align-middle">{{ $voters_profile->lastname }} {{ $voters_profile->firstname }} {{ $voters_profile->middlename }}</td>
                                <td class="align-middle">{{ $voters_profile->barangays->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mb-5">
                {{ $voters_profiles->appends([
                    'precinct' => request('precinct'),
                    'alliances_status' => request('alliances_status')
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
<script src="{{ asset('js/spinner.js') }}"></script>
@endsection
