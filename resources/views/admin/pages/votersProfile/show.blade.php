@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        <!-- Left Side Content -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Voters Profile Details</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <strong>Firstname:</strong>
                        {{ $votersProfile->firstname }}
                    </div>
                    <div class="form-group">
                        <strong>Middlename:</strong>
                        {{ $votersProfile->middlename }}
                    </div>
                    <div class="form-group">
                        <strong>Lastname:</strong>
                        {{ $votersProfile->lastname }}
                    </div>
                    <div class="form-group">
                        <strong>Sitio:</strong>
                        {{ $votersProfile->sitios->name }}
                    </div>
                    <div class="form-group">
                        <strong>Purok:</strong>
                        {{ $votersProfile->puroks->name }}
                    </div>
                    <div class="form-group">
                        <strong>Barangay:</strong>
                        {{ $votersProfile->barangays->name }}
                    </div>
                    <div class="form-group">
                        <strong>Precinct:</strong>
                        {{ $votersProfile->precincts->number }}
                    </div>
                    <div class="form-group">
                        <strong>Leader:</strong>
                        {{ $votersProfile->leader }}
                    </div>
                    <div class="mt-2">
                        <a class="button-index" href="{{ route('voters_profile.index') }}">
                            <i class="fa-solid fa-arrow-turn-down fa-rotate-90 fa-xl"></i>
                              <span class="fw-semibold ms-2">Return to the List</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Side Content -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Voters Tagging Path</h2>
                </div>
                <div class="card-body">
                    @foreach ($hierarchyPath as $tagging)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a class="predecessor_link" href="{{ route('voters_profile.show', $tagging->predecessors->id) }}">
                                    {{ $tagging->predecessors->firstname }} {{ $tagging->predecessors->middlename }} {{ $tagging->predecessors->lastname }}
                                </a>
                            </h5>
                            <p class="card-text">
                                Precinct: {{ $tagging->predecessors->precincts->number }} |
                                Barangay: {{ $tagging->predecessors->barangays->name }}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <i style="color: #e94f37;" class="fa-solid fa-down-long fa-xl"></i>
                    </div>
                    @endforeach
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $votersProfile->firstname }} {{ $votersProfile->middlename }} {{ $votersProfile->lastname }}</h5>
                            <p class="card-text">
                                Sitio: {{ $votersProfile->sitios->name }} |
                                Purok: {{ $votersProfile->puroks->name }} |
                                Barangay: {{ $votersProfile->barangays->name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
