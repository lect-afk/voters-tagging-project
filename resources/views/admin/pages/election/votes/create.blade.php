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
                <div class="form-group mb-4">
                    <label>Position</label>
                    <select id="position" class="form-control" required>
                        <option disabled selected value="">Select</option>
                        <option value="Councilor">Councilor</option>
                        <option value="Vice-Mayor">Vice-Mayor</option>
                        <option value="Mayor">Mayor</option>
                        <option value="Board Member">Board Member</option>
                        <option value="Congressman">Congressman</option>
                        <option value="Vice-Governor">Vice-Governor</option>
                        <option value="Governor">Governor</option>
                    </select>
                </div>
                <form action="{{ route('votes.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="candidate">Candidate</label>
                        <select name="candidate_id" id="candidates" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            {{-- Candidate options will be dynamically inserted here --}}
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="precinct">Precinct</label>
                        <select name="precinct" id="precinct" class="form-control" required>
                            <option disabled selected value="">Select</option>
                            @foreach ($precincts as $precinct)
                                <option value="{{ $precinct->id }}">{{ $precinct->number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="actual_votes">Actual Votes</label>
                        <input type="number" name="actual_votes" id="actual_votes" class="form-control" required min="1" pattern="[1-9][0-9]*">
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Submit</span>
                    </button>
                    <a href="{{ route('votes.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-xl"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>

<script>
    const candidates = @json($candidates);

    document.getElementById('position').addEventListener('change', function() {
        const position = this.value;
        const candidatesDropdown = document.getElementById('candidates');
        candidatesDropdown.innerHTML = '<option disabled selected value="">Select</option>';

        const filteredCandidates = candidates.filter(candidate => candidate.position === position);
        filteredCandidates.forEach(candidate => {
            const option = document.createElement('option');
            option.value = candidate.id;
            option.text = candidate.fullname;
            candidatesDropdown.appendChild(option);
        });
    });

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
