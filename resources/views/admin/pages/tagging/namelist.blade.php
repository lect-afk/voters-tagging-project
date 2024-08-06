@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <h1>List Of Leaders</h1>
            </div>
        </div>
        <form class="row g-2" method="GET" action="{{ route('leaders.search') }}" role="search">
            <div class="col-12 col-md-6">
                <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
            </div>
            <div class="col-12 col-md-4">
                <select id="leaderFilter" name="leader" class="form-select">
                    <option value="Barangay" {{ request('leader') == 'Barangay' ? 'selected' : '' }}>Barangay Leader</option>
                    <option value="Purok" {{ request('leader') == 'Purok' ? 'selected' : '' }}>Purok Leader</option>
                    <option value="Municipal" {{ request('leader') == 'Municipal' ? 'selected' : '' }}>Municipal Leader</option>
                    <option value="District" {{ request('leader') == 'District' ? 'selected' : '' }}>District Leader</option>
                    <option value="Provincial" {{ request('leader') == 'Provincial' ? 'selected' : '' }}>Provincial Leader</option>
                    <option value="Regional" {{ request('leader') == 'Regional' ? 'selected' : '' }}>Regional Leader</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-md"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table mt-2 table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Full Name</th>
                        <th>Barangay</th>
                        <th style="width: 15%;"></th>
                    </tr>
                </thead>
                <tbody class="leader-table-body">
                    @include('admin.pages.tagging.leader_table_body', ['leaders' => $leaders])
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $leaders->appends(['query' => request('query'), 'leader' => request('leader')])->links('admin.pages.partials.pagination') }}
        </div>
    </div>
    
@endsection
