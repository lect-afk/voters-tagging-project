@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Purok</h1>
            <a href="{{ route('purok.create') }}" class="button-index">Add Purok</a>
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
        <table class="table table-striped table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Barangay</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            @foreach ($purok as $purok)
                <tr>
                    <td>{{ $purok->name }}</td>
                    <td>{{ $purok->barangays->name }}</td>
                    <td>
                        <a href="{{ route('purok.show', $purok->id) }}" class="icon-link" title="Show">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('purok.edit', $purok->id) }}" class="icon-link" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('purok.destroy', $purok->id) }}" method="POST" class="d-inline">
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
@endsection
