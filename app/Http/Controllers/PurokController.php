<?php
namespace App\Http\Controllers;

use App\Models\Purok;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PurokController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $puroks = Purok::when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%$query%");
        })
        ->paginate(25);

        return view('admin.pages.purok.index', compact('puroks'))
            ->with('query', $query);
    }

    public function create()
    {
        $barangay = Barangay::all();
        return view('admin.pages.purok.create',compact('barangay'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'barangay' => 'required|exists:barangay,id',
        ]);

        Purok::create($request->all());
        return redirect()->route('purok.index')->with('success', 'Purok created successfully.');
    }

    public function show(Purok $purok)
    {
        return view('admin.pages.purok.show', compact('purok'));
    }

    public function edit(Purok $purok)
    {
        $barangay = Barangay::all();
        return view('admin.pages.purok.edit', compact('purok','barangay'));
    }

    public function update(Request $request, Purok $purok)
    {
        $request->validate([
            'name' => 'required',
            'barangay' => 'required|exists:barangay,id',
        ]);

        $purok->update($request->all());
        return redirect()->route('purok.index')->with('success', 'Purok updated successfully.');
    }

    public function destroy(Purok $purok)
    {
        try {
            $purok->delete();
            return redirect()->route('purok.index')->with('success', 'Purok deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // 23000 is the SQLSTATE code for integrity constraint violation
                return redirect()->route('purok.index')->with('error', 'Cannot delete Purok: it is referenced by other records.');
            }
            return redirect()->route('purok.index')->with('error', 'An unexpected error occurred while trying to delete the Purok.');
        }
    }
}

