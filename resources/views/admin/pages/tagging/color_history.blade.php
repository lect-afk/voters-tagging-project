@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <h5>Color History</h5>
            </div> 
        </div>
        <!-- Add Spinner HTML -->
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
    

        
    
        <div class="col-12 col-md-9">
            <select class="form-select" onchange="updateRemarks(this.value)">
                <option selected disabled value="">Select Remarks</option>
                <option value="None">None</option>
                <option value="Candidate Behavior and Scandals">Candidate Behavior and Scandals</option>
                <option value="Policy Changes">Policy Changes</option>
                <option value="Social Issues">Social Issues</option>
                <option value="Party Allegiance and Identity">Party Allegiance and Identity</option>
                <option value="Media Influence">Media Influence</option>
                <option value="Endorsements and Alliances">Endorsements and Alliances</option>
                <option value="Campaign Effectiveness">Campaign Effectiveness</option>
                <option value="Personal Experience">Personal Experience</option>
                <option value="Strategic Voting">Strategic Voting</option>
                <option value="Financial Incentives">Financial Incentives</option>
                <option value="Promises of Personal Gain">Promises of Personal Gain</option>
                <option value="Threats and Coercion">Threats and Coercion</option>
                <option value="Development Projects and Local Investments">Development Projects and Local Investments</option>
            </select>
        </div>
    </div>
    <div class="card-body dashboard_card_body">
        <form id="colorHistoryForm" method="POST" action="{{ route('colorhistory.updateRemarks') }}">
            @csrf
            <input type="hidden" name="remarks" id="remarks">
            <div class="table-responsive">
                <table class="table mt-2 table-light table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Full Name</th>
                            <th>Brgy / Precinct</th>
                            <th>Alliance Changes</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($color_histories as $color_history)
                            @php
                                // Determine the font color for old_tag
                                $oldFontColor = '#6c757d'; 
                                switch ($color_history->old_tag) {
                                    case 'Green':
                                        $oldFontColor = '#0466c8'; 
                                        break;
                                    case 'Yellow':
                                        $oldFontColor = '#ffd60a'; 
                                        break;
                                    case 'Orange':
                                        $oldFontColor = '#99582a'; 
                                        break;
                                    case 'Red':
                                        $oldFontColor = '#d00000'; 
                                        break;
                                    case 'White':
                                        $oldFontColor = '#e0fbfc'; 
                                        break;
                                    case 'Black':
                                        $oldFontColor = '#353535'; 
                                        break;
                                }
                    
                                // Determine the font color for new_tag
                                $newFontColor = '#6c757d'; 
                                switch ($color_history->new_tag) {
                                    case 'Green':
                                        $newFontColor = '#0466c8'; 
                                        break;
                                    case 'Yellow':
                                        $newFontColor = '#ffd60a'; 
                                        break;
                                    case 'Orange':
                                        $newFontColor = '#99582a'; 
                                        break;
                                    case 'Red':
                                        $newFontColor = '#d00000'; 
                                        break;
                                    case 'White':
                                        $newFontColor = '#e0fbfc'; 
                                        break;
                                    case 'Black':
                                        $newFontColor = '#353535'; 
                                        break;
                                }

                                // Determine the Alliance status for old_tag
                                $oldAllianceStatus = 'Non-participant'; 
                                    switch ($color_history->old_tag) {
                                        case 'Green':
                                            $oldAllianceStatus = 'Allied'; 
                                            break;
                                        case 'Yellow':
                                            $oldAllianceStatus = 'Prospective Ally'; 
                                            break;
                                        case 'Orange':
                                            $oldAllianceStatus = 'Unlikely Ally'; 
                                            break;
                                        case 'Red':
                                            $oldAllianceStatus = 'Non-supporter'; 
                                            break;
                                        case 'White':
                                            $oldAllianceStatus = 'Unilateral'; 
                                            break;
                                        case 'Black':
                                            $oldAllianceStatus = 'Unidentified'; 
                                            break;
                                    }
                        
                                // Determine the Alliance status for new_tag
                                $newAllianceStatus = 'Non-participant'; 
                                    switch ($color_history->new_tag) {
                                        case 'Green':
                                            $newAllianceStatus = 'Allied'; 
                                            break;
                                        case 'Yellow':
                                            $newAllianceStatus = 'Prospective Ally'; 
                                            break;
                                        case 'Orange':
                                            $newAllianceStatus = 'Unlikely Ally'; 
                                            break;
                                        case 'Red':
                                            $newAllianceStatus = 'Non-supporter'; 
                                            break;
                                        case 'White':
                                            $newAllianceStatus = 'Unilateral'; 
                                            break;
                                        case 'Black':
                                            $newAllianceStatus = 'Unidentified'; 
                                            break;
                                    }
                            @endphp
                            <tr>
                                <td class="align-middle">
                                    <input class="form-check-input" type="checkbox" name="selected_profiles[]" value="{{ $color_history->id }}">
                                </td>
                                <td class="align-middle">{{ $color_history->profile->lastname }} {{ $color_history->profile->firstname }} {{ $color_history->profile->middlename }}</td>
                                <td class="align-middle">{{ $color_history->profile->barangays->name }} / {{ $color_history->profile->precincts->number }}</td>
                                <td class="align-middle">
                                    <span style="color: {{ $oldFontColor }};">{{ $oldAllianceStatus }}</span>
                                    <i class="fa-solid fa-right-long fa-sm"></i> 
                                    <span style="color: {{ $newFontColor }};">{{ $newAllianceStatus }}</span>
                                </td>
                                <td class="align-middle">{{ $color_history->created_at }}</td>
                                <td class="align-middle">{{ $color_history->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>                    
                </table>
            </div>
            <div class="d-flex justify-content-center mb-5">
                
            </div>
                    
        </form>
    </div>
</div>
<script>
    function updateRemarks(status) {
        document.getElementById('remarks').value = status;
        document.getElementById('colorHistoryForm').submit();
    }
</script>
<script src="{{ asset('js/spinner.js') }}"></script>
@endsection
