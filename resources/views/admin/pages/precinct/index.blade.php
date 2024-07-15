@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Precinct</h1>
            <a href="{{ route('precinct.create') }}" class="button-index">Add Precinct</a>
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
                    <th>Number</th>
                    <th>Barangay</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            @foreach ($precinct as $precinct)
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
@endsection
