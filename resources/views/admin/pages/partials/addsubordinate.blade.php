@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>{{ $manageleader->firstname }} {{ $manageleader->middlename }} {{ $manageleader->lastname }}</h1>
        <h4>Add Subordinates:</h4>
        <div class="container mt-3">
            <form action="{{ route('storeSubordinate') }}" method="POST" class="d-flex align-items-center">
                @csrf
                <div class="me-3">
                    <label for="choose_subordinate" class="form-label">Choose subordinate:</label>
                    <select name="successor" class="form-select" id="choose_subordinate" name="dropdown_option">
                        @foreach ($subordinates as $subordinates)
                            <option value="{{ $subordinates->id }}">{{ $subordinates->firstname }} {{ $subordinates->middlename }} {{ $subordinates->lastname }}</option>
                        @endforeach
                    </select>

                    <input hidden type="text" name="predecessor" class="form-control" required value="{{ $manageleader->id }}">
                    <input hidden type="text" name="tier_level" class="form-control" required value="1">
                    <input hidden type="text" name="team" class="form-control" required value="Sample">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-4">Add</button>
                </div>
            </form>
        </div>
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
                <th>Full Name</th>
                <th>Precinct No.</th>
                <th>Actions</th>
            </tr>
            @foreach ($successors  as $successors)
                <tr>
                    <td>{{ $successors->successors->firstname }} {{ $successors->successors->middlename }} {{ $successors->successors->lastname }}</td>
                    <td>{{ $successors->successors->precincts->number }}</td>
                    <td>
                        <a href="{{ route('voter_profile.manageleader', $successors->successor) }}" class="btn btn-info">Link to Voter</a>
                        <form action="" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
