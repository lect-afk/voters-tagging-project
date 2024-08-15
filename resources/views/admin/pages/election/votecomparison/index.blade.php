@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="row mb-3">
            <div class="col-12">
                <h1>Vote Comparison</h1>
            </div>
        </div>

        <form class="row g-2 mb-3" method="GET" action="" role="search">
            <div class="col-12 col-md-3">
                <select id="position" name="position" class="form-select">
                    <option value="" {{ request('position') == '' ? 'selected' : '' }}>All Positions</option>
                    <option value="Councilor" {{ request('position') == 'Councilor' ? 'selected' : '' }}>Councilor</option>
                    <option value="Vice-Mayor" {{ request('position') == 'Vice-Mayor' ? 'selected' : '' }}>Vice-Mayor</option>
                    <option value="Mayor" {{ request('position') == 'Mayor' ? 'selected' : '' }}>Mayor</option>
                    <option value="Board Member" {{ request('position') == 'Board Member' ? 'selected' : '' }}>Board Member</option>
                    <option value="Congressman" {{ request('position') == 'Congressman' ? 'selected' : '' }}>Congressman</option>
                    <option value="Vice-Governor" {{ request('position') == 'Vice-Governor' ? 'selected' : '' }}>Vice-Governor</option>
                    <option value="Governor" {{ request('position') == 'Governor' ? 'selected' : '' }}>Governor</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <select name="candidate_id" id="candidates" class="form-control" required>
                    <option disabled selected value="">Select Candidate</option>
                    {{-- Candidate options will be dynamically inserted here --}}
                </select>
            </div>
            <div class="col-12 col-md-3">
                <select name="barangay" class="form-control">
                    <option value="" {{ request('barangay') == '' ? 'selected' : '' }}>All Barangays</option>
                    @foreach ($barangay as $b)
                        <option value="{{ $b->id }}" {{ request('barangay') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table mt-2 table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Precinct</th>
                        <th>Actual Votes</th>
                        <th>Expected Votes</th>
                        <th>+/- Comparison</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($precincts as $item)
                        <tr>
                            <td>{{ $item['precinct'] }}</td>
                            <td>{{ $item['actualVotes'] }}</td>
                            <td>{{ $item['totalLeadersAndDownline'] }}</td>
                            <td style="color: {{ $item['comparison'] < 0 ? 'red' : 'inherit' }}">
                                {{ $item['comparison'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $precincts->appends([
                'position' => request('position'),
                'candidate_id' => request('candidate_id'),
                'barangay' => request('barangay')
            ])->links('admin.pages.partials.pagination') }}
        </div>        
    </div>
<script>
    const candidates = @json($candidates);

    document.getElementById('position').addEventListener('change', function() {
        const position = this.value;
        const candidatesDropdown = document.getElementById('candidates');
        const selectedCandidateId = '{{ request('candidate_id') }}'; // Get the selected candidate ID from the request

        candidatesDropdown.innerHTML = '<option disabled selected value="">Select Candidate</option>';

        const filteredCandidates = candidates.filter(candidate => candidate.position === position);
        filteredCandidates.forEach(candidate => {
            const option = document.createElement('option');
            option.value = candidate.id;
            option.text = candidate.fullname;

            // Retain the selected candidate after search
            if (candidate.id == selectedCandidateId) {
                option.selected = true;
            }

            candidatesDropdown.appendChild(option);
        });
    });

    // Trigger change event on page load to set candidates according to selected position
    document.getElementById('position').dispatchEvent(new Event('change'));

</script>
@endsection
