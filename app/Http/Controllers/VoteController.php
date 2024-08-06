<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Candidate;
use App\Models\Precinct;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index(Request $request)
    {
        // $getPrecinct = Vote::with(['candidates', 'precincts'])->get();

        $query = $request->input('query');
        
        $votes = Vote::with(['candidates', 'precincts'])
            ->when($query, function($queryBuilder) use ($query) {
                return $queryBuilder->whereHas('precincts', function($precinctQuery) use ($query) {
                    $precinctQuery->where('number', 'like', "%$query%");
                });
            })
            ->paginate(50);
        return view('admin.pages.election.votes.index', compact('votes'));
    }

    public function create()
    {
        $candidates = Candidate::all();
        $precincts = Precinct::all();
        return view('admin.pages.election.votes.create', compact('candidates', 'precincts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'actual_votes' => 'required|integer',
            'precinct' => 'required|exists:precinct,id',
        ]);

        Vote::create($request->all());

        return redirect()->route('votes.index')->with('success', 'Vote created successfully.');
    }

    public function show(Vote $vote)
    {
        return view('admin.pages.election.votes.show', compact('vote'));
    }

    public function edit(Vote $vote)
    {
        $candidates = Candidate::all();
        $precincts = Precinct::all();
        return view('admin.pages.election.votes.edit', compact('vote', 'candidates', 'precincts'));
    }

    public function update(Request $request, Vote $vote)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'actual_votes' => 'required|integer',
            'precinct' => 'required|exists:precinct,id',
        ]);

        $vote->update($request->all());

        return redirect()->route('votes.index')->with('success', 'Vote updated successfully.');
    }

    public function destroy(Vote $vote)
    {
        $vote->delete();
        return redirect()->route('votes.index')->with('success', 'Vote deleted successfully.');
    }
    
}
