@foreach ($leaders  as $leader)
    <tr>
        <td>{{ $leader->firstname }} {{ $leader->middlename }} {{ $leader->lastname }}</td>
        <td>{{ $leader->barangays->name }}</td>
        <td>{{ $leader->puroks->name  }}</td>
        <td>{{ $leader->sitios->name }}</td>
        <td>
            <a href="{{ route('voter_profile.manageleader', $leader->id) }}" class="btn btn-primary">Manage</a>
        </td>
    </tr>
@endforeach