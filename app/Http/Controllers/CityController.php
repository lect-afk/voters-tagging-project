<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\LegislativeDistrict;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $cities = City::with(['districts', 'provinces'])->when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%$query%");
        })
        ->paginate(50);

        return view('admin.pages.city.index', compact('cities'))
            ->with('query', $query);
    }

    public function create()
    {
        $district = LegislativeDistrict::all();
        $province = Province::all();
        return view('admin.pages.city.create', compact('district', 'province'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district' => 'required|exists:legislative_district,id',
            'province' => 'required|exists:province,id',
        ]);

        City::create($request->all());
        return redirect()->route('city.index')->with('success', 'City created successfully.');
    }

    public function show(City $city)
    {
        return view('admin.pages.city.show', compact('city'));
    }

    public function edit(City $city)
    {
        $district = LegislativeDistrict::all();
        $province = Province::all();
        return view('admin.pages.city.edit', compact('city', 'district', 'province'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district' => 'required|exists:legislative_district,id',
            'province' => 'required|exists:province,id',
        ]);

        $city->update($request->all());
        return redirect()->route('city.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        try {
            $city->delete();
            return redirect()->route('city.index')->with('success', 'City deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // 23000 is the SQLSTATE code for integrity constraint violation
                return redirect()->route('city.index')->with('error', 'Cannot delete City: it is referenced by other records.');
            }
            return redirect()->route('city.index')->with('error', 'An unexpected error occurred while trying to delete the City.');
        }
    }

    public function getDistrict4City($provinceID)
    {
        $district = LegislativeDistrict::where('province', $provinceID)->get();
        return response()->json($district);
    }
}

