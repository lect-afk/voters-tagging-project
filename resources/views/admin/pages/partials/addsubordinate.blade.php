@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('voter_profile.namelist') }}" class="text-decoration-none leader_link">
                                <i class="fa-solid fa-arrow-turn-up fa-rotate-270 fa-lg"></i>
                                <span class="fw-semibold ms-2">Back</span> 
                            </a>
                        </h5>
                        <span class="fw-semibold">Leaders</span> 
                        <div class="mt-3">
                            @foreach ($leaders as $leader)
                                <a class="d-block leader_link" style="text-decoration: none;" href="{{ route('voter_profile.manageleader', $leader->id) }}">{{ $leader->firstname }} {{ $leader->middlename }} {{ $leader->lastname }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h1>{{ $manageleader->firstname }} {{ $manageleader->middlename }} {{ $manageleader->lastname }}</h1>
                <form class="d-flex" role="search">
                    <input id="searchInput" class="form-control me-2 w-25" type="search" placeholder="Search" aria-label="Search">
                </form>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-2">
                        <p>{{ $message }}</p>
                    </div>
                @elseif ($message = Session::get('error'))
                    <div class="alert alert-danger mt-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            @foreach ($successors as $successor)
                                @php
                                    $backgroundColor = '#6c757d';

                                    switch ($successor->successors->alliances_status) {
                                        case 'Green':
                                            $backgroundColor = '#70e000';
                                            break;
                                        case 'Yellow':
                                            $backgroundColor = '#ffd60a';
                                            break;
                                        case 'Orange':
                                            $backgroundColor = '#fb8500';
                                            break;
                                        case 'Red':
                                            $backgroundColor = '#d00000';
                                            break;
                                    }
                                @endphp
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <div class="rounded-circle" style="width: 30px; height: 30px; background-color: {{ $backgroundColor }};"></div>
                                            <div class="text-center flex-grow-1">
                                                <h5 class="card-title mb-0 ">Precinct No.</h5>
                                                <h6 class="card-subtitle mb-0 fw-semibold">{{ $successor->successors->precincts->number }}</h6>
                                            </div>
                                            <form action="{{ route('successor.destroy', $successor->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-close" aria-label="Remove"></button>
                                            </form>
                                        </div>
                                        <div class="card-body">
                                            <h4>{{ $successor->successors->firstname }} {{ $successor->successors->middlename }} {{ $successor->successors->lastname }}</h4>
                                            <a href="{{ route('voter_profile.manageleader', $successor->successor) }}" class="text-decoration-none leader_link">
                                                <i class="fa-solid fa-people-arrows fa-lg"></i>
                                                <span class="fw-semibold ms-2">Manage Subordinates</span> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-4 mb-4">
                                <form action="{{ route('storeSubordinate') }}" method="POST" class="d-flex flex-column align-items-center h-100">
                                    @csrf
                                    <div class="me-3 align-self-start">
                                        <label for="choose_subordinate" class="form-label fw-semibold">Choose subordinate:</label>
                                        <select name="successor" class="form-select" id="choose_subordinate">
                                            <option disabled selected value="">Select</option>
                                            @foreach ($subordinates as $subordinate)
                                                <option value="{{ $subordinate->id }}">{{ $subordinate->firstname }} {{ $subordinate->middlename }} {{ $subordinate->lastname }}</option>
                                            @endforeach
                                        </select>

                                        <input hidden type="text" name="predecessor" class="form-control" required value="{{ $manageleader->id }}">
                                        <input hidden type="text" name="tier_level" class="form-control" required value="1">
                                        <input hidden type="text" name="team" class="form-control" required value="Sample">
                                    </div>
                                    <div class="align-self-start mt-2">
                                        <button type="submit" class="button-index">
                                            <i class="fa-solid fa-square-plus fa-sm"></i>
                                            <span class="fw-semibold ms-2">Add Subordinate</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-3">
                    {{ $successors->links('admin.pages.partials.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
