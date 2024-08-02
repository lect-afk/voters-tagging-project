@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>City</h1>
            <div class="pt-3">
                {{ $cities->links('admin.pages.partials.pagination') }}
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

        <form class="d-flex mb-3 justify-content-between" method="GET" action="{{ route('city.index') }}" role="search">
            <input id="searchInput" name="query" class="form-control me-2" type="search" placeholder="Search..." aria-label="Search" value="{{ request('query') }}">
            <button class="ms-2 button-index" type="submit">
                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                <span class="fw-semibold ms-2">Search</span>
            </button>

            <a href="{{ route('city.create') }}" class="button-index ms-2">
                <i class="fa-solid fa-circle-plus fa-xl"></i>
                <span class="fw-semibold ms-2">Add</span>
            </a>
        </form>
        <table class="table mt-2 table-light table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Province</th>
                    <th>District</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            @foreach ($cities as $city)
                <tr>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->provinces->name }}</td>
                    <td>{{ $city->districts->name }}</td>
                    <td>
                        <a href="{{ route('city.show', $city->id) }}" class="icon-link" title="Show">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('city.edit', $city->id) }}" class="icon-link" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('city.destroy', $city->id) }}" method="POST" class="d-inline">
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
        {{ $cities->links('admin.pages.partials.pagination') }}
    </div>
@endsection
