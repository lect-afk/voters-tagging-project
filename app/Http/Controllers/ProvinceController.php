<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $provinces = Province::when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%$query%");
        })
        ->paginate(50);

        return view('admin.pages.province.index', compact('provinces'))
            ->with('query', $query);
    }

    public function create()
    {
        return view('admin.pages.province.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Province::create($request->all());
        return redirect()->route('province.index')->with('success', 'Province created successfully.');
    }

    public function show(Province $province)
    {
        return view('admin.pages.province.show', compact('province'));
    }

    public function edit(Province $province)
    {
        return view('admin.pages.province.edit', compact('province'));
    }

    public function update(Request $request, Province $province)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $province->update($request->all());
        return redirect()->route('province.index')->with('success', 'Province updated successfully.');
    }

    public function destroy(Province $province)
    {
        try {
            $province->delete();
            return redirect()->route('province.index')->with('success', 'Province deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // 23000 is the SQLSTATE code for integrity constraint violation
                return redirect()->route('province.index')->with('error', 'Cannot delete Province: it is referenced by other records.');
            }
            return redirect()->route('province.index')->with('error', 'An unexpected error occurred while trying to delete the Province.');
        }
    }
}

