@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Precinct Summary</h1>
        </div>
        <form class="d-flex mb-3 justify-content-between" method="GET" action="{{ route('voters.precinctsummary') }}" role="search">
            <input id="searchInput" name="query" class="form-control me-2" type="search" placeholder="Search..." aria-label="Search" value="{{ request('query') }}">
            <button class="ms-2 button-index" type="submit">
                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                <span class="fw-semibold ms-2">Search</span>
            </button>
        </form>
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
                @foreach($data as $item)
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
@endsection
