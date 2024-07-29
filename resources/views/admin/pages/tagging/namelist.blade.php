@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>List Of Leaders</h1>
            {{ $leaders->appends(['query' => request('query'), 'leader' => request('leader')])->links('admin.pages.partials.pagination') }}
        </div>
        <form class="d-flex" method="GET" action="{{ route('leaders.search') }}" role="search">
            <input id="searchInput" name="query" class="form-control me-2 w-50" type="search" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
            <select id="leaderFilter" name="leader" class="form-select w-50">
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
        </form>
        
        <table class="table mt-2 table-light table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Full Name</th>
                    <th>Barangay</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            <tbody class="leader-table-body">
                @include('admin.pages.tagging.leader_table_body', ['leaders' => $leaders])
            </tbody>
        </table>
    </div>
    <div class="pt-3">
        {{ $leaders->appends(['query' => request('query'), 'leader' => request('leader')])->links('admin.pages.partials.pagination') }}
    </div>
@endsection
