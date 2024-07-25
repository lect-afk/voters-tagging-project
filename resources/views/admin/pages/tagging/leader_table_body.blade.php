@foreach ($leaders  as $leader)
    <tr>
        <td>{{ $leader->firstname }} {{ $leader->middlename }} {{ $leader->lastname }}</td>
        <td>{{ $leader->barangays->name }}</td>
        {{-- <td>{{ $leader->puroks->name  }}</td>
        <td>{{ $leader->sitios->name }}</td> --}}
        <td>
            <a class="icon-link" href="{{ route('voter_profile.manageleader', $leader->id) }}" title="Manage Subordinate">
                <i class="fa-solid fa-user-gear"></i>
            </a>
            <a class="icon-link" href="{{ route('voter_profile.viewhierarchy', $leader->id) }}" title="View Hierarchy">
                <i class="fa-solid fa-users-viewfinder"></i>
            </a>
        </td>
    </tr>
@endforeach