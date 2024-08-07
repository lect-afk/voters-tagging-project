@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <h1>Sitio</h1>
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

        <form class="row g-2 mb-3" method="GET" action="{{ route('sitio.index') }}" role="search">
            <div class="col-12 col-md-10">
                <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search..." aria-label="Search" value="{{ request('query') }}">
            </div>
            <div class="col-6 col-md-1">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-md"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
            <div class="col-6 col-md-1">
                <a href="{{ route('sitio.create') }}" class="button-index w-100">
                    <i class="fa-solid fa-circle-plus fa-md"></i>
                    <span class="fw-semibold ms-2">Add</span>
                </a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table mt-2 table-light table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Barangay</th>
                        <th>Purok</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sitios as $sitio)
                        <tr>
                            <td class="align-middle">{{ $sitio->name }}</td>
                            <td class="align-middle">{{ $sitio->barangays->name }}</td>
                            <td class="align-middle">{{ $sitio->puroks->name }}</td>
                            <td class="align-middle">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('sitio.show', $sitio->id) }}" class="icon-link" title="Show">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('sitio.edit', $sitio->id) }}" class="icon-link" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('sitio.destroy', $sitio->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item" type="submit" class="icon-link" title="Delete">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $sitios->links('admin.pages.partials.pagination') }}
        </div>
    </div>
@endsection
