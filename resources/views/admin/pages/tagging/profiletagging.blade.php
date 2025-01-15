@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <div class="row mb-3">
            <div class="col d-flex align-items-center justify-content-between">
                <h5>Profile Tagging</h5>
                <p class="justify-content-end">Search Results: {{ $voters_profiles->total() }}</p>
            </div> 
        </div>
        <div id="loadingSpinner" style="display: none;">
            <i class="fas fa-spinner fa-spin"></i> Your PDF is being generated. Please wait and refrain from making any actions until it's finished.
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

        <form class="row g-2 mb-3" method="GET" action="" role="search">
            <div class="col-12 col-md-2">
                <input id="searchInput" name="query" class="form-control" type="search" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
            </div>
            <div class="col-12 col-md-2">
                <select name="barangay" class="form-control" id="barangayDropdown" onchange="this.form.submit()">
                    <option value="" {{ request('barangay') == '' ? 'selected' : '' }}>Select Barangay</option>
                    @foreach ($barangay as $b)
                        <option value="{{ $b->id }}" {{ request('barangay') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2">
                <select name="leader" class="form-control" id="leaderDropdown">
                    <option value="" {{ request('leader') == '' ? 'selected' : '' }}>Select Leader</option>
                    @foreach ($leaders as $leader)
                        <option value="{{ $leader->id }}" {{ request('leader') == $leader->id ? 'selected' : '' }}>{{ $leader->firstname }} {{ $leader->lastname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-1 d-flex">
                <button class="button-index w-100" type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-md"></i>
                    <span class="fw-semibold ms-2">Search</span>
                </button>
            </div>
        </form>

        <div class="col-12 col-md-9 d-flex flex-wrap justify-content-between gap-2">
            <button type="button" class="btn btn-sm buttonAT_blue d-flex align-items-center" onclick="tagProfiles()">
                <i class="fa-solid fa-tag me-1"></i> Tag Selected Profiles
            </button>
        </div>
    </div>
    <div class="card-body dashboard_card_body">
        <form id="taggingForm" method="POST" action="{{ route('voters_profile.tagProfilesToLeader') }}">
            @csrf
            <input type="hidden" name="leader_id" id="leader_id">
            <input type="hidden" name="profile_ids" id="profile_ids">
            <div class="table-responsive">
                <table class="table mt-2 table-light table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Full Name</th>
                            <th>Barangay</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voters_profiles as $profile)
                            <tr>
                                <td class="align-middle">
                                    <input class="form-check-input" type="checkbox" value="{{ $profile->id }}" id="profile{{ $profile->id }}">
                                </td>
                                <td class="align-middle">{{ $profile->lastname }} {{ $profile->firstname }} {{ $profile->middlename }}</td>
                                <td class="align-middle">{{ $profile->barangays->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mb-5">
                {{ $voters_profiles->appends([
                    'query' => request('query'),
                    'leader' => request('leader')
                ])->links('admin.pages.partials.pagination') }}
            </div>
        </form>
    </div>
</div>
<script>
function tagProfiles() {
    let selectedProfiles = [];
    document.querySelectorAll('input[type=checkbox]:checked').forEach((checkbox) => {
        selectedProfiles.push(checkbox.value);
    });
    document.getElementById('profile_ids').value = selectedProfiles.join(',');
    document.getElementById('leader_id').value = document.querySelector('select[name=leader]').value;
    document.getElementById('taggingForm').submit();
}
</script>
@endsection
