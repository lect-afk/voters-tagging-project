@extends('layouts.backend')

@section('content')
<style>
    /* Hides the up and down arrows for number input */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Create Votes</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('votes.update', $vote->id) }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="candidate">Candidate</label>
                        <select name="candidate_id" id="candidates" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            @foreach ($candidates as $candidate)
                                <option value="{{ $candidate->id }}" {{ $candidate->id == $vote->candidate_id ? 'selected' : '' }}>{{ $candidate->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="precinct">Precinct</label>
                        <select name="precinct" id="precinct" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            @foreach ($precincts as $precinct)
                                <option value="{{ $precinct->id }}" {{ $precinct->id == $vote->precinct ? 'selected' : '' }}>{{ $precinct->number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="actual_votes">Actual Votes</label>
                        <input type="number" name="actual_votes" id="actual_votes" class="form-control" required min="1" pattern="[1-9][0-9]*" value="{{ $vote->actual_votes }}">
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-md"></i>
                        <span class="fw-semibold ms-2">Update</span>
                    </button>
                    <a href="{{ route('votes.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-md"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>

<script>
    document.getElementById('actual_votes').addEventListener('input', function (e) {
        let value = e.target.value;
        // Prevent negative values and leading zeros
        if (value.length > 1 && value.startsWith('0')) {
            e.target.value = value.replace(/^0+/, '');
        }
        if (value < 0) {
            e.target.value = '';
        }
    });
</script>
@endsection
