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
        $voters_profile = VotersProfile::with(['sitios', 'puroks', 'barangays', 'precincts'])->get();
        return view('admin.pages.votersProfile.index', compact('voters_profile'));
    }

    public function create()
    {
        $sitio = Sitio::all();
        $purok = Purok::all();
        $barangay = Barangay::all();
        $precinct = Precinct::all();
        return view('admin.pages.votersProfile.create', compact('sitio', 'purok', 'barangay', 'precinct'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'middlename' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'sitio' => 'required|exists:sitio,id',
            'purok' => 'required|exists:purok,id',
            'barangay' => 'required|exists:barangay,id',
            'precinct' => 'required|exists:precinct,id',
            'leader' => 'required|in:None,Barangay,Municipal,District,Provincial,Regional',
        ]);

        VotersProfile::create($request->all());
        return redirect()->route('voters_profile.index')->with('success', 'Voters Profile created successfully.');
    }

    public function show(VotersProfile $votersProfile)
    {
        return view('admin.pages.votersProfile.show', compact('votersProfile'));
    }

    public function edit(VotersProfile $votersProfile)
    {
        $sitio = Sitio::all();
        $purok = Purok::all();
        $barangay = Barangay::all();
        $precinct = Precinct::all();
        return view('admin.pages.votersProfile.edit', compact('votersProfile', 'sitio', 'purok', 'barangay', 'precinct'));
    }

    public function update(Request $request, VotersProfile $votersProfile)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'middlename' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'sitio' => 'required|exists:sitio,id',
            'purok' => 'required|exists:purok,id',
            'barangay' => 'required|exists:barangay,id',
            'precinct' => 'required|exists:precinct,id',
            'leader' => 'required|in:None,Barangay,Municipal,District,Provincial,Regional',
        ]);

        $votersProfile->update($request->all());
        return redirect()->route('voters_profile.index')->with('success', 'Voters Profile updated successfully.');
    }

    public function destroy(VotersProfile $votersProfile)
    {
        $votersProfile->delete();
        return redirect()->route('voters_profile.index')->with('success', 'Voters Profile deleted successfully.');
    }

    public function namelist(Request $request)
    {
        $leaders = VotersProfile::all();

        return view('admin.pages.tagging.namelist', compact('leaders'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $leader = $request->input('leader', 'Barangay'); // Default to 'Barangay' if not provided

        $leaders = VotersProfile::where(function($queryBuilder) use ($leader) {
            $queryBuilder->where('leader', $leader);
        })
        ->where(function($queryBuilder) use ($query) {
            $queryBuilder->where('firstname', 'like', "%$query%")
                        ->orWhere('lastname', 'like', "%$query%");
        })
        ->get();

        return view('admin.pages.tagging.leader_table_body', compact('leaders'))->render();
    }

    public function manageleader(VotersProfile $manageleader)
    {
        $successors = Tagging::with(['predecessors', 'successors'])
        ->where('predecessor', '=', $manageleader->id)->get();
        $subordinates = VotersProfile::where('id', '!=', $manageleader->id)
        ->where('barangay', '=', $manageleader->barangay)->get();
        return view('admin.pages.partials.addsubordinate', compact('manageleader','subordinates','successors'));
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




}


