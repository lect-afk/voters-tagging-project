<?php

namespace App\Http\Controllers;

use App\Models\LegislativeDistrict;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class LegislativeDistrictController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $legislative_districts = LegislativeDistrict::with('provinces')->when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%$query%");
        })
        ->paginate(25);

        return view('admin.pages.district.index', compact('legislative_districts'))
            ->with('query', $query);
    }

    public function create()
    {
        $province = Province::all();
        return view('admin.pages.district.create', compact('province'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|exists:province,id',
        ]);

        LegislativeDistrict::create($request->all());
        return redirect()->route('legislative_district.index')->with('success', 'Legislative District created successfully.');
    }

    public function show(LegislativeDistrict $legislativeDistrict)
    {
        return view('admin.pages.district.show', compact('legislativeDistrict'));
    }

    public function edit(LegislativeDistrict $legislativeDistrict)
    {
        $province = Province::all();
        return view('admin.pages.district.edit', compact('legislativeDistrict', 'province'));
    }

    public function update(Request $request, LegislativeDistrict $legislativeDistrict)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|exists:province,id',
        ]);

        $legislativeDistrict->update($request->all());
        return redirect()->route('legislative_district.index')->with('success', 'Legislative District updated successfully.');
    }

    public function destroy(LegislativeDistrict $legislativeDistrict)
    {
        try {
            $legislativeDistrict->delete();
            return redirect()->route('legislative_district.index')->with('success', 'Legislative District deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // 23000 is the SQLSTATE code for integrity constraint violation
                return redirect()->route('legislative_district.index')->with('error', 'Cannot delete Legislative District: it is referenced by other records.');
            }
            return redirect()->route('legislative_district.index')->with('error', 'An unexpected error occurred while trying to delete the Legislative District.');
        }
    }
}

