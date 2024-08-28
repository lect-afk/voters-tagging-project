@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="row mb-3">
            <div class="col-12">
                <h1>Alliance Tagging Summary</h1>
            </div>
        </div>

        <form class="row g-2 mb-3" method="GET" action="{{ route('voters.precinctsummary') }}" role="search">
            <div class="col-12 col-md-10">
                <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search..." aria-label="Search" value="{{ request('query') }}">
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
                        <th>Barangay</th>
                        <th>Allied</th>
                        <th>Hard Core</th>
                        <th>Undecided</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($precincts as $item)
                        <tr>
                            <td>{{ $item['precinct'] }}</td>
                            <td>{{ $item['barangay'] }}</td>
                            <td class="{{ $item['allied'] < 50 ? 'text-danger' : '' }}">
                                {{ $item['allied'] }} / {{ $item['total'] }} 
                                ({{ number_format(($item['allied'] / $item['total']) * 100, 1) }}%)
                            </td>
                            <td>
                                {{ $item['hardcore'] }} / {{ $item['total'] }}
                                ({{ number_format(($item['hardcore'] / $item['total']) * 100, 1) }}%)
                            </td>
                            <td>
                                {{ $item['undecided'] }} / {{ $item['total'] }}
                                ({{ number_format(($item['undecided'] / $item['total']) * 100, 1) }}%)
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $precincts->appends(['query' => request('query')])->links('admin.pages.partials.pagination') }}
        </div>
    </div>
    
@endsection
