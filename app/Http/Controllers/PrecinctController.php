<?php

namespace App\Http\Controllers;

use App\Models\Precinct;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PrecinctController extends Controller
{
    public function index()
    {
        $precinct = Precinct::with('barangays')->get();
        return view('admin.pages.precinct.index', compact('precinct'));
    }

    public function create()
    {
        $barangay = Barangay::all();
        return view('admin.pages.precinct.create', compact('barangay'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|string|max:255',
            'barangay' => 'required|exists:barangay,id',
        ]);

        Precinct::create($request->all());
        return redirect()->route('precinct.index')->with('success', 'Precinct created successfully.');
    }

    public function show(Precinct $precinct)
    {
        return view('admin.pages.precinct.show', compact('precinct'));
    }

    public function edit(Precinct $precinct)
    {
        $barangay = Barangay::all();
        return view('admin.pages.precinct.edit', compact('precinct', 'barangay'));
    }

    public function update(Request $request, Precinct $precinct)
    {
        $request->validate([
            'number' => 'required|string|max:255',
            'barangay' => 'required|exists:barangay,id',
        ]);

        $precinct->update($request->all());
        return redirect()->route('precinct.index')->with('success', 'Precinct updated successfully.');
    }

    public function destroy(Precinct $precinct)
    {
        try {
            $precinct->delete();
            return redirect()->route('precinct.index')->with('success', 'Precinct deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // 23000 is the SQLSTATE code for integrity constraint violation
                return redirect()->route('precinct.index')->with('error', 'Cannot delete Precinct: it is referenced by other records.');
            }
            return redirect()->route('precinct.index')->with('error', 'An unexpected error occurred while trying to delete the Precinct.');
        }
    }
}


