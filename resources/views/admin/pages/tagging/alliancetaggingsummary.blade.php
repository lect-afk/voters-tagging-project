@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <div class="row mb-3 align-items-center">
            <div class="col-12 col-md-6">
                <h5>Alliance Tagging Summary</h5>
            </div>
            <!-- Add Spinner HTML -->
            <div id="loadingSpinner" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i> Your PDF is being generated. Please wait and refrain from making any actions until it's finished.
            </div> 
            <div class="col-12 col-md-6 text-md-end">
                @php
                    $totalAllied = 0;
                    $totalVotes = 0;
                    foreach ($barangay as $item) {
                        $totalAllied += $item['allied'];
                        $totalVotes += $item['total'];
                    }
                    $totalPercentage = ($totalAllied / $totalVotes) * 100;
                @endphp
                <h4>
                    Total Allied: {{ $totalAllied }} out of {{ $totalVotes }} 
                    <span class="{{ $totalPercentage < 50 ? 'text-danger' : '' }}">
                        ({{ number_format($totalPercentage, 1) }}%)
                    </span>
                </h4>
            </div>
        </div>

        <form class="row g-2 mb-3" method="GET" action="{{ route('voters.alliancetaggingsummary') }}" role="search">
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
                <a id="pdfDownloadButton" href="{{ route('alliancetaggingsummary.pdf', request()->all()) }}" class="button-index w-100" data-filename="alliance_tagging_summary.pdf">
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
                        <th>Barangay</th>
                        <th>Allies</th>
                        <th>Prospective Ally</th>
                        <th>Tentative Ally</th>
                        <th>Non-Participant</th>
                        <th>Non-Supporter</th>
                        <th>Unilateral</th>
                        <th>Unidentified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangay as $item)
                        @php
                            $percentage = ($item['allied'] / $item['total']) * 100;
                        @endphp
                        <tr>
                            <td>{{ $item['barangay'] }}</td>
                            <td style="background-color: #0466c84D" class="{{ $percentage < $item['nonsupporter'] ? 'text-danger' : '' }}">
                                {{ $item['allied'] }} / {{ $item['total'] }} 
                                ({{ number_format($percentage, 1) }}%)
                            </td>
                            <td style="background-color: #ffd60a4D">{{ $item['prospectiveally'] }} / {{ $item['total'] }}
                                ({{ number_format(($item['prospectiveally'] / $item['total']) * 100, 1) }}%)</td>
                            <td style="background-color: #99582a80">{{ $item['unlikelyally'] }} / {{ $item['total'] }}
                                ({{ number_format(($item['unlikelyally'] / $item['total']) * 100, 1) }}%)</td>
                            <td style="background-color: #6c757dCC">
                                {{ $item['nonparticipant'] }} / {{ $item['total'] }}
                                ({{ number_format(($item['nonparticipant'] / $item['total']) * 100, 1) }}%)
                            </td>
                            <td style="background-color: #d0000080">
                                {{ $item['nonsupporter'] }} / {{ $item['total'] }}
                                ({{ number_format(($item['nonsupporter'] / $item['total']) * 100, 1) }}%)
                            </td>
                            <td style="background-color: #e0fbfc4D">
                                {{ $item['inc'] }} / {{ $item['total'] }}
                                ({{ number_format(($item['inc'] / $item['total']) * 100, 1) }}%)
                            </td>
                            <td style="background-color: #353535; color: #FCFCFD;">
                                {{ $item['unidentified'] }} / {{ $item['total'] }}
                                ({{ number_format(($item['unidentified'] / $item['total']) * 100, 1) }}%)
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mb-5">
            {{ $barangay->appends(['query' => request('query')])->links('admin.pages.partials.pagination') }}
        </div>
    </div>
</div>
<script src="{{ asset('js/spinner.js') }}"></script>
@endsection
