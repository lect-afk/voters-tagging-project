<?php

namespace App\Http\Controllers;

use App\Models\VotersProfile;
use App\Models\Sitio;
use App\Models\Purok;
use App\Models\Barangay;
use App\Models\Precinct;
use App\Models\Tagging;
use App\Models\Candidate;
use Illuminate\Http\Request;

class VotersProfileController extends Controller
{
    public function index(Request $request)
    {
        $barangay = Barangay::all();
        $query = $request->input('query');
        $leader = $request->input('leader');
        $barangayId = $request->input('barangay');

        $voters_profiles = VotersProfile::with(['sitios', 'puroks', 'barangays', 'precincts'])
            ->when($leader, function($queryBuilder) use ($leader) {
                return $queryBuilder->where('leader', $leader);
            })
            ->when($query, function($queryBuilder) use ($query) {
                return $queryBuilder->where(function($queryBuilder) use ($query) {
                    $queryBuilder->where('firstname', 'like', "%$query%")
                                ->orWhere('lastname', 'like', "%$query%");
                });
            })
            ->when($barangayId, function($queryBuilder) use ($barangayId) {
                return $queryBuilder->where('barangay', $barangayId);
            })
            ->paginate(25);

        return view('admin.pages.votersProfile.index', compact('voters_profiles', 'barangay'))
            ->with('query', $query)
            ->with('leader', $leader)
            ->with('barangayId', $barangayId);
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
            'middlename' => 'nullable|string|max:50',
            'lastname' => 'required|string|max:50',
            'sitio' => 'nullable|exists:sitio,id',
            'purok' => 'nullable|exists:purok,id',
            'barangay' => 'required|exists:barangay,id',
            'precinct' => 'nullable|exists:precinct,id',
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
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:50',
            'sitio' => 'nullable|exists:sitio,id',
            'purok' => 'nullable|exists:purok,id',
            'barangay' => 'required|exists:barangay,id',
            'precinct' => 'nullable|exists:precinct,id',
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
        $leaders = VotersProfile::where('leader', '=', 'Barangay')->paginate(25);

        return view('admin.pages.tagging.namelist', compact('leaders'));
    }

    public function leadersearch(Request $request)
    {
        $query = $request->input('query');
        $leader = $request->input('leader', 'Barangay');

        $leaders = VotersProfile::when($leader, function($queryBuilder) use ($leader) {
                return $queryBuilder->where('leader', $leader);
            })
            ->when($query, function($queryBuilder) use ($query) {
                return $queryBuilder->where(function($queryBuilder) use ($query) {
                    $queryBuilder->where('firstname', 'like', "%$query%")
                                ->orWhere('lastname', 'like', "%$query%");
                });
            })
            ->paginate(25);

        return view('admin.pages.tagging.namelist', compact('leaders'))
            ->with('query', $query)
            ->with('leader', $leader);
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
        $leaders = VotersProfile::where('barangay', '=', $manageleader->barangay)->paginate(25);
        
        // Get successors (current leader's subordinates)
        $successors = Tagging::with(['predecessors', 'successors'])
            ->where('predecessor', '=', $manageleader->id)
            ->paginate(47);
        
        // Get subordinates for dropdown
        $subordinates = VotersProfile::where('id', '!=', $manageleader->id)
            ->where('barangay', '=', $manageleader->barangay)
            ->get();

        // Get subordinates of previous leaders
        $previousSubordinates = [];
        $currentLeader = $manageleader;
        while ($currentLeader) {
            $previousLeader = Tagging::with('predecessors')
                ->where('successor', $currentLeader->id)
                ->first();
            if ($previousLeader) {
                $subordinatesOfPrevious = Tagging::with('successors')
                    ->where('predecessor', $previousLeader->predecessors->id)
                    ->get()
                    ->pluck('successors');
                $previousSubordinates = array_merge($previousSubordinates, $subordinatesOfPrevious->toArray());
                $currentLeader = $previousLeader->predecessors;
            } else {
                break;
            }
        }

        return view('admin.pages.partials.addsubordinate', compact('manageleader', 'subordinates', 'successors', 'leaders', 'previousSubordinates'));
    }


    // public function viewhierarchy(VotersProfile $viewhierarchy)
    // {
    //     $leaders = VotersProfile::all();
    //     $successors = Tagging::with(['predecessors', 'successors'])
    //     ->where('predecessor', '=', $viewhierarchy->id)->paginate(47);
    //     $subordinates = VotersProfile::where('id', '!=', $viewhierarchy->id)
    //     ->where('barangay', '=', $viewhierarchy->barangay)->get();
    //     return view('admin.pages.tagging.hierarchy', compact('viewhierarchy','subordinates','successors','leaders'));
    // }

    public function viewhierarchy(VotersProfile $viewhierarchy)
    {
        $hierarchy = $this->buildhierarchy($viewhierarchy);

        return view('admin.pages.tagging.hierarchy', compact('hierarchy'));
    }

    private function buildhierarchy($voter)
    {

        // Initialize $hierarchy to avoid undefined variable issues
        $hierarchy = [
            'name' => $voter->firstname . ' ' . $voter->middlename . ' ' . $voter->lastname,
            'purok' => $voter->puroks->name ?? 'N/A',
            'precinct' => $voter->precincts->number ?? 'N/A',
            'alliance_status' => $voter->alliances_status,
            'leader_type' => $voter->leader,
            'children' => []
        ];

        if ($voter->leader == 'Barangay') {
            $hierarchy = [
                'name' => $voter->firstname . ' ' . $voter->middlename . ' ' . $voter->lastname,
                'precinct' => $voter->precincts->number ?? 'No Precinct',
                'alliance_status' => $voter->alliances_status,
                'leader_type' => $voter->leader,
                'children' => []
            ];
        } elseif($voter->leader == 'Purok') {
            $hierarchy = [
                'name' => $voter->firstname . ' ' . $voter->middlename . ' ' . $voter->lastname,
                'precinct' => $voter->puroks->name ?? 'No Purok',
                'alliance_status' => $voter->alliances_status,
                'leader_type' => $voter->leader,
                'children' => []
            ];
        }

        $successors = Tagging::with('successors')
            ->where('predecessor', $voter->id)
            ->get();

        foreach ($successors as $tag) {
            if ($tag->successors) {
                $hierarchy['children'][] = $this->buildhierarchy($tag->successors);
            }
        }

        return $hierarchy;
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
        
        // Check if the successor is already a successor in the tagging table
        $isAlreadySuccessor = Tagging::where('successor', $request->successor)->exists();

        if ($isAlreadySuccessor) {
            return redirect()->back()->with('error', 'This person has been tagged under [existing predecessor]');
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

    public function barangaysummary(Request $request)
    {
        // Get all barangays
        $query = $request->input('query');

        $barangays = Barangay::when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%$query%");
        })
        ->paginate(25);

        $barangays->getCollection()->transform(function($barangay) {
            // Count Barangay Leaders
            $barangayLeadersCount = VotersProfile::where('barangay', $barangay->id)
                ->where('leader', 'Barangay')
                ->count();

            // Count Purok Leaders
            $purokLeadersCount = VotersProfile::where('barangay', $barangay->id)
                ->where('leader', 'Purok')
                ->count();

            // Get all predecessors for the barangay
            $predecessors = Tagging::whereHas('predecessors', function($query) use ($barangay) {
                $query->where('barangay', $barangay->id)
                    ->where('leader', 'None');
            })->pluck('predecessor')->toArray();

            // Get all successors for the barangay
            $successors = Tagging::whereHas('successors', function($query) use ($barangay) {
                $query->where('barangay', $barangay->id)
                    ->where('leader', 'None');
            })->pluck('successor')->toArray();

            // Combine predecessors and successors and remove duplicates
            $downLine = array_unique(array_merge($predecessors, $successors));
            $downLineCount = count($downLine);

            // Count Total Voters
            $totalVotersCount = VotersProfile::where('barangay', $barangay->id)->count();
            $totalLeadersAndDownline = $barangayLeadersCount + $purokLeadersCount + $downLineCount;

            // Calculate the percentage
            $percentage = $totalVotersCount > 0 ? ($totalLeadersAndDownline / $totalVotersCount) * 100 : 0;

            return [
                'barangay' => $barangay->name,
                'barangayLeaders' => $barangayLeadersCount,
                'purokLeaders' => $purokLeadersCount,
                'downLine' => $downLineCount,
                'totalLeadersAndDownline' => $totalLeadersAndDownline,
                'total' => $totalVotersCount,
                'percentage' => $percentage,
            ];
        });

        return view('admin.pages.tagging.barangaysummary', compact('barangays'))->with('query', $query);
    }



    public function precinctsummary(Request $request)
    {
        // Get all precincts
        $query = $request->input('query');

        $precincts = Precinct::with('barangays')->when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('number', 'like', "%$query%");
        })
        ->paginate(25);
        
        $precincts->getCollection()->transform(function($precinct) {
            // Count Barangay Leaders
            $barangayLeadersCount = VotersProfile::where('precinct', $precinct->id)
                ->where('leader', 'Barangay')
                ->count();

            // Count Purok Leaders
            $purokLeadersCount = VotersProfile::where('precinct', $precinct->id)
                ->where('leader', 'Purok')
                ->count();

            // Get all predecessors for the precinct
            $predecessors = Tagging::whereHas('predecessors', function($query) use ($precinct) {
                $query->where('precinct', $precinct->id)
                      ->where('leader', 'None');
            })->pluck('predecessor')->toArray();

            // Get all successors for the precinct
            $successors = Tagging::whereHas('successors', function($query) use ($precinct) {
                $query->where('precinct', $precinct->id)
                      ->where('leader', 'None');
            })->pluck('successor')->toArray();

            // Combine predecessors and successors and remove duplicates
            $downLine = array_unique(array_merge($predecessors, $successors));
            $downLineCount = count($downLine);

            // Count Total Voters
            $totalVotersCount = VotersProfile::where('precinct', $precinct->id)->count();

            // Calculate the total of barangay leaders, purok leaders, and downline members
            $totalLeadersAndDownline = $barangayLeadersCount + $purokLeadersCount + $downLineCount;

            // Calculate the percentage
            $percentage = $totalVotersCount > 0 ? ($totalLeadersAndDownline / $totalVotersCount) * 100 : 0;

            return [
                'precinct' => $precinct->number,
                'barangay' => $precinct->barangays->name,
                'totalLeadersAndDownline' => $totalLeadersAndDownline,
                'total' => $totalVotersCount,
                'percentage' => $percentage,
            ];
        });

        return view('admin.pages.tagging.precinctsummary', compact('precincts'))->with('query', $query);
    }


    public function votecomparison(Request $request)
{
    $candidates = Candidate::all();
    $barangay = Barangay::all();

    $position = $request->input('position');
    $candidate_id = $request->input('candidate_id');
    $barangay_id = $request->input('barangay');

    // Check if any filter is applied
    $filtersApplied = $position || $candidate_id || $barangay_id;

    $precincts = collect(); // Start with an empty collection

    if ($filtersApplied) {
        $precincts = Precinct::with(['barangays', 'votes'])
            ->when($candidate_id, function($query) use ($candidate_id) {
                return $query->whereHas('votes', function($voteQuery) use ($candidate_id) {
                    $voteQuery->where('candidate_id', $candidate_id);
                });
            })
            ->when($barangay_id, function($query) use ($barangay_id) {
                return $query->where('barangay', $barangay_id);
            })
            ->paginate(25);

        $precincts->getCollection()->transform(function($precinct) {
            $barangayLeadersCount = VotersProfile::where('precinct', $precinct->id)
                ->where('leader', 'Barangay')
                ->count();

            $purokLeadersCount = VotersProfile::where('precinct', $precinct->id)
                ->where('leader', 'Purok')
                ->count();

            $predecessors = Tagging::whereHas('predecessors', function($query) use ($precinct) {
                $query->where('precinct', $precinct->id)
                    ->where('leader', 'None');
            })->pluck('predecessor')->toArray();

            $successors = Tagging::whereHas('successors', function($query) use ($precinct) {
                $query->where('precinct', $precinct->id)
                    ->where('leader', 'None');
            })->pluck('successor')->toArray();

            $downLine = array_unique(array_merge($predecessors, $successors));
            $downLineCount = count($downLine);

            $totalVotersCount = VotersProfile::where('precinct', $precinct->id)->count();

            $totalLeadersAndDownline = $barangayLeadersCount + $purokLeadersCount + $downLineCount;

            $actualVotes = $precinct->votes->sum('actual_votes');

            $comparison = $totalLeadersAndDownline - $actualVotes;

            return [
                'precinct' => $precinct->number,
                'barangay' => $precinct->barangays->name,
                'totalLeadersAndDownline' => $totalLeadersAndDownline,
                'actualVotes' => $actualVotes,
                'comparison' => $comparison,
            ];
        });
    }

    return view('admin.pages.election.votecomparison.index', compact('precincts', 'barangay', 'candidates'))
        ->with('position', $position)
        ->with('candidate_id', $candidate_id)
        ->with('barangay_id', $barangay_id);
}




}


