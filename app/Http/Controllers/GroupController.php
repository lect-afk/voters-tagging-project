<?php

namespace App\Http\Controllers;

use App\Models\Group;
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
use App\Models\Candidate;
use App\Models\GroupTagging;
use Illuminate\Support\Facades\DB;
use PDF;
use setasign\Fpdi\Fpdi;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $groups = Group::when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%$query%");
        })
        ->paginate(25);

        return view('admin.pages.group.index', compact('groups'))
            ->with('query', $query);
    }

    public function create()
    {
        return view('admin.pages.group.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Group::create($request->all());
        return redirect()->route('group.index')->with('success', 'Group created successfully.');
    }

    public function show(Group $group)
    {
        return view('admin.pages.group.show', compact('group'));
    }

    public function edit(Group $group)
    {
        return view('admin.pages.group.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $group->update($request->all());
        return redirect()->route('group.index')->with('success', 'Group updated successfully.');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('group.index')->with('success', 'Group deleted successfully.');
    }

    public function grouptagging(Request $request)
    {
        $precinct = Precinct::all();
        $groups = Group::all();
        $barangay = Barangay::all();
        $query = $request->input('query');
        $barangayId = $request->input('barangay');
        $precinctId = $request->input('precinct');
        

        $group_taggings = VotersProfile::with(['sitios', 'puroks', 'barangays', 'precincts', 'groupTaggings.group', 'groupTaggings.group.groupTaggings'])
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

        return view('admin.pages.tagging.grouptaggings', compact('group_taggings', 'precinct','barangay','groups'))
            ->with('precinctId', $precinctId)
            ->with('query', $query)
            ->with('barangayId', $barangayId);
    }

    public function connectvoterGroup(Request $request)
    {
        $request->validate([
            'group' => 'required|exists:group,id',
            'selected_profiles' => 'required|array',
            'selected_profiles.*' => 'exists:voters_profile,id',
        ]);

        $groupId = $request->group;

        $existingGroupTaggings = GroupTagging::whereIn('profile_id', $request->selected_profiles)
            ->where('group_id', $groupId)
            ->pluck('profile_id')
            ->toArray();

        $profilesToUpdate = array_intersect($request->selected_profiles, $existingGroupTaggings);
        $profilesToCreate = array_diff($request->selected_profiles, $existingGroupTaggings);

        foreach ($profilesToUpdate as $profileId) {
            GroupTagging::where('profile_id', $profileId)->where('group_id', $groupId)->update([
                'color_tag' => null // You can set a specific color tag if needed
            ]);
        }

        foreach ($profilesToCreate as $profileId) {
            GroupTagging::create([
                'profile_id' => $profileId,
                'group_id' => $groupId,
                'color_tag' => null // You can set a specific color tag if needed
            ]);
        }

        return redirect()->back()->with('success', 'Group Tagging successfully updated.');
    }
}
