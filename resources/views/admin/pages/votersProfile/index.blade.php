@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <h1>Voters Profiles</h1>
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

        <form class="row g-2 mb-3" method="GET" action="{{ route('voters_profile.index') }}" role="search">
            <div class="col-12 col-md-4">
                <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
            </div>
            <div class="col-12 col-md-3">
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
            <div class="col-12 col-md-3">
                <select name="barangay" class="form-control">
                    <option value="" {{ request('barangay') == '' ? 'selected' : '' }}>All Barangays</option>
                    @foreach ($barangay as $b)
                        <option value="{{ $b->id }}" {{ request('barangay') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-1">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-md"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
            <div class="col-12 col-md-1">
                <a href="{{ route('voters_profile.create') }}" class="button-index w-100">
                    <i class="fa-solid fa-circle-plus fa-md"></i>
                    <span class="fw-semibold ms-2">Add</span>
                </a>
            </div>
        </form>

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
        <div class="d-flex justify-content-center">
            {{ $voters_profiles->appends([
                'query' => request('query'),
                'leader' => request('leader'),
                'barangay' => request('barangay')
            ])->links('admin.pages.partials.pagination') }}
        </div>        
    </div>
@endsection
