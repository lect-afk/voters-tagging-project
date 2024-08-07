<?php
namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class BarangayController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $barangays = Barangay::with('cities')->when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%$query%");
        })
        ->paginate(25);

        return view('admin.pages.barangay.index', compact('barangays'))
            ->with('query', $query);
    }

    public function create()
    {
        $city = City::all();
        return view('admin.pages.barangay.create', compact('city'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|exists:city,id',
        ]);

        Barangay::create($request->all());
        return redirect()->route('barangay.index')->with('success', 'Barangay created successfully.');
    }

    public function show(Barangay $barangay)
    {
        return view('admin.pages.barangay.show', compact('barangay'));
    }

    public function edit(Barangay $barangay)
    {
        $city = City::all();
        return view('admin.pages.barangay.edit', compact('barangay', 'city'));
    }

    public function update(Request $request, Barangay $barangay)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|exists:city,id',
        ]);

        $barangay->update($request->all());
        return redirect()->route('barangay.index')->with('success', 'Barangay updated successfully.');
    }

    public function destroy(Barangay $barangay)
    {
        try {
            $barangay->delete();
            return redirect()->route('barangay.index')->with('success', 'Barangay deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // 23000 is the SQLSTATE code for integrity constraint violation
                return redirect()->route('barangay.index')->with('error', 'Cannot delete Barangay: it is referenced by other records.');
            }
            return redirect()->route('barangay.index')->with('error', 'An unexpected error occurred while trying to delete the Barangay.');
        }
    }
}


