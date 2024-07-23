<?php

namespace App\Http\Controllers;

use App\Models\VotersProfile;
use App\Models\Sitio;
use App\Models\Purok;
use App\Models\Barangay;
use App\Models\Precinct;
use App\Models\Tagging;
use Illuminate\Http\Request;

class VotersProfileController extends Controller
{
    public function index()
    {
        $voters_profiles = VotersProfile::with(['sitios', 'puroks', 'barangays', 'precincts'])->paginate(50);
        return view('admin.pages.votersProfile.index', compact('voters_profiles'));
    }

    public function create()
    {
        $sitio = Sitio::all();
        $purok = Purok::all();
        $barangay = Barangay::all();
        $precinct = Precinct::all();
        return view('admin.pages.votersProfile.create', compact('sitio', 'purok', 'barangay', 'precinct'));
    }

    public function getPurok($barangayID)
    {
        $purok = Purok::where('barangay', $barangayID)->get();
        return response()->json($purok);
    }

    public function getSitio($purokID)
    {
        $sitio = Sitio::where('purok', $purokID)->get();
        return response()->json($sitio);
    }

    public function getPrecinct($barangayID)
    {
        $precinct = Precinct::where('barangay', $barangayID)->get();
        return response()->json($precinct);
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            // 'middlename' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            // 'sitio' => 'required|exists:sitio,id',
            // 'purok' => 'required|exists:purok,id',
            // 'barangay' => 'required|exists:barangay,id',
            // 'precinct' => 'required|exists:precinct,id',
            'leader' => 'required|in:None,Purok,Barangay,Municipal,District,Provincial,Regional',
            'alliances_status' => 'required|in:None,Green,Yellow,Orange,Red',
        ]);

        VotersProfile::create($request->all());
        return redirect()->route('voters_profile.index')->with('success', 'Voters Profile created successfully.');
    }

    // Function to get hierarchy path
    public function getHierarchyPath($votersProfileId)
    {
        $path = [];
        $this->fetchPredecessors($votersProfileId, $path);
        return array_reverse($path);
    }

    // Recursive function to fetch predecessors
    private function fetchPredecessors($successorId, &$path)
    {
        $votersPath = Tagging::with(['predecessors', 'successors'])
            ->where('successor', '=', $successorId)
            ->first();

        if ($votersPath) {
            $path[] = $votersPath;
            if ($votersPath->predecessor) {
                $this->fetchPredecessors($votersPath->predecessors->id, $path);
            }
        }
    }

    // public function show(VotersProfile $id)
    // {
    //     // $voterspath = Tagging::with(['predecessors', 'successors'])
    //     // ->where('successor', '=', $votersProfile->id)->get();
    //     // $taggings = Tagging::all();
    //     $votersProfile = VotersProfile::find($id);
    //     $hierarchyPath = $this->getHierarchyPath($votersProfile->id);
    //     return view('admin.pages.votersProfile.show', compact('votersProfile','hierarchyPath'));
    // }
    public function show(VotersProfile $votersProfile)
    {
        $hierarchyPath = $this->getHierarchyPath($votersProfile->id);
        return view('admin.pages.votersProfile.show', compact('votersProfile', 'hierarchyPath'));
    }

    public function edit(VotersProfile $votersProfile)
    {
        // $sitio = Sitio::all();
        // $purok = Purok::all();
        $barangay = Barangay::all();
        $purok = Purok::where('barangay', $votersProfile->barangay)->get();
        $sitio = Sitio::where('purok', $votersProfile->purok)->get();
        $precinct = Precinct::all();
        return view('admin.pages.votersProfile.edit', compact('votersProfile', 'sitio', 'purok', 'barangay', 'precinct'));
    }

    public function update(Request $request, VotersProfile $votersProfile)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            // 'middlename' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            // 'sitio' => 'required|exists:sitio,id',
            // 'purok' => 'required|exists:purok,id',
            'barangay' => 'required|exists:barangay,id',
            // 'precinct' => 'required|exists:precinct,id',
            'leader' => 'required|in:None,Purok,Barangay,Municipal,District,Provincial,Regional',
            'alliances_status' => 'required|in:None,Green,Yellow,Orange,Red',
        ]);

        $votersProfile->update($request->all());
        return redirect()->route('voters_profile.index')->with('success', 'Voters Profile updated successfully.');
    }

    public function updateLeader(Request $request, VotersProfile $votersProfile)
    {
        $request->validate([
            'leader' => 'required|in:None,Purok,Barangay,Municipal,District,Provincial,Regional',
        ]);

        $votersProfile->update([
            'leader' => $request->leader,
        ]);

        return redirect()->route('voters_profile.index')->with('success', 'Leader updated successfully.');
    }


    public function destroy(VotersProfile $votersProfile)
    {
        $votersProfile->delete();
        return redirect()->route('voters_profile.index')->with('success', 'Voters Profile deleted successfully.');
    }

    public function namelist(Request $request)
    {
        $leaders = VotersProfile::where('leader', '=', 'Barangay')->paginate(50);

        return view('admin.pages.tagging.namelist', compact('leaders'));
    }

    public function leadersearch(Request $request)
    {
        $query = $request->input('query');
        $leader = $request->input('leader', 'Barangay');

        $leaders = VotersProfile::where(function($queryBuilder) use ($leader) {
            if (!empty($leader)) {
                $queryBuilder->where('leader', $leader);
            }
        })
        ->where(function($queryBuilder) use ($query) {
            $queryBuilder->where('firstname', 'like', "%$query%")
                        ->orWhere('lastname', 'like', "%$query%");
        })
        ->get();

        return view('admin.pages.tagging.leader_table_body', compact('leaders'))->render();

    }

    public function votersearch(Request $request)
    {
        $query = $request->input('query');
        $voters_profiles = VotersProfile::with(['sitios', 'puroks', 'barangays', 'precincts'])->where('firstname', 'like', "%$query%")
        ->orWhere('lastname', 'like', "%$query%")->get();

        return view('admin.pages.votersProfile.voter_table_body', compact('voters_profiles'))->render();

    }

    public function manageleader(VotersProfile $manageleader)
    {
        $leaders = VotersProfile::all();
        $successors = Tagging::with(['predecessors', 'successors'])
        ->where('predecessor', '=', $manageleader->id)->paginate(47);
        $subordinates = VotersProfile::where('id', '!=', $manageleader->id)
        ->where('barangay', '=', $manageleader->barangay)->get();
        return view('admin.pages.partials.addsubordinate', compact('manageleader','subordinates','successors','leaders'));
    }

    public function storeSubordinate(Request $request)
    {
        $request->validate([
            'successor' => 'required|exists:voters_profile,id',
            'predecessor' => 'required|exists:voters_profile,id',
            'tier_level' => 'required|integer',
            'team' => 'required|string',
        ]);

        // Check if the combination of successor and predecessor already exists
            $exists = Tagging::where('successor', $request->successor)
            ->where('predecessor', $request->predecessor)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This subordinate relationship already exists.');
        }

        Tagging::create($request->all());

        return redirect()->back()->with('success', 'Subordinate added successfully.');
    }

    // public function searchSuccessors(Request $request, VotersProfile $manageleader)
    // {
    //     try {
    //         $query = $request->get('query');
    //         $successors = Tagging::with(['predecessors', 'successors'])
    //             ->where('predecessor', '=', $manageleader->id)
    //             ->whereHas('successors', function($q) use ($query) {
    //                 $q->where('firstname', 'LIKE', "%{$query}%")
    //                 ->orWhere('middlename', 'LIKE', "%{$query}%")
    //                 ->orWhere('lastname', 'LIKE', "%{$query}%");
    //             })
    //             ->paginate(47);

    //         return response()->json($successors);
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching successors: ' . $e->getMessage());
    //         return response()->json(['error' => 'Internal Server Error'], 500);
    //     }
    // }
    
    public function successorDestroy($id)
    {
        // Get the successor record to delete
        $successor = Tagging::find($id);

        if (!$successor) {
            return redirect()->back()->with('error', 'Successor not found.');
        }

        // Check if successor value exists as predecessor in other records
        $conflictingPredecessors = Tagging::where('predecessor', $successor->successor)
                                          ->where('id', '!=', $successor->id)
                                          ->exists();

        if ($conflictingPredecessors) {
            return redirect()->back()->with('error', 'Cannot delete successor because it is used as a predecessor in another record.');
        }

        // If no conflict, proceed with deletion
        $successor->delete();
        return redirect()->back()->with('success', 'Successor removed successfully.');
    }


}


