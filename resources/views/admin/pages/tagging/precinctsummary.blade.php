@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <div class="row mb-3">
            <div class="col-12">
                <h5>Precinct Summary</h5>
            </div>
            <!-- Add Spinner HTML -->
            <div id="loadingSpinner" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i> Your PDF is being generated. Please wait and refrain from making any actions until it's finished.
            </div>  
        </div>

        <form class="row g-2 mb-3" method="GET" action="{{ route('voters.precinctsummary') }}" role="search">
            <div class="col-12 col-md-8">
                <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search..." aria-label="Search" value="{{ request('query') }}">
            </div>
            <div class="col-12 col-md-2">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
            <div class="col-12 col-md-2 d-flex">
                <a id="pdfDownloadButton" href="{{ route('precinctsummary.pdf', request()->all()) }}" class="button-index w-100" data-filename="precinct_summary.pdf">
                    <i class="fa-solid fa-file-pdf fa-md"></i>
                    <span class="fw-semibold ms-2">Download</span>
                </a>
            </div>
        </form>
    </div>
    <div class="card-body dashboard_card_body">
        <div class="table-responsive">
            <table class="table mt-2 table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Precinct</th>
                        <th>Barangay</th>
                        <th>Total</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($precincts as $item)
                        <tr>
                            <td>{{ $item['precinct'] }}</td>
                            <td>{{ $item['barangay'] }}</td>
                            <td>{{ $item['totalLeadersAndDownline'] }} / {{ $item['total'] }}</td>
                            <td class="{{ $item['percentage'] < 50 ? 'text-danger' : '' }}">
                                {{ number_format($item['percentage'], 1) }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mb-5">
            {{ $precincts->appends(['query' => request('query')])->links('admin.pages.partials.pagination') }}
        </div>
    </div>
</div>
<script src="{{ asset('js/spinner.js') }}"></script>
@endsection
