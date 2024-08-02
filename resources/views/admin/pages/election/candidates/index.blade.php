@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Candidates</h1>
            <div class="pt-3">
                {{-- {{ $voters_profiles->appends(['query' => request('query'), 'leader' => request('leader')])->links('admin.pages.partials.pagination') }} --}}
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

        <form class="d-flex" method="GET" action="{{ route('candidates.index') }}" role="search">
            <input id="searchInput" name="query" class="form-control me-2 w-100" type="search" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
            <button class="ms-2 button-index" type="submit">
                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                <span class="fw-semibold ms-2">Search</span>
            </button>
            <a href="{{ route('candidates.create') }}" class="button-index ms-2">
                <i class="fa-solid fa-circle-plus fa-xl"></i>
                <span class="fw-semibold ms-2">Add</span>
            </a>
        </form>

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
                        <td>{{ $candidate->fullname }}</td>
                        <td>{{ $candidate->position }}</td>
                        <td>
                            @if ($candidate->provinces && $candidate->provinces->name)
                                {{ $candidate->provinces->name }}
                            @else
                                None
                            @endif
                        </td>
                        <td>
                            @if ($candidate->districts && $candidate->districts->name)
                                {{ $candidate->districts->name }}
                            @else
                                None
                            @endif
                        </td>
                        <td>
                            @if ($candidate->cities && $candidate->cities->name)
                                {{ $candidate->cities->name }}
                            @else
                                None
                            @endif
                        </td>
                        <td>
                            {{-- <a href="{{ route('candidates.show', $candidate->id) }}" class="icon-link" title="Show">
                                <i class="fas fa-eye"></i>
                            </a> --}}
                            <a href="{{ route('candidates.edit', $candidate->id) }}" class="icon-link" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-link" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pt-3">
        {{-- {{ $voters_profiles->appends(['query' => request('query'), 'leader' => request('leader')])->links('admin.pages.partials.pagination') }} --}}
    </div>
@endsection
