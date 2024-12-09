<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\LegislativeDistrict;
use App\Models\Province;
use App\Models\VotersProfile;
use App\Models\Sitio;
use App\Models\Purok;
use App\Models\Barangay;
use App\Models\Precinct;
use App\Models\Tagging;
use App\Models\Event;
use App\Models\ColorHistory;
use App\Models\CandidateTagging;
use Illuminate\Support\Facades\DB;
use PDF;
use setasign\Fpdi\Fpdi;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        
        $candidates = Candidate::with(['cities', 'districts', 'provinces', 'votes'])
            ->when($query, function($queryBuilder) use ($query) {
                return $queryBuilder->where(function($queryBuilder) use ($query) {
                    $queryBuilder->where('fullname', 'like', "%$query%");
                });
            })
            ->paginate(25);

        return view('admin.pages.election.candidates.index', compact('candidates'));
    }

    public function create()
    {
        $district = LegislativeDistrict::all();
        $province = Province::all();
        $city = City::all();
        return view('admin.pages.election.candidates.create', compact('district','province','city'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|max:50',
            'position' => 'nullable|in:Councilor,Vice-Mayor,Mayor,Board Member,Congressman,Vice-Governor,Governor',
            'city' => 'nullable|exists:city,id',
            'district' => 'nullable|exists:legislative_district,id',
            'province' => 'nullable|exists:province,id',
        ]);

        Candidate::create($request->all());

        return redirect()->route('candidates.index')->with('success', 'Candidate created successfully.');
    }

    public function show(Candidate $candidate)
    {
        return view('admin.pages.election.candidates.show', compact('candidate'));
    }

    public function edit(Candidate $candidate)
    {
        $district = LegislativeDistrict::all();
        $province = Province::all();
        $city = City::all();
        return view('admin.pages.election.candidates.edit', compact('candidate','district','province','city'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'fullname' => 'required|max:50',
            'position' => 'nullable|in:Councilor,Vice-Mayor,Mayor,Board Member,Congressman,Vice-Governor,Governor',
            'city' => 'nullable|exists:city,id',
            'district' => 'nullable|exists:legislative_district,id',
            'province' => 'nullable|exists:province,id',
        ]);

        $candidate->update($request->all());

        return redirect()->route('candidates.index')->with('success', 'Candidate updated successfully.');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('candidates.index')->with('success', 'Candidate deleted successfully.');
    }

    public function getDistrict($provinceID)
    {
        $district = LegislativeDistrict::where('province', $provinceID)->get();
        return response()->json($district);
    }

    public function getCity($districtID)
    {
        $city = City::where('district', $districtID)->get();
        return response()->json($city);
    }

    public function candidatetagging(Request $request)
    {
        $precinct = Precinct::all();
        $candidate = Candidate::all();
        $barangay = Barangay::all();
        $query = $request->input('query');
        $barangayId = $request->input('barangay');
        $precinctId = $request->input('precinct');

        $candidate_taggings = VotersProfile::with(['sitios', 'puroks', 'barangays', 'precincts', 'candidateTaggings.candidate'])
        ->when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->whereHas('profile', function($queryBuilder) use ($query) {
                $queryBuilder->where('firstname', 'like', "%$query%")
                    ->orWhere('middlename', 'like', "%$query%")
                    ->orWhere('lastname', 'like', "%$query%")
                    ->orWhere(DB::raw("CONCAT(firstname, ' ', middlename, ' ', lastname)"), 'like', "%$query%")
                    ->orWhere(DB::raw("CONCAT(firstname, ' ', middlename)"), 'like', "%$query%")
                    ->orWhere(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', "%$query%");
            });
        })
        ->when($barangayId, function($queryBuilder) use ($barangayId) {
            return $queryBuilder->where('barangay', $barangayId);
        })
        ->when($precinctId, function($queryBuilder) use ($precinctId) {
            return $queryBuilder->where('precinct', $precinctId);
        })
        ->orderBy('lastname', 'asc')
        ->orderBy('id', 'asc')
        ->paginate(50);

        return view('admin.pages.tagging.candidatetaggings', compact('candidate_taggings', 'precinct','barangay','candidate'))
            ->with('precinctId', $precinctId)
            ->with('query', $query)
            ->with('barangayId', $barangayId);
    }

    public function updatevoterCandidate(Request $request)
    {
        $request->validate([
            'candidate' => 'required|exists:candidates,id',
            'selected_profiles' => 'required|array',
            'selected_profiles.*' => 'exists:voters_profile,id',
        ]);

        $candidateId = $request->candidate;

        // Fetch the candidate's position
        $candidate = Candidate::find($candidateId);
        $candidatePosition = $candidate->position;

        // Fetch the selected profiles
        $selectedProfiles = VotersProfile::whereIn('id', $request->selected_profiles)->get();

        foreach ($selectedProfiles as $votersProfile) {
            // Check if there is an existing CandidateTagging for the profile with the same position
            $existingTagging = CandidateTagging::where('profile_id', $votersProfile->id)
                ->whereHas('candidate', function ($query) use ($candidatePosition) {
                    $query->where('position', $candidatePosition);
                })
                ->first();

            if ($existingTagging) {
                // Update the existing CandidateTagging
                $existingTagging->update([
                    'candidate_id' => $candidateId,
                    'color_tag' => $votersProfile->alliances_status
                ]);
            } else {
                // Create a new CandidateTagging
                CandidateTagging::create([
                    'profile_id' => $votersProfile->id,
                    'candidate_id' => $candidateId,
                    'color_tag' => $votersProfile->alliances_status
                ]);
            }
        }

        return redirect()->back()->with('success', 'Candidate Tagging successfully updated.');
    }



}
