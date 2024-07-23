@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Voters Profiles</h1>
            <a href="{{ route('voters_profile.create') }}" class="button-index">
                <i class="fa-solid fa-circle-plus fa-xl"></i>
                <span class="fw-semibold ms-2">Add</span>
            </a>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @elseif ($message = Session::get('error'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @endif

        <form class="d-flex" role="search">
            <input id="searchInput" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        </form>
        <table class="table mt-2 table-light table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Alliance Status</th>
                    <th>Full Name</th>
                    <th>Barangay</th>
                    <th>Precinct</th>
                    <th>Leader</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            <tbody class="voter-table-body">
                @include('admin.pages.votersProfile.voter_table_body')
            </tbody>
        </table>
    </div>
    <div class="pt-3">
        {{ $voters_profiles->links('admin.pages.partials.pagination') }}
    </div>



<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            var query = $(this).val().toLowerCase();
            $.ajax({
                url: '{{ route("voters.search") }}',
                type: 'GET',
                data: { query: query },
                success: function(response) {
                    // Update table rows with filtered results
                    $('.voter-table-body').html(response);
                }
            });
        });
    });
</script>
@endsection
