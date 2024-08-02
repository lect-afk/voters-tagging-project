<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\LegislativeDistrict;
use App\Models\Province;

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
            ->paginate(50);

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

}
