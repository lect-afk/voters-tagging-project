@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Group</h1>
            <div class="pt-3">
                {{ $groups->links('admin.pages.partials.pagination') }}
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
        <form class="d-flex mb-3 justify-content-between" method="GET" action="{{ route('group.index') }}" role="search">
            <input id="searchInput" name="query" class="form-control me-2" type="search" placeholder="Search..." aria-label="Search" value="{{ request('query') }}">
            <button class="ms-2 button-index" type="submit">
                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                <span class="fw-semibold ms-2">Search</span>
            </button>

            <a href="{{ route('group.create') }}" class="button-index ms-2">
                <i class="fa-solid fa-circle-plus fa-xl"></i>
                <span class="fw-semibold ms-2">Add</span>
            </a>
        </form>
        <table class="table mt-2 table-light table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            @foreach ($groups as $group)
                <tr>
                    <td>{{ $group->name }}</td>
                    <td>
                        <a href="{{ route('group.show', $group->id) }}" class="icon-link" title="Show">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('group.edit', $group->id) }}" class="icon-link" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('group.destroy', $group->id) }}" method="POST" class="d-inline">
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
        {{ $groups->links('admin.pages.partials.pagination') }}
    </div>
@endsection
