<?php
namespace App\Http\Controllers;

use App\Models\Sitio;
use App\Models\Barangay;
use App\Models\Purok;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class SitioController extends Controller
{
    public function index()
    {
        $sitios = Sitio::paginate(50);
        return view('admin.pages.sitio.index', compact('sitios'));
    }

    public function create()
    {
        $purok = Purok::all();
        $barangay = Barangay::all();
        return view('admin.pages.sitio.create', compact('barangay','purok'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'barangay' => 'required|exists:barangay,id',
            'purok' => 'required|exists:purok,id',
        ]);

        Sitio::create($request->all());
        return redirect()->route('sitio.index')->with('success', 'Sitio created successfully.');
    }

    public function show(Sitio $sitio)
    {
        return view('admin.pages.sitio.show', compact('sitio'));
    }

    public function edit(Sitio $sitio)
    {
        $barangay = Barangay::all();
        $purok = Purok::all();
        return view('admin.pages.sitio.edit', compact('sitio','barangay','purok'));
    }

    public function update(Request $request, Sitio $sitio)
    {
        $request->validate([
            'name' => 'required',
            'barangay' => 'required|exists:barangay,id',
            'purok' => 'required|exists:purok,id',
        ]);

        $sitio->update($request->all());
        return redirect()->route('sitio.index')->with('success', 'Sitio updated successfully.');
    }

    public function destroy(Sitio $sitio)
    {
        try {
            $sitio->delete();
            return redirect()->route('sitio.index')->with('success', 'Sitio deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // 23000 is the SQLSTATE code for integrity constraint violation
                return redirect()->route('sitio.index')->with('error', 'Cannot delete Sitio: it is referenced by other records.');
            }
            return redirect()->route('purok.index')->with('error', 'An unexpected error occurred while trying to delete the Sitio.');
        }
    }
}

