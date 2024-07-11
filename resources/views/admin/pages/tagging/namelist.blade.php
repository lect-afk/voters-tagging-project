@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>List Of Leaders</h1>

        {{-- <div>
            <form class="d-flex" role="search">
                <input id="searchInput" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            </form>
        </div> --}}
        <form class="d-flex" role="search">
            <input id="searchInput" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <select id="leaderFilter" class="form-select">
                <option selected disabled>Select</option>
                <option value="None">None</option>
                <option value="Barangay">Barangay</option>
                <option value="Municipal">Municipal</option>
                <option value="District">District</option>
                <option value="Provincial">Provincial</option>
                <option value="Regional">Regional</option>
            </select>
        </form>
        
        <table class="table mt-2">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Barangay</th>
                    <th>Purok</th>
                    <th>Sitio</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="leader-table-body">
                @include('admin.pages.tagging.leader_table_body', ['leaders' => $leaders])
            </tbody>
        </table>
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
