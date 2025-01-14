@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <div class="row mb-3">
            <div class="col d-flex align-items-center justify-content-between">
                <h5>Group Tagging</h5>
                <p>Search Results: {{ $group_taggings->total() }} ({{ $group_taggings->count() }})</p>
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
        
        <form class="row g-2 mb-3" method="GET" action="{{ route('voters.grouptagging') }}" role="search">
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
            <div class="col-12 col-md-2">
                <select name="group_filter" class="form-control">
                    <option value="" {{ request('group_filter') == '' ? 'selected' : '' }}>All Groups</option>
                    @foreach ($groups as $g)
                        <option value="{{ $g->id }}" {{ request('group_filter') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2">
                <select name="alliance_status" class="form-control">
                    <option value="" {{ request('alliance_status') == '' ? 'selected' : '' }}>All Alliance Status</option>
                    <option value="Allied" {{ request('alliance_status') == 'Allied' ? 'selected' : '' }}>Allied</option>
                    <option value="Prospective Ally" {{ request('alliance_status') == 'Prospective Ally' ? 'selected' : '' }}>Prospective Ally</option>
                    <option value="Unlikely Ally" {{ request('alliance_status') == 'Unlikely Ally' ? 'selected' : '' }}>Unlikely Ally</option>
                    <option value="Non-supporter" {{ request('alliance_status') == 'Non-supporter' ? 'selected' : '' }}>Non-supporter</option>
                    <option value="Unilateral" {{ request('alliance_status') == 'Unilateral' ? 'selected' : '' }}>Unilateral</option>
                    <option value="Unidentified" {{ request('alliance_status') == 'Unidentified' ? 'selected' : '' }}>Unidentified</option>
                    <option value="Non-participant" {{ request('alliance_status') == 'Non-participant' ? 'selected' : '' }}>Non-participant</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-md"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
            <div class="col-12 col-md-4">
                <div class="d-flex align-items-center">
                    <select class="form-select me-2" id="groupSelect" onchange="updatevoterGroup(this.value)">
                        <option selected disabled value="">Select Group</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" {{ request('group') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="button-index w-25" onclick="submitgroupTaggingForm()">
                        <i class="fa-solid fa-pen-nib fa-md"></i>
                        <span class="fw-semibold ms-2">Modify</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body dashboard_card_body">
        <form id="groupTaggingForm" method="POST" action="{{ route('voters.connectvoterGroup') }}">
            @csrf
            <input type="hidden" name="group" id="group">
            <div class="table-responsive">
                <table class="table mt-2 table-light table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Alliance Status</th>
                            <th>Fullname</th>
                            <th>Brgy / Precinct</th>
                            <th>Group</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group_taggings as $group_tagging)
                            @php
                                $backgroundColor = '#6c757d'; 
                                switch ($group_tagging->alliances_status) {
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
                                    <input class="form-check-input" type="checkbox" name="selected_profiles[]" value="{{ $group_tagging->id }}">
                                </td>
                                <td class="align-middle"><div class="rounded-circle" style="width: 30px; height: 30px; background-color: {{ $backgroundColor }};"></div></td>
                                <td class="align-middle">{{ $group_tagging->lastname }} {{ $group_tagging->firstname }} {{ $group_tagging->middlename }}</td>
                                <td class="align-middle">{{ $group_tagging->barangays->name }} / {{ $group_tagging->precincts->number }}</td>
                                <td class="align-middle">
                                    @if($group_tagging->groupTaggings->isNotEmpty())
                                        @foreach($group_tagging->groupTaggings as $tagging)
                                            {{ $tagging->group->name }}<br>
                                        @endforeach
                                    @else
                                        No Group
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>                    
                </table>
            </div>
            <div class="d-flex justify-content-center mb-5">
                {{ $group_taggings->appends([
                    'precinct' => request('precinct'),
                    'query' => request('query'),
                    'barangay' => request('barangay'),
                    'group_filter' => request('group_filter'),
                    'alliance_status' => request('alliance_status')
                ])->links('admin.pages.partials.pagination') }}
            </div>
        </form>
    </div>
</div>

<script>
    function updatevoterGroup(status) {
        document.getElementById('group').value = status;
    }

    function submitgroupTaggingForm() {
        document.getElementById('groupTaggingForm').submit();
    }

    // Display the loading spinner when form is submitted
    $('#groupTaggingForm').on('submit', function() {
        $('#loadingSpinner').show();
    });
</script>
@endsection
