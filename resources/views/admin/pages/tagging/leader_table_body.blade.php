@foreach ($leaders  as $leader)
    <tr>
        <td>{{ $leader->firstname }} {{ $leader->middlename }} {{ $leader->lastname }}</td>
        <td>{{ $leader->barangays->name }}</td>
        {{-- <td>{{ $leader->puroks->name  }}</td>
        <td>{{ $leader->sitios->name }}</td> --}}
        <td>
            <a class="button-30" href="{{ route('voter_profile.manageleader', $leader->id) }}" class="btn btn-primary">
                <i class="fa-solid fa-user-gear fa-xs"></i>
                <span class="fw-semibold ms-2">MANAGE</span>
            </a>
        </td>
    </tr>
@endforeach