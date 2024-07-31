@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Voters Profiles</h1>
            <div class="pt-3">
                {{ $voters_profiles->appends(['query' => request('query'), 'leader' => request('leader')])->links('admin.pages.partials.pagination') }}
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

        <form class="d-flex" method="GET" action="{{ route('voters_profile.index') }}" role="search">
            <input id="searchInput" name="query" class="form-control me-2 w-50" type="search" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
            <select id="leaderFilter" name="leader" class="form-select w-50">
                <option value="" {{ request('leader') == '' ? 'selected' : '' }}>All</option>
                <option value="None" {{ request('leader') == 'None' ? 'selected' : '' }}>None Leader</option>
                <option value="Barangay" {{ request('leader') == 'Barangay' ? 'selected' : '' }}>Barangay Leader</option>
                <option value="Purok" {{ request('leader') == 'Purok' ? 'selected' : '' }}>Purok Leader</option>
                <option value="Municipal" {{ request('leader') == 'Municipal' ? 'selected' : '' }}>Municipal Leader</option>
                <option value="District" {{ request('leader') == 'District' ? 'selected' : '' }}>District Leader</option>
                <option value="Provincial" {{ request('leader') == 'Provincial' ? 'selected' : '' }}>Provincial Leader</option>
                <option value="Regional" {{ request('leader') == 'Regional' ? 'selected' : '' }}>Regional Leader</option>
            </select>
            <button class="ms-2 button-index" type="submit">
                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                <span class="fw-semibold ms-2">Search</span>
            </button>
            <a href="{{ route('voters_profile.create') }}" class="button-index ms-2">
                <i class="fa-solid fa-circle-plus fa-xl"></i>
                <span class="fw-semibold ms-2">Add</span>
            </a>
        </form>

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
    <div class="pt-3">
        {{ $voters_profiles->appends(['query' => request('query'), 'leader' => request('leader')])->links('admin.pages.partials.pagination') }}
    </div>
@endsection
