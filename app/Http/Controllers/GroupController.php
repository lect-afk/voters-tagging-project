<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $groups = Group::when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%$query%");
        })
        ->paginate(50);

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
}

