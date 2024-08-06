@foreach ($leaders  as $leader)
    <tr>
        <td class="align-middle">{{ $leader->firstname }} {{ $leader->middlename }} {{ $leader->lastname }}</td>
        <td class="align-middle">{{ $leader->barangays->name }}</td>
        {{-- <td>{{ $leader->puroks->name  }}</td>
        <td>{{ $leader->sitios->name }}</td> --}}
        <td class="align-middle">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a class="dropdown-item" href="{{ route('voter_profile.manageleader', $leader->id) }}">
                            <i class="fa-solid fa-user-gear"></i> Manage Subordinate
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('voter_profile.viewhierarchy', $leader->id) }}">
                            <i class="fa-solid fa-users-viewfinder"></i> View Hierarchy
                        </a>
                    </li>
                </ul>
            </div>
        </td>        
    </tr>
@endforeach