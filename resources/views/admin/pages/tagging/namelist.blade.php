@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>List Of Leaders</h1>
        </div>
        {{-- <div>
            <form class="d-flex" role="search">
                <input id="searchInput" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            </form>
        </div> --}}
        <form class="d-flex" role="search">
            <input id="searchInput" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <select id="leaderFilter" class="form-select">
                {{-- <option selected disabled>Filter by</option> --}}
                <option selected value="Barangay">Barangay Leader</option>
                <option value="Purok">Purok Leader</option>
                <option value="Municipal">Municipal Leader</option>
                <option value="District">District Leader</option>
                <option value="Provincial">Provincial Leader</option>
                <option value="Regional">Regional Leader</option>
            </select>
        </form>
        
        <table class="table mt-2 table-light table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Full Name</th>
                    <th>Barangay</th>
                    {{-- <th>Purok</th>
                    <th>Sitio</th> --}}
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            <tbody class="leader-table-body">
                @include('admin.pages.tagging.leader_table_body', ['leaders' => $leaders])
            </tbody>
        </table>
    </div>
    <div class="pt-3">
        {{ $leaders->links('admin.pages.partials.pagination') }}
    </div>
<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchInput, #leaderFilter').on('input change', function() {
            var query = $('#searchInput').val();
            var leader = $('#leaderFilter').val();
            console.log('Search query:', query); // Debugging
            $.ajax({
                url: '{{ route("leaders.search") }}',
                type: 'GET',
                data: { query: query, leader: leader },
                success: function(response) {
                    $('.leader-table-body').html(response);
                }
            });
        });
    });
</script>


@endsection
