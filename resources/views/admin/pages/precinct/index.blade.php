@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Precinct</h1>
            <div class="pt-3">
                {{ $precincts->links('admin.pages.partials.pagination') }}
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
        <form class="d-flex mb-3 justify-content-between" method="GET" action="{{ route('precinct.index') }}" role="search">
            <input id="searchInput" name="query" class="form-control me-2" type="search" placeholder="Search..." aria-label="Search" value="{{ request('query') }}">
            <button class="ms-2 button-index" type="submit">
                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                <span class="fw-semibold ms-2">Search</span>
            </button>

            <a href="{{ route('precinct.create') }}" class="button-index ms-2">
                <i class="fa-solid fa-circle-plus fa-xl"></i>
                <span class="fw-semibold ms-2">Add</span>
            </a>
        </form>
        <table class="table mt-2 table-light table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Number</th>
                    <th>Barangay</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            @foreach ($precincts as $precinct)
                <tr>
                    <td>{{ $precinct->number }}</td>
                    <td>{{ $precinct->barangays->name }}</td>
                    <td>
                        <a href="{{ route('precinct.show', $precinct->id) }}" class="icon-link" title="Show">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('precinct.edit', $precinct->id) }}" class="icon-link" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('precinct.destroy', $precinct->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-link" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="pt-3">
        {{ $precincts->links('admin.pages.partials.pagination') }}
    </div>
@endsection
