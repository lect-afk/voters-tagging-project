@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Legislative District</h1>
        <a href="{{ route('legislative_district.create') }}" class="btn btn-primary">Add Legislative District</a>
        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
                <p>{{ $message }}</p>
            </div>
        @elseif ($message = Session::get('error'))
            <div class="alert alert-danger mt-2">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table mt-2">
            <tr>
                <th>Name</th>
                <th>Province</th>
                <th>Actions</th>
            </tr>
            @foreach ($legislative_district as $legislative_district)
                <tr>
                    <td>{{ $legislative_district->name }}</td>
                    <td>{{ $legislative_district->provinces->name }}</td>
                    <td>
                        <a href="{{ route('legislative_district.show', $legislative_district->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('legislative_district.edit', $legislative_district->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('legislative_district.destroy', $legislative_district->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
