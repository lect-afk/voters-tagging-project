@extends('layouts.backend')

@section('content')
    <div class="card dashboard_card">
        <div class="card-header">
            <div class="row mb-3">
                <div class="col d-flex align-items-center justify-content-between">
                    <h5>Event Overview</h5>
                    <p class="justify-content-end">Search Results: {{ $eventoverviews->total() }} ({{ $eventoverviews->count() }})</p>
                </div>
                <!-- Add Spinner HTML -->
                <div id="loadingSpinner" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Your PDF is being generated. Please wait and refrain from making any actions until it's finished.
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
                <div class="col-12 col-md-2">
                    <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
                </div>
                {{-- <div class="col-12 col-md-2">
                    <select id="leaderFilter" name="leader" class="form-select">
                        <option value="" {{ request('leader') == '' ? 'selected' : '' }}>All</option>
                        <option value="None" {{ request('leader') == 'None' ? 'selected' : '' }}>None Leader</option>
                        <option value="Barangay" {{ request('leader') == 'Barangay' ? 'selected' : '' }}>Barangay Leader</option>
                        <option value="Purok" {{ request('leader') == 'Purok' ? 'selected' : '' }}>Purok Leader</option>
                        <option value="Municipal" {{ request('leader') == 'Municipal' ? 'selected' : '' }}>Municipal Leader</option>
                        <option value="District" {{ request('leader') == 'District' ? 'selected' : '' }}>District Leader</option>
                        <option value="Provincial" {{ request('leader') == 'Provincial' ? 'selected' : '' }}>Provincial Leader</option>
                        <option value="Regional" {{ request('leader') == 'Regional' ? 'selected' : '' }}>Regional Leader</option>
                    </select>
                </div> --}}
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
                <div class="col-12 col-md-2 d-flex">
                    <a id="pdfDownloadButton" href="{{ route('eventstaggingsummary.pdf', request()->all()) }}" class="button-index w-100" data-filename="eventoverviews.pdf">
                        <i class="fa-solid fa-file-pdf fa-md"></i>
                        <span class="fw-semibold ms-2">Download</span>
                    </a>
                </div>
            </form>
        </div>
        <div class="card-body dashboard_card_body">
            <div class="table-responsive">
                <table class="table mt-2 table-light table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Voters Name</th>
                            {{-- <th>Barangay</th>
                            <th>Precinct</th> --}}
                            <th>Events Attended</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eventoverviews as $eventoverview)
                            <tr>
                                <td class="align-middle">{{ $eventoverview->lastname }} {{ $eventoverview->firstname }} {{ $eventoverview->middlename }}</td>
                                {{-- <td class="align-middle">{{ $eventoverview->barangays->name }}</td>
                                <td class="align-middle">
                                    @if ($eventoverview->precincts && $eventoverview->precincts->number)
                                        {{ $eventoverview->precincts->number }}
                                    @else
                                        None
                                    @endif
                                </td> --}}
                                <td class="align-middle">
                                    @foreach ($eventoverview->eventtaggings as $eventtagging)
                                        {{ $eventtagging->event->name }}<br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mb-5">
                {{ $eventoverviews->appends([
                    'query' => request('query'),
                    'barangay' => request('barangay')
                ])->links('admin.pages.partials.pagination') }}
            </div>
        </div>
    </div>
    <script src="{{ asset('js/spinner.js') }}"></script>
@endsection
