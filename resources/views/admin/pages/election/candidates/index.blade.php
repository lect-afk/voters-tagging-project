@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="row mb-3">
            <div class="col-12">
                <h1>Candidates</h1>
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

        <form class="row g-2 mb-3" method="GET" action="{{ route('candidates.index') }}" role="search">
            <div class="col-12 col-md-10">
                <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
            </div>
            <div class="col-6 col-md-1">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-md"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
            <div class="col-6 col-md-1">
                <a href="{{ route('candidates.create') }}" class="button-index w-100">
                    <i class="fa-solid fa-circle-plus fa-md"></i>
                    <span class="fw-semibold ms-2">Add</span>
                </a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table mt-2 table-light table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Full Name</th>
                        <th>Position</th>
                        <th>Province</th>
                        <th>District</th>
                        <th>City/Municipality</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($candidates as $candidate)
                        <tr>
                            <td class="align-middle">{{ $candidate->fullname }}</td>
                            <td class="align-middle">{{ $candidate->position }}</td>
                            <td class="align-middle">
                                @if ($candidate->provinces && $candidate->provinces->name)
                                    {{ $candidate->provinces->name }}
                                @else
                                    None
                                @endif
                            </td>
                            <td class="align-middle">
                                @if ($candidate->districts && $candidate->districts->name)
                                    {{ $candidate->districts->name }}
                                @else
                                    None
                                @endif
                            </td>
                            <td class="align-middle">
                                @if ($candidate->cities && $candidate->cities->name)
                                    {{ $candidate->cities->name }}
                                @else
                                    None
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('candidates.edit', $candidate->id) }}" class="icon-link" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" class="d-inline">
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
            {{ $candidates->appends(['query' => request('query')])->links('admin.pages.partials.pagination') }}
        </div>
    </div>
@endsection
