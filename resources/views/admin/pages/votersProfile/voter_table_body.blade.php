@foreach ($voters_profiles as $voters_profile)
    @php
        $backgroundColor = '#6c757d'; 
        switch ($voters_profile->alliances_status) {
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
    <tr>
        <td class="align-middle"><div class="rounded-circle" style="width: 30px; height: 30px; background-color: {{ $backgroundColor }};"></div></td>
        <td class="align-middle">{{ $voters_profile->firstname }} {{ $voters_profile->middlename }} {{ $voters_profile->lastname }}</td>
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
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <form action="{{ route('voters_profile.destroy', $voters_profile->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="dropdown-item" type="submit" class="icon-link" title="Delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
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
