@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <div class="row mb-3">
            <div class="col d-flex align-items-center justify-content-between">
                <h5>Candidate Tagging</h5>
                <p>Search Results: {{ $candidate_taggings->total() }} ({{ $candidate_taggings->count() }})</p>
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
        
        <form class="row g-2 mb-3" method="GET" action="{{ route('voters.candidatetagging') }}" role="search">
            <div class="col-12 col-md-2">
                <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
            </div>
            <div class="col-12 col-md-2">
                <select name="precinct" class="form-control">
                    <option value="" {{ request('precinct') == '' ? 'selected' : '' }}>All Precinct</option>
                    @foreach ($precinct as $precinct)
                        <option value="{{ $precinct->id }}" {{ request('precinct') == $precinct->id ? 'selected' : '' }}>{{ $precinct->number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2">
                <select name="barangay" class="form-control">
                    <option value="" {{ request('barangay') == '' ? 'selected' : '' }}>All Barangays</option>
                    @foreach ($barangay as $b)
                        <option value="{{ $b->id }}" {{ request('barangay') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2 d-flex">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-md"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
            <div class="col-12 col-md-4">
                <div class="d-flex align-items-center">
                    <select class="form-select me-2" id="candidateSelect" onchange="updatevoterCandidate(this.value)">
                        <option selected disabled value="">Select Candidate</option>
                        @foreach ($candidate as $candidate)
                            <option value="{{ $candidate->id }}" {{ request('candidate') == $candidate->id ? 'selected' : '' }}>{{ $candidate->fullname }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="button-index w-25" onclick="submitcandidateTaggingForm()">
                        <i class="fa-solid fa-pen-nib fa-md"></i>
                        <span class="fw-semibold ms-2">Modify</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body dashboard_card_body">
        <form id="candidateTaggingForm" method="POST" action="{{ route('voters.updatevoterCandidate') }}">
            @csrf
            <input type="hidden" name="candidate" id="candidate">
            <div class="table-responsive">
                <table class="table mt-2 table-light table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Full Name</th>
                            <th>Brgy / Precinct</th>
                            <th>Candidates</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidate_taggings as $candidate_tagging)
                            @php
                                // Determine the font color
                                $FontColor = '#6c757d'; 
                                switch ($candidate_tagging->alliances_status) {
                                    case 'Green':
                                        $FontColor = '#0466c8'; 
                                        break;
                                    case 'Yellow':
                                        $FontColor = '#ffd60a'; 
                                        break;
                                    case 'Orange':
                                        $FontColor = '#99582a'; 
                                        break;
                                    case 'Red':
                                        $FontColor = '#d00000'; 
                                        break;
                                    case 'White':
                                        $FontColor = '#e0fbfc'; 
                                        break;
                                    case 'Black':
                                        $FontColor = '#353535'; 
                                        break;
                                }

                                // Determine the Alliance status
                                $AllianceStatus = 'Non-participant'; 
                                    switch ($candidate_tagging->alliances_status) {
                                        case 'Green':
                                            $AllianceStatus = 'Allied'; 
                                            break;
                                        case 'Yellow':
                                            $AllianceStatus = 'Prospective Ally'; 
                                            break;
                                        case 'Orange':
                                            $AllianceStatus = 'Unlikely Ally'; 
                                            break;
                                        case 'Red':
                                            $AllianceStatus = 'Non-supporter'; 
                                            break;
                                        case 'White':
                                            $AllianceStatus = 'Unilateral'; 
                                            break;
                                        case 'Black':
                                            $AllianceStatus = 'Unidentified'; 
                                            break;
                                    }
                            @endphp

                            <tr>
                                <td class="align-middle">
                                    <input class="form-check-input" type="checkbox" name="selected_profiles[]" value="{{ $candidate_tagging->id }}">
                                </td>
                                <td class="align-middle">{{ $candidate_tagging->lastname }} {{ $candidate_tagging->firstname }} {{ $candidate_tagging->middlename }}</td>
                                <td class="align-middle">{{ $candidate_tagging->barangays->name }} / {{ $candidate_tagging->precincts->number }}</td>
                                <td class="align-middle">
                                    <!-- Display all associated candidate names -->
                                    @foreach($candidate_tagging->candidateTaggings as $tag)
                                    <span style="color: {{ $FontColor }};">{{ $AllianceStatus }}</span>
                                    <i class="fa-solid fa-right-long fa-sm"></i> 
                                    (<b>{{ $tag->candidate->position }}</b>) {{ $tag->candidate->fullname }}<br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>                    
                </table>
            </div>
            <div class="d-flex justify-content-center mb-5">
                {{ $candidate_taggings->appends([
                    'precinct' => request('precinct'),
                    'query' => request('query'),
                    'barangay' => request('barangay')
                ])->links('admin.pages.partials.pagination') }}
            </div>
        </form>
    </div>
</div>

<script>
    function updatevoterCandidate(status) {
        document.getElementById('candidate').value = status;
    }

    function submitcandidateTaggingForm() {
        document.getElementById('candidateTaggingForm').submit();
    }

    // Display the loading spinner when form is submitted
    $('#candidateTaggingForm').on('submit', function() {
        $('#loadingSpinner').show();
    });
</script>
@endsection
