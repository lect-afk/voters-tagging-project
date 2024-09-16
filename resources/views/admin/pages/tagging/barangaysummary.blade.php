@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="row mb-3">
            <div class="col-12">
                <h1>Barangay Summary</h1>
            </div>
            <!-- Add Spinner HTML -->
            <div id="loadingSpinner" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i> Your PDF is being generated. Please wait and refrain from making any actions until it's finished.
            </div>       
        </div>

        <form class="row g-2 mb-3" method="GET" action="{{ route('voters.barangaysummary') }}" role="search">
            <div class="col-12 col-md-8">
                <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search..." aria-label="Search" value="{{ request('query') }}">
            </div>
            <div class="col-12 col-md-2">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
            <div class="col-12 col-md-2">
                <a id="pdfDownloadButton" href="{{ route('barangaysummary.pdf', request()->all()) }}" class="button-index w-100" data-filename="barangay_summary.pdf">
                    <i class="fa-solid fa-file-pdf fa-md"></i>
                    <span class="fw-semibold ms-2">Download</span>
                </a>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table mt-2 table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Barangay</th>
                        <th>Barangay Leader</th>
                        <th>Purok Leader</th>
                        <th>Down Line</th>
                        <th>Total</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangays as $item)
                        <tr>
                            <td>{{ $item['barangay'] }}</td>
                            <td>{{ $item['barangayLeaders'] }}</td>
                            <td>{{ $item['purokLeaders'] }}</td>
                            <td>{{ $item['downLine'] }}</td>
                            <td>{{ $item['totalLeadersAndDownline'] }} / {{ $item['total'] }}</td>
                            <td class="{{ $item['percentage'] < 50 ? 'text-danger' : '' }}">
                                {{ number_format($item['percentage'], 1) }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $barangays->appends(['query' => request('query')])->links('admin.pages.partials.pagination') }}
        </div>
    </div>
    <script src="{{ asset('js/spinner.js') }}"></script>
@endsection
