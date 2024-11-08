@extends('layouts.backend')

@section('content')
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 order-md-1 order-2">
                <div class="card dashboard_card">
                    <div class="card-body dashboard_card_body">
                        <h5 class="card-title">
                            <span class="fw-semibold">Subordinates Navigation</span>
                        </h5>
                        <div class="mt-3">
                            @foreach ($previousSubordinates as $subordinate)
                                <a class="d-block leader_link" style="text-decoration: none;" href="{{ route('voter_profile.manageleader', $subordinate['id']) }}">
                                    {{ $subordinate['firstname'] }} {{ $subordinate['middlename'] }} {{ $subordinate['lastname'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 order-md-2 order-1">
                
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
                <div class="card dashboard_card">
                    <div class="card-body dashboard_card_body">
                        <h1 class="mb-4">{{ $manageleader->firstname }} {{ $manageleader->middlename }} {{ $manageleader->lastname }}'s subordinates</h1>
                        <div class="row">
                            @foreach ($successors as $successor)
                                @php
                                    $backgroundColor = '#6c757d';

                                    switch ($successor->successors->alliances_status) {
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
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <div class="rounded-circle" style="width: 30px; height: 30px; background-color: {{ $backgroundColor }};"></div>
                                            <div class="text-center flex-grow-1">
                                                <h5 class="card-title mb-0 ">Precinct No.</h5>
                                                <h6 class="card-subtitle mb-0 fw-semibold">{{ $successor->successors->precincts->number ?? 'None' }}</h6>
                                            </div>
                                            <form action="{{ route('successor.destroy', $successor->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-close" aria-label="Remove"></button>
                                            </form>
                                        </div>
                                        <div class="card-body">
                                            <h4>{{ $successor->successors->firstname }} {{ $successor->successors->middlename }} {{ $successor->successors->lastname }}</h4>
                                            <a href="{{ route('voter_profile.manageleader', $successor->successor) }}" class="text-decoration-none leader_link">
                                                <i class="fa-solid fa-people-arrows fa-lg"></i>
                                                <span class="fw-semibold ms-2">Manage Subordinates</span> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-4 mb-4">
                                <form action="{{ route('storeSubordinate') }}" method="POST" class="d-flex flex-column align-items-center h-100">
                                    @csrf
                                    <div class="me-3 align-self-start">
                                        <label for="choose_subordinate_autocomplete" class="form-label fw-semibold">Choose subordinate:</label>
                                        <input type="text" id="choose_subordinate_autocomplete" class="form-control">
                                        <select name="successor" class="form-select d-none" id="choose_subordinate">
                                            <option disabled selected value="">Select</option>
                                            @foreach ($subordinates as $subordinate)
                                                <option value="{{ $subordinate->id }}">{{ $subordinate->firstname }} {{ $subordinate->middlename }} {{ $subordinate->lastname }}</option>
                                            @endforeach
                                        </select>
                            
                                        <input hidden type="text" name="predecessor" class="form-control" required value="{{ $manageleader->id }}">
                                        <input hidden type="text" name="tier_level" class="form-control" required value="1">
                                        <input hidden type="text" name="team" class="form-control" required value="Sample">
                                    </div>
                                    <div class="choose_subordinate align-self-start mt-2">
                                        <button type="submit" class="button-index">
                                            <i class="fa-solid fa-square-plus fa-sm"></i>
                                            <span class="fw-semibold ms-2">Add Subordinate</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-3">
                    {{ $successors->links('admin.pages.partials.pagination') }}
                </div>
            </div>
        </div>

    <script>
        $(document).ready(function() {
            var subordinates = [];
            $('#choose_subordinate option').each(function() {
                if ($(this).val()) {
                    subordinates.push({
                        label: $(this).text(),
                        value: $(this).val()
                    });
                }
            });
        
            $('#choose_subordinate_autocomplete').autocomplete({
                source: subordinates,
                select: function(event, ui) {
                    $('#choose_subordinate').val(ui.item.value);
                    $('#choose_subordinate_autocomplete').val(ui.item.label);
                    return false; // Prevents the default behavior of setting the value
                }
            });
        });
    </script>    
@endsection
