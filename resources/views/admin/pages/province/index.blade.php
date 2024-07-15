@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Province</h1>
            <a href="{{ route('province.create') }}" class="button-index">Add Province</a>
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
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($province as $province)
                    <tr>
                        <td>{{ $province->name }}</td>
                        <td>
                            <a href="{{ route('province.show', $province->id) }}" class="icon-link" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('province.edit', $province->id) }}" class="icon-link" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('province.destroy', $province->id) }}" method="POST" class="d-inline">
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
@endsection
