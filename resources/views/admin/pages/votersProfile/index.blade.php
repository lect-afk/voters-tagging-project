@extends('layouts.backend')

@section('content')
    <div class="card dashboard_card">
        <div class="card-header">
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <h5>Voters Profiles</h5>
                </div>
                <!-- Add Spinner HTML -->
                <div id="loadingSpinner" class="col-12" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Your PDF is being generated. Please wait and refrain from making any actions until it's finished.
                </div>
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

            <form class="row g-2 mb-3" method="GET" action="{{ route('voters_profile.index') }}" role="search">
                <div class="col-12 col-md-2">
                    <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
                </div>
                <div class="col-12 col-md-2">
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
                <div class="col-12 col-md-2 d-flex">
                    <a href="{{ route('voters_profile.create') }}" class="button-index w-100">
                        <i class="fa-solid fa-circle-plus fa-md"></i>
                        <span class="fw-semibold ms-2">Add</span>
                    </a>
                </div>
                <div class="col-12 col-md-2 d-flex">
                    <a id="pdfDownloadButton" href="{{ route('voters_profile.pdf', request()->all()) }}" class="button-index w-100" data-filename="voters_profiles.pdf">
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
                            <th>Alliance Status</th>
                            <th>Full Name</th>
                            <th>Barangay</th>
                            <th>Precinct</th>
                            <th>Leader</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="voter-table-body">
                        @include('admin.pages.votersProfile.voter_table_body')
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mb-5">
                {{ $voters_profiles->appends([
                    'query' => request('query'),
                    'leader' => request('leader'),
                    'barangay' => request('barangay')
                ])->links('admin.pages.partials.pagination') }}
            </div>
        </div>
    </div>
    <script src="{{ asset('js/spinner.js') }}"></script>
@endsection