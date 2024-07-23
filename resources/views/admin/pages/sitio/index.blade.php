@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Sitio</h1>
            <a href="{{ route('sitio.create') }}" class="button-index">
                <i class="fa-solid fa-circle-plus fa-xl"></i>
                <span class="fw-semibold ms-2">Add</span>
            </a>
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
        <table class="table mt-2 table-light table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Barangay</th>
                    <th>Purok</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            @foreach ($sitios as $sitio)
                <tr>
                    <td>{{ $sitio->name }}</td>
                    <td>{{ $sitio->barangays->name}}</td>
                    <td>{{ $sitio->puroks->name }}</td>
                    <td>
                        <a href="{{ route('sitio.show', $sitio->id) }}" class="icon-link" title="Show">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('sitio.edit', $sitio->id) }}" class="icon-link" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('sitio.destroy', $sitio->id) }}" method="POST" class="d-inline">
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
        {{ $sitios->links('admin.pages.partials.pagination') }}
    </div>
@endsection
