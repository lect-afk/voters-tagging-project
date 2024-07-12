@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Left Side Content -->
            <div class="col-md-6">
                <h1>Show Voter Profile</h1>
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
                <a href="{{ route('voters_profile.index') }}" class="btn btn-primary mt-2">Back</a>
            </div>
            <!-- Right Side Content -->
            <div class="col-md-6">
                <h2>Voters Tagging Path</h2>
                <div class="form-group">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          {{-- @foreach ($allvoters as $allvoters)
                            <li class="breadcrumb-item"><a href="#">{{ $allvoters->predecessors->firstname }}</a></li>
                          @endforeach
                          <li class="breadcrumb-item"><a href="#">{{ $votersProfile->firstname }}</a></li> --}}
                          @foreach ($voterspath as $voterspath)
                            <li class="breadcrumb-item"><a href="{{ route('voters_profile.show', $voterspath->predecessors) }}">{{ $voterspath->predecessors->firstname }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('voters_profile.show', $voterspath->successors) }}">{{ $voterspath->successors->firstname }}</a></li>
                          @endforeach
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
