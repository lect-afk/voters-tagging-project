@extends('layouts.backend')

@section('content')
    <div class="card dashboard_card">
        <div class="card-header">
            <div class="row mb-3">
                <div class="col d-flex align-items-center justify-content-between">
                    <h5>Voters Profiles</h5>
                    <p class="justify-content-end">Search Results: {{ $voters_profiles->total() }} ({{ $voters_profiles->count() }})</p>
                </div>
                <!-- Add Spinner HTML -->
                <div id="loadingSpinner" class="col-12" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Your PDF is being generated. Please wait and refrain from making any actions until it's finished.
                </div>
            </div>

            @if ($message = Session::get('success') ?? Session::get('error'))
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header {{ Session::get('success') ? 'bg-success' : 'bg-danger' }} text-white">
                            <strong class="mr-auto">{{ Session::get('success') ? 'Success' : 'Error' }}</strong>
                        </div>
                        <div class="toast-body">
                            {{ $message }}
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        $('.toast').toast({ delay: 5000 });
                        $('.toast').toast('show');
                    });
                </script>
            @endif

            <form class="row g-2 mb-3" method="GET" action="{{ route('voters_profile.index') }}" role="search">
                <div class="col-12 col-md-2">
                    <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
                </div>
                <div class="col-12 col-md-2">
                    <select id="leaderFilter" name="leader" class="form-select">
                        <option value="" {{ request('leader') == '' ? 'selected' : '' }}>All</option>
                        <option value="None" {{ request('leader') == 'None' ? 'selected' : '' }}>None Leader</option>
                        <option value="Barangay" {{ request('leader') == 'Barangay' ? 'selected' : '' }}>Barangay Leader</option>
                        <option value="Purok" {{ request('leader') == 'Purok' ? 'selected' : '' }}>Purok Leader</option>
                        <option value="Municipal" {{ request('leader') == 'Municipal' ? 'selected' : '' }}>Municipal Leader</option>
                        <option value="District" {{ request('leader') == 'District' ? 'selected' : '' }}>District Leader</option>
                        <option value="Provincial" {{ request('leader') == 'Provincial' ? 'selected' : '' }}>Provincial Leader</option>
                        <option value="Regional" {{ request('leader') == 'Regional' ? 'selected' : '' }}>Regional Leader</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <select name="barangay" class="form-control">
                        <option value="" {{ request('barangay') == '' ? 'selected' : '' }}>All Barangays</option>
                        @foreach ($barangay as $b)
                            <option value="{{ $b->id }}" {{ request('barangay') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2 d-flex">
                    <button class="button-index w-100" type="submit">
                        <i class="fa-solid fa-magnifying-glass fa-md"></i>
                        <span class="fw-semibold ms-2">Search</span>
                    </button>
                </div>
                <div class="col-12 col-md-2 d-flex">
                    <a href="{{ route('voters_profile.create') }}" class="button-index w-100">
                        <i class="fa-solid fa-circle-plus fa-md"></i>
                        <span class="fw-semibold ms-2">Add</span>
                    </a>
                </div>
                <div class="col-12 col-md-2 d-flex">
                    <a id="pdfDownloadButton" href="{{ route('voters_profile.pdf', request()->all()) }}" class="button-index w-100" data-filename="voters_profiles.pdf">
                        <i class="fa-solid fa-file-pdf fa-md"></i>
                        <span class="fw-semibold ms-2">Download</span>
                    </a>
                </div>
            </form>
        </div>
        <div class="card-body dashboard_card_body">
            <div class="table-responsive">
                <table class="table mt-2 table-light table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID#</th>
                            <th>Alliance Status</th>
                            <th>Full Name</th>
                            <th>Barangay</th>
                            <th>Precinct</th>
                            <th>Leader</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voters_profiles as $voters_profile)
                            @php
                                $backgroundColor = '#6c757d'; 
                                switch ($voters_profile->alliances_status) {
                                    case 'Green':
                                        $backgroundColor = '#0466c8'; 
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
                            <tr>
                                <td class="align-middle">{{ $voters_profile->id }}</td>
                                <td class="align-middle"><div class="rounded-circle" style="width: 30px; height: 30px; background-color: {{ $backgroundColor }};"></div></td>
                                <td class="align-middle">{{ $voters_profile->lastname }} {{ $voters_profile->firstname }} {{ $voters_profile->middlename }}</td>
                                <td class="align-middle">{{ $voters_profile->barangays->name }}</td>
                                <td class="align-middle">
                                    @if ($voters_profile->precincts && $voters_profile->precincts->number)
                                        {{ $voters_profile->precincts->number }}
                                    @else
                                        None
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if ($voters_profile->leader != 'None')
                                        {{ $voters_profile->leader }}
                                    @else
                                        <a class="a_alternate" href="#" data-bs-toggle="modal" data-bs-target="#setLeaderModal{{ $voters_profile->id }}"><b>Set as leader</b></a>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle btn-custom" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('voters_profile.show', $voters_profile->id) }}" class="icon-link" title="Show">
                                                    <i class="fas fa-eye"></i> Show
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('voter_profile.manageleader', $voters_profile->id) }}" class="icon-link" title="Manage Tagging">
                                                    <i class="fas fa-users-gear"></i> Manage Tagging
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('voters_profile.edit', $voters_profile->id) }}" class="icon-link" title="Edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <!-- Trigger the modal with the delete button -->
                                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="{{ $voters_profile->id }}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Set as Leader Modal -->
                            <div class="modal fade" id="setLeaderModal{{ $voters_profile->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="setLeaderModalLabel{{ $voters_profile->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header card-header">
                                            <h1 class="modal-title fs-5" id="setLeaderModalLabel{{ $voters_profile->id }}">Set Voter As Leader</h1>
                                        </div>
                                        <div class="modal-body card-body">
                                            <form action="{{ route('voters_profile.update_leader', $voters_profile->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <div class="form-group mb-4">
                                                    <label for="leader">Select Leader Type</label>
                                                    <select name="leader" id="leader" class="form-control" required>
                                                        <option value="None">None</option>
                                                        <option value="Purok">Purok</option>
                                                        <option value="Barangay">Barangay</option>
                                                        <option value="Cluster">Cluster</option>
                                                        <option value="Municipal">Municipal</option>
                                                        <option value="District">District</option>
                                                        <option value="Provincial">Provincial</option>
                                                        <option value="Regional">Regional</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="button-index" data-bs-dismiss="modal">
                                                        <i class="fa-solid fa-solid fa-ban fa-xl"></i>
                                                        <span class="fw-semibold ms-2">Cancel</span>
                                                    </button>
                                                    <button type="submit" class="button-index">
                                                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                                                        <span class="fw-semibold ms-2">Update</span>
                                                    </button>
                                                </div>
                                            </form>        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mb-5">
                {{ $voters_profiles->appends([
                    'query' => request('query'),
                    'leader' => request('leader'),
                    'barangay' => request('barangay')
                ])->links('admin.pages.partials.pagination') }}
            </div>
        </div>
    </div>

    <!-- Confirmation Modal for Deletion -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this voter profile?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var confirmDeleteModal = document.getElementById('confirmDeleteModal');
            confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var voterId = button.getAttribute('data-id');
                var form = document.getElementById('deleteForm');
                form.action = '/voters_profile/' + voterId;
            });
        });
    </script>

    <script src="{{ asset('js/spinner.js') }}"></script>
@endsection